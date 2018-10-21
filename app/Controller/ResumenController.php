<?php
App::uses('AppController', 'Controller');
/**
 * Facturas Controller
 *
 * @property Factura $Factura
 * @property PaginatorComponent $Paginator
 */
class ResumenController extends AppController {

/**
 * Components
 *
 * @var array
 */
	//public $components = array('Paginator');


	public $paginate = array(

		'limit' => 10,
		'order' => array(
			'Cierre.id' => 'asc'

			)

		);

public function isAuthorized($usuario)
	{

		$privilegio = $this->Session->read('privilegio_id');

		if ($privilegio == '4') {

			
				if (in_array($this->action, array('index'))) {
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
			$efectivo = $this->DetallePago->query("SELECT SUM(detalle_pagos.total) AS EFECTIVO FROM detalle_pagos, efectivos, tickets, usuarios, turno_cajeros WHERE efectivos.id = detalle_pagos.efectivo_id AND tickets.id = detalle_pagos.ticket_id AND tickets.turno_cajero_id = turno_cajeros.id AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero 
				AND turno_cajeros.estadoturno = 'A'"); 

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
				AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero
				AND turno_cajeros.estadoturno = 'A' "); 

			$this->set('puntos', $punto);


			//POR TRANSFERENCIAS
			$transferencia = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TRANSFERENCIAS
				FROM detalle_pagos, transferencias, tickets, usuarios, turno_cajeros
				WHERE transferencias.id = detalle_pagos.transferencia_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id 
				AND turno_cajeros.usuario_id = usuarios.id AND usuarios.id = $idCajero
				AND turno_cajeros.estadoturno = 'A' "); 

			$this->set('transferencias', $transferencia);


			//GASTOS
			$this->loadModel('Gasto');
			$gastos = $this->Gasto->query("SELECT  SUM(gastos.montogasto) AS GASTOS
				FROM gastos, usuarios, turno_cajeros
				WHERE usuarios.id = $idCajero
				AND turno_cajeros.usuario_id = usuarios.id
				AND gastos.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('gastos', $gastos);


			//TOTAL INGRESOS
			$total = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos, tickets, usuarios, turno_cajeros
				WHERE tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id 
				AND usuarios.id = $idCajero
				AND turno_cajeros.estadoturno = 'A'"); 

			$this->set('total', $total);

			$NoHayDatos = null;

			$this->set('NoHayDatos', $NoHayDatos);
			
		} else {
			$NoHayDatos = 'NoHayDatos';
			
			$this->set('NoHayDatos', $NoHayDatos);

			$this->set('datosCajero', $idCajero);


		}
			
		

	}






	public function principal() {
		$this->loadModel('Cierre');

		$this->paginate['Cierre']['limit'] = 20;
		$this->paginate['Cierre']['order'] = array('Cierre.id' => 'desc');
		$this->set('cierres', $this->paginate());

		//$cierres = $this->Cierre->find('all', array('order' => array('Cierre.id' => 'DESC'), 'recursive' => -1));
		//$ticket = $this->Ticket->find('all', array('conditions' => array('Pagado'), 'order' => array('Ticket.modified' => 'DESC')));
		//$this->set('cierres', $cierres);
	}



	public function detalle($idCierre = null){

		if ($idCierre == null) {
			throw new NotFoundException("No se encuentra el id del cierre", 1);
			
		}

		$this->loadModel('TurnoCajero');

		$turnos = $this->TurnoCajero->find('all', array('conditions' => array('TurnoCajero.cierre_id' => $idCierre), 'recursive' => 1));
		$this->set('turnos', $turnos);

		$this->set('idcierre', $idCierre);

	}


	public function tickets_cobrados(){

		
	}




	public function ver($idTurno = null, $idcierre = null) {

		if ($idTurno === null || $idcierre === null) {
			throw new NotFoundException("No se encuentra el id del cierre o el id del turno", 1);
			
		}

		$this->set('idcierre', $idcierre);

		//FACTURAS EMITIDAS
		$this->loadModel('Factura');
		$maxFactura = $this->Factura->query("SELECT MAX(facturas.nfactura) AS MAX FROM facturas, tickets, turno_cajeros, cierres
			WHERE facturas.id = tickets.factura_id
			AND tickets.turno_cajero_id = turno_cajeros.id
			AND turno_cajeros.id = $idTurno");

		$minFactura = $this->Factura->query("SELECT MIN(facturas.nfactura) AS MIN FROM facturas, tickets, turno_cajeros, cierres
			WHERE facturas.id = tickets.factura_id
			AND tickets.turno_cajero_id = turno_cajeros.id
			AND turno_cajeros.id = $idTurno");

		$this->set('maxFactura', $maxFactura);
		$this->set('minFactura', $minFactura);

		//BUSCAMOS DATOS DEL TURNO
		$this->loadModel('TurnoCajero');
			$turno = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.id' => $idTurno)));

			$this->set('datosTurno', $turno);
			//debug($cierre);

			$idUsuario = $turno['TurnoCajero']['usuario_id'];
			$idTurno = $turno['TurnoCajero']['id'];

			//$this->loadModel('TurnoCajero');
			//$turno = $this->TurnoCajero->find('first', array('conditions' => array('TurnoCajero.id' => $idTurno)));

			//$this->set('datosTurno', $turno);
			
			//BUSCAMOS EL MONTO DEL REPORTEX/Z ANTERIOR


			/*$this->loadModel('TurnoCajero');
			$cierreAnterior = $this->TurnoCajero->query("SELECT MAX(cierres.totalzx) AS 'anterior' FROM turno_cajeros WHERE cierres.id < $idCierre");
			$this->set('cierreAnterior', $cierreAnterior);*/

		if($idUsuario != null){
							
				$this->loadModel('Usuario');
				$datosCajero = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $idUsuario)));

				$this->set('datosCajero', $datosCajero);

			}else {
				$idUsuario = null;
			}


		if($idUsuario != null){
		$this->loadModel('DetallePago');
			//EFECTIVO
			$efectivo = $this->DetallePago->query("SELECT SUM(detalle_pagos.total) AS EFECTIVO FROM detalle_pagos, efectivos, tickets, usuarios, turno_cajeros WHERE efectivos.id = detalle_pagos.efectivo_id AND tickets.id = detalle_pagos.ticket_id AND tickets.turno_cajero_id = turno_cajeros.id AND turno_cajeros.usuario_id = usuarios.id AND turno_cajeros.id = $idTurno "); 

			$this->set('efectivo', $efectivo);

			//POR CADA PUNTO
			$puntos = $this->DetallePago->query("SELECT bancopuntos.nombre, SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos,puntos, tickets, usuarios, turno_cajeros, bancopuntos 
				WHERE bancopuntos.id = puntos.bancopunto_id
				AND puntos.id = detalle_pagos.punto_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND turno_cajeros.id = $idTurno 
				GROUP BY bancopuntos.nombre"); 

			$this->set('cadaPunto', $puntos);



			//TOTAL EN PUNTOS
			$punto = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS PUNTOS
				FROM detalle_pagos,puntos, tickets, usuarios, turno_cajeros
				WHERE puntos.id = detalle_pagos.punto_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id
				AND turno_cajeros.usuario_id = usuarios.id AND turno_cajeros.id = $idTurno"); 

			$this->set('puntos', $punto);


			//POR TRANSFERENCIAS
			$transferencia = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TRANSFERENCIAS
				FROM detalle_pagos, transferencias, tickets, usuarios, turno_cajeros
				WHERE transferencias.id = detalle_pagos.transferencia_id 
				AND tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id 
				AND turno_cajeros.usuario_id = usuarios.id AND turno_cajeros.id = $idTurno"); 

			$this->set('transferencias', $transferencia);


			//GASTOS
			$this->loadModel('Gasto');
			$gastos = $this->Gasto->query("SELECT  SUM(gastos.montogasto) AS GASTOS
				FROM gastos, usuarios, turno_cajeros
				WHERE usuarios.id = $idUsuario
				AND turno_cajeros.id = $idTurno
				AND gastos.turno_cajero_id = turno_cajeros.id"); 

			$this->set('gastos', $gastos);


			//TOTAL INGRESOS
			$total = $this->DetallePago->query("SELECT  SUM(detalle_pagos.total) AS TOTAL
				FROM detalle_pagos, tickets, usuarios, turno_cajeros
				WHERE tickets.id = detalle_pagos.ticket_id 
				AND tickets.turno_cajero_id = turno_cajeros.id 
				AND turno_cajeros.usuario_id = usuarios.id 
				AND turno_cajeros.id = $idTurno"); 

			$this->set('total', $total);

			$NoHayDatos = null;

			$this->set('NoHayDatos', $NoHayDatos);
			
		} else {
			$NoHayDatos = 'NoHayDatos';
			
			$this->set('NoHayDatos', $NoHayDatos);

			$this->set('datosCajero', $idCajero);




		}



		
	}


}
