<?php
App::uses('AppController', 'Controller');
/**
 * Facturas Controller
 *
 * @property Factura $Factura
 * @property PaginatorComponent $Paginator
 */
class FacturasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

public function isAuthorized($usuario)
	{

		$privilegio = $this->Session->read('privilegio_id');


		if ($privilegio == '4') {

			
				if (in_array($this->action, array('add', 'factura_simple'))) {
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
		$this->Factura->recursive = 0;
		$this->set('facturas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Factura->exists($id)) {
			throw new NotFoundException(__('Invalid factura'));
		}
		$options = array('conditions' => array('Factura.' . $this->Factura->primaryKey => $id));
		$this->set('factura', $this->Factura->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Factura->create();
			if ($this->Factura->save($this->request->data)) {

				$idFactura = $this->Factura->find('first', array('fields' => 'id', 'order' => array('id' => 'DESC')));
				$idFactura = $idFactura['Factura']['id'];
				
				//Guardamos el id de la factura en los tickets
				//Buscando todos los tickets
				$this->loadModel('Ticket');

				$tickets = $this->Ticket->query(
					"SELECT * FROM tickets, usuarios, turno_cajeros
						WHERE tickets.estadoticket = 'Pagado'
						AND tickets.turno_cajero_id = turno_cajeros.id
						AND turno_cajeros.usuario_id = usuarios.id
						AND tickets.estadoticket = 'Pagado'
						AND turno_cajeros.estadoturno = 'A'	
						");
				
				foreach ($tickets as $ticket) {
					$idTicket = $ticket['tickets']['id'];

					$datos = array('id' => $idTicket, 'factura_id' => $idFactura, 'estadoticket' => 'Facturado');

					if ($this->Ticket->save($datos)) {
						
					}else{

						throw new Exception("Error al guardar los datos en FacturasController->add", 1);
						
					}
				}

				
				$this->Flash->success(__('La factura fué ingresada exitosamente.'));
				return $this->redirect(array('controller' => 'tickets', 'action' => 'caja'));

				
				
			} else {
				$this->Flash->error(__('La Factura no pudo ser guardada.'));
			}
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
			AND tickets.estadoticket = 'Pagado' "
			);

		$this->set('total', $total);

		$facturas = $this->Factura->find('first', array('fields', array('Factura.nfactura'), 'order' => array('Factura.id' =>'desc')));

		if(empty($facturas)){
			$facturas = 9945;
		}else{
			$facturas = $facturas['Factura']['nfactura'];
		}

		$this->set('facturaanterior', $facturas);

		
	}


	//Funcion para facturar un solo ticket
	public function factura_simple($id = null){

		$this->loadModel('Ticket');

		if (!$this->Ticket->exists($id)) {
			throw new NotFoundException(__('Id del ticket no encontrado'));
		}

		$id_ticket = $id;

		if ($this->request->is('post')) {
			$this->Factura->create();
			if ($this->Factura->save($this->request->data)) {

				$idFactura = $this->Factura->find('first', array('fields' => 'id', 'order' => array('id' => 'DESC')));
				$idFactura = $idFactura['Factura']['id'];
				
				//Guardamos el id de la factura en los tickets

				//Buscando todos los tickets
				$tickets = $this->Ticket->query(
					"SELECT * FROM tickets, usuarios, turno_cajeros
						WHERE tickets.estadoticket = 'Pagado'
						AND tickets.turno_cajero_id = turno_cajeros.id
						AND turno_cajeros.usuario_id = usuarios.id
						AND tickets.estadoticket = 'Pagado'
						AND turno_cajeros.estadoturno = 'A'
						AND tickets.id = $id_ticket
						");
				
				foreach ($tickets as $ticket) {
					$idTicket = $ticket['tickets']['id'];

					$datos = array('id' => $idTicket, 'factura_id' => $idFactura, 'estadoticket' => 'Facturado');

					if ($this->Ticket->save($datos)) {
						
					}else{

						throw new Exception("Error al guardar los datos en FacturasController->add", 1);
						
					}
				}

				
				$this->Flash->success(__('La factura fué ingresada exitosamente.'));
				return $this->redirect(array('controller' => 'tickets', 'action' => 'caja'));

				
				
			} else {
				$this->Flash->error(__('La Factura no pudo ser guardada.'));
			}
		}

		$this->loadModel('Servicio');
		$datos_a_facturar = $this->Servicio->query(
			"SELECT tservicios.nombretipo AS tipo, SUM(detalle_tickets.monto) AS total
				FROM tickets, detalle_tickets, servicios, usuarios, turno_cajeros, tservicios
				WHERE tservicios.id = servicios.tservicio_id
                AND servicios.id = detalle_tickets.servicio_id
				AND detalle_tickets.ticket_id = tickets.id
				AND detalle_tickets.ticket_id = $id_ticket
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id
				AND tickets.estadoticket = 'Pagado'
				AND turno_cajeros.estadoturno = 'A'
				AND detalle_tickets.borrado = 0
				GROUP BY tservicios.nombretipo");

		$this->set('datos', $datos_a_facturar);

		$total = $this->Servicio->query(
			"SELECT SUM(detalle_tickets.monto) AS total
			FROM servicios, detalle_tickets, tickets, usuarios, turno_cajeros 
			WHERE detalle_tickets.servicio_id = servicios.id 
			AND detalle_tickets.ticket_id = tickets.id 
			AND detalle_tickets.ticket_id = $id_ticket
			AND tickets.turno_cajero_id = turno_cajeros.id 
			AND turno_cajeros.usuario_id = usuarios.id 
			AND turno_cajeros.estadoturno = 'A' 
			AND tickets.estadoticket = 'Pagado'
			AND detalle_tickets.borrado = 0"
			);

		$this->set('total', $total);

		$facturas = $this->Factura->find('first', array('fields', array('Factura.nfactura'), 'order' => array('Factura.id' =>'desc')));

		if(empty($facturas)){
			$facturas = 9945;
		}else{
			$facturas = $facturas['Factura']['nfactura'];
		}

		$this->set('facturaanterior', $facturas);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Factura->exists($id)) {
			throw new NotFoundException(__('Invalid factura'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Factura->save($this->request->data)) {
				$this->Flash->success(__('The factura has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The factura could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Factura.' . $this->Factura->primaryKey => $id));
			$this->request->data = $this->Factura->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Factura->id = $id;
		if (!$this->Factura->exists()) {
			throw new NotFoundException(__('Invalid factura'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Factura->delete()) {
			$this->Flash->success(__('The factura has been deleted.'));
		} else {
			$this->Flash->error(__('The factura could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
