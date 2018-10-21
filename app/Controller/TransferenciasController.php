<?php
App::uses('AppController', 'Controller');
/**
 * Transferencias Controller
 *
 * @property Transferencia $Transferencia
 * @property PaginatorComponent $Paginator
 */
class TransferenciasController extends AppController {

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

			
				if (in_array($this->action, array('pago_transferencia'))) {
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
		$this->Transferencia->recursive = 0;
		$this->set('transferencias', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Transferencia->exists($id)) {
			throw new NotFoundException(__('Invalid transferencia'));
		}
		$options = array('conditions' => array('Transferencia.' . $this->Transferencia->primaryKey => $id));
		$this->set('transferencia', $this->Transferencia->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Transferencia->create();
			if ($this->Transferencia->save($this->request->data)) {
				$this->Flash->success(__('The transferencia has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The transferencia could not be saved. Please, try again.'));
			}
		}
		$bancos = $this->Transferencia->Banco->find('list');
		$this->set(compact('bancos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Transferencia->exists($id)) {
			throw new NotFoundException(__('Invalid transferencia'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Transferencia->save($this->request->data)) {
				$this->Flash->success(__('The transferencia has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The transferencia could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Transferencia.' . $this->Transferencia->primaryKey => $id));
			$this->request->data = $this->Transferencia->find('first', $options);
		}
		$bancos = $this->Transferencia->Banco->find('list');
		$this->set(compact('bancos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Transferencia->id = $id;
		if (!$this->Transferencia->exists()) {
			throw new NotFoundException(__('Invalid transferencia'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Transferencia->delete()) {
			$this->Flash->success(__('The transferencia has been deleted.'));
		} else {
			$this->Flash->error(__('The transferencia could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	//Funcion que guarda el pago realizado por un punto
	public function pago_transferencia($idTicket = null){

		if ($idTicket == null) {
			throw new NotFoundException("Forma de pago o id del ticket no encontrado", 1);
		}

		if ($this->request->is('post')) {

			if ($this->request->data['Transferencia']['monto'] > 0) {
				
				$this->Transferencia->create();
				if ($this->Transferencia->save($this->request->data)) {

					//Obtenemos id del punto
					$datos = $this->Transferencia->find('first', array('order' => 'Transferencia.id DESC'));
					$idTransferencia = $datos['Transferencia']['id'];
					$monto = $datos['Transferencia']['monto'];

					//Guardamos el id en detallepago
					
					$this->redirect(array('controller' => 'detallePagos', 'action' => 'addTransferencia', $idTicket, $idTransferencia, $monto));


					$this->Flash->success(__('El pago por transferencia ha sido exitoso.'));
					return $this->redirect(array('controller' => 'tickets', 'action' => 'ver', $idTicket));
				} else {
					$this->Flash->error(__('El pago por Transferencia no pudo ser realizado.'));
				}

			}else {
				$this->Flash->error(__('El monto a pagar debe ser mayor a cero.'));
			}
		}

		$this->loadModel('Banco');
		$bancos = $this->Banco->find('list');
		$this->set(compact('bancos'));

		//Buscando monto del ticket
		$this->loadModel('Ticket');
		$monto = $this->Ticket->find('first',  array('conditions' => array('Ticket.id' => $idTicket), 'fields' => array('Ticket.montoticket')));

		$this->set('idTicket', $idTicket);

		$total = $monto['Ticket']['montoticket'];

		$totalpagado = $this->Ticket->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket), 'fields' => array('ticket_id', 'SUM(DetallePago.total) as subtotal')));

		$totalpagado = $totalpagado[0][0]['subtotal'];

		$porpagar = $total - $totalpagado;

		$this->set('porpagar', $porpagar);



	}//Fin de funcion que guarda el pago realizado por transferencia


}//Fin clase
