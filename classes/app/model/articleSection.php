<?php
namespace App\Model;

class ArticleSection extends \PHPixie\ORM\Model {
    // Table name
    public $table = 'articleSections';
    
    // Primary key
    public $id_field = 'id';    
    
    // Each section belongs to a article
    protected $belongs_to=array(
        'article'=>array(
            'model'=>'article',
            'key'=>'article_id'
        ),
        'template'=>array(
            'model'=>'TemplateSection',
            'key'=>'section_id'
        )
    );
}
