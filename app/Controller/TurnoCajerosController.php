<?php
App::uses('AppController', 'Controller');
/**
 * TurnoCajeros Controller
 *
 * @property TurnoCajero $TurnoCajero
 * @property PaginatorComponent $Paginator
 */
class TurnoCajerosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function isAuthorized($usuario)
	{

		$privilegio = $this->Session->read('privilegio_id');

		if ($privilegio_id === '4') {

			
				if (in_array($this->action, array('add', 'cerrar'))) {
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
		$this->TurnoCajero->recursive = 0;
		$this->set('turnoCajeros', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TurnoCajero->exists($id)) {
			throw new NotFoundException(__('Invalid turno cajero'));
		}
		$options = array('conditions' => array('TurnoCajero.' . $this->TurnoCajero->primaryKey => $id));
		$this->set('turnoCajero', $this->TurnoCajero->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		//

		$datos = array('usuario_id' => $this->Auth->user('id'), 'estadoturno' => 'A');

			$this->TurnoCajero->create();

			if ($this->TurnoCajero->save($datos)) {
				
				return true;
				
			} else {
				
				return false;
			}
		
		$this->autoRender = false;
	}

	public function cerrar($idTurno = null) {

		if ($idTurno == null) {
			throw new NotFoundException("Error con el id del turno", 1);
			
		}

		$datos = array('id' => $idTurno, 'usuario_id' => $this->Auth->user('id'), 'estadoturno' => 'C');
			
			if ($this->TurnoCajero->save($datos)) {
				
				return true;
			} else {
				
				return false;
			}
		
		$this->autoRender = false;
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TurnoCajero->exists($id)) {
			throw new NotFoundException(__('Invalid turno cajero'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TurnoCajero->save($this->request->data)) {
				$this->Flash->success(__('The turno cajero has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The turno cajero could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TurnoCajero.' . $this->TurnoCajero->primaryKey => $id));
			$this->request->data = $this->TurnoCajero->find('first', $options);
		}
		$usuarios = $this->TurnoCajero->Usuario->find('list');
		$this->set(compact('usuarios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TurnoCajero->id = $id;
		if (!$this->TurnoCajero->exists()) {
			throw new NotFoundException(__('Invalid turno cajero'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TurnoCajero->delete()) {
			$this->Flash->success(__('The turno cajero has been deleted.'));
		} else {
			$this->Flash->error(__('The turno cajero could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
