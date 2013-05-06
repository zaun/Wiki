<?php
namespace App\Model;

class Template extends \PHPixie\ORM\Model {
    // Table name
    public $table = 'templates';
    
    // Primary key
    public $id_field = 'id';
    
    // Each template can have many sections
    // Each template can be used by many articles
    protected $has_many=array(
        'sections'=>array(
            'model'=>'TemplateSection',
            'key'=>'template_id'
        ),
        'attributes'=>array(
            'model'=>'TemplateAttribute',
            'key'=>'template_id'
        ),
        'articles'=>array(
            'model'=>'Article',
            'key'=>'template_id'
        )
    );
}
