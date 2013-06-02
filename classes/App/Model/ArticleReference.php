<?php
namespace App\Model;

class ArticleReference extends \PHPixie\ORM\Model {
    // Table name
    public $table = 'articleReferences';
    
    // Primary key
    public $id_field = 'id';
    
    protected $belongs_to=array(
        'article'=>array(
            'model'=>'article',
            'key'=>'article_id'
        )
    );
}
