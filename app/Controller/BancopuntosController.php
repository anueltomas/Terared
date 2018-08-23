<?php
App::uses('AppController', 'Controller');
/**
 * Bancopuntos Controller
 *
 * @property Bancopunto $Bancopunto
 * @property PaginatorComponent $Paginator
 */
class BancopuntosController extends AppController {

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
		$this->Bancopunto->recursive = 0;
		$puntos = $this->Bancopunto->find('all', array('conditions' => array('Bancopunto.borrado' => 0)));
		$this->set('bancopuntos', $puntos, $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Bancopunto->exists($id)) {
			throw new NotFoundException(__('Invalid bancopunto'));
		}
		$options = array('conditions' => array('Bancopunto.' . $this->Bancopunto->primaryKey => $id));
		$this->set('bancopunto', $this->Bancopunto->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Bancopunto->create();
			if ($this->Bancopunto->save($this->request->data)) {
				$this->Flash->success(__('The bancopunto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The bancopunto could not be saved. Please, try again.'));
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
		if (!$this->Bancopunto->exists($id)) {
			throw new NotFoundException(__('Invalid bancopunto'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Bancopunto->save($this->request->data)) {
				$this->Flash->success(__('The bancopunto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The bancopunto could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bancopunto.' . $this->Bancopunto->primaryKey => $id));
			$this->request->data = $this->Bancopunto->find('first', $options);
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
		$this->Bancopunto->id = $id;
		if (!$this->Bancopunto->exists()) {
			throw new NotFoundException(__('Invalid bancopunto'));
		}
		$this->request->data['Bancopunto']['borrado'] = 1;
		if ($this->Bancopunto->save($this->request->data)) {
			$this->Flash->success(__('The bancopunto has been deleted.'));
		} else {
			$this->Flash->error(__('The bancopunto could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}


