<?php
App::uses('AppModel', 'Model');
/**
 * Gasto Model
 *
 * @property TurnoCajero $TurnoCajero
 */
class Gasto extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'concepto' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'turno_cajero_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'TurnoCajero' => array(
			'className' => 'TurnoCajero',
			'foreignKey' => 'turno_cajero_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
