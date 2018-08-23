<?php
App::uses('AppController', 'Controller');
/**
 * DetalleTickets Controller
 *
 * @property DetalleTicket $DetalleTicket
 * @property PaginatorComponent $Paginator
 */
class DetalleTicketsController extends AppController {
	  
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
		$this->DetalleTicket->recursive = 0;
		$this->set('detalleTickets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DetalleTicket->exists($id)) {
			throw new NotFoundException(__('Invalid detalle ticket'));
		}
		$options = array('conditions' => array('DetalleTicket.' . $this->DetalleTicket->primaryKey => $id));
		$this->set('detalleTicket', $this->DetalleTicket->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($idTicket = null) {
		

		if ($idTicket == null) {
			throw new NotFoundException("Id del ticket no encontrado", 1);
			
		}



		if ($this->request->is('post')) {
			
			

			//CALCULANDO EL MONTO
			$idServicio = $this->request->data['DetalleTicket']['servicio_id'];
			$cantidad = $this->request->data['DetalleTicket']['cantidad'];
			$idUsuario = $this->Auth->user('id');
			
			$this->loadModel('Servicio');
			$precio = $this->Servicio->find('first', array('conditions' => array('Servicio.id' => $idServicio)));

			$precio = $precio['Servicio']['precio'];

			$monto = $cantidad * $precio;

			$datos = array('cantidad' => $cantidad,
							'monto' => $monto,
							'precio' => $precio,
							'ticket_id' => $idTicket,
							'servicio_id' => $idServicio,
							'usuario_id' => $idUsuario);

				$this->DetalleTicket->create();
				if ($this->DetalleTicket->save($datos)) {

					$this->Flash->success(__('Servicio añadido.'));
					return $this->redirect(array('controller' => 'tickets', 'action' => 'ticketactual'));
				} else {
					$this->Flash->error(__('El servicio no pudo ser añadido.'));
				}
				
			}

			$tickets = $this->DetalleTicket->Ticket->find('list');
			$servicios = $this->DetalleTicket->Servicio->find('list', array('conditions' => array('Servicio.precio !=' => 0)));
			$this->set(compact('tickets', 'servicios'));
	}


	public function add_ajax() {

		if ($this->request->is('ajax')) {
		
			if ($this->request->is('post')) {

				$idUsuario = $this->Auth->user('id');

				$this->request->data['usuario_id'] = $idUsuario;
			
				$this->DetalleTicket->create();
				if ($this->DetalleTicket->save($this->request->data)) {
					$this->Flash->success(__('Servicio agregado.'));
					return $this->redirect(array('controller' => 'tickets', 'action' => 'ticketactual'));
				} else {
					$this->Flash->error(__('El servicio no pudo ser agregado'));
				}

			}

		//echo debug($this->request->data);

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

		if (!$this->DetalleTicket->exists($id)) {
			throw new NotFoundException(__('Id no válido'));
		}


		if ($this->request->is(array('post', 'put'))) {
			if ($this->DetalleTicket->save($this->request->data)) {
				$this->Flash->success(__('Servicio editado'));
				return $this->redirect(array('controller' => 'tickets', 'action' => 'ticketactual'));
			} else {
				$this->Flash->error(__('Servicio no editado'));
			}
		} else {
			$options = array('conditions' => array('DetalleTicket.' . $this->DetalleTicket->primaryKey => $id));
			$this->request->data = $this->DetalleTicket->find('first', $options);
		}
		$tickets = $this->DetalleTicket->Ticket->find('list');
		$servicios = $this->DetalleTicket->Servicio->find('list');
		$this->set(compact('tickets', 'servicios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete() {

		if ($this->request->is('ajax')) {
			$idServicio = $this->request->data['idServicio'];
			$idTicket = $this->request->data['idTicket'];
			if ($this->DetalleTicket->delete($idServicio)) {
				$this->Flash->success(__('Servicio removido.'));
			} else {
				$this->Flash->error(__('El servicio no pudo ser removido.'));
			}
		}
		
		$total_servicios = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idServicio, 'DetalleTicket.servicio_id' => $idTicket), 'fields' => array('SUM(DetalleTicket.monto) as subtotal')));

		$mostrar_total_servicios = $total_servicios['0']['0']['subtotal'];

		echo json_encode('mostrar_total_servicios');

		$this->autoRender = false;

		/*$this->DetalleTicket->id = $id;
		if (!$this->DetalleTicket->exists()) {
			throw new NotFoundException(__('Id del detalle del ticket no válido'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DetalleTicket->delete()) {
			$this->Flash->success(__('El servicio ha sido removido.'));
		} else {
			$this->Flash->error(__('El servicio no pudo ser removido.'));
		}
		return $this->redirect(array('controller' => 'tickets', 'action' => 'ticketactual', $idUsuario));*/


	}

	//Funcion para editar la cantidad de cada servicio agregado a un ticket
	public function edit_cantidad()
	{
		
		if ($this->request->is('ajax')) 
		{


			$idServicio = $this->request->data['idServicio'];

			$idDetalle = $this->request->data['idDetalle'];

			$cantidad = isset($this->request->data['cantidad']) ? $this->request->data['cantidad'] : null;

			$cantidad = $this->request->data['cantidad'];

			if ($cantidad == 0) 
			{
				$cantidad = 1;
			}

			//Busqueda del precio del servicio a editar	
			$this->loadModel('Servicio');
			$precio_servicio = $this->Servicio->find('all', array('fields' => array('Servicio.id', 'Servicio.precio'), 'conditions' => array('Servicio.id' => $idServicio)));

			$precio = $precio_servicio[0]['Servicio']['precio'];

			$monto = $precio * $cantidad;

			$update_servicio_in_detalle = array('id' => $idDetalle, 'cantidad' => $cantidad, 'monto' => $monto);

			//Editando el detalle del servicio en la bd
			$this->DetalleTicket->saveAll($update_servicio_in_detalle);

		

		$idTicket = $this->request->data['idTicket'];

		//Buscando monto total de los servicios en el detalle
		//$monto_total = $this->find('all', array('field' => array('SUM(DetalleTicket.monto) as subtotal')), 'conditions' => array('DetalleTicket.id' => $idDetalle));

		$monto_total = $this->DetalleTicket->find('all', array('conditions' => array('DetalleTicket.ticket_id' => $idTicket), 'fields' => array('SUM(DetalleTicket.monto) as subtotal')));

		$mostrar_monto_total = $monto_total['0']['0']['subtotal'];

		$servicio_update = $this->DetalleTicket->find('all', array('fields' => array('DetalleTicket.id', 'DetalleTicket.monto'), 'conditions' => array('DetalleTicket.id' => $idDetalle)));

		$enviar_por_json = array('id' => $idServicio, 'monto' => $servicio_update['0']['DetalleTicket']['monto'], 'total' => $mostrar_monto_total);

		echo json_encode(compact('enviar_por_json'));

		$this->autoRender = false;

		}

	}


	public function isAuthorized($usuario)
	{

		if (in_array($this->action, array('add', 'add_ajax', 'edit', 'delete', 'edit_cantidad'))) {
				return true;
		}
		
		return parent::isAuthorized($usuario);

	}


}//FIN DE LA CLASE
