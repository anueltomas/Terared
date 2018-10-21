<?php
App::uses('AppModel', 'Model');
/**
 * DetallePago Model
 *
 * @property Ticket $Ticket
 * @property Transferencia $Transferencia
 * @property Efectivo $Efectivo
 * @property Punto $Punto
 */
class DetallePago extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'borrado' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ticket_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'total' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'ticket_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Transferencia' => array(
			'className' => 'Transferencia',
			'foreignKey' => 'transferencia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Efectivo' => array(
			'className' => 'Efectivo',
			'foreignKey' => 'efectivo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Punto' => array(
			'className' => 'Punto',
			'foreignKey' => 'punto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
