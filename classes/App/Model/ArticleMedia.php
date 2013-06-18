<?php
namespace App\Model;

class ArticleMedia extends \PHPixie\ORM\Model {
    // Table name
    public $table = 'articleMedia';
    
    // Primary key
    public $id_field = 'id';    
    
    // Each section belongs to a article
    protected $belongs_to=array(
        'article'=>array(
            'model'=>'article',
            'key'=>'article_id'
        )
    );
}
