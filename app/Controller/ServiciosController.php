<?php
App::uses('AppController', 'Controller');
/**
 * Servicios Controller
 *
 * @property Servicio $Servicio
 * @property PaginatorComponent $Paginator
 */
class ServiciosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	//public $components = array('Paginator');
	public $paginate = array(
		'limit' => 30, 
		'order' => array(
			'Servicio.nombreservicio' => 'asc'
			)
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Servicio->recursive = 0;
		$servicio = $this->Servicio->find('all', array('order' => 'Servicio.nombreservicio ASC'), array('conditions' => array('Servicio.borrado' => 0)));
		$this->set('servicios', $servicio, $this->paginate());

	}

	public function listado(){
		$this->Servicio->recursive = 0;
		$servicio = $this->Servicio->find('all', array('order' => 'Servicio.nombreservicio ASC'), array('conditions' => array('Servicio.borrado' => 0, 'Servicio.estadoservicio' => 1)));
		$this->set('servicios', $servicio, $this->paginate());

		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Servicio->exists($id)) {
			throw new NotFoundException(__('Id del servicio no encontrado'));
		}
		$options = array('conditions' => array('Servicio.' . $this->Servicio->primaryKey => $id));
		$this->set('servicio', $this->Servicio->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {

			if (is_null($this->request->data['Servicio']['precio']) || $this->request->data['Servicio']['precio'] == '') {
				$fecha = "";
				$this->request->data['Servicio']['precio'] = 0;
			}else{

				$fecha = $this->request->data['Servicio']['fechaprecio'];
			}

			$this->request->data['Servicio']['fechaprecio'] = $fecha;

			$this->Servicio->create();
			if ($this->Servicio->save($this->request->data)) {
				$this->Flash->success(__('Servicio guardado correctamente.'));
				return $this->redirect(array('controller' => 'servicios', 'action' => 'index'));

			} else {
				$this->Flash->error(__('El servicio no pudo ser guardado, por favor revise.'));
			}

			//debug($this->request->data);
		}
		$tservicios = $this->Servicio->Tservicio->find('list');
		$this->set(compact('tservicios'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Servicio->exists($id)) {
			throw new NotFoundException(__('Id del servicio no encontrado'));
		}
		if ($this->request->is(array('post', 'put'))) {

			if (is_null($this->request->data['Servicio']['precio']) || $this->request->data['Servicio']['precio'] == '') {
				$fecha = "";
			}else{

				$fecha = $this->request->data['Servicio']['fechaprecio'];
			}

			$this->request->data['Servicio']['fechaprecio'] = $fecha;

			if ($this->Servicio->save($this->request->data)) {
				$this->Flash->success(__('Servicio editado correctamente.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('El servicio no pudo ser editado, por favor revise.'));
			}

			//debug($this->request->data);
		} else {
			$options = array('conditions' => array('Servicio.' . $this->Servicio->primaryKey => $id));
			$this->request->data = $this->Servicio->find('first', $options);
		}
		$tservicios = $this->Servicio->Tservicio->find('list');
		$this->set(compact('tservicios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Servicio->id = $id;
		if (!$this->Servicio->exists()) {
			throw new NotFoundException(__('Id del servicio no permitido'));
		}
		$this->request->data['Servicio']['borrado'] = 1;
		if ($this->Servicio->save($this->request->data)) {
			$this->Flash->success(__('El servicio ha sido eliminado.'));
		} else {
			$this->Flash->error(__('El servicio no puede ser eliminado.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	//FUNCION DE BUSQUEDA AUTOPREDICTIVA
	public function buscarjson(){

		$term = null;
		if (!empty($this->request->query['term'])) {
			$term = $this->request->query['term'];
			$terms = explode(' ', trim($term));
			$terms = array_diff($terms, array(''));
			foreach ($terms as $term) {
				$conditions[]= array('Servicio.nombreservicio LIKE' => '%'. $term . '%');
			}


			$servicios = $this->Servicio->find('all', array('recursive' => -1, 'fields' => array('Servicio.id', 'Servicio.nombreservicio', 'Servicio.precio'), 'conditions' => array($conditions, 'Servicio.estadoservicio' => '1', 'Servicio.borrado' => '0'), 'limit' => 20));
		}

		echo json_encode($servicios);
		$this->autoRender = false;


	}

	public function buscar(){

		$buscar = null;
		if (!empty($this->request->query['buscar'])) {
			$buscar = $this->request->query['buscar'];
			$buscar = preg_replace('/[^a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ]/', '', $buscar);
			$terms = explode(' ', trim($buscar));
			$terms = array_diff($terms, array(''));

			foreach ($terms as $term) {
				$terms1[] = preg_replace('/[^a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ]/', '', $term);
				$conditions[]= array('Servicio.nombreservicio LIKE' => '%'. $term . '%');  
			}

			$servicios = $this->Servicio->find('all', array('recursive' => -1, 'fields' => array('Servicio.id', 'Servicio.nombreservicio', 'Servicio.precio'), 'conditions' => array($conditions, 'Servicio.estadoservicio' => '1', 'Servicio.borrado' => '0'), 'limit' => 1));

			if (count($servicios) != 0) {
				return $this->redirect(array('controller' => 'servicios', 'action' => 'edit', $servicios[0]['Servicio']['id']));
			}else{
				$this->Flash->error(__('Servicio no encontrado'));
			}
			//$terms1 = array_diff($terms1, array(''));
			//$this->set(compact('servicios', 'terms1'));
			
		}

		debug($servicios);

		$this->autoRender = false;

	}

	public function isAuthorized($usuario){
		//Todos los usuarios registrados puden ver el listado de servicios
		if ($this->action==='listado' || $this->action==='buscarjson') {
				return true;
		}
		return parent::isAuthorized($usuario);
	}

	public function eliminados(){

		$this->Servicio->recursive = 0;
		$servicio = $this->Servicio->find('all', array('conditions' => array('Servicio.borrado' => 1)));
		$this->set('servicios', $servicio, $this->paginate());
	}

	public function restaurar($id = null) {
		$this->Servicio->id = $id;
		if (!$this->Servicio->exists()) {
			throw new NotFoundException(__('Id del servicio no permitido'));
		}
		$this->request->data['Servicio']['borrado'] = 0;
		if ($this->Servicio->save($this->request->data)) {
			$this->Flash->success(__('El servicio ha sido restaurado.'));
		} else {
			$this->Flash->error(__('El servicio no puede ser restaurado.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function cargaprecios($id = null){

		$this->Servicio->recursive = 0;
		$servicio = $this->Servicio->find('all', array('conditions' => array('Servicio.borrado' => 0)));
		$this->set('servicios', $servicio, $this->paginate());

	}



}
