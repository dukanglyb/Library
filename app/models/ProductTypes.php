<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class ProductTypes extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * ProductTypes initializer
     */
    public function initialize()
    {
        $this->hasMany('id', 'Products', 'product_types_id', array(
        	'foreignKey' => array(
        		'message' => 'Product Type cannot be deleted because it\'s used in Products'
        	)
        ));
    }
}
