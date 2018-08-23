<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helpers = array('Html', 'Form', 'Time', 'Js');
	public $components = array('Flash', 'Session', 'Auth' );

	public function beforeFilter(){
		$this->Auth->allow('login, logout');
		$this->config_login();
		$this->set('current_user', $this->Auth->user());
	}

	public function config_login()
	{

        $this->Auth->authenticate = array(
            AuthComponent::ALL => array('userModel' => 'Usuario'),
            'Form' => array(
            	'passwordHasher' => 'Blowfish',
            	'fields' => array('username' => 'username', 'password' => 'password')
            )
        );

		$this->Auth->loginAction = array('controller' => 'usuarios', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'principal', 'action' => 'index');
		$this->Auth->logoutRedirect= array('controller'=>'usuarios', 'action' => 'login');
		$this->Auth->authorize = array('Controller');

		$this->Auth->allow(array('login'));

	}

	public function isAuthorized($usuario){

		if (isset($usuario['privilegio_id']) && $usuario['privilegio_id'] === '1' || $usuario['privilegio_id'] ==='2') {
			return true;
		}else{
				if ($this->Auth->user('id')) {
					$this->Flash->error(__('No tiene privilegios suficientes para acceder'));
					$this->redirect($this->Auth->redirect());
				}
			}

		return parent::isAuthorized($usuario);

	}


}