<?php
App::uses('AppController', 'Controller');
/**
 * Privilegios Controller
 *
 * @property Privilegio $Privilegio
 * @property PaginatorComponent $Paginator
 */
class PrivilegiosController extends AppController {

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
		$this->Privilegio->recursive = 0;
		$this->set('privilegios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Privilegio->exists($id)) {
			throw new NotFoundException(__('Invalid privilegio'));
		}
		$options = array('conditions' => array('Privilegio.' . $this->Privilegio->primaryKey => $id));
		$this->set('privilegio', $this->Privilegio->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Privilegio->create();
			if ($this->Privilegio->save($this->request->data)) {
				$this->Flash->success(__('El privilegio ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('El privilegio no pudo ser guardado.'));
			}
		}
	}

	public function nuevo() {
		if ($this->request->is('post')) {
			$this->Privilegio->create();
			if ($this->Privilegio->save($this->request->data)) {
				$this->Flash->success(__('El privilegio ha sido guardado.'));
				return $this->redirect(array('controller' => 'usuarios', 'action' => 'add'));
			} else {
				$this->Flash->error(__('El privilegio no pudo ser guardado.'));
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
		if (!$this->Privilegio->exists($id)) {
			throw new NotFoundException(__('Invalid privilegio'));
		}
		//VALIDACION PARA QUE NO PUEDA SER EDITADO EL USUARIO ROOT
		if ($id == 1) {

				$this->Flash->error(__('El privilegio no puede ser editado'));
				return $this->redirect(array('action' => 'index'));

		}else{

			if ($this->request->is(array('post', 'put'))) {

			if ($this->request->data['Privilegio']['id'] != 1 || $this->request->data['Privilegio']['id'] != 2) {

				if ($this->Privilegio->save($this->request->data)) {
					$this->Flash->success(__('El privilegio ha sido editado.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('El privilegio no puede ser editado'));
				}

			}else{

				$this->Flash->error(__('Éste Privilegio no puede ser editado.'));

			}

		}

		}

		
			$options = array('conditions' => array('Privilegio.' . $this->Privilegio->primaryKey => $id));
			$this->request->data = $this->Privilegio->find('first', $options);
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Privilegio->id = $id;
		if (!$this->Privilegio->exists()) {
			throw new NotFoundException(__('Invalid privilegio'));
		}
		if ($this->Privilegio->id != 1) {

			$this->request->data['Privilegio']['borrado'] = 1 || $this->request->data['Privilegio']['id'] != 2;
			if ($this->Privilegio->save($this->request->data)) {
				$this->Flash->success(__('El Privilegio ha sido eliminado.'));
			} else {
				$this->Flash->error(__('El Privilegio no puede ser eliminado.'));
			}
			return $this->redirect(array('action' => 'index'));
		}else{

				$this->Flash->error(__('Éste Privilegio no puede ser eliminado.'));
				return $this->redirect(array('action' => 'index'));
				
		 }
	}

	

} //FIN
