<?php
App::uses('AppController', 'Controller');
/**
 * Bancos Controller
 *
 * @property Banco $Banco
 * @property PaginatorComponent $Paginator
 */
class BancosController extends AppController {

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
		$this->Banco->recursive = 0;
		$bancos = $this->Banco->find('all', array('conditions' => array('Banco.borrado' => 0)));
		$this->set('bancos', $bancos, $this->Paginator->paginate());
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Banco->exists($id)) {
			throw new NotFoundException(__('Invalid banco'));
		}
		$options = array('conditions' => array('Banco.' . $this->Banco->primaryKey => $id));
		$this->set('banco', $this->Banco->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Banco->create();
			if ($this->Banco->save($this->request->data)) {
				$this->Flash->success(__('El banco ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('La información no pudo ser almacenada.'));
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
		if (!$this->Banco->exists($id)) {
			throw new NotFoundException(__('Invalid banco'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Banco->save($this->request->data)) {
				$this->Flash->success(__('El banco ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('La información no pudo ser almacenada.'));
			}
		} else {
			$options = array('conditions' => array('Banco.' . $this->Banco->primaryKey => $id));
			$this->request->data = $this->Banco->find('first', $options);
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
		$this->Banco->id = $id;
		if (!$this->Banco->exists()) {
			throw new NotFoundException(__('Invalid banco'));
		}
		$this->request->data['Banco']['borrado'] = 1;
		if ($this->Banco->save($this->request->data)) {
			$this->Flash->success(__('The banco has been deleted.'));
		} else {
			$this->Flash->error(__('The banco could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
