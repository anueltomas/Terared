<?php
App::uses('AppController', 'Controller');
/**
 * Cierres Controller
 *
 * @property Cierre $Cierre
 * @property PaginatorComponent $Paginator
 */
class CierresController extends AppController {

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

			
				if (in_array($this->action, array('add', 'index', 'edit', 'calcular'))) {
				return true;
				}
						
			}

				
		return parent::isAuthorized($usuario);

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cierre->recursive = 0;
		$this->set('cierres', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cierre->exists($id)) {
			throw new NotFoundException(__('Invalid cierre'));
		}
		$options = array('conditions' => array('Cierre.' . $this->Cierre->primaryKey => $id));
		$this->set('cierre', $this->Cierre->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($idTurno = null) {

		//BUSCAMOS EL CAJERO ACTUAL
		$this->loadModel('TurnoCajero');
		$idCajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

		$idCajero = $idCajero['TurnoCajero']['usuario_id'];
		

		if ($idTurno == null) {
			throw new NotFoundException("Error con el id del turno", 1);
			
		}

		if ($this->request->is('post')) {

			$datos = array(
				'id' => $idTurno,
				'montoturno' => $this->request->data['Cierre']['montoturno'],
				'observaciones' => $this->request->data['Cierre']['nota'],
				'estadoturno' => 'C');

			//debug($this->request->data);


			if ($this->TurnoCajero->save($datos)) {


				$dats = array('id' => $this->request->data['Cierre']['idCaja'],
								'montocierre' => $this->request->data['Cierre']['dia_mas_turno']);
			
				if ($this->Cierre->save($dats)) {

					$this->Flash->success(__('Los datos fueron guardados exitosamente.'));
					return $this->redirect(array('controller' => 'principal', 'action' => 'index'));

				} else {
					
					$this->Flash->error(__('El turno no pudo ser cerrado.'));
				}

				
			} else {
				$this->Flash->error(__('Los datos no pudieron ser guardados.'));
			}

		}
		 //BUSCANDO EL ID DEL TURNO
		$this->loadModel('TurnoCajero');
		$idTurno = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));

		$idTurno = $idTurno['TurnoCajero']['id'];

		$this->set('turno', $idTurno);

		$this->loadModel('Factura');
		$inicioFactura = $this->Factura->query("SELECT facturas.nfactura FROM facturas, tickets, usuarios, turno_cajeros 
				WHERE facturas.id = tickets.factura_id
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND usuarios.id = turno_cajeros.usuario_id
				AND turno_cajeros.estadoturno = 'A'
				AND turno_cajeros.usuario_id = $idCajero
				ORDER BY facturas.id ASC
				LIMIT 1");

		$finFactura = $this->Factura->query("SELECT facturas.nfactura FROM facturas, tickets, usuarios, turno_cajeros 
				WHERE facturas.id = tickets.factura_id
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND usuarios.id = turno_cajeros.usuario_id
				AND usuarios.id = $idCajero
				AND turno_cajeros.estadoturno = 'A'
				ORDER BY facturas.id DESC
				LIMIT 1");

		$Facturas = array('inicio' => $inicioFactura, 'fin' => $finFactura);
		$this->set('facturas', $Facturas);



		$monto_del_dia = $this->Cierre->find('first', array('fields' => array('id', 'Cierre.montocierre'), 'conditions' => array('Cierre.estadocierre' => 'A'), 'recursive' => -1));

		if (empty($monto_del_dia)) {
			$this->Flash->error('La caja no se encuentra abierta');
			return $this->redirect(array('controller' => 'tickets', 'action' => 'administrar_caja'));
		}

		$this->set('montoanterior', $monto_del_dia);

		$privilegio = $this->Session->read('privilegio_id');

		if ($privilegio != 4) {

			$this->loadModel('TurnoCajero');
			$idcajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A')));
			
			if($idcajero != null){
				$idCajero = $idcajero['TurnoCajero']['usuario_id'];
			
				$this->loadModel('Usuario');
				$datosCajero = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $idCajero)));

				$this->set('datosCajero', $datosCajero);
			}else {
				$idCajero = null;
			}
			
			

		} else {

			$idCajero = $this->Auth->user('id');

			$this->loadModel('TurnoCajero');
			$idcajero = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.estadoturno' => 'A', 'TurnoCajero.usuario_id' => $idCajero)));
			
			if($idcajero != null){
				$idCajero = $idcajero['TurnoCajero']['usuario_id'];
			
				$this->loadModel('Usuario');
				$datosCajero = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $idCajero)));

				$this->set('datosCajero', $datosCajero);
			}else {
				$idCajero = null;
			}

		}
		
		if($idCajero != null){
			//debug($idCajero);
			$this->loadModel('DetallePago');
			//EFECTIVO
			$efectivo = $this->DetallePago->query("SELECT SUM(detalle_pagos.total) AS EFECTIVO FROM detalle_pagos, efectivos, tickets, usuarios, turno_cajeros WHERE efectivos.id = detalle_pagos.efectivo_id AND tickets.id = detalle_pagos.ticket_id AND tickets.turno_cajero_id = turno_cajeros.id AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero AND turno_cajeros.estadoturno = 'A' "); 

			$this->set('efectivo', $efectivo);

			//POR CADA PUNTO
			$puntos = $this->DetallePago->query("SELECT bancopuntos.nombre, SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos,puntos, tickets, usuarios, turno_cajeros, bancopuntos 
				WHERE bancopuntos.id = puntos.bancopunto_id
				AND puntos.id = detalle_pagos.punto_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero
				AND turno_cajeros.estadoturno = 'A' 
				GROUP BY bancopuntos.nombre"); 

			$this->set('cadaPunto', $puntos);



			//TOTAL EN PUNTOS
			$punto = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS PUNTOS
				FROM detalle_pagos,puntos, tickets, usuarios, turno_cajeros
				WHERE puntos.id = detalle_pagos.punto_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('puntos', $punto);


			//POR TRANSFERENCIAS
			$transferencia = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TRANSFERENCIAS
				FROM detalle_pagos, transferencias, tickets, usuarios, turno_cajeros
				WHERE transferencias.id = detalle_pagos.transferencia_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('transferencias', $transferencia);


			//GASTOS
			$this->loadModel('Gasto');
			$gastos = $this->Gasto->query("SELECT  SUM(gastos.montogasto) AS GASTOS
				FROM gastos, usuarios, turno_cajeros
				WHERE usuarios.id = $idCajero
				AND turno_cajeros.usuario_id = usuarios.id
				AND gastos.turno_cajero_id = turno_cajeros.id AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('gastos', $gastos);


			//TOTAL INGRESOS
			$total = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos, tickets, usuarios, turno_cajeros
				WHERE tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id 
				AND usuarios.id = $idCajero AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('total', $total);

			$NoHayDatos = null;

			$this->set('NoHayDatos', $NoHayDatos);
			
		} else {
			$NoHayDatos = 'NoHayDatos';
			
			$this->set('NoHayDatos', $NoHayDatos);

			$this->set('datosCajero', $idCajero);


		}


	}//FIN FUNCTION ADD

public function calcular()
{
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
		if (!$this->Cierre->exists($id)) {
			throw new NotFoundException(__('Invalid cierre'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cierre->save($this->request->data)) {
				$this->Flash->success(__('The cierre has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The cierre could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cierre.' . $this->Cierre->primaryKey => $id));
			$this->request->data = $this->Cierre->find('first', $options);
		}
		$turnoCajeros = $this->Cierre->TurnoCajero->find('list');
		$this->set(compact('turnoCajeros'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cierre->id = $id;
		if (!$this->Cierre->exists()) {
			throw new NotFoundException(__('Invalid cierre'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Cierre->delete()) {
			$this->Flash->success(__('The cierre has been deleted.'));
		} else {
			$this->Flash->error(__('The cierre could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}



