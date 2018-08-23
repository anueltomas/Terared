<?php
App::uses('AppController', 'Controller');
/**
 * Trabajadores Controller
 *
 * @property Trabajador $Trabajador
 * @property PaginatorComponent $Paginator
 */
class TrabajadorsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	//public $components = array('Paginator');

	public $paginate = array(
		'limit' => 20, 
		'order' => array(
			'Trabajador.id' => 'asc'
			)
		);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Trabajador->recursive = 0;
		$trabajadores = $this->Trabajador->find('all', array('conditions' => array('Trabajador.borrado' => 0)));
		$this->set('trabajadores', $trabajadores, $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Trabajador->exists($id)) {
			throw new NotFoundException(__('Invalid trabajador'));
		}
		$options = array('conditions' => array('Trabajador.' . $this->Trabajador->primaryKey => $id));
		$this->set('trabajador', $this->Trabajador->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Trabajador->create();
			if ($this->Trabajador->save($this->request->data)) {
				$this->Flash->success(__('El trabajador ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('El trabajador no pudo ser guardado'));
			}
		}
	}

	public function nuevo() {
		if ($this->request->is('post')) {
			$this->Trabajador->create();
			if ($this->Trabajador->save($this->request->data)) {
				$this->Flash->success(__('El trabajador ha sido guardado.'));
				return $this->redirect(array('controller' => 'usuarios', 'action' => 'add'));
			} else {
				$this->Flash->error(__('El trabajador no pudo ser guardado'));
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
		if (!$this->Trabajador->exists($id)) {
			throw new NotFoundException(__('Id del trabajador no encontrado'));
		}


		if ($this->request->is(array('post', 'put'))) {

	
				if ($this->Trabajador->save($this->request->data)) {
					$this->Flash->success(__('El trabajador ha sido editado.'));
				return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('El  no pudo ser editado.'));
				}
			

		} else {
			$options = array('conditions' => array('Trabajador.' . $this->Trabajador->primaryKey => $id));
			$this->request->data = $this->Trabajador->find('first', $options);
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
			$this->Trabajador->id = $id;
		if (!$this->Trabajador->exists()) {
			throw new NotFoundException(__('Id del servicio no permitido'));
		}

		if ($this->Trabajador->id != 1) {

			$this->request->data['Trabajador']['borrado'] = 1;
			if ($this->Trabajador->save($this->request->data)) {
				$this->Flash->success(__('El Trabajador ha sido eliminado.'));
			} else {
				$this->Flash->error(__('El Trabajador no puede ser eliminado.'));
			}
			return $this->redirect(array('action' => 'index'));
		}else{

				$this->Flash->error(__('Éste Trabajador no puede ser eliminado.'));
				return $this->redirect(array('action' => 'index'));
				
		 }
	}



	


	

}// Fin de la Clase
