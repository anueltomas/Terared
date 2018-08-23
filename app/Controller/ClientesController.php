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
		$this->paginate['Cliente']['conditions'] = array('Cliente.estadocliente' => 1, 'Cliente.borrado' => 0, 'Cliente.cola_id' => 1);
		//$this->paginate['Cliente']['conditions'] => array('Cliente.status' => 1);
		$this->set('clientes', $this->paginate());
		
	}


	public function tabla_cybercontrol(){
		$this->layout = 'ajax';
		$this->Cliente->recursive = 0;
		$this->paginate['Cliente']['limit'] = 50;
		$this->paginate['Cliente']['order'] = array('Cliente.id' => 'ASC');
		$this->paginate['Cliente']['conditions'] = array('Cliente.estadocliente' => 1, 'Cliente.borrado' => 0, 'Cliente.cola_id' => 2);
		//$this->paginate['Cliente']['conditions'] => array('Cliente.status' => 1);
		$this->set('clientes', $this->paginate());
		
	}



	public function index() {

		if ($this->request->is('post')) {
			//$nombre =  strtoupper($this->request->data['nombrecliente']);
			//$this->request->data['nombre'] = $nombre;
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
			$this->paginate['Cliente']['limit'] = 50;
			$this->paginate['Cliente']['order'] = array('Cliente.id' => 'ASC');
			$this->paginate['Cliente']['conditions'] = array('Cliente.estadocliente' => 1, 'Cliente.borrado' => 0);
			//$this->paginate['Cliente']['conditions'] => array('Cliente.status' => 1);
			$this->set('clientes', $this->paginate());

			$this->loadModel('Ticket');
			$conditions = array('Ticket.estadoticket' => array('Pagado', 'Facturado'));
			$ticket = $this->Ticket->find('all', array('conditions' => $conditions, 'order' => array('Ticket.modified' => 'DESC'), 'limit' => 20));
			$this->set('pagados', $ticket);

			$this->loadModel('Cola');
			$colas = $this->Cola->find('list', array('fields' => array('id', 'nombre')));
			$this->set('colas', $colas);

	}

	public function clienteExpress($nombreCliente = null) {

		if ($nombreCliente == null) {
			throw new NotFoundException("Error en el id del cliente", 1);
			
		}

			$datos = array('nombre' => $nombreCliente, 'cola_id' => 1);

		
			$this->Cliente->create();
			if ($this->Cliente->save($datos)) {
				$this->Flash->success('Cliente Agregado Exitosamente');

				//Buscamos ultimo cliente ingresado
				$datos = $this->Cliente->find('first', array('fields' => array('Cliente.id'), 'order' => array('Cliente.id' => 'desc')));

				$idCliente = $datos['Cliente']['id'];

				return $this->redirect(array('controller' => 'tickets', 'action' => 'nuevo', $idCliente));

			} else {
				return false;
			}

			$this->autoRender=false;
		
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
				debug($this->request->data);
			}
		} else {
			$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
			$this->request->data = $this->Cliente->find('first', $options);
		}
	}

	public function editar($id = null) {
		if (!$this->Cliente->exists($id)) {
			throw new NotFoundException(__('Id de cliente no válido'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$datos = array('id' => $id, 'nombre' => $this->request->data['Cliente']['nombre'], 'estadocliente' => 0);
			if ($this->Cliente->save($datos)) {
				$this->Flash->success(__('El cliente ha sido modificado.'));
				return $this->redirect(array('controller' => 'tickets', 'action' => 'ticketactual'));
			} else {
				$this->Flash->error(__('El cliente no puede ser modificado'));
				debug($this->request->data);
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
