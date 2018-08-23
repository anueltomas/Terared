<?php
App::uses('AppController', 'Controller');
/**
 * Configurations Controller
 *
 * @property Configuration $Configuration
 * @property PaginatorComponent $Paginator
 */
class ConfigurationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$datos = $this->Configuration->find('all');
		if ($datos != null) {
			$this->set('datos', $datos);
		}else{
			$this->redirect(array('action' => 'add'));
		}


	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Configuration->exists($id)) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		$options = array('conditions' => array('Configuration.' . $this->Configuration->primaryKey => $id));
		$this->set('configuration', $this->Configuration->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			if ($this->request->data['opcion'] == 'ticket') {
				$datos = array('ticket' => $this->request->data['ticket'], 'tipo' => 'TICKETS');
			} else {
				$datos = array('monto' => $this->request->data['ticket'], 'tipo' => 'MONTO');
			}
			$this->Configuration->create();
			if ($this->Configuration->save($datos)) {
				$this->Flash->success(__('La Frecuencia de facturación ha sido guardada exitosamente.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('La Frecuencia de facturación no pudo ser guardada'));
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
		if (!$this->Configuration->exists($id)) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->request->data['opcion'] == 'ticket') {
				$datos = array('ticket' => $this->request->data['cantidad'], 'tipo' => 'TICKETS', 'id' => $this->request->data['id']);
			} else {
				$datos = array('monto' => $this->request->data['monto'], 'tipo' => 'MONTO', 'id' => $this->request->data['id']);
			}
			if ($this->Configuration->save($datos)) {
				$this->Flash->success(__('La Frecuencia de facturación ha sido guardada exitosamente'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('La Frecuencia de facturación no pudo ser guardada'));
			}
		}
		$options = array('conditions' => array('Configuration.' . $this->Configuration->primaryKey => $id));
			$this->request->data = $this->Configuration->find('first', $options);
		//debug($this->request->data);
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Configuration->delete()) {
			$this->Flash->success(__('The configuration has been deleted.'));
		} else {
			$this->Flash->error(__('The configuration could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
