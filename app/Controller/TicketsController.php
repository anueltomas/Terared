<?php
App::uses('AppController', 'Controller');

class TicketsController extends AppController {


	//public $components = array('Paginator');

	public $paginate = array(

		'limit' => 10,
		'order' => array(
			'Ticket.id' => 'asc'

			)

		);



	public function isAuthorized($usuario)
	{

		$privilegio = $this->Session->read('privilegio_id');

		if (in_array($this->action, array(
											'index', 
											'detalle_ticket', 
											'add',
											'tabla_tickets',
											'verificar_ticket_en_espera', 
											'calcular_total_ticket', 
											'verificarservicio', 
											'calculomonto',
											'precioservicio',
											
											'delete',
											
											))) {
				return true;
		}

		 

		if ($privilegio == '5' || $privilegio == '3') {

			
				if (in_array($this->action, array('editar', 'nuevo', 'ticketactual', 'crear_ticket', 'guardar_ticket', 'express', 'add'))) {
				return true;
				}
						
			}

		if ($privilegio == '4') {

			
				if (in_array($this->action, array('index', 'caja', 'comprobar_inicio_caja', 'abrir_caja', 'ver', 'detalle_pagos', 'procesar_ticket', 'ingresar_pago','iniciar_caja', 'cerrar_caja', 'cerrar_turno', 'calcular_total_ticket', 'pagados', 'detalles', 'tabla_caja', 'facturar'))) {
				return true;
				}
						
			}
		
		return parent::isAuthorized($usuario);

	}
 

	//-------------------------************----------------------*****************----------


	//Funcion para evaluar si el usuario inicio caja
	public function iniciar_caja() {

		$this->loadModel('Cierre');

		//EVALUAMOS SI EL TURNO QUE SE ESTA INICIANDO TIENE UNA CAJA ABIERTA DEL DIA DE HOY
		$fecha_hoy = date('Y-m-d');

		$resultado = $this->Cierre->find('first', array('fields' => array('Cierre.id', 'Cierre.estadocierre'), 'conditions' => array('DATE(Cierre.created)' => $fecha_hoy, 'Cierre.estadocierre' => 'A'), 'recursive' => -1));

		if (empty($resultado)) {
			//NO ENCONTRAMOS, BUSCAMOS CAJA ABIERTA ANTERIOR
			$caja_abierta = $this->Cierre->find('first', array('fields' => array('Cierre.id', 'Cierre.estadocierre'), 'conditions' => array('Cierre.estadocierre' => 'A'), 'recursive' => -1));

			if (empty($caja_abierta)) {
				//APERTURAMOS UNA NUEVA CAJA
				$resultado = $this->abrircaja();

				if ($resultado === false) {
					//NO SE PUDO ABRIR CAJA
				}else{

					//ABRIMOS UN NUEVO TURNO
					$this->aperturarturno($respuesta);

				}

			}else{
				//CERRAMOS CAJA ANTERIOR
				$idCaja = $caja_abierta['Cierre']['id'];
				$respuesta = $this->cerrarcaja($idCaja);

				if ($respuesta === true) {

					//ABRIMOS NUEVA CAJA
					$respuesta = $this->abrircaja();

					if ($respuesta === false) {
						
					}else{

						//ABRIMOS UN NUEVO TURNO
						$this->aperturarturno($respuesta);

					}

				}else{
					//ERROR AL CERRAR CAJA
				}

				
			}
			
		}else{
			//APERTURAMOS TURNO CON LA CAJA QUE SE ENCUENTRA ABIERTA ENVIANDOLE EN ID DE LA CAJA
			$idCaja = $resultado['Cierre']['id'];
			$this->aperturarturno($idCaja);
		}

		
		
		$this->autoRender = false;

		

	}//Fin de inicio de caja


	public function aperturarturno($idCaja = null){

		if($idCaja === null) {
			throw new NotFoundException("Error en el id de la caja", 1);
			
		}

		$this->loadModel('Configuration');

		$frecuencia = $this->Configuration->find();

			if (empty($frecuencia)) {

				$this->Flash->error(__('No ha sido configurada la frecuencia de la facturación, informe a un administrador'));

				$this->redirect(array('action' => 'abrir_caja'));

			} else {

				$datos = array('usuario_id' => $this->Auth->user('id'), 'estadoturno' => 'A', 'cierre_id' => $idCaja);

				$this->loadModel('TurnoCajero');

					$this->TurnoCajero->create();

					if ($this->TurnoCajero->save($datos)) {
						
						$this->Flash->success(__('Turno Iniciado.'));
						$this->redirect(array('action' => 'caja'));
						
					} else {
						
						$this->Flash->error(__('El turno no pudo ser iniciado.'));
					}

			}

	}



	public function abrircaja(){

		$this->loadModel('Cierre');

		$this->Cierre->create();

					if ($this->Cierre->save()) {

						$fecha_hoy = date('Y-m-d');

						$result = $this->Cierre->find('first', array('fields' => array('Cierre.id', 'Cierre.estadocierre'), 'conditions' => array('DATE(Cierre.created)' => $fecha_hoy, 'Cierre.estadocierre' => 'A'), 'recursive' => -1));

						$idCaja = $result['Cierre']['id'];
						
						$respuesta = $idCaja;
						
					} else {
						
						$respuesta = false;
					}

					return $respuesta;
	}

	public function cerrarcaja($idCaja = null){

		if($idCaja === null) {
			throw new NotFoundException("Error en el id de la caja", 1);
			
		}


		$this->loadModel('Cierre');

			$this->Cierre->id = $idCaja;


					if ($this->Cierre->saveField('estadocierre', 'C')) {
						
						$respuesta = true;
						
					} else {
						
						$respuesta = false;
					}

					return $respuesta;

	}


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

	public function cerrar_caja() {

		//EVALUAMOS SI EXISTE UN CAJERO ACTIVO
		$this->loadModel('TurnoCajero');
		$idCajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

		if ($idCajero != null) {
			$this->Flash->error(__('Existe un cajero activo.'));
		}else {

			$datos = array('montoanterior' => 0);

		$this->loadModel('Cierre');

		if ($this->Cierre->save($datos)) {

							
					$this->Flash->success(__('Caja cerrada con exito.'));
					return $this->redirect(array('controller' => 'principal', 'action' => 'index'));

				} else {
					
					$this->Flash->error(__('La caja no pudo cerrarse.'));
				}

		}
		

		

	}

	public function cerrar_turno($idTurno = null) {

		if ($idTurno == null) {
			throw new NotFoundException("Error con el id del turno", 1);
			
		}

		//EVALUAR SI EL CAJERO TIENE FACTURAS PENDIENTES

		$ticketsSinFacturar = $this->Ticket->query("SELECT * FROM tickets, usuarios, turno_cajeros 
			WHERE tickets.turno_cajero_id = turno_cajeros.id
			AND turno_cajeros.id = $idTurno
			AND tickets.estadoticket = 'Pagado'
			");

		if ($ticketsSinFacturar != null) {
			$this->Flash->error(__('Debe facturar todos los tickets cobrados para cerrar el turno'));

			$this->redirect(array('controller' => 'tickets', 'action' => 'facturar'));
		}else {
			$this->redirect(array('controller' => 'cierres', 'action' => 'add', $idTurno));
		}

		

		

		$this->autoRender = false;

	}



	//COMPROBAR SI EL USUARIO ES UN CAJERO
	public function comprobar_cajero() {

		$privilegio = $this->Session->read('privilegio_id');

		if ($privilegio == 4 || $privilegio == 1 || $privilegio == 2) {
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
				$resultado2 = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.usuario_id' => $this->Auth->user('id'), 'TurnoCajero.estadoturno' => 'A')));

				if ($resultado2 != null) {

					$this->Ticket->recursive = 0;

					$conditions = array('Ticket.estadoticket' => array('Por pagar'));
					$ticket = $this->Ticket->find('all', array('conditions' => $conditions));
					$this->set('tickets', $ticket);

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

					$conditions = array('Ticket.estadoticket' => array('Pagado'));
					$ticket = $this->Ticket->find('all', array('conditions' => $conditions, 'order' => array('Ticket.modified' => 'DESC'), 'limit' => 20));
					$this->set('pagados', $ticket);

				} else {

					//DEBE SOLICITAR A UN ADMINISTRADOR CERRAR ESTA CAJA
					$this->Flash->error(__('La caja se encuentra aperturada por otro usuario. Por favor dirijase a un administrador del sistema'));
				return $this->redirect(array('controller' => 'principal', 'action' => 'index'));

				}
					
			}else {
				$this->redirect(array('action' => 'abrir_caja'));
			}
				
			

		} else {//NO ES CAJERO 

				$this->Flash->error(__('Debe ser un cajero para poder acceder'));
				return $this->redirect(array('controller' => 'principal', 'action' => 'index'));

		}

		

	}//Fin funcion caja

	//FUNCION PARA QUE ADMINISTRADOR CIERRA CAJA
	public function administrar_caja(){

		//PREGUNTAMOS SI ES ADMINISTRADOR
		$privilegio = $this->Session->read('privilegio_id');
		if ($privilegio == 1 || $privilegio == 2) {

			$this->loadModel('TurnoCajero');

			$datos = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

			$this->set('cajero', $datos);

			//$fecha = $this->TurnoCajero->query("SELECT DATE(created) FROM `turno_cajeros`");

			//$this->set('fecha', $fecha);
		} else {

			$this->Flash->error(__('Debe ser administrador para poder acceder'));
				return $this->redirect(array('controller' => 'principal', 'action' => 'index'));

		}

	}




	//Funcion para tickets rapidos
	public function express() {

		

				if ($this->request->is('post')) {
					
					$nombreCliente = $this->request->data['Cliente']['nombre'];
					$respuesta = $this->redirect(array('controller' => 'clientes', 'action' => 'clienteExpress', $nombreCliente));
					if ($respuesta != false) {
					} else {
						$this->Flash->error('Error al agregar el cliente');
					}

				}
				

		

	}//Fin ticket express

	public function nuevo($idCliente = null) {

		

		//Comprobamos si el cliente tiene un ticket pendiente

			if ($idCliente != null) {

				$respuesta = $this->verificar_ticket_pendiente();

				$idTicketActual = $respuesta['Ticket']['id'];
				
				if ($respuesta != false) {

					$this->cambiar_ticket_a_espera($idTicketActual);

					//Creamos un nuevo ticket para el cliente

					$idTicket = $this->crear_ticket($idCliente);

					$datos_nuevo_ticket = $this->Ticket->find('all', array('conditions' => array('Ticket.id' => $idTicket)));

					
					$idTicket = $datos_nuevo_ticket[0]['Ticket']['id'];


					$this->redirect(array('action' => 'ticketactual'));

				
				} else {
				
				//Creamos un nuevo ticket para el cliente

					$idTicket = $this->crear_ticket($idCliente);

					$datos_nuevo_ticket = $this->Ticket->find('all', array('conditions' => array('Ticket.id' => $idTicket)));

					
					$idTicket = $datos_nuevo_ticket[0]['Ticket']['id'];


					$this->redirect(array('action' => 'ticketactual'));

				}

			}else {

					$this->Flash->error(__('No existe el cliente para ser agregado a un nuevo ticket'));
				}
		
		

		$this->autoRender = false;

	}//Fin nuevo


	public function pagados() {

		$this->Ticket->recursive = 0;
		$this->Ticket->recursive = 0;
		$this->paginate['Ticket']['limit'] = 10;
		$this->paginate['Ticket']['conditions'] = array('Ticket.estadoticket' => 'Pagado');
		$this->paginate['Ticket']['order'] = array('Ticket.id' => 'desc');

					//$conditions = array('Ticket.estadoticket' => array('Pagado'));
					//$ticket = $this->Ticket->find('all', array('conditions' => $conditions, 'order' => array('Ticket.modified' => 'DESC')));
					//$this->set('tickets', $ticket, $this->Paginator->paginate());
		$this->set('tickets', $this->paginate());

		/*			$this->loadModel('DetalleTicket');
					$detalles = $this->DetalleTicket->find('all');
					$this->set('detalles', $detalles);

					//Calculando total de tickets
					$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));


					$this->set('totales', $totaltickets);

					//Enviando datos de usuario
					$this->loadModel('TurnoCajero');

					$cajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A', 'TurnoCajero.usuario_id' => $this->Auth->user('id'))));

					$this->set('cajero', $cajero);

					$this->loadModel('DetallePago');
					$pagos = $this->DetallePago->find('all');
					$this->set('pagos', $pagos);
		*/
	}//FINAL PAGADOS

	public function historico_pagos() {

		$this->Ticket->recursive = 0;
		$this->paginate['Ticket']['limit'] = 10;
		$this->paginate['Ticket']['order'] = array('Ticket.id' => 'desc');
			//$this->paginate['Ticket']['conditions'] => array('Ticket.estadoticket' => );
			$this->set('tickets', $this->paginate());
					//$conditions = array('Ticket.estadoticket' => array('Facturado'));
					//$ticket = $this->Ticket->find('all', array('conditions' => $conditions, 'order' => array('Ticket.modified' => 'DESC')));
					//$this->set('tickets', $ticket);

					
				/*
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

					$this->loadModel('DetallePago');
					$pagos = $this->DetallePago->find('all');
					$this->set('pagos', $pagos);
				*/
	}//FINAL historico_pago


	public function total_pagados() {

		$total = $this->Ticket->find('all', array('fields' => array('Ticket.id', 'SUM(Ticket.montoticket) as total'), 'group' => array('Ticket.id')));

		

	}



	//Funcion para crear un nuevo ticket
	public function crear_ticket($idCliente = null) {

			
			
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
			$usuario_id = $this->Auth->user('id');

			//Creamos vector que almacena datos a guardar
			$datosGuardar = array(
					'numeroticket' => $proximo_numero_ticket,
					'estadoticket' => $edoTicket,  
					'cliente_id' => $idCliente,
					'usuario_id' => $usuario_id);

			//Cambiar estadoturno de cliente de 1 a 0 para eliminar cliente de la lista
			$this->estadoturnocliente($idCliente);

			//Guardamos y validamos que se guardó
			if ($this->Ticket->saveAll($datosGuardar)) {

				return $proximo_id_ticket;


			}else{
				$this->Flash->error(__('Error al crear un nuevo ticket'));
			}

			$this->autoRender = false;

	
		
			

	}//Fin de la function nuevo


	public function verificar_usuario_ticket($idTicket = null){

		if ($idTicket == null) {
			throw new NotFoundException("Error en verificar_usuario_ticket", 1);
		}
		
		$datos = $this->Ticket->find('first', array('conditions' => array('Ticket.borrado' => 0, 'Ticket.id' => $idTicket)));


		$estado = $datos['Ticket']['estadoticket'];
		$usuario = $datos['Ticket']['usuario_id'];

		if ($estado == 'Atencion') {
			if ($usuario == $this->Auth->user('id')) {
				return true;
			}else{
				return false;
			}
		}else{
			if ($estado == 'Por pagar') {
				return true;
			}else{
				if ($estado == 'Espera') {
					if ($usuario == $this->Auth->user('id')) {
						return true;
					}else{
						return false;
					}
				}
			}
		}




	}



	public function verificar_ticket_en_espera(){

	
		$ticket_en_espera = $this->Ticket->find('first', array('conditions' => array('Ticket.borrado' => 0, 'Ticket.estadoticket' => 'Espera', 'Ticket.usuario_id' => $this->Auth->user('id'))));
//debug($ticket_en_espera);

		if ($ticket_en_espera == null) {
			
			return false;

		} else{

			return $ticket_en_espera;

		}

	}//Fin verificar ticket en espera


	public function verificar_ticket_pendiente() {

	

		$ticket_pendiente = $this->Ticket->find('first', array('conditions' => array('Ticket.borrado' => 0, 'Ticket.estadoticket' => 'Atencion', 'Ticket.usuario_id' => $this->Auth->user('id'))));


		if ($ticket_pendiente == null) {
			
			return false;

		} else{

			return $ticket_pendiente;

		}



	}//Fin verificar_ticket_pendiente

	//Funcion para editar un ticket que se encuentra en estado "Por pagar"
	public function editar($idTicket = null) {


		if ($idTicket == null ) {

			throw new NotFoundException("El Id del ticket no existe", 1);
			
		}

		//Comprobar si el ticket no esta siendo atendido por otro usuario
		$resultado = $this->verificar_usuario_ticket($idTicket);

		if ($resultado == true) {

			//Comprobamos si el usuario tiene un ticket en Atencion
			$ticket_actual = $this->verificar_ticket_pendiente();

			$idTicketActual = $ticket_actual['Ticket']['id'];

			if ($ticket_actual == false) {
				
			}else{

				$this->cambiar_ticket_a_espera($idTicketActual);

			}

			$this->cambiar_ticket_a_atencion($idTicket);

			$this->redirect(array('action' => 'ticketactual'));
				
		} else {
			$this->Flash->error(__('El ticket se encuentra siendo editado por otro usuario.'));

			$this->redirect(array('action' => 'index'));
		}

		


	}//Fin editar


	public function tabla_tickets(){

		$this->layout = 'ajax';

		$this->Ticket->recursive = 0;

		$conditions = array('Ticket.estadoticket' => array('Atencion', 'Espera', 'Por pagar'), 'Ticket.borrado' => 0);
		$ticket = $this->Ticket->find('all', array('conditions' => $conditions));
		$this->set('tickets', $ticket);

		$this->loadModel('Usuario');

		$usuarios = $this->Usuario->find('all', array('conditions' => array('Usuario.estadousuario' => 1, 'Usuario.borrado' => 0), 'recursive' => -1));

		$this->set('usuarios', $usuarios);

	}



	//Funcion para la vista los tickets
	public function index() {



		$conditions = array('Ticket.estadoticket' => array('Pagado', 'Facturado'));
		$ticket = $this->Ticket->find('all', array('conditions' => $conditions, 'order' => array('Ticket.modified' => 'DESC'), 'limit' => 20));
		$this->set('pagados', $ticket);

		$this->loadModel('DetalleTicket');
		$detalles = $this->DetalleTicket->find('all');
		$this->set('detalles', $detalles);

		//Calculando total de tickets
		$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));


		$this->set('totales', $totaltickets);

		

		}

	//Funcion para la vista del ticket en el que este trabajando un usuario
	public function ticketactual() {

	
		if ($this->request->is('post')) {

			$this->loadModel('Servicio');
			$idServicio = $this->Servicio->query("SELECT serv.id FROM servicios serv INNER JOIN tservicios ON serv.tservicio_id = tservicios.id AND tservicios.nombretipo = 'INTERNET' ");
			$idServicio = $idServicio['0']['serv']['id'];

			$monto = $this->request->data['DetalleTicket']['totalalquiler'];
			$ticket = $this->request->data['DetalleTicket']['ticket_id'];
			$usuario = $this->request->data['DetalleTicket']['usuario_id'];
			$this->loadModel('DetalleTicket');
			$datos = array('cantidad' => 1,
							'monto' => $monto,
							'ticket_id' => $ticket,
							'servicio_id' => $idServicio,
							'usuario_id' => $usuario);
			
				$this->DetalleTicket->create();
				if ($this->DetalleTicket->save($datos)) {

					$this->Flash->success(__('Servicio añadido.'));
					return $this->redirect(array('controller' => 'tickets', 'action' => 'ticketactual'));
				} else {
					$this->Flash->error(__('El servicio no pudo ser añadido.'));
				}
		}



		//VERIFICAMOS SI 
		$ticketactual = $this->verificar_ticket_pendiente();
		$idTicket = $ticketactual['Ticket']['id'];

		
			if($ticketactual == false){

				$ticketactual = $this->verificar_ticket_en_espera();
				$idTicket = $ticketactual['Ticket']['id'];

				if($ticketactual == false){

					$this->Flash->error(__('El usuario no tiene un ticket actual. Por favor atienda un nuevo cliente.'));

					$this->redirect(array('controller' => 'clientes', 'action' => 'index')); 
				} else {
					$this->cambiar_ticket_a_atencion($idTicket);

					$this->redirect(array('action' => 'ticketactual'));
				}

			}else {

				$this->set('datos', $ticketactual);

				
				//ENVIANDO DETALLES DE TICKET

				$this->loadModel('DetalleTicket');
				$detalles = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket, 'DetalleTicket.borrado' => 0)));

				$this->set(compact('detalles', $detalles));

				$total_ticket = $this->calcular_total_ticket($idTicket);

				$this->set('totalticket', $total_ticket);

				$this->loadModel('Servicio');
				$servicios = $this->Servicio->find('list', array('conditions' => array('Servicio.tservicio_id !=' => 2, 'Servicio.precio !=' => 0)));
				$this->set('listaservicios', $servicios);
				
				$conditions = array('Ticket.estadoticket' => array('Pagado', 'Facturado'));
				$ticket = $this->Ticket->find('all', array('conditions' => $conditions, 'order' => array('Ticket.id' => 'DESC'), 'limit' => 20));
				$this->set('pagados', $ticket);

				$this->loadModel('Cola');
			$colas = $this->Cola->find('list', array('fields' => array('id', 'nombre')));
			$this->set('colas', $colas);

			}



		$datos = $this->Ticket->find('first', array('conditions' => array('Ticket.borrado' => 0, 'Ticket.id' => $idTicket)));


		$this->set('prueba', $datos);
		

	}//Fin ticketactual



	public function guardar_ticket($idTicket = null){


		if ($idTicket != null) {

			//Validar si el ticket tiene servicios agregados
			$this->loadModel('DetalleTicket');
			$servicios_en_ticket = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket)));

			if ($servicios_en_ticket == null) {
				$this->Flash->error(__('Tickets sin servicios no pueden ser procesados. Por favor ingrese un servicio'));
				$this->redirect(array('action' => 'ticketactual'));
			} else {

				$respuesta = $this->cambiar_ticket_a_porpagar($idTicket);

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

  $this->redirect(array('controller' => 'tickets', 'action' => 'index'));

}else {

     $this->Flash->error(__('Error al procesar ticket.'));

 }


						
	//Buscamos si el usuario tiene un ticket en espera
	$respuesta_2 = $this->verificar_ticket_en_espera();

	if ($respuesta_2 == false) {
					
	}else {

		$idTicketEspera = $respuesta_2['Ticket']['id'];

		$this->cambiar_ticket_a_atencion($idTicketEspera);

		$this->redirect(array('action' => 'ticketactual'));

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

		$datos = array(
			'id' => $idTicket,
			'estadoticket' => 'Atencion',
			'usuario_id' => $this->Auth->user('id'));
		

		if ($this->Ticket->saveAll($datos)) {
			//Guardado exitoso

		}else{

			$this->Flash->error(__('Error al cambiar el estado de del ticket a atencion.'));

		}

		

	}//Fin cambiar ticket a atencion


	//Funcion para cambiar el estado de un ticket a Facturado
	public function cambiar_ticket_a_facturado($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado en cambiar ticket a atencion", 1);
		}

		$datos = array('id' => $idTicket, 'estadoticket' => 'Facturado');
		

		if ($this->Ticket->saveAll($datos)) {
			//Guardado exitoso

		}else{

			$this->Flash->error(__('Error al cambiar el estado de del ticket a facturado.'));

		}

		

	}//Fin cambiar ticket a facturado


	//Funcion para cambiar el estado de un ticket a Por pagar
	public function cambiar_ticket_a_porpagar($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado en cambiar ticket a por pagar", 1);
		}

		$datos = array(
			'id' => $idTicket, 
			'estadoticket' => 'Por pagar',
			'usuario_id' => '');
		

		if ($this->Ticket->saveAll($datos)) {
			
			return true;

		}else{

			return false;
		}

	}//Fin cambiar ticket a espera

	//Funcion para cambiar el estado de un ticket a pagado
	public function cambiar_ticket_a_pagado($idTicket = null) {

		//Buscamos el turno activo
		$this->loadModel('TurnoCajero');
		$turnoCajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

		$idTurno = $turnoCajero['TurnoCajero']['id'];

		if ($idTurno == null) {
			throw new NotFoundException("Id del turno no encontrado en cambiar ticket a por pagar", 1);
		}

		
		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado en cambiar ticket a por pagar", 1);
		}

		$datos = array('id' => $idTicket, 'estadoticket' => 'Pagado', 'turno_cajero_id' => $idTurno);
		

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

		$datos = array('id' => $idTicket, 'estadoticket' => 'Cancelado', 'borrado' => 1);
		

		if ($this->Ticket->saveAll($datos)) {
			
			return true;

		}else{

			return false;
		}

	}//Fin cambiar ticket a cancelar






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

			$exists = $this->DetalleTicket->find('all', array('fields' => array('DetalleTicket.ticket_id', 'DetalleTicket.servicio_id'), 'conditions' => array('DetalleTicket.ticket_id' => $idTicket, 'DetalleTicket.servicio_id' => $idServicio, 'DetalleTicket.borrado' => 0)));

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
		$total_servicios = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket, 'DetalleTicket.borrado' => 0), 'fields' => array('SUM(DetalleTicket.monto) as subtotal')));
		
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

		if ($total_ticket == null) {
			$total_ticket = 0;
		}

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
				$detalles = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket, 'DetalleTicket.borrado' => 0)));

				$this->set(compact('detalles'));

				//Calculamos y enviamos el total del ticket a cobrar
				$total_ticket = $this->calcular_total_ticket($idTicket);

				$this->set('totalticket', $total_ticket);

				$this->set('idTicket', $idTicket);



				$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));

				$totalpagado = $this->Ticket->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket), 'fields' => array('ticket_id', 'SUM(DetallePago.total) as subtotal')));

				$this->set('pagado', $totalpagado);

				$conditions = array('Ticket.estadoticket' => 'Por pagar', 'Ticket.id' => $idTicket);
				$ticket = $this->Ticket->find('all', array('conditions' => $conditions, 'recursive' => 0));
				$this->set('tickets', $ticket);

								
	}//Fin function ver

	public function detalles($idTicket = null) {

		if (!$this->Ticket->exists($idTicket)) {
			throw new NotFoundException(__('Id de ticket no válido '));
		}

		if ($this->request->is('post')) {
			//debug($this->request->data);
			$formapago = $this->request->data['Ticket']['forma_pago'];
			$idTicket = $this->request->data['Ticket']['IdTicket'];

			$this->ingresar_pago($formapago, $idTicket);
		}


				//Enviamos el nombre del cliente
			$ticket = $this->Ticket->find('all', array('conditions' => array('Ticket.id' => $idTicket)));
			$this->set('tick', $ticket);

				//Buscamos y enviamos el detalle de ticket a cobrar
				$this->loadModel('DetalleTicket');
				$detalles = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket, 'DetalleTicket.borrado' => 0)));

				$this->set(compact('detalles', $detalles));

				//Calculamos y enviamos el total del ticket a cobrar
				$total_ticket = $this->calcular_total_ticket($idTicket);

				$this->set('totalticket', $total_ticket);

				$this->set('idTicket', $idTicket);



				$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));

				$totalpagado = $this->Ticket->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket), 'fields' => array('ticket_id', 'SUM(DetallePago.total) as subtotal')));

				$this->set('pagado', $totalpagado);

								
	}//Fin function detalles


	public function detalle_historico($idTicket = null) {

		if (!$this->Ticket->exists($idTicket)) {
			throw new NotFoundException(__('Id de ticket no válido '));
		}

		if ($this->request->is('post')) {
			//debug($this->request->data);
			$formapago = $this->request->data['Ticket']['forma_pago'];
			$idTicket = $this->request->data['Ticket']['IdTicket'];

			$this->ingresar_pago($formapago, $idTicket);
		}

			$ticket = $this->Ticket->find('all', array('conditions' => array('Ticket.id' => $idTicket)));
			$this->set('tick', $ticket);

				//Buscamos y enviamos el detalle de ticket a cobrar
				$this->loadModel('DetalleTicket');
				$detalles = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket, 'DetalleTicket.borrado' => 0)));

				$this->set(compact('detalles', $detalles));

				//Calculamos y enviamos el total del ticket a cobrar
				$total_ticket = $this->calcular_total_ticket($idTicket);

				$this->set('totalticket', $total_ticket);

				$this->set('idTicket', $idTicket);



				$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));

				$totalpagado = $this->Ticket->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket), 'fields' => array('ticket_id', 'SUM(DetallePago.total) as subtotal')));

				$this->set('pagado', $totalpagado);

								
	}//Fin function detalle_historico

	//Procesar cobro de un ticket
	public function procesar_ticket($idTicket = null) {

		if ($idTicket == null) {
			throw new NotFoundException("Id de ticket no recibido para procesar pago", 1);
		}

		$resultado = $this->cambiar_ticket_a_pagado($idTicket);
		//$resultado = true;
		if ($resultado == true) {
			$this->Flash->success(__('Ticket procesado exitosamente.'));

			//Averiguamos como se estan evaluando las facturas si por tickets o por monto en bolivares
			$this->loadModel('Configuration');
			$tipo = $this->Configuration->query("SELECT tipo FROM configurations");
			//debug($tipo);

			if ($tipo == null) {
				throw new NotFoundException("No ha sido configurada la frecuencia de la facturación", 1);
			}

			$tipo = $tipo[0]['configurations']['tipo'];

			if ($tipo == 'TICKETS') {
				$medida = $this->Configuration->query("SELECT ticket FROM configurations");
				$medida = $medida[0]['configurations']['ticket'];
			}else{
				if($tipo == 'MONTO'){
					$medida = $this->Configuration->query("SELECT monto FROM configurations");
					$medida = $medida[0]['configurations']['monto'];
				}
			}
			//debug($tipo);
			//debug($medida);
			//VERIFICAMOS SI ES MOMENTO DE FACTURAR LOS TICKETS
			$resultado = $this->verificar_si_facturar($tipo, $medida);
			//debug($resultado);
			if ($resultado == 'FACTURAR') {
				$this->Flash->facturar(__('ES MOMENTO DE EMITIR UNA FACTURA...'));
			}


			return $this->redirect(array('controller' => 'tickets', 'action' => 'caja'));
		}else{
			$this->Flash->error(__('Ticket no procesado.'));
		}

		//$this->autoRender = false;
	}//Fin cobrar ticket

	public function verificar_si_facturar($tipo = null, $medida = null){

		if ($tipo == null || $medida == null) {
			throw new NotFoundException("El tipo de consulta no pudo ser hallado", 1);
			
		}

		if ($tipo == 'TICKETS') {
			$tickets = $this->Ticket->query(
			"SELECT COUNT(tickets.id) AS CANTIDAD 
			FROM tickets, turno_cajeros
			WHERE tickets.estadoticket = 'Pagado'
			AND tickets.turno_cajero_id = turno_cajeros.id");
			
			$tickets = $tickets[0][0]['CANTIDAD'];
			//debug($tickets);
			//debug($medida);
			if ($tickets >= $medida) {
				$resultado = 'FACTURAR'; 	
			} else {
				$resultado = 'NO FACTURAR';
			}	

		}else{


		$this->loadModel('DetalleTicket');

		$monto = $this->DetalleTicket->query("SELECT SUM(dt.monto) AS total FROM detalle_tickets dt 
			INNER JOIN tickets tick ON (dt.ticket_id = tick.id) 
			INNER JOIN turno_cajeros tc ON(tc.estadoturno = 'A') 
			WHERE tick.estadoticket = 'Pagado'");
		
		$monto = $monto[0][0]['total'];
		//debug($monto);
		if ($monto >= $medida) {
				$resultado = 'FACTURAR';
			}else{
				$resultado = 'NO FACTURAR';
			}

		}

		return $resultado;

	}


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

	public function add()
{

}


	public function tabla_caja() {
		$this->layout = 'ajax';
			$this->Ticket->recursive = 0;

			$conditions = array('Ticket.estadoticket' => array('Por pagar'));
			$ticket = $this->Ticket->find('all', array('conditions' => $conditions));
			$this->set('tickets', $ticket);
	}

	public function tabla_administrar() {
		$this->layout = 'ajax';
			$this->Ticket->recursive = 0;

			$conditions = array('Ticket.estadoticket' => array('Por pagar'));
			$ticket = $this->Ticket->find('all', array('conditions' => $conditions));
			$this->set('tickets', $ticket, $this->Paginator->paginate());
	}


	public function facturar(){

		if ($this->request->is('post')) {
			# code...
		}

		$this->loadModel('Servicio');
		$datos_a_facturar = $this->Servicio->query(
			"SELECT tservicios.nombretipo AS tipo, SUM(detalle_tickets.monto) AS total
				FROM tickets, detalle_tickets, servicios, usuarios, turno_cajeros, tservicios
				WHERE tservicios.id = servicios.tservicio_id
                AND servicios.id = detalle_tickets.servicio_id
				AND detalle_tickets.ticket_id = tickets.id
				AND detalle_tickets.borrado = 0
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id
				AND tickets.estadoticket = 'Pagado'
				AND turno_cajeros.estadoturno = 'A'
				GROUP BY tservicios.nombretipo");

		$this->set('datos', $datos_a_facturar);

		$total = $this->Servicio->query(
			"SELECT SUM(detalle_tickets.monto) AS total
			FROM servicios, detalle_tickets, tickets, usuarios, turno_cajeros 
			WHERE detalle_tickets.servicio_id = servicios.id 
			AND detalle_tickets.ticket_id = tickets.id 
			AND detalle_tickets.borrado = 0
			AND tickets.turno_cajero_id = turno_cajeros.id 
			AND turno_cajeros.usuario_id = usuarios.id 
			AND turno_cajeros.estadoturno = 'A' 
			AND tickets.estadoticket = 'Pagado'");

		$this->set('total', $total);

	}


	public function tickets_facturas($idTicket = null, $idCierre = null) {

		if (!$this->Ticket->exists($idTicket)) {
			throw new NotFoundException(__('Id de ticket no válido '));
		}

		if ($this->request->is('post')) {
			//debug($this->request->data);
			$formapago = $this->request->data['Ticket']['forma_pago'];
			$idTicket = $this->request->data['Ticket']['IdTicket'];

			$this->ingresar_pago($formapago, $idTicket);
		}

			$ticket = $this->Ticket->find('all', array('conditions' => array('Ticket.id' => $idTicket)));
			$this->set('tick', $ticket);

				//Buscamos y enviamos el detalle de ticket a cobrar
				$this->loadModel('DetalleTicket');
				$detalles = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket, 'DetalleTicket.borrado' => 0)));

				$this->set(compact('detalles', $detalles));

				//Calculamos y enviamos el total del ticket a cobrar
				$total_ticket = $this->calcular_total_ticket($idTicket);

				$this->set('totalticket', $total_ticket);

				$this->set('idTicket', $idTicket);



				$totaltickets = $this->DetalleTicket->find('all', array('fields' => array('ticket_id', 'SUM(DetalleTicket.monto) as subtotal'), 'group' => array('DetalleTicket.ticket_id')));

				$totalpagado = $this->Ticket->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket), 'fields' => array('ticket_id', 'SUM(DetallePago.total) as subtotal')));

				$this->set('pagado', $totalpagado);

				$this->set('idcierre', $idCierre);

								
	}//Fin function tickets_facturas


} //FIN CLASE
