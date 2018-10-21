<?php
App::uses('AppController', 'Controller');
/**
 * DetallePagos Controller
 *
 * @property DetallePago $DetallePago
 * @property PaginatorComponent $Paginator
 */
class DetallePagosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function isAuthorized($usuario)
	{

		$privilegio = $this->Session->read('privilegio_id');

	
		if ($privilegio === '4') {

			
				if (in_array($this->action, array('detalle_pagos', 'addPunto', 'addEfectivo', 'addTransferencia', 'pagos'))) {
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
		$this->DetallePago->recursive = 0;
		$this->set('detallePagos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DetallePago->exists($id)) {
			throw new NotFoundException(__('Invalid detalle pago'));
		}
		$options = array('conditions' => array('DetallePago.' . $this->DetallePago->primaryKey => $id));
		$this->set('detallePago', $this->DetallePago->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function addPunto($idTicket = null, $idPunto = null, $monto = null) {

		if ($idTicket == null || $idPunto == null) {
			throw new NotFoundException("Id de ticket o id de la forma de pago no encontrado", 1);
		}

		$datosGuardar = array('ticket_id' => $idTicket, 
						'punto_id' => $idPunto, 
						'total' => $monto);
		
			$this->DetallePago->create();
			if ($this->DetallePago->saveAll($datosGuardar)) {
				$this->Flash->success(__('El Pago ha sido ingresado'));
				return $this->redirect(array('controller' => 'tickets', 'action' => 'ver', $idTicket));
			} else {
				$this->Flash->error(__('El detalle del pago no pudo ser guardado.'));
			}

			$this->autoRender = false;
		
	}//Fin addPunto





	public function addEfectivo($idTicket = null, $idEfectivo = null, $monto = null) {

		if ($idTicket == null || $idEfectivo == null) {
			throw new NotFoundException("Id de ticket o id de la forma de pago no encontrado", 1);
		}

		$datosGuardar = array('ticket_id' => $idTicket, 
						'efectivo_id' => $idEfectivo, 
						'total' => $monto);
		
			$this->DetallePago->create();
			if ($this->DetallePago->saveAll($datosGuardar)) {
				$this->Flash->success(__('El Pago ha sido ingresado'));
				return $this->redirect(array('controller' => 'tickets', 'action' => 'ver', $idTicket));
			} else {
				$this->Flash->error(__('El detalle del pago no pudo ser guardado.'));
			}

			$this->autoRender = false;


	}//Fin addEfectivo



	public function addTransferencia($idTicket = null, $idTransferencia = null, $monto = null) {

		if ($idTicket == null || $idTransferencia == null) {
			throw new NotFoundException("Id de ticket o id de la forma de pago no encontrado", 1);
		}

		$datosGuardar = array('ticket_id' => $idTicket, 
						'transferencia_id' => $idTransferencia, 
						'total' => $monto);
		
			$this->DetallePago->create();
			if ($this->DetallePago->saveAll($datosGuardar)) {
				$this->Flash->success(__('El Pago ha sido ingresado'));
				return $this->redirect(array('controller' => 'tickets', 'action' => 'ver', $idTicket));
			} else {
				$this->Flash->error(__('El detalle del pago no pudo ser guardado.'));
			}

			$this->autoRender = false;


	}//Fin addTransferencia

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DetallePago->exists($id)) {
			throw new NotFoundException(__('Invalid detalle pago'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DetallePago->save($this->request->data)) {
				$this->Flash->success(__('The detalle pago has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The detalle pago could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DetallePago.' . $this->DetallePago->primaryKey => $id));
			$this->request->data = $this->DetallePago->find('first', $options);
		}
		$tickets = $this->DetallePago->Ticket->find('list');
		$mpagos = $this->DetallePago->Mpago->find('list');
		$this->set(compact('tickets', 'mpagos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DetallePago->id = $id;
		if (!$this->DetallePago->exists()) {
			throw new NotFoundException(__('Invalid detalle pago'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DetallePago->delete()) {
			$this->Flash->success(__('The detalle pago has been deleted.'));
		} else {
			$this->Flash->error(__('The detalle pago could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

//*******----------------//////--------------************----------/////////
	public function detalle_pagos($idTicket = null){

		if ($idTicket == null) {
			throw new NotFoundException("Id de ticket no encontrado", 1);
		}

		$detalletransferencias = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.transferencia_id !=' => null)));

		$detalleefectivos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.efectivo_id !=' => null)));

		$detallepuntos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.punto_id !=' => null)));

		$this->set(compact('detalletransferencias', 'detalleefectivos', 'detallepuntos', 'idTicket'));

	}


	public function pagos($idTicket = null){

		if ($idTicket == null) {
			throw new NotFoundException("Id de ticket no encontrado", 1);
		}

		$detalletransferencias = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.transferencia_id !=' => null)));

		$detalleefectivos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.efectivo_id !=' => null)));

		$detallepuntos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.punto_id !=' => null)));

		$this->set(compact('detalletransferencias', 'detalleefectivos', 'detallepuntos', 'idTicket'));

	}

	public function pago_historico($idTicket = null, $volver = null, $idTurno = null, $idCierre = null){

		if ($idTicket == null) {
			throw new NotFoundException("Id de ticket no encontrado", 1);
		}

		$detalletransferencias = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.transferencia_id !=' => null)));

		$detalleefectivos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.efectivo_id !=' => null)));

		$detallepuntos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.punto_id !=' => null)));

		$this->set(compact('detalletransferencias', 'detalleefectivos', 'detallepuntos', 'idTicket'));

		$this->set('volver', $volver);

		$this->set('idturno', $idTurno);

		$this->set('idcierre', $idCierre);

	}


	public function historico_pago($idTicket = null){

		if ($idTicket == null) {
			throw new NotFoundException("Id de ticket no encontrado", 1);
		}

		$detalletransferencias = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.transferencia_id !=' => null)));

		$detalleefectivos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.efectivo_id !=' => null)));

		$detallepuntos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.punto_id !=' => null)));

		$this->set(compact('detalletransferencias', 'detalleefectivos', 'detallepuntos', 'idTicket'));


	}

	public function detalle_pago_factura($idTicket = null, $idCierre = null){

		if ($idTicket == null) {
			throw new NotFoundException("Id de ticket no encontrado", 1);
		}

		$detalletransferencias = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.transferencia_id !=' => null)));

		$detalleefectivos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.efectivo_id !=' => null)));

		$detallepuntos = $this->DetallePago->find('all', array('conditions' => array('DetallePago.ticket_id' => $idTicket, 'DetallePago.punto_id !=' => null)));

		$this->set(compact('detalletransferencias', 'detalleefectivos', 'detallepuntos', 'idTicket'));

		$this->set('idcierre', $idCierre);


	}




}//FIN DE LA CLASE
