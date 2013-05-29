<?php
namespace App\Model;

class Post extends \PHPixie\ORM\Model {
    // Table name
    public $table = 'posts';
    
    // Primary key
    public $id_field = 'id';
    
    // Each section belongs to a article
    protected $belongs_to=array(
        'article'=>array(
            'model'=>'article',
            'key'=>'article_id'
        ),
        'template'=>array(
            'model'=>'temlpate',
            'key'=>'template_id'
        ),
        'parent'=>array(
            'model'=>'Post',
            'key'=>'parent_id'
        ),
        'owner'=>array(
            'model'=>'User',
            'key'=>'owner_id'
        ),
    );
    
    protected $has_many=array(
        'children'=>array(
            'model'=>'Post',
            'key'=>'parent_id'
        ),
    );
}
