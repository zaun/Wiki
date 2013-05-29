<?php
namespace App\Model;

class ArticleAttribute extends \PHPixie\ORM\Model {
    // Table name
    public $table = 'articleAttributes';
    
    // Primary key
    public $id_field = 'id';    
    
    // Each section belongs to a article
    protected $belongs_to=array(
        'article'=>array(
            'model'=>'article',
            'key'=>'article_id'
        ),
        'template'=>array(
            'model'=>'TemplateAttribute',
            'key'=>'attribute_id'
        )
    );
}
