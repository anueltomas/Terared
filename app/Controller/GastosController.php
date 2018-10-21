<?php
App::uses('AppController', 'Controller');
/**
 * Gastos Controller
 *
 * @property Gasto $Gasto
 * @property PaginatorComponent $Paginator
 */
class GastosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function isAuthorized($usuario)
	{

		$privilegio = $this->Session->read('privilegio_id');


		if ($privilegio == '4') {

			
				if (in_array($this->action, array('add', 'index', 'edit'))) {
				return true;
				}
						
			}

				
		return parent::isAuthorized($usuario);

	}

	public function add() {

		//EVALUAMOS SI EL CAJERO TIENE UN TURNO ACTIVO
		//PREGUNTAMOS SI EL USUARIO ES ADMINISTRADOR
		$privilegioUsuario = $privilegio = $this->Session->read('privilegio_id');

		$idUsuario = $this->Auth->user('id');

		$this->loadModel('TurnoCajero');
			$DatosTurno = $this->TurnoCajero->find('first', array('conditions' => array('estadoturno' => 'A', 'usuario_id' => $idUsuario)));

		if ($privilegioUsuario == 1 || $privilegioUsuario == 2 || $DatosTurno != null) {

			if ($this->request->is('post')) {
				$this->loadModel('TurnoCajero');

				$idCajero = $this->TurnoCajero->find('first', array('conditions' => array('estadoturno' => 'A')));
				$idCajero = $idCajero['TurnoCajero']['id'];
				$datos = array('concepto' => $this->request->data['Gasto']['concepto'], 'montogasto' => $this->request->data['Gasto']['montogasto'], 'turno_cajero_id' => $idCajero);
				
				$this->Gasto->create();
				if ($this->Gasto->save($datos)) {
					$this->Flash->success(__('El gasto ha sido guardado.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('El gasto no pudo ser guardado.'));
				}
			}
			
		}else {

			$this->Flash->error(__('El usuario debe iniciar turno'));
			return $this->redirect(array('controller' => 'principal', 'action' => 'index'));
		}

		
	}

	public function index() {

		//PREGUNTAMOS SI EL USUARIO ES ADMINISTRADOR
		$privilegioUsuario = $privilegio = $this->Session->read('privilegio_id');

		$idUsuario = $this->Auth->user('id');

		if ($privilegioUsuario == 1 || $privilegioUsuario == 2) {
			$this->Gasto->recursive = 0;
			$this->set('gastos', $this->Paginator->paginate());
		}else {
			//BUSCAMOS EL TURNO DE ESTE CAJERO
			$this->loadModel('TurnoCajero');
			$DatosTurno = $this->TurnoCajero->find('first', array('conditions' => array('estadoturno' => 'A', 'usuario_id' => $idUsuario)));
			//debug($DatosTurno);

			if ($DatosTurno == null) {
				$cajero = 1;
				$this->set('cajeroNoActivo', $cajero);
			}else {

				$idTurno = $DatosTurno['TurnoCajero']['id'];

				//Buscamos los gastos que ha ingresado este cajero
				$gastos = $this->Gasto->find('all', array('conditions' => array('turno_cajero_id' => $idTurno)));

				$cajero = null;
				$this->set('cajeroNoActivo', $cajero);

				$this->set('gastos', $gastos);
				
			}

			
			
			
		}

	
	}

	public function edit($id = null) {

		if ($id == null) {
			throw new NotFountException("Error en el id del gasto a editar", 1);
			
		}

		if ($this->request->is(array('post', 'put'))) {

			
			if ($this->Gasto->save($this->request->data)) {
				$this->Flash->success(__('Gasto editado correctamente.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('El gasto no pudo ser editado, por favor revise.'));
			}

			//debug($this->request->data);
		} else {
			$options = array('conditions' => array('Gasto.' . $this->Gasto->primaryKey => $id));
			$this->request->data = $this->Gasto->find('first', $options);
		}
		
	}

}//FIN DE LA CLASE
