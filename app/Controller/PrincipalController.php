<?php 

	class PrincipalController extends AppController{

		public function index(){

		}

		public function acercade(){
			
		}

		public function isAuthorized($usuario){
			//Todos los usuarios registrados puden ver el listado de servicios
			if (in_array($this->action, array('acercade', 'index'))) {
				return true;
			}

			return parent::isAuthorized($usuario);
		}


	}