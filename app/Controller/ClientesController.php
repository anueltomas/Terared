<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class ClientesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	//public $components = array('Paginator');

	public $paginate = array(
		'limit' => 30, 
		'order' => array(
			'Cliente.id' => 'asc'
			)
		);

/**
 * index method
 *
 * @return void
 */

	//FUNCION PARA EL AUTOREFRESH
	public function tabla(){
		$this->layout = 'ajax';
		$this->Cliente->recursive = 0;
		$this->paginate['Cliente']['limit'] = 50;
		$this->paginate['Cliente']['order'] = array('Cliente.id' => 'ASC');
		$this->paginate['Cliente']['conditions'] = array('Cliente.estadocliente' => 1, 'Cliente.borrado' => 0);
		//$this->paginate['Cliente']['conditions'] => array('Cliente.status' => 1);
		$this->set('clientes', $this->paginate());
	}

	public function index() {

		if ($this->request->is('post')) {
			$this->Cliente->create();
			if ($this->Cliente->save($this->request->data)) {
				$this->Flash->success('Cliente Agregado Exitosamente');
				//return $this->redirect(array('action' => 'index'));
			} else {
				//$this->Flash->error('El cliente no pudo ser ingresado.');
			}
			//debug($this->request->data);
		}


			$this->Cliente->recursive = 0;
			$this->paginate['Cliente']['limit'] = 30;
			$this->paginate['Cliente']['order'] = array('Cliente.id' => 'ASC');
			$this->paginate['Cliente']['conditions'] = array('Cliente.estadocliente' => 1, 'Cliente.borrado' => 0);
			//$this->paginate['Cliente']['conditions'] => array('Cliente.status' => 1);
			$this->set('clientes', $this->paginate());

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cliente->exists($id)) {
			throw new NotFoundException(__('Invalid cliente'));
		}
		$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
		$this->set('cliente', $this->Cliente->find('first', $options));
	}



/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Cliente->exists($id)) {
			throw new NotFoundException(__('Id de cliente no válido'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cliente->save($this->request->data)) {
				$this->Flash->success(__('El cliente ha sido modificado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('El cliente no puede ser modificado'));
			}
		} else {
			$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
			$this->request->data = $this->Cliente->find('first', $options);
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
		$this->Cliente->id = $id;
		if (!$this->Cliente->exists()) {
			throw new NotFoundException(__('Cliente no encontrado'));
		}
		$this->request->data['Cliente']['borrado'] = 1;
		if ($this->Cliente->save($this->request->data)) {
			$this->Flash->success(__('El cliente ha sido eliminado'));
		} else {
			$this->Session->setFlash('El cliente no pudo ser eliminado.', 'default', array('class' => ''));
		}
		//$this->autoRender = false;
		return $this->redirect(array('action' => 'index'));
	}


	public function atender($id = null){

		$this->Cliente->id = $id;
		if (!$this->Cliente->exists()) {
			throw new NotFoundException(__('Cliente no encontrado'));
		}

		$this->request->data['Cliente']['estadocliente'] = 0;
		if ($this->Cliente->save($this->request->data)) {
			$this->Flash->success(__('El cliente ha sido atendido exitosamente'));
		}else{
			echo "Cliente no puede ser atendido";
		}

		return $this->redirect(array('action' => 'index'));

	}//FIN ATENDER

	public function isAuthorized($usuario){
		//Todos los usuarios registrados puden ver el listado de servicios
		if ($this->action==='index' || 'tabla') {
			return true;
		}

		return parent::isAuthorized($usuario);
	}

	
}
