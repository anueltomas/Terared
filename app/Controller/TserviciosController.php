<?php
App::uses('AppController', 'Controller');
/**
 * Tservicios Controller
 *
 * @property Tservicio $Tservicio
 * @property PaginatorComponent $Paginator
 */
class TserviciosController extends AppController {

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
		$this->Tservicio->recursive = 0;
		$this->set('tservicios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tservicio->exists($id)) {
			throw new NotFoundException(__('Invalid tservicio'));
		}
		$options = array('conditions' => array('Tservicio.' . $this->Tservicio->primaryKey => $id));
		$this->set('tservicio', $this->Tservicio->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tservicio->create();
			if ($this->Tservicio->save($this->request->data)) {
				$this->Flash->success(__('Tipo de servicio creado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('El tipo de servicio no pudo ser creado.'));
			}
		}
	}

	public function nuevo() {
		if ($this->request->is('post')) {
			$this->Tservicio->create();
			if ($this->Tservicio->save($this->request->data)) {
				$this->Flash->success(__('Tipo de servicio creado.'));
				return $this->redirect(array('controller' => 'servicios', 'action' => 'add'));
			} else {
				$this->Flash->error(__('El tipo de servicio no pudo ser creado.'));
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
		if (!$this->Tservicio->exists($id)) {
			throw new NotFoundException(__('Invalid tservicio'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tservicio->save($this->request->data)) {
				$this->Flash->success(__('The tservicio has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tservicio could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tservicio.' . $this->Tservicio->primaryKey => $id));
			$this->request->data = $this->Tservicio->find('first', $options);
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
		$this->Tservicio->id = $id;
		if (!$this->Tservicio->exists()) {
			throw new NotFoundException(__('Invalid tservicio'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Tservicio->delete()) {
			$this->Flash->success(__('The tservicio has been deleted.'));
		} else {
			$this->Flash->error(__('The tservicio could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	

}
