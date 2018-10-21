<?php
App::uses('AppModel', 'Model');
/**
 * Efectivo Model
 *
 * @property DetallePago $DetallePago
 */
class Efectivo extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'monto' => array(
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'DetallePago' => array(
			'className' => 'DetallePago',
			'foreignKey' => 'efectivo_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
