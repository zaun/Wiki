<?php
namespace App\Model;

class User extends \PHPixie\ORM\Model {
    // Table name
    public $table = 'users';
    
    // Primary key
    public $id_field = 'id';
    
    protected $has_many = array (
        'rights' => array(
            'model' => 'right',
            'through' => 'user_rights',
            'key'=>'user_id', 
            'foreign_key'=>'right_id'
        )
    );
}
