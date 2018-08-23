<?php
App::uses('AppController', 'Controller');
/**
 * Usuarios Controller
 *
 * @property Usuario $Usuario
 * @property PaginatorComponent $Paginator
 */
class UsuariosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	//FUNCIONES PROPIAS
	public function beforeFilter()
	{
		parent::beforeFilter();

		//SI LA BD ESTA VACIA, DESCOMENTAR LA SIGUIENTE LINEA Y COMENTAR LA CONSIGUIENTE

		//$this->Auth->allow('login', 'logout','edit', 'editarpassword');

		$this->Auth->allow('login', 'logout');
	}

	public function isAuthorized($usuario)
	{
		
		if ($this->action==='editarusuario') {
				return true;
		}
		


		if ($this->action==='logout') {

			return true;

		}

		return parent::isAuthorized($usuario);
	}

	public function comprobarUsuario($usuario)
	{

		if (isset($usuario)) 
		{
			$datosUsuario = $this->Usuario->find('first', array('conditions' => array('Usuario.username' => $usuario)));
			//debug($datosUsuario);

			if (!empty($datosUsuario) == 1) 
			{

				if ($datosUsuario['Usuario']['estadousuario'] == true) 
				{
					if ($datosUsuario['Usuario']['borrado'] == false) 
					{
						return true;
					}else
					{
						//$this->Flash->error('Usuario no activo 1');
						return false;
					}
				}else
				{

					//$this->Flash->error('Usuario no activo 2');
					return false;
				}
			}else
			{
				//$this->Flash->error('Nombre de usuario no encontrado');
				return false;
			}
		}else
		{

			$this->Flash->error('Error 1');
			return false;
		}
	}

	public function login()
	{

		
		if ($this->request->is('post')) {

			if ($this->comprobarUsuario($this->request->data['Usuario']['username']) == true) {
				//debug($this->request->data);
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl() );
			}
			$this->Session->setFlash('Usuario y/o contraseña incorrectos', 'default', array('class' => 'alert alert-danger'));
			}else{
				$this->Session->setFlash('Usuario no habilitado para usar el sistema. Dirijase al administrador', 'default', array('class' => 'alert alert-danger'));
			}

			
		}
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}

	public function editarpassword($id = null){
		if (!$this->Usuario->exists($id)) {
			throw new NotFoundException(__('Id de usuario no válido'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$contraseña = $this->request->data['contraseña'];

			 	$rcontraseña = $this->request->data['rcontraseña'];


				 	if ($contraseña == $rcontraseña) {
				 		
				 	$this->request->data['Usuario']['password'] = $contraseña; 

					if ($this->Usuario->save($this->request->data)) {
						$this->Flash->success(__('La contraseña ha sido modificada.'));
						return $this->redirect(array('action' => 'edit', $id));
					} else {
						$this->Flash->error(__('La contraseña no pudo ser modificada.'));
					}
					//debug($this->request->data);

				}else{
					 		$this->Flash->error('Las contraseñas no coinciden');
				}
		} else {
			$options = array('conditions' => array('Usuario.' . $this->Usuario->primaryKey => $id));
			$this->request->data = $this->Usuario->find('first', $options);
		}
		
	}



/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Usuario->recursive = 0;
		$usuario = $this->Usuario->find('all', array('conditions' => array('Usuario.borrado' => 0)));
		$this->set('usuarios', $usuario, $this->Paginator->paginate());
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Usuario->exists($id)) {
			throw new NotFoundException(__('Invalid usuario'));
		}
		$options = array('conditions' => array('Usuario.' . $this->Usuario->primaryKey => $id));
		$this->set('usuario', $this->Usuario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$contraseña = $this->request->data['contraseña'];

			 	$rcontraseña = $this->request->data['rcontraseña'];


				 	if ($contraseña == $rcontraseña) {

				 		//COMPROBANDO SI EL TRABAJADOR YA TIENE ESTE PRIVILEGIO
				 		$idTrab = $this->request->data['Usuario']['trabajador_id'];
				 		$idPriv = $this->request->data['Usuario']['privilegio_id'];

				 		$coincidencia = $this->Usuario->find('first', array('conditions' => array('trabajador_id' => $idTrab, 'privilegio_id' => $idPriv)));

				 		$coincidencia = count($coincidencia);

				 		if ($coincidencia == 0) {
				 			$this->request->data['Usuario']['password'] = $contraseña; 

							$this->Usuario->create();
				
							if ($this->Usuario->save($this->request->data)) {
								$this->Flash->success(__('El usuario ha sido creado exitosamente.'));
								return $this->redirect(array('action' => 'index'));
							} else {
								$this->Flash->error(__('El usuario no fué creado.'));
						
							}
				 		}else{
				 			$this->Flash->error(__('El trabajador ya tiene el privilegio asignado.'));
				 		}
 			
					
			 	}else{
			 		$this->Flash->error('Las contraseñas no coinciden');
			 	}

			
		}
		$trabajadors = $this->Usuario->Trabajador->find('list');
		$privilegios = $this->Usuario->Privilegio->find('list', array('conditions' => array('Privilegio.id !=' => 1 )));
		$this->set(compact('trabajadors', 'privilegios'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Usuario->exists($id)) {
			throw new NotFoundException(__('Invalid usuario'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$contraseña = $this->request->data['contraseña'];

			$rcontraseña = $this->request->data['rcontraseña'];

			if ($contraseña == $rcontraseña) {
				 		
				$this->request->data['Usuario']['password'] = $contraseña;


				if ($this->Usuario->save($this->request->data)) {
					$this->Flash->success(__('El usuario ha sido editado.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('El Usuario no pudo se editado.'));
				}

			}else{
			 	$this->Flash->error('Las contraseñas no coinciden');
			 }

			//debug($this->request->data);
		} else {
			$options = array('conditions' => array('Usuario.' . $this->Usuario->primaryKey => $id));
			$this->request->data = $this->Usuario->find('first', $options);
			$this->set('usuario', $this->request->data);
		}
		$trabajadors = $this->Usuario->Trabajador->find('list');
		$privilegios = $this->Usuario->Privilegio->find('list');
		$this->set(compact('trabajadors', 'privilegios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException(__('Invalid usuario'));
		}
		$this->request->data['Usuario']['borrado'] = 1;
		if ($this->Usuario->save($this->request->data)) {
			$this->Flash->success(__('El usuario ha sido eliminado.'));
		} else {
			$this->Flash->error(__('El usuario no puede ser eliminado.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	//Funcion para que cada usuario no administrador pueda modificar sus credenciales de acceso al sistema
	public function editarusuario($id = null){

		if (!$this->Usuario->exists($id)) {
			throw new NotFoundException(__('Id de usuario no accesado'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$contraseña = $this->request->data['contraseña'];

			 	$rcontraseña = $this->request->data['rcontraseña'];


				 	if ($contraseña == $rcontraseña) {
				 		
				 	$this->request->data['Usuario']['password'] = $contraseña; 

			//debug($this->request->data);
			if ($this->Usuario->save($this->request->data)) {
				
				return $this->redirect(array('action' => 'logout'));

			} else {
				
				$this->Flash->error(__('El usuario por alguna razón no pudo ser modificado.'));
			}
					}else{
			 		$this->Flash->error('Las contraseñas no coinciden');
			 		}
		} else {
			$options = array('conditions' => array('Usuario.' . $this->Usuario->primaryKey => $id));
			$this->request->data = $this->Usuario->find('first', $options);
		}


	}


}//FIN DE LA CLASE
