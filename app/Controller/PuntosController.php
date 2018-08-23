<?php
App::uses('AppController', 'Controller');
/**
 * Puntos Controller
 *
 * @property Punto $Punto
 * @property PaginatorComponent $Paginator
 */
class PuntosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public function isAuthorized($usuario)
	{

	
		if ($usuario['privilegio_id'] == '4') {

			
				if (in_array($this->action, array('pago_punto'))) {
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
		$this->Punto->recursive = 0;
		$this->set('puntos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Punto->exists($id)) {
			throw new NotFoundException(__('Invalid punto'));
		}
		$options = array('conditions' => array('Punto.' . $this->Punto->primaryKey => $id));
		$this->set('punto', $this->Punto->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Punto->exists($id)) {
			throw new NotFoundException(__('Invalid punto'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Punto->save($this->request->data)) {
				$this->Flash->success(__('The punto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The punto could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Punto.' . $this->Punto->primaryKey => $id));
			$this->request->data = $this->Punto->find('first', $options);
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
		$this->Punto->id = $id;
		if (!$this->Punto->exists()) {
			throw new NotFoundException(__('Invalid punto'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Punto->delete()) {
			$this->Flash->success(__('The punto has been deleted.'));
		} else {
			$this->Flash->error(__('The punto could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}




	//Funcion que guarda el pago realizado por un punto
	public function pago_punto($idTicket = null){

		if ($idTicket == null) {
			throw new NotFoundException("Forma de pago o id del ticket no encontrado", 1);
		}

		if ($this->request->is('post')) {

			if ($this->request->data['Punto']['monto'] > 0) {
				
				$this->Punto->create();
				if ($this->Punto->save($this->request->data)) {

					//Obtenemos id del punto
					$datos = $this->Punto->find('first', array('order' => 'Punto.id DESC'));
					$idPunto = $datos['Punto']['id'];
					$monto = $datos['Punto']['monto'];

					//Guardamos el id en detallepago
					
					$this->redirect(array('controller' => 'detallePagos', 'action' => 'addPunto', $idTicket, $idPunto, $monto));


					$this->Flash->success(__('El pago por el punto ha sido exitoso.'));
					return $this->redirect(array('controller' => 'tickets', 'action' => 'ver', $idTicket));
				} else {
					$this->Flash->error(__('El pago por el punto no pudo ser realizado.'));
				}

			}else {
				$this->Flash->error(__('El monto a pagar debe ser mayor a cero.'));
			}
		}

		$this->loadModel('Bancopunto');
		$bancopuntos = $this->Bancopunto->find('list');
		$this->set(compact('bancopuntos'));

		//Buscando monto del ticket
		$this->loadModel('Ticket');
		$monto = $this->Ticket->find('first',  array('conditions' => array('Ticket.id' => $idTicket), 'fields' => array('Ticket.montoticket')));

		$this->set('idTicket', $idTicket);

		$total = $monto['Ticket']['montoticket'];

		$totalpagado = $this->Ticket->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket), 'fields' => array('ticket_id', 'SUM(DetallePago.total) as subtotal')));

		$totalpagado = $totalpagado[0][0]['subtotal'];

		$porpagar = $total - $totalpagado;

		$this->set('porpagar', $porpagar);



	}//Fin de funcion que guarda el pago realizado por un punto

}//Fin clase
