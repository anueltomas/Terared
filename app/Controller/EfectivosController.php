<?php
App::uses('AppController', 'Controller');
/**
 * Efectivos Controller
 *
 * @property Efectivo $Efectivo
 * @property PaginatorComponent $Paginator
 */
class EfectivosController extends AppController {

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

			
				if (in_array($this->action, array('pago_efectivo'))) {
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
		$this->Efectivo->recursive = 0;
		$this->set('efectivos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Efectivo->exists($id)) {
			throw new NotFoundException(__('Invalid efectivo'));
		}
		$options = array('conditions' => array('Efectivo.' . $this->Efectivo->primaryKey => $id));
		$this->set('efectivo', $this->Efectivo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Efectivo->create();
			if ($this->Efectivo->save($this->request->data)) {
				$this->Flash->success(__('The efectivo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The efectivo could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Efectivo->exists($id)) {
			throw new NotFoundException(__('Invalid efectivo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Efectivo->save($this->request->data)) {
				$this->Flash->success(__('The efectivo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The efectivo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Efectivo.' . $this->Efectivo->primaryKey => $id));
			$this->request->data = $this->Efectivo->find('first', $options);
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
		$this->Efectivo->id = $id;
		if (!$this->Efectivo->exists()) {
			throw new NotFoundException(__('Invalid efectivo'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Efectivo->delete()) {
			$this->Flash->success(__('The efectivo has been deleted.'));
		} else {
			$this->Flash->error(__('The efectivo could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	//Funcion que guarda el pago realizado por un punto
	public function pago_efectivo($idTicket = null){

		if ($idTicket == null) {
			throw new NotFoundException("Forma de pago o id del ticket no encontrado", 1);
		}

		if ($this->request->is('post')) {

			if ($this->request->data['Efectivo']['monto'] > 0) {
				
				$this->Efectivo->create();
				if ($this->Efectivo->save($this->request->data)) {

					//Obtenemos id del punto
					$datos = $this->Efectivo->find('first', array('order' => 'Efectivo.id DESC'));
					$idEfectivo = $datos['Efectivo']['id'];
					$monto = $datos['Efectivo']['monto'];

					//Guardamos el id en detallepago
					$this->redirect(array('controller' => 'detallePagos', 'action' => 'addEfectivo', $idTicket, $idEfectivo, $monto));


					$this->Flash->success(__('El pago por en efectivo ha sido exitoso.'));
					return $this->redirect(array('controller' => 'tickets', 'action' => 'ver', $idTicket));
				} else {
					$this->Flash->error(__('El pago por en efectivo no pudo ser realizado.'));
				}

			}else {
				$this->Flash->error(__('El monto a pagar debe ser mayor a cero.'));
			}
		}

		//Buscando monto del ticket
		$this->loadModel('Ticket');
		$monto = $this->Ticket->find('first',  array('conditions' => array('Ticket.id' => $idTicket), 'fields' => array('Ticket.montoticket')));

		$this->set('idTicket', $idTicket);

		$total = $monto['Ticket']['montoticket'];

		$totalpagado = $this->Ticket->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket), 'fields' => array('ticket_id', 'SUM(DetallePago.total) as subtotal')));

		$totalpagado = $totalpagado[0][0]['subtotal'];

		$porpagar = $total - $totalpagado;

		$this->set('porpagar', $porpagar);



	}//Fin de funcion que guarda el pago realizado por efectivo

}//Fin clase
