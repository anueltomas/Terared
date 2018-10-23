<?php
App::uses('AppController', 'Controller');
/**
 * Servicios Controller
 *
 * @property Servicio $Servicio
 * @property PaginatorComponent $Paginator
 */
class ServiciosController extends AppController {

	public $components = array('RequestHandler');

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
		$servicio = $this->Servicio->find('all', array('order' => 'Servicio.id ASC'), array('conditions' => array('Servicio.borrado' => 0)));
		$this->set('servicios', $servicio, $this->paginate());
		
	}

	public function listado(){
		$this->Servicio->recursive = 0;
		$servicio = $this->Servicio->find('all', array('order' => 'Servicio.id ASC'), array('conditions' => array('Servicio.borrado' => 0, 'Servicio.estadoservicio' => 1)));
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


			$servicios = $this->Servicio->find('all', array('recursive' => -1, 'fields' => array('Servicio.id', 'Servicio.nombreservicio', 'Servicio.precio'), 'conditions' => array($conditions, 'Servicio.estadoservicio' => '1', 'Servicio.borrado' => '0', 'Servicio.precio !=' => 0), 'limit' => 20));
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
				$terms1[] = preg_replace('/[^a-zA-ZñÑáéíóúÁÉÍÓÚ0-9() ]/', '', $term);
				$conditions[]= array('Servicio.nombreservicio LIKE' => '%'. $term . '%');  
			}

			$servicios = $this->Servicio->find('all', array('recursive' => -1, 'fields' => array('Servicio.id', 'Servicio.nombreservicio', 'Servicio.precio'), 'conditions' => array($conditions, 'Servicio.estadoservicio' => '1', 'Servicio.borrado' => '0'), 'limit' => 20));

			if (count($servicios) != 0) {
				return $this->redirect(array('controller' => 'servicios', 'action' => 'edit', $servicios[0]['Servicio']['id']));
			}else{
				//$this->Flash->error(__('Servicio no encontrado'));
				//debug($conditions);
			}
			//$terms1 = array_diff($terms1, array(''));
			//$this->set(compact('servicios', 'terms1'));
			
		}

		//debug($servicios);

		


		$this->autoRender = false;
	}

	public function isAuthorized($usuario){
		//Todos los usuarios registrados puden ver el listado de servicios
		if ($this->action==='listado' || $this->action==='buscarjson' || $this->action==='imprimir') {
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

	//Funcion que nos permite guardar el precio anterior de varios prductos
	public function guardar_precios_anteriores($lista_servicios) {
		$this->loadModel('PreciosServicio');
		//debug($lista_servicios);

		foreach ($lista_servicios as $servicios) {

			$nombre = $servicios['Servicio']['nombreservicio'];

			$precio = $servicios['Servicio']['precio'];

			$id = $servicios['Servicio']['id'];

			$datos = array('nombre' => $nombre, 'servicio_id' => $id, 'precio' => $precio);

			$this->PreciosServicio->create();

			if($this->PreciosServicio->save($datos)) {
				$respuesta = 0;
			}else {
				$respuesta = false;
			}
		}

		if (empty($respuesta)) {
			$respuesta = true;
		}else{ 
			$respuesta = false;
		}

		return $respuesta;
				

	}


	//Esta funcion le permite a un administrador modificar todos los precios de los servicios por porcentaje
	public function modificar_precios() {

		if ($this->request->is('post')) {
			//debug($this->request->data);

			//Obtenemos lista de precios de los servicios
			$this->loadModel('Servicio');
			//$Servicios = $this->Servicio->query("SELECT id, precio FROM servicios WHERE precio >= 0");

			$Servicios = $this->Servicio->find('all', array('fields' => array('Servicio.nombreservicio', 'Servicio.id', 'Servicio.precio'), 'conditions' => array('Servicio.precio >=' => 0), 'recursive' => -1));

			//Obtenemos datos enviado por request post
			$porcentaje = $this->request->data['cifra'];

			$operacion = $this->request->data['opcion'];

			//Averiguamos la operacion que se va a realizar
			if ($operacion == 'aumentar') {
				foreach ($Servicios as $servicio) {
					//echo $servicio['servicios']['precio'] . "<br>";

					//Calculamos el aumento
					$precio = $servicio['Servicio']['precio'];

					$id = $servicio['Servicio']['id'];

					$resultado = $precio * $porcentaje;

					$resultado = $resultado / 100;

					$resultado = $precio + $resultado;

					$x = $resultado;

					//MODIFICAMOS RESULTADO PARA UN MEJOR MANEJO DEL EFECTIVO
					//$x = $resultado / 1000;

					$x = ceil($x);

					$nuevo_precio = $x;

					//$x = $x * 1000;

					//$y= $x - $resultado;

					/*if ($y >= 500) {
						$nuevo_precio = $x - 500;
					}else{
						$nuevo_precio = $x;
					}*/
					
						//Guardar en Servicios
						$datos = array('id' => $id, 'precio' => $nuevo_precio);

						if ($this->Servicio->save($datos)) {
							$resultado_final = true;

						}else{
							$resultado_final = false;
						}

					}//Fin foreach

					

				
			} else {
				foreach ($Servicios as $servicio) {
					//echo $servicio['servicios']['precio'] . "<br>";

					//Calculamos
					$precio = $servicio['Servicio']['precio'];

					$id = $servicio['Servicio']['id'];

					$resultado = $precio * $porcentaje;

					$resultado = $resultado / 100;

					$resultado = $precio - $resultado;

					$x = $resultado;

					//MODIFICAMOS RESULTADO PARA UN MEJOR MANEJO DEL EFECTIVO
					//$x = $resultado / 1000;

					$x = ceil($x);

					$nuevo_precio = $x;

					//$x = $x * 1000;

					//$y= $x - $resultado;

					/*if ($y >= 500) {
						$nuevo_precio = $x - 500;
					}else{
						$nuevo_precio = $x;
					}*/

					//Guardar en Servicios
					$datos = array('id' => $id, 'precio' => $nuevo_precio);

					if ($this->Servicio->save($datos)) {
						$resultado_final = true;

					}else{
						$resultado_final = false;
					}


				}//Fin foreach
			}
			
		
			if ($resultado_final == true) {

				$result = $this->guardar_precios_anteriores($Servicios);
//debug($result);
				if ($result == true) {
					$this->Flash->success('Los precios fueron modificados con éxito y se hizo un respaldo de los precios anteriores');
				$this->redirect(array('action' => 'index'));
				}else{

					$this->Flash->precioNoRespaldado('Los precios fueron modificados con éxito pero no se realizó un respaldo de los precios anteriores, notificar');
			$this->redirect(array('action' => 'index'));
				}
				
			}else{
				$this->Flash->error('Los precios no pudieron ser modificados');

			}
		}

	}//Fin modificar precios


	//Funcion para restaurar precios a una fecha anterior
	public function restaurar_precios() {

		$this->loadModel('PreciosServicio');
		$this->PreciosServicio->recursive = 0;
		
		$fechas = $this->PreciosServicio->find('all', array('fields' => array('DISTINCT PreciosServicio.created'), 'order' => array('PreciosServicio.created DESC')));

		$this->set('fechas', $fechas, $this->paginate());

		if (empty($servicio)) {
			return false;
		}else{
			return true;
		}


	}//Fin restaurar precios


	/*public function imprimir() {

		

		$this->Servicio->recursive = 0;
		$servicio = $this->Servicio->find('all', array('order' => 'Servicio.id ASC'), array('conditions' => array('Servicio.borrado' => 0)));
		
		
		$this->pdfConfig = array(
			'download' => true,
			'filename' => 'Listado_Servicios_Terared.pdf'
		);
		$this->set('servicios', $servicio, $this->paginate());

    }*/

    /*
		NOTA IMPORTANTE:
		PARA LA VISUALIZACION DE LOS ARCHIVOS EN FORMATO PDF, SE TUVO QUE IMPORTAR DESD LA VISTA
		DONDE ESTA PRESENTE TODA LA INFORMACION QUE SERA MOSTRADA AL USUARIO EL ARCHIVO tcpdf de:
		App::import('Vendor', 'tcpdf/tcpdf');
		A SU VEZ ANTES DE MOSTRAR DICHO ARCHIVO DEBEMOS LIMPIAR EL BUFFER CON ob_end_clean() en la lineas 112 del archivo imprimir.ctp
    */


    public function imprimir($id = 2){

    	if (!$id)
        {
            $this->Session->setFlash('no has seleccionado ningun pdf.');
            $this->redirect(array('action'=>'index'));
        }
        // Sobrescribimos para que no aparezcan los resultados de debuggin
        // ya que sino daria un error al generar el pdf.
        Configure::write('debug', 0);
        $resultado = $this->Servicio->find('all', array('order' => 'Servicio.id ASC'), array('conditions' => array('Servicio.borrado' => 0))); 
        $this->set('servicios',$resultado);
        $this->layout = 'pdf'; //esto usara el layout pdf.ctp

        $this->render();
		
    }


    public function reporte(){

	
	}


	public function tabla_reporte(){

		if ($this->request->is('ajax')) {

			
			$finicio = $this->request->data['desde'];
			$ffin = $this->request->data['hasta'];
			
				$this->loadModel('Servicio');

				$consulta_reporte = $this->Servicio->query("SELECT servicios.nombreservicio AS NOMBRE_SERVICIOS, SUM(detalle_tickets.monto) AS TOTAL, SUM(detalle_tickets.cantidad) AS CANT_POR_SERVICIO FROM servicios, tickets, detalle_tickets WHERE tickets.id = detalle_tickets.ticket_id AND servicios.id = detalle_tickets.servicio_id AND tickets.estadoticket = 'Facturado'AND detalle_tickets.borrado = false AND DATE(tickets.modified) BETWEEN '$finicio' AND '$ffin' GROUP BY servicios.id ORDER BY SUM(detalle_tickets.monto) DESC");
				//debug($consulta_reporte);
				$this->set('servicios', $consulta_reporte);

			//$this->autoRender = false;
		}
		
	}



}//	FIN CLASE
