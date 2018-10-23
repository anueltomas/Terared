<?php
App::uses('AppController', 'Controller');
/**
 * Cierres Controller
 *
 * @property Cierre $Cierre
 * @property PaginatorComponent $Paginator
 */
class CierresController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

public $paginate = array(

		'limit' => 10,
		'order' => array(
			'Cierre.id' => 'DESC'
			)
		);


public function principal() {

		$this->Paginator->settings = array(
				'order' => array('Cierre.id' => 'DESC'),
				'limit' => 10
				);
			$modelos = $this->Cierre;
			$datos = $this->Paginator->paginate($modelos);
			$this->set('cierres', $datos);


		

		//$cierres = $this->Cierre->find('all', array('order' => array('Cierre.id' => 'DESC'), 'recursive' => -1));
		//$ticket = $this->Ticket->find('all', array('conditions' => array('Pagado'), 'order' => array('Ticket.modified' => 'DESC')));
		//$this->set('cierres', $cierres);
	}



	public function detalle($idCierre = null){

		if ($idCierre == null) {
			throw new NotFoundException("No se encuentra el id del cierre", 1);
			
		}

		$this->loadModel('TurnoCajero');

		$turnos = $this->TurnoCajero->find('all', array('conditions' => array('TurnoCajero.cierre_id' => $idCierre), 'recursive' => 1));
		$this->set('turnos', $turnos);

		$this->set('idcierre', $idCierre);

	}



	public function isAuthorized($usuario)
	{

		$privilegio = $this->Session->read('privilegio_id');


		if ($privilegio == '4') {

			
				if (in_array($this->action, array('add', 'index', 'edit', 'calcular'))) {
				return true;
				}
						
			}

				
		return parent::isAuthorized($usuario);

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cierre->recursive = 0;
		$this->set('cierres', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cierre->exists($id)) {
			throw new NotFoundException(__('Invalid cierre'));
		}
		$options = array('conditions' => array('Cierre.' . $this->Cierre->primaryKey => $id));
		$this->set('cierre', $this->Cierre->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($idTurno = null) {

		//BUSCAMOS EL CAJERO ACTUAL
		$this->loadModel('TurnoCajero');
		$idCajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

		$idCajero = $idCajero['TurnoCajero']['usuario_id'];
		

		if ($idTurno == null) {
			throw new NotFoundException("Error con el id del turno", 1);
			
		}

		if ($this->request->is('post')) {

			$datos = array(
				'id' => $idTurno,
				'montoturno' => $this->request->data['Cierre']['montoturno'],
				'observaciones' => $this->request->data['Cierre']['nota'],
				'estadoturno' => 'C');

			//debug($this->request->data);


			if ($this->TurnoCajero->save($datos)) {


				$dats = array('id' => $this->request->data['Cierre']['idCaja'],
								'montocierre' => $this->request->data['Cierre']['dia_mas_turno']);
			
				if ($this->Cierre->save($dats)) {

					$this->Flash->success(__('Los datos fueron guardados exitosamente.'));
					return $this->redirect(array('controller' => 'principal', 'action' => 'index'));

				} else {
					
					$this->Flash->error(__('El turno no pudo ser cerrado.'));
				}

				
			} else {
				$this->Flash->error(__('Los datos no pudieron ser guardados.'));
			}

		}
		 //BUSCANDO EL ID DEL TURNO
		$this->loadModel('TurnoCajero');
		$idTurno = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

		$idTurno = $idTurno['TurnoCajero']['id'];

		$this->set('turno', $idTurno);

		$this->loadModel('Factura');
		$inicioFactura = $this->Factura->query("SELECT facturas.nfactura FROM facturas, tickets, usuarios, turno_cajeros 
				WHERE facturas.id = tickets.factura_id
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND usuarios.id = turno_cajeros.usuario_id
				AND turno_cajeros.estadoturno = 'A'
				AND turno_cajeros.usuario_id = $idCajero
				ORDER BY facturas.id ASC
				LIMIT 1");

		$finFactura = $this->Factura->query("SELECT facturas.nfactura FROM facturas, tickets, usuarios, turno_cajeros 
				WHERE facturas.id = tickets.factura_id
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND usuarios.id = turno_cajeros.usuario_id
				AND usuarios.id = $idCajero
				AND turno_cajeros.estadoturno = 'A'
				ORDER BY facturas.id DESC
				LIMIT 1");

		$Facturas = array('inicio' => $inicioFactura, 'fin' => $finFactura);
		$this->set('facturas', $Facturas);



		$monto_del_dia = $this->Cierre->find('first', array('fields' => array('id', 'Cierre.montocierre'), 'conditions' => array('Cierre.estadocierre' => 'A'), 'recursive' => -1));

		if (empty($monto_del_dia)) {
			$this->Flash->error('La caja no se encuentra abierta');
			return $this->redirect(array('controller' => 'tickets', 'action' => 'administrar_caja'));
		}

		$this->set('montoanterior', $monto_del_dia);

		$privilegio = $this->Session->read('privilegio_id');

		if ($privilegio != 4) {

			$this->loadModel('TurnoCajero');
			$idcajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));
			
			if($idcajero != null){
				$idCajero = $idcajero['TurnoCajero']['usuario_id'];
			
				$this->loadModel('Usuario');
				$datosCajero = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $idCajero)));

				$this->set('datosCajero', $datosCajero);
			}else {
				$idCajero = null;
			}
			
			

		} else {

			$idCajero = $this->Auth->user('id');

			$this->loadModel('TurnoCajero');
			$idcajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A', 'TurnoCajero.usuario_id' => $idCajero)));
			
			if($idcajero != null){
				$idCajero = $idcajero['TurnoCajero']['usuario_id'];
			
				$this->loadModel('Usuario');
				$datosCajero = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $idCajero)));

				$this->set('datosCajero', $datosCajero);
			}else {
				$idCajero = null;
			}

		}
		
		if($idCajero != null){
			//debug($idCajero);
			$this->loadModel('DetallePago');
			//EFECTIVO
			$efectivo = $this->DetallePago->query("SELECT SUM(detalle_pagos.total) AS EFECTIVO FROM detalle_pagos, efectivos, tickets, usuarios, turno_cajeros WHERE efectivos.id = detalle_pagos.efectivo_id AND tickets.id = detalle_pagos.ticket_id AND tickets.turno_cajero_id = turno_cajeros.id AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero AND turno_cajeros.estadoturno = 'A' "); 

			$this->set('efectivo', $efectivo);

			//POR CADA PUNTO
			$puntos = $this->DetallePago->query("SELECT bancopuntos.nombre, SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos,puntos, tickets, usuarios, turno_cajeros, bancopuntos 
				WHERE bancopuntos.id = puntos.bancopunto_id
				AND puntos.id = detalle_pagos.punto_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero
				AND turno_cajeros.estadoturno = 'A' 
				GROUP BY bancopuntos.nombre"); 

			$this->set('cadaPunto', $puntos);



			//TOTAL EN PUNTOS
			$punto = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS PUNTOS
				FROM detalle_pagos,puntos, tickets, usuarios, turno_cajeros
				WHERE puntos.id = detalle_pagos.punto_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('puntos', $punto);


			//POR TRANSFERENCIAS
			$transferencia = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TRANSFERENCIAS
				FROM detalle_pagos, transferencias, tickets, usuarios, turno_cajeros
				WHERE transferencias.id = detalle_pagos.transferencia_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('transferencias', $transferencia);


			//GASTOS
			$this->loadModel('Gasto');
			$gastos = $this->Gasto->query("SELECT  SUM(gastos.montogasto) AS GASTOS
				FROM gastos, usuarios, turno_cajeros
				WHERE usuarios.id = $idCajero
				AND turno_cajeros.usuario_id = usuarios.id
				AND gastos.turno_cajero_id = turno_cajeros.id AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('gastos', $gastos);


			//TOTAL INGRESOS
			$total = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos, tickets, usuarios, turno_cajeros
				WHERE tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id 
				AND usuarios.id = $idCajero AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('total', $total);

			$NoHayDatos = null;

			$this->set('NoHayDatos', $NoHayDatos);
			
		} else {
			$NoHayDatos = 'NoHayDatos';
			
			$this->set('NoHayDatos', $NoHayDatos);

			$this->set('datosCajero', $idCajero);


		}


	}//FIN FUNCTION ADD

public function calcular()
{
	$this->autoRender = false;
}


/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Cierre->exists($id)) {
			throw new NotFoundException(__('Invalid cierre'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cierre->save($this->request->data)) {
				$this->Flash->success(__('The cierre has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The cierre could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cierre.' . $this->Cierre->primaryKey => $id));
			$this->request->data = $this->Cierre->find('first', $options);
		}
		$turnoCajeros = $this->Cierre->TurnoCajero->find('list');
		$this->set(compact('turnoCajeros'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cierre->id = $id;
		if (!$this->Cierre->exists()) {
			throw new NotFoundException(__('Invalid cierre'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Cierre->delete()) {
			$this->Flash->success(__('The cierre has been deleted.'));
		} else {
			$this->Flash->error(__('The cierre could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

		public function ver($idTurno = null, $idcierre = null) {

		if ($idTurno === null || $idcierre === null) {
			throw new NotFoundException("No se encuentra el id del cierre o el id del turno", 1);
			
		}

		$this->set('idcierre', $idcierre);
		$this->set('idturno', $idTurno);

		//FACTURAS EMITIDAS
		$this->loadModel('Factura');
		$maxFactura = $this->Factura->query("SELECT MAX(facturas.nfactura) AS MAX FROM facturas, tickets, turno_cajeros, cierres
			WHERE facturas.id = tickets.factura_id
			AND tickets.turno_cajero_id = turno_cajeros.id
			AND turno_cajeros.id = $idTurno");

		$minFactura = $this->Factura->query("SELECT MIN(facturas.nfactura) AS MIN FROM facturas, tickets, turno_cajeros, cierres
			WHERE facturas.id = tickets.factura_id
			AND tickets.turno_cajero_id = turno_cajeros.id
			AND turno_cajeros.id = $idTurno");

		$this->set('maxFactura', $maxFactura);
		$this->set('minFactura', $minFactura);

		//BUSCAMOS DATOS DEL TURNO
		$this->loadModel('TurnoCajero');
			$turno = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.id' => $idTurno)));

			$this->set('datosTurno', $turno);
			//debug($cierre);

			$idUsuario = $turno['TurnoCajero']['usuario_id'];
			$idTurno = $turno['TurnoCajero']['id'];

			//$this->loadModel('TurnoCajero');
			//$turno = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.id' => $idTurno)));

			//$this->set('datosTurno', $turno);
			
			//BUSCAMOS EL MONTO DEL REPORTEX/Z ANTERIOR


			/*$this->loadModel('TurnoCajero');
			$cierreAnterior = $this->TurnoCajero->query("SELECT MAX(cierres.totalzx) AS 'anterior' FROM turno_cajeros WHERE cierres.id < $idCierre");
			$this->set('cierreAnterior', $cierreAnterior);*/

		if($idUsuario != null){
							
				$this->loadModel('Usuario');
				$datosCajero = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $idUsuario)));

				$this->set('datosCajero', $datosCajero);

			}else {
				$idUsuario = null;
			}


		if($idUsuario != null){
		$this->loadModel('DetallePago');
			//EFECTIVO
			$efectivo = $this->DetallePago->query("SELECT SUM(detalle_pagos.total) AS EFECTIVO FROM detalle_pagos, efectivos, tickets, usuarios, turno_cajeros WHERE efectivos.id = detalle_pagos.efectivo_id AND tickets.id = detalle_pagos.ticket_id AND tickets.turno_cajero_id = turno_cajeros.id AND turno_cajeros.usuario_id = usuarios.id AND turno_cajeros.id = $idTurno AND tickets.borrado = false "); 

			$this->set('efectivo', $efectivo);

			//POR CADA PUNTO
			$puntos = $this->DetallePago->query("SELECT bancopuntos.nombre, SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos,puntos, tickets, usuarios, turno_cajeros, bancopuntos 
				WHERE bancopuntos.id = puntos.bancopunto_id
				AND puntos.id = detalle_pagos.punto_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND turno_cajeros.id = $idTurno AND tickets.borrado = false
				GROUP BY bancopuntos.nombre"); 

			$this->set('cadaPunto', $puntos);



			//TOTAL EN PUNTOS
			$punto = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS PUNTOS
				FROM detalle_pagos,puntos, tickets, usuarios, turno_cajeros
				WHERE puntos.id = detalle_pagos.punto_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND tickets.borrado = false
				AND turno_cajeros.usuario_id = usuarios.id AND turno_cajeros.id = $idTurno"); 

			$this->set('puntos', $punto);


			//POR TRANSFERENCIAS
			$transferencia = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TRANSFERENCIAS
				FROM detalle_pagos, transferencias, tickets, usuarios, turno_cajeros
				WHERE transferencias.id = detalle_pagos.transferencia_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id 
				AND tickets.borrado = false
				AND turno_cajeros.usuario_id = usuarios.id AND turno_cajeros.id = $idTurno"); 

			$this->set('transferencias', $transferencia);


			//GASTOS
			$this->loadModel('Gasto');
			$gastos = $this->Gasto->query("SELECT  SUM(gastos.montogasto) AS GASTOS
				FROM gastos, usuarios, turno_cajeros
				WHERE usuarios.id = $idUsuario
				AND turno_cajeros.id = $idTurno
				AND gastos.turno_cajero_id = turno_cajeros.id"); 

			$this->set('gastos', $gastos);


			//TOTAL INGRESOS
			$total = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos, tickets, usuarios, turno_cajeros
				WHERE tickets.id = detalle_pagos.ticket_id 
				AND tickets.borrado = false
				AND tickets.turno_cajero_id = turno_cajeros.id 
				AND turno_cajeros.usuario_id = usuarios.id 
				AND turno_cajeros.id = $idTurno"); 

			$this->set('total', $total);

			$NoHayDatos = null;

			$this->set('NoHayDatos', $NoHayDatos);
			
		} else {
			$NoHayDatos = 'NoHayDatos';
			
			$this->set('NoHayDatos', $NoHayDatos);

			$this->set('datosCajero', $idCajero);

		}



		
	}

		public function tickets_cobrados($idFactura = null, $idTurno = null){

			$this->loadModel('TurnoCajero');

			$this->TurnoCajero->id = $idTurno;
			if (!$this->TurnoCajero->exists()) {
				throw new NotFoundException(__('Id de turno no válido'));
			}

			$this->loadModel('Factura');

			$this->Factura->id = $idFactura;
			if (!$this->Factura->exists()) {
				throw new NotFoundException(__('Id de factura no válido'));
			}

			//Aca se hara una consulta de todos los tickets que fueron cobrados por un cajero en un cierre en especifico

			$this->set('idturno', $idTurno);
			$this->set('idfactura', $idFactura);

			$this->loadModel('Ticket');

			$this->Paginator->settings = array(
				'conditions' => array('Ticket.factura_id' => $idFactura),
				'limit' => 10
				);
			$modelos = $this->Ticket;
			$datos = $this->Paginator->paginate($modelos);
			$this->set('tickets', $datos);

		
	}

	public function facturas_emitidas($idTurno = null){

				$this->loadModel('TurnoCajero');
			$this->TurnoCajero->id = $idTurno;
			if (!$this->TurnoCajero->exists()) {
				throw new NotFoundException(__('Id de turno no válido'));
			}

			//Buscamos a que turno pertenecen los tickets para establecer a que facturas se agregaron dichos tickets

			$this->loadModel('Factura');

			/*$this->Paginator->settings = array(
				'fields' => array('DISTINCT Factura.id', 'Factura.created', 'Factura.totalfactura'),
				'conditions' => array('Ticket.turno_cajero_id' => $turno),
				'limit' => 10
				);
			$modelos = $this->Factura->Ticket;
			$datos = $this->Paginator->paginate($modelos);
			
			*/

			$datos = $this->Factura->query("SELECT DISTINCT facturas.id, facturas.nfactura, facturas.totalfactura, facturas.created FROM facturas, tickets WHERE tickets.turno_cajero_id = $idTurno AND tickets.factura_id = facturas.id ORDER BY facturas.id ASC");
			//debug($datos);
			//$datos = $this->Paginator->paginate($datos);
			$this->set('turnos', $datos);

			$this->set('idturno', $idTurno);

	}

	public function detalle_tickets($idTicket = null, $idTurno = null, $idCierre = null){
		$this->loadModel('Ticket');
		if (!$this->Ticket->exists($idTicket)) {
			throw new NotFoundException(__('Id de ticket no válido '));
		}

		if ($this->request->is('post')) {
			//debug($this->request->data);
			$formapago = $this->request->data['Ticket']['forma_pago'];
			$idTicket = $this->request->data['Ticket']['IdTicket'];

			$this->ingresar_pago($formapago, $idTicket);
		}

			$this->set('idticket', $idTicket);

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

				$this->set('idturno', $idTurno);

				$this->set('idcierre', $idCierre);
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



}



