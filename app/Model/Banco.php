<?php
App::uses('AppModel', 'Model');
/**
 * Banco Model
 *
 * @property Transferencia $Transferencia
 */
class Banco extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nombrebanco';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nombrebanco' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
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
		'Transferencia' => array(
			'className' => 'Transferencia',
			'foreignKey' => 'banco_id',
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
