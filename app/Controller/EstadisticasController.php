<?php
App::uses('AppController', 'Controller');
/**
 * Facturas Controller
 *
 * @property Factura $Factura
 * @property PaginatorComponent $Paginator
 */
class EstadisticasController extends AppController {

	public function index() {
		$this->loadModel('Servicio');
		$servicios = $this->Servicio->query("SELECT servicios.nombreservicio AS nombre, COUNT(detalle_tickets.servicio_id) AS cantidad 
				FROM servicios, detalle_tickets, tickets
				WHERE servicios.id = detalle_tickets.servicio_id
				AND detalle_tickets.ticket_id = tickets.id
				AND tickets.estadoticket = 'Facturado'
				GROUP BY servicios.nombreservicio");

		$this->set('datos', $servicios);
		

	}

	public function ticketsAtendidos() {

		//ENVIANDO TICKETS ATENDIDOS
		$this->loadModel('Ticket');
		$ticketAtendidos = $this->Ticket->query("SELECT usuarios.nombreusuario AS nombre, SUM(detalle_tickets.monto) cantidad FROM tickets, detalle_tickets, usuarios
				WHERE tickets.estadoticket = 'Facturado'
				AND tickets.id = detalle_tickets.ticket_id
				AND detalle_tickets.usuario_id = usuarios.id
				GROUP BY usuarios.nombreusuario");

		$i = 0;

		foreach ($ticketAtendidos as $ticketAtendido) {
			
			$datos[] = array('nombre' => $ticketAtendidos[$i]['usuarios']['nombre'], 'cantidad' => intval($ticketAtendidos[$i][0]['cantidad']));
			
			$i++;
		}
		
		echo json_encode($datos);
		$this->autoRender = false;

	}

	public function servicios() {

		//ENVIANDO TICKETS ATENDIDOS
		$this->loadModel('Servicio');
		$servicios = $this->Servicio->query("SELECT servicios.nombreservicio AS nombre, COUNT(detalle_tickets.servicio_id) AS cantidad 
				FROM servicios, detalle_tickets, tickets
				WHERE servicios.id = detalle_tickets.servicio_id
				AND detalle_tickets.ticket_id = tickets.id
				AND tickets.estadoticket = 'Facturado'
				GROUP BY servicios.nombreservicio");

		$i = 0;

		foreach ($servicios as $servicio) {
			
			$datos[] = array('nombre' => $servicios[$i]['servicios']['nombre'], 'cantidad' => intval($servicios[$i][0]['cantidad']));
			
			$i++;
		}
		
		echo json_encode($datos);
		$this->autoRender = false;

	}

}