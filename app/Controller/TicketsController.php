<?php
App::uses('AppController', 'Controller');

class TicketsController extends AppController {


	public $components = array('Paginator');

	public function isAuthorized($usuario)
	{

		if (in_array($this->action, array(
											'index', 
											'detalle_ticket', 
											'editar', 
											'nuevo', 
											'ticketactual', 
											'crear_ticket', 
											'guardar_ticket', 
											'verificar_ticket_en_espera', 
											'calcular_total_ticket', 
											'verificarservicio', 
											'calculomonto',
											'precioservicio'))) {
				return true;
		}

		if ($usuario['privilegio_id'] == '4') {

			
				if (in_array($this->action, array('index', 'editar', 'nuevo', 'ticketactual', 'express', 'caja', 'comprobar_inicio_caja', 'abrir_caja', 'ver', 'detalle_pagos', 'procesar_ticket', 'ingresar_pago','iniciar_caja', 'cerrar_caja', 'calcular_total_ticket'))) {
				return true;
				}
						
			}
		
		return parent::isAuthorized($usuario);

	}

	//-------------------------************----------------------*****************----------


	//Funcion para evaluar si el usuario inicio caja
	public function iniciar_caja() {

		$datos = array('usuario_id' => $this->Auth->user('id'), 'estadoturno' => 'A');

		$this->loadModel('TurnoCajero');

			$this->TurnoCajero->create();

			if ($this->TurnoCajero->save($datos)) {
				
				$this->Flash->success(__('Caja iniciada.'));
				$this->redirect(array('action' => 'caja'));
				
			} else {
				
				$this->Flash->error(__('Caja no iniciada.'));
			}
		
		$this->autoRender = false;

		

	}//Fin de inicio de caja


	//COMPROBAR EL INICIO DE CAJA
	public function comprobar_inicio_caja() {


		$this->loadModel('TurnoCajero');

		$resultado = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

		if ($resultado != null) {
			return true;
		} else{
			return false;
		}

	}//COMPROBAR EL INICIO DE CAJA

	public function abrir_caja(){


	}

	public function cerrar_caja($idTurno = null) {

		if ($idTurno == null) {
			throw new NotFoundException("Error con el id del turno", 1);
			
		}

		$datos = array('id' => $idTurno, 'usuario_id' => $this->Auth->user('id'), 'estadoturno' => 'C');

		$this->loadModel('TurnoCajero');
			
			if ($this->TurnoCajero->save($datos)) {
				
				$this->Flash->success(__('Caja cerrada.'));
				$this->redirect(array('controller' => 'principal', 'action' => 'index'));

			} else {
				
				$this->Flash->error(__('La caja no pudo ser cerrada.'));
			}

		$this->autoRender = false;

	}



	//COMPROBAR SI EL USUARIO ES UN CAJERO
	public function comprobar_cajero() {

		if ($this->Auth->user('privilegio_id') == 4) {
			return true;
		}else{
			return false;
		}

	}//FIN COMPROBAR CAJERO



	//FUNCION PARA SER MANEJADA POR LOS CAJEROS
	public function caja() {

		//COMPROBAR SI EL USUARIO TIENE LOS PRIVILEGIOS ADECUADOS
		$comprobacion_cajero = $this->comprobar_cajero();

		if ($comprobacion_cajero == true) {

			//COMPROBAR SI FUE ABIERTA LA CAJA
			$resultado = $this->comprobar_inicio_caja();

			if ($resultado == true) {

				//DE ESTE MISMO USUARIO???
				$resultado2 = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.usuario_id' => $this->Auth->user('id'))));

				if ($resultado2 != null) {

					$this->Ticket->recursive = 0;

					$conditions = array('Ticket.estadoticket' => array('Por pagar'));
					$ticket = $this->Ticket->find('all', array('conditions' => $conditions));
					$this->set('tickets', $ticket, $this->Paginator->paginate());

					$this->loadModel('DetalleTicket');
					$detalles = $this->DetalleTicket->find('all');
					$this->set('detalles', $detalles);

					//Calculando total de tickets
					$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));


					$this->set('totales', $totaltickets);

					//Enviando datos de usuario
					$this->loadModel('TurnoCajero');

					$cajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A', 'TurnoCajero.usuario_id' => $this->Auth->user('id'))));

					$this->set('cajero', $cajero);

				} else {

					//DEBE SOLICITAR A UN ADMINISTRADOR CERRAR ESTA CAJA
					$this->Flash->error(__('La caja se encuentra aperturada por otro usuario. Por favor dirijase a un administrador del sistema'));
				return $this->redirect(array('controller' => 'principal', 'action' => 'index'));

				}
					
			}else {
				$this->redirect(array('action' => 'abrir_caja'));
			}
				
			

		} else {//NO ES CAJERO 

			//PREGUNTAMOS SI ES ADMINISTRADOR
			if ($this->Auth->user('privilegio_id') == 1 || $this->Auth->user('privilegio_id' == 2)) {
			$this->redirect(array('action' => 'administrar_caja'));
			}else{
				$this->Flash->error(__('Debe ser un cajero para poder acceder'));
				return $this->redirect(array('controller' => 'principal', 'action' => 'index'));
			}

		}

		

	}//Fin funcion caja

	//FUNCION PARA QUE ADMINISTRADOR CIERRA CAJA
	public function administrar_caja(){

		$this->loadModel('TurnoCajero');

		$datos = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

		$this->set('cajero', $datos);

		//$fecha = $this->TurnoCajero->query("SELECT DATE(created) FROM `turno_cajeros`");

		//$this->set('fecha', $fecha);

	}




	//Funcion para tickets rapidos
	public function express() {


	}//Fin ticket expresss

	public function nuevo($idCliente = null) {

		$idUsuario = $this->Auth->user('id');

		//Comprobamos si el cliente tiene un ticket pendiente



		if ($idUsuario == null) {

			throw new NotFoundException("El Id del usuario no existe", 1);

		}else{

			$respuesta = $this->verificar_ticket_pendiente();
			
			if ($respuesta != false) {

				$this->Flash->error(__('El usuario tiene un ticket pendiente.'));

				$this->redirect(array('action' => 'ticketactual'));
				
			}else{

				//Es distinto de nulo el valor del idCliente que viene cuando presionamos
				//"Atender" en la lista de los clientes??
				if ($idCliente != null) {

					//Creamos un nuevo ticket para el cliente

					$idTicket = $this->crear_ticket($idCliente);

					$datos_nuevo_ticket = $this->Ticket->find('all', array('conditions' => array('Ticket.id' => $idTicket)));

					
					$idTicket = $datos_nuevo_ticket[0]['Ticket']['id'];


					$this->redirect(array('action' => 'ticketactual'));
						
				
				}else {

					$this->Flash->error(__('No existe el cliente para ser agregado a un nuevo ticket'));

				}

			}

		}

		$this->autoRender = false;

	}//Fin nuevo



	//Funcion para crear un nuevo ticket
	public function crear_ticket($idCliente = null) {

		$idUsuario = $this->Auth->user('id');

		if ($idCliente == null || $idUsuario == null) {
			throw new NotFoundException("El Id del cliente o del usuario no existe", 1);
			
		}else{
			
			//Recuperando ultimo id de los tickets
			$datosultimoticket = $this->Ticket->find('first', array('fields', array('Ticket.id', 'Ticket.numeroticket'),'order' => array('Ticket.id' => 'desc'))); 

			//Contamos elementos en la matriz $datosultimoticket para detecta si se ha creado algun ticket. Esto funciona para cuando el sistema este nuevo.

			$cant = count($datosultimoticket);

			if ($cant == 0) {

				$id_ultimo_ticket = 0;

				$numero_ultimo_ticket = 0;

			}else{

				$id_ultimo_ticket = $datosultimoticket['Ticket']['id'];

				$numero_ultimo_ticket = $datosultimoticket['Ticket']['numeroticket'];
			}

			//Incrementamos valor del proximo ticket y creamos variable 
			$proximo_id_ticket = $id_ultimo_ticket + 1;
			$proximo_numero_ticket = $numero_ultimo_ticket + 1;
			$edoTicket = "Atencion";

			//Creamos vector que almacena datos a guardar
			$datosGuardar = array('numeroticket' => $proximo_numero_ticket,
								 'estadoticket' => $edoTicket,  
								 'cliente_id' => $idCliente,
								 'usuario_id' => $idUsuario);

			//Cambiar estadoturno de cliente de 1 a 0 para eliminar cliente de la lista
			$this->estadoturnocliente($idCliente);

			//Guardamos y validamos que se guardó
			if ($this->Ticket->saveAll($datosGuardar)) {

				return $proximo_id_ticket;


			}else{
				$this->Flash->error(__('Error al crear un nuevo ticket'));
			}

			$this->autoRender = false;

			
		}
		
			

	}//Fin de la function nuevo



	public function verificar_ticket_en_espera(){

		$idUsuario = $this->Auth->user('id');

		if ($idUsuario == null) {

			throw new NotFoundException("El Id del cliente no existe", 1);
			
		}

		$ticket_en_espera = $this->Ticket->find('first', array('conditions' => array('Ticket.borrado' => 0, 'Ticket.usuario_id' => $idUsuario, 'Ticket.estadoticket' => 'Espera')));


		if ($ticket_en_espera == null) {
			
			return false;

		} else{

			return $ticket_en_espera;

		}

	}//Fin verificar ticket en espera


	public function verificar_ticket_pendiente() {

		$idUsuario = $this->Auth->user('id');

		if ($idUsuario == null) {

			throw new NotFoundException("El Id del cliente no existe", 1);
			
		}

		$ticket_pendiente = $this->Ticket->find('first', array('conditions' => array('Ticket.borrado' => 0, 'Ticket.usuario_id' => $idUsuario, 'Ticket.estadoticket' => 'Atencion')));


		if ($ticket_pendiente == null) {
			
			return false;

		} else{

			return $ticket_pendiente;

		}



	}//Fin verificar_ticket_pendiente

	//Funcion para editar un ticket que se encuentra en estado "Por pagar"
	public function editar($idTicket = null) {

		$idUsuario = $this->Auth->user('id');

		if ($idTicket == null || $idUsuario == null) {

			throw new NotFoundException("El Id del ticket o del usuario no existe", 1);
			
		}

		//Comprobamos si el usuario tiene un ticket en Atencion
		$ticket_actual = $this->verificar_ticket_pendiente();

		$idUsuario = $this->Auth->user('id');

		$idTicketActual = $ticket_actual['Ticket']['id'];

		if ($ticket_actual == false) {
			
		}else{

			$this->cambiar_ticket_a_espera($idTicketActual);

		}

		$this->cambiar_usuario_de_ticket($idTicket);

		$this->cambiar_ticket_a_atencion($idTicket);

		$this->redirect(array('action' => 'ticketactual'));


	}//Fin editar



	//Funcion para la vista los tickets
	public function index() {

	
		$this->Ticket->recursive = 0;

		$conditions = array('Ticket.estadoticket' => array('Atencion', 'Espera', 'Por pagar'));
		$ticket = $this->Ticket->find('all', array('conditions' => $conditions));
		$this->set('tickets', $ticket, $this->Paginator->paginate());

		$this->loadModel('DetalleTicket');
		$detalles = $this->DetalleTicket->find('all');
		$this->set('detalles', $detalles);

		//Calculando total de tickets
		$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));


		$this->set('totales', $totaltickets);


	}

	//Funcion para la vista del ticket en el que este trabajando un usuario
	public function ticketactual () {

		$idUsuario = $this->Auth->user('id');

		if ($idUsuario == null) {
			throw new NotFoundException("Id de Usuario no encontrado", 1);
		}

		$ticketactual = $this->verificar_ticket_pendiente();
		$idTicket = $ticketactual['Ticket']['id'];

		
			if($ticketactual == null){

				$this->Flash->error(__('El usuario no tiene un ticket actual. Por favor atienda un nuevo cliente.'));

				$this->redirect(array('controller' => 'clientes', 'action' => 'index')); 

			}else {

				$this->set('datos', $ticketactual);

				
				//ENVIANDO DETALLES DE TICKET

				$this->loadModel('DetalleTicket');
				$detalles = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket)));

				$this->set(compact('detalles', $detalles));

				$total_ticket = $this->calcular_total_ticket($idTicket);

				$this->set('totalticket', $total_ticket);

				$this->loadModel('Servicio');
				$servicios = $this->Servicio->find('list');
				$this->set('listaservicios', $servicios);

			}

		

	}//Fin ticketactual



	public function guardar_ticket($idTicket = null){

		$idUsuario = $this->Auth->user('id');

		if ($idTicket != null) {

			//Validar si el ticket tiene servicios agregados
			$this->loadModel('DetalleTicket');
			$servicios_en_ticket = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket)));

			if ($servicios_en_ticket == null) {
				$this->Flash->error(__('Tickets sin servicios no pueden ser procesados. Por favor ingrese un servicio'));
				$this->redirect(array('action' => 'ticketactual'));
			} else {

				$respuesta = $this->cambiar_ticket_a_porpagar($idTicket);

						
				//Buscamos si el usuario tiene un ticket en espera
				$respuesta_2 = $this->verificar_ticket_en_espera();

				if ($respuesta_2 == false) {
					
				}else {

					$idTicketEspera = $respuesta_2['Ticket']['id'];

					$this->cambiar_ticket_a_atencion($idTicketEspera);

				}


				if ($respuesta == true) {

					
						//Guardamos monto en ticket
						$total_ticket = $this->calcular_total_ticket($idTicket);

						$montoticket = array('id' => $idTicket, 'montoticket' => $total_ticket);
						if ($this->Ticket->saveAll($montoticket)) {
								//GUARDADO
						}else{
							$this->Flash->error(__('El servicio no pudo ser añadido. Error al ingresar el monto en el ticket'));
						}


					$this->Flash->success(__('Ticket procesado exitosamente'));

					$this->redirect(array('controller' => 'clientes', 'action' => 'index'));
					

				}else {

					$this->Flash->error(__('Error al procesar ticket.'));

				}

			}

		} else {

			throw new NotFoundException("Error Processing Request", 1);

		}

			
		$this->autoRender = false;
	}//Fin guardar_ticket



	//Obtener datos de un ticket
	public function obtener_datos_ticket_actual($idTicket = null) {

		if ($idTicket == null) {

			throw new NotFoundException("El Id del ticket no existe al obtener datos del ticket", 1);
			
		}

		$datosTicket = $this->Ticket->find('first', array('conditions' => array('Ticket.id' => $idTicket, 'Ticket.estadoticket' => 'Atencion')));

		if ($datosTicket == null) {
			
			throw new NotFoundException("No se obtuvieron datos de este ticket", 1);

		}else{

			return $datosTicket;

		}



	}//FIn Obtener_datos_ticket

	//Obtener datos de un ticket
	public function obtener_datos_ticket($idTicket = null) {

		if ($idTicket == null) {

			throw new NotFoundException("El Id del ticket no existe al obtener datos del ticket", 1);
			
		}

		$datosTicket = $this->Ticket->find('first', array('conditions' => array('Ticket.id' => $idTicket)));

		if ($datosTicket == null) {
			
			throw new NotFoundException("No se obtuvieron datos de este ticket", 1);

		}else{

			return $datosTicket;

		}



	}//FIn Obtener_datos_ticket


	//FUNCION PARA CAMBIAR EL ESTADO DE UN CLIENTE DE 1 A CERO Y QUE NO APAREZCA MAS EN LA LISTA
	public function estadoturnocliente($id_cliente = null){
		$datos = array('id' => $id_cliente, 'estadocliente' => 0);
		$this->loadModel('Cliente');

		if ($this->Cliente->saveAll($datos)) {
			//Guardado exitoso
		}else{

			$this->Flash->error(__('Error al cambiar el estado de turno del cliente.'));

		}	

	}//Fin estado turno cliente

	

	//Funcion para cambiar el estado de un ticket a espera
	public function cambiar_ticket_a_espera($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado en cambiar ticket a espera", 1);
		}

		$datos = array('id' => $idTicket, 'estadoticket' => 'Espera');
		

		if ($this->Ticket->saveAll($datos)) {
			//Guardado exitoso

		}else{

			$this->Flash->error(__('Error al cambiar el estado de del ticket a espera.'));

		}

		

	}//Fin cambiar ticket a espera



//Funcion para cambiar el estado de un ticket a Atencion
	public function cambiar_ticket_a_atencion($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado en cambiar ticket a atencion", 1);
		}

		$datos = array('id' => $idTicket, 'estadoticket' => 'Atencion');
		

		if ($this->Ticket->saveAll($datos)) {
			//Guardado exitoso

		}else{

			$this->Flash->error(__('Error al cambiar el estado de del ticket a atencion.'));

		}

		

	}//Fin cambiar ticket a atencion


	//Funcion para cambiar el estado de un ticket a Por pagar
	public function cambiar_ticket_a_porpagar($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado en cambiar ticket a por pagar", 1);
		}

		$datos = array('id' => $idTicket, 'estadoticket' => 'Por pagar');
		

		if ($this->Ticket->saveAll($datos)) {
			
			return true;

		}else{

			return false;
		}

	}//Fin cambiar ticket a espera

	//Funcion para cambiar el estado de un ticket a pagado
	public function cambiar_ticket_a_pagado($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado en cambiar ticket a por pagar", 1);
		}

		$datos = array('id' => $idTicket, 'estadoticket' => 'Pagado');
		

		if ($this->Ticket->saveAll($datos)) {
			
			return true;

		}else{

			return false;
		}

	}//Fin cambiar ticket a pagado



	//Funcion para cambiar el estado de un ticket a Cancelar
	public function cambiar_ticket_a_cancelar($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado en cambiar ticket a por pagar", 1);
		}

		$datos = array('id' => $idTicket, 'estadoticket' => 'Cancelado');
		

		if ($this->Ticket->saveAll($datos)) {
			
			return true;

		}else{

			return false;
		}

	}//Fin cambiar ticket a cancelar




	public function cambiar_usuario_de_ticket($idTicket = null) {

		$idUsuario = $this->Auth->user('id');

		if ($idUsuario == null || $idTicket == null) {

			throw new NotFoundException("Id de usuario o de ticket no encontrado", 1);
			
		}

		$datos = array('id' => $idTicket, 'usuario_id' => $idUsuario);
		

		if ($this->Ticket->saveAll($datos)) {
			//Guardado exitoso

		}else{

			$this->Flash->error(__('Error al cambiar el estado de del ticket a atencion.'));

		}


	}//Fin cambiar usuario de ticket



	//////////********FUNCIONES PARA SER USADAS POR JS**********//////////

	public function calculomonto(){
		
		if ($this->request->is('ajax')) {
			
			$id = $this->request->data['idServicio'];
			$cantidad = isset($this->request->data['cantidad']) ? $this->request->data['cantidad'] : null;
			$cantidad = $this->request->data['cantidad'];
			if($cantidad == 0){
				$cantidad = 1;
			}


			$this->loadModel('Servicio');

			//$precio = $this->Precio->query("SELECT `precios`.`precio` FROM `servicios` LEFT JOIN `precios` ON `precios`.`servicio_id` = `servicios`.`id` WHERE `servicios`.`id` = $id");

			$valPrecio = $this->Servicio->find('all', array('fields' => array('Servicio.id', 'Servicio.precio'), 'conditions' => array('Servicio.id' => $id)));

			$precio = $valPrecio[0]['Servicio']['precio'];

			$monto = $precio * $cantidad;

			
			$mostrar_datos = array('precio' => $precio, 'monto' => $monto);

			echo json_encode(compact('mostrar_datos'));

			$this->autoRender = false;

			
		}

	}

		
	public function precioservicio(){
		
		if ($this->request->is('ajax')) {

			$id = $this->request->data['idServicio'];

			$cantidad = isset($this->request->data['cantidad']) ? $this->request->data['cantidad'] : null;
			
			$cantidad = $this->request->data['cantidad'];

			if($cantidad == 0 || $cantidad == ''){
				$cantidad = 1;
			}
			
			$this->loadModel('Servicio');

			$valPrecio = $this->Servicio->find('all', array('fields' => array('Servicio.id', 'Servicio.precio'), 'conditions' => array('Servicio.id' => $id)));

			if ($valPrecio == null) {
				throw new NotFoundException("Error en precioservicio", 1);
				
			} else {

			$precio = $valPrecio[0]['Servicio']['precio'];

			$monto = $precio * $cantidad;

			$mostrar_datos = array('precio' => $precio, 'monto' => $monto);

			echo json_encode(compact('mostrar_datos'));

			$this->autoRender = false;

			}
			
		}

	
	}

	public function verificarservicio(){

		if ($this->request->is('ajax')) {
			
			$idServicio = $this->request->data['idServicio'];
			$idTicket = $this->request->data['idTicket'];

			$this->loadModel('DetalleTicket');

			$exists = $this->DetalleTicket->find('all', array('fields' => array('DetalleTicket.ticket_id', 'DetalleTicket.servicio_id'), 'conditions' => array('DetalleTicket.ticket_id' => $idTicket, 'DetalleTicket.servicio_id' => $idServicio)));

			if ($exists != null) {

				echo $resultado = 0;

			}else{

				echo $resultado = 1;

			}

			

		}

		$this->autoRender = false;

	}

	public function detalle_ticket(){

		$this->layout = 'ajax';

		if ($this->request->is('ajax')) {

			$id = $this->request->data['idTicket'];
			
			//ENVIANDO LISTADO DE LOS PRECIOS DE LOS SERVICIOS

			$this->loadModel('Servicio');

			$precios = $this->Servicio->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $id)));

			//$precios = $this->Servicio->query("SELECT `servicios`.`id`, `servicios`.`codigoservicio`, `servicios`.`nombreservicio`, `detalle_tickets`.`cantidad`, `precio_servicios`.`precio`, `detalle_tickets`.`monto`, `detalle_tickets`.`id` FROM `servicios` LEFT JOIN `detalle_tickets` ON `detalle_tickets`.`servicio_id` = `servicios`.`id` LEFT JOIN `precio_servicios` ON `precio_servicios`.`servicio_id` = `servicios`.`id`  WHERE `detalle_tickets`.`ticket_id` = $id;");

			$this->set('servicios', $precios);


			//MANERA DE CONSULTAR SENCILLA "SEGUN CAKEPHP"
			$this->loadModel('DetalleTicket');
			$total_servicios = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $id), 'fields' => array('SUM(DetalleTicket.monto) as subtotal')));

			$mostrar_total_servicios = $total_servicios['0']['0']['subtotal'];

			$this->set('total_servicios', $mostrar_total_servicios);

			
		}



	}


	public function calcular_total_ticket($idTicket = null){

		if ($idTicket == null) {

			throw new NotFoundException("Id de ticket no válido", 1);
			
		}

		$this->loadModel('DetalleTicket');
		$total_servicios = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket), 'fields' => array('SUM(DetalleTicket.monto) as subtotal')));
		
		$total_servicios = $total_servicios['0']['0']['subtotal'];

		return $total_servicios;

	}//Fin calcula total ticket



	//Funcion para eliminar un ticket
	public function delete($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Ticket para ser eliminado no encontrado", 1);
		}

		//Guardamos monto en ticket
		$total_ticket = $this->calcular_total_ticket($idTicket);

		$montoticket = array('id' => $idTicket, 'montoticket' => $total_ticket);
		if ($this->Ticket->saveAll($montoticket)) {
			//GUARDADO
		}else{
			$this->Flash->error(__('Error al guardar monto del ticket cuando se eliminaba'));
		}

		$resultado = $this->cambiar_ticket_a_cancelar($idTicket);

		if ($resultado == true) {
			$this->Flash->success(__('Ticket Eliminado con exito.'));
			$this->redirect(array('action' => 'index'));
		}else{
			$this->Flash->error(__('Error al eliminar el ticket.'));
			$this->redirect(array('action' => 'ticketactual'));
		}

	}//Fin delete

	public function anular($idTicket = null) {

	}//Fin anular


	



	//Funcion para ver el ticket que va a ser cancelado
	public function ver($idTicket = null) {

		if (!$this->Ticket->exists($idTicket)) {
			throw new NotFoundException(__('Id de ticket no válido '));
		}

		if ($this->request->is('post')) {
			//debug($this->request->data);
			$formapago = $this->request->data['Ticket']['forma_pago'];
			$idTicket = $this->request->data['Ticket']['IdTicket'];

			$this->ingresar_pago($formapago, $idTicket);
		}

				//Buscamos y enviamos el detalle de ticket a cobrar
				$this->loadModel('DetalleTicket');
				$detalles = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket)));

				$this->set(compact('detalles', $detalles, $this->Paginator->paginate()));

				//Calculamos y enviamos el total del ticket a cobrar
				$total_ticket = $this->calcular_total_ticket($idTicket);

				$this->set('totalticket', $total_ticket);

				$this->set('idTicket', $idTicket);



				$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));

				$totalpagado = $this->Ticket->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket), 'fields' => array('ticket_id', 'SUM(DetallePago.total) as subtotal')));

				$this->set('pagado', $totalpagado);

				
	}//Fin function ver

	//Procesar cobro de un ticket
	public function procesar_ticket($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id de ticket no recibido para procesar pago", 1);
		}

		$resultado = $this->cambiar_ticket_a_pagado($idTicket);

		if ($resultado == true) {
			$this->Flash->success(__('Ticket procesado exitosamente.'));
			return $this->redirect(array('controller' => 'tickets', 'action' => 'caja'));
		}else{
			$this->Flash->error(__('Ticket no procesado.'));
		}


	}//Fin cobrar ticket


	//Aca se evalua que tipo de pago se va a generar
	public function ingresar_pago($formapago = null, $idTicket = null){

		if ($formapago == null || $idTicket == null) {
			throw new NotFoundException("Forma de pago o id del ticket no encontrado", 1);
		}

			if ($formapago == 0) {
				return $this->redirect(array('controller' => 'puntos', 'action' => 'pago_punto', $idTicket));
			}
			if ($formapago == 1) {
				return $this->redirect(array('controller' => 'efectivos', 'action' => 'pago_efectivo', $idTicket));
			}
			if ($formapago == 2) {
				return $this->redirect(array('controller' => 'transferencias', 'action' => 'pago_transferencia', $idTicket));
			}
			
	

		$this->autoRender = false;

	}//fin iniciar pago


	public function calcular_monto_pagado($idTicket = null) {

		if (!$this->Ticket->exists($idTicket)) {
			throw new NotFoundException(__('Id de ticket no válido en calcular_monto_pagado '));
		}

		//$total_pagado = $this->Detalle

	}




} //FIN CLASE