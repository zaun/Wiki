<?php
return array(
    // System table, holds general key=value pairs
    'system' => array (
		'id' => array (
			'type' => 'id'
		),
		'name' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'value' => array(
			'type' => 'varchar',
			'size' => 255
		)
	),
	
	// User account information
	'users' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
		'email' => array(
			'type' => 'varchar',
			'size' => 512
		),
		'nickname' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'passwordHash' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'points' => array(
			'type' => 'int',
			'default' => 10
		),
		'lastLogon' => array(
			'type' => 'date'
		),
		'lastIP' => array(
			'type' => 'varchar',
			'size' => 15
		)
	),
	
	// Access right groups
	'rights' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
		'points' => array(
			'type' => 'int',
			'default' => 10
		),
		'key' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'name' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'description' => array(
			'type' => 'varchar',
			'size' => 1024
		)
	),
	
	// User Rights
	'user_rights' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
		'user_id' => array(
			'type' => 'int'
		),
		'right_id' => array(
			'type' => 'int'
		)
	),
	
	// Site Tempates
	'templates' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
		'parent_id' => array(
			'type' => 'int'
		),
		'owner_id' => array(
			'type' => 'int'
		),
		'name' => array(
			'type' => 'varchar',
			'size' => 50
		),
		'description' => array(
			'type' => 'varchar',
			'size' => 1024
		),
		'lastEditUser' => array(
			'type' => 'int'
		),
		'lastEditIP' => array(
			'type' => 'varchar',
			'size' => 512
		),
		'lastEditDate' => array(
			'type' => 'date'
		),
	),
	
	// Site Tempate Sections
	'template_sections' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
	    'template_id' => array (
	        'type' => 'int'
	    ),
		'title' => array(
			'type' => 'varchar',
			'size' => 50
		),
		'type' => array(
			'type' => 'varchar',
			'size' => 50
		),
		'properties' => array(
			'type' => 'varchar',
			'size' => 2048
		),
		'order' => array(
			'type' => 'int'
		),
    ),
	
	// Site Tempate Attributes
	'template_attributes' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
	    'template_id' => array (
	        'type' => 'int'
	    ),
		'title' => array(
			'type' => 'varchar',
			'size' => 50
		),
		'summary' => array(
			'type' => 'varchar',
			'size' => 2048
		),
		'type' => array(
			'type' => 'varchar',
			'size' => 50
		),
		'order' => array(
			'type' => 'int'
		)
	),
	
	// Site Articles
	'articles' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
	    'template_id' => array (
	        'type' => 'int'
	    ),
		'title' => array(
			'type' => 'varchar',
			'size' => 256
		),
		'image_name' => array(
			'type' => 'varchar',
			'size' => 256
		),
		'image_title' => array(
			'type' => 'varchar',
			'size' => 30
		),
		'summary' => array(
			'type' => 'varchar',
			'size' => 4056
		),
		'summary_html' => array(
			'type' => 'text'
		),
		'owner_id' => array(
			'type' => 'int'
		),
		'private' => array(
			'type' => 'boolean'
		),
		'lastEditUser' => array(
			'type' => 'int'
		),
		'lastEditIP' => array(
			'type' => 'varchar',
			'size' => 512
		),
		'lastEditDate' => array(
			'type' => 'date'
		)
	),
	
	// Article Sections
	'articleSections' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
	    'article_id' => array (
	        'type' => 'int'
	    ),
	    'section_id' => array (
	        'type' => 'int'
	    ),
		'raw' => array(
			'type' => 'text'
		),
		'html' => array(
			'type' => 'text'
		),
		'lastEditUser' => array(
			'type' => 'int'
		),
		'lastEditIP' => array(
			'type' => 'varchar',
			'size' => 512
		),
		'lastEditDate' => array(
			'type' => 'date'
		)
	),	
	
	// Article Attributes
	'articleAttributes' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
	    'article_id' => array (
	        'type' => 'int'
	    ),
	    'attribute_id' => array (
	        'type' => 'int'
	    ),
		'raw' => array(
			'type' => 'text'
		),
		'html' => array(
			'type' => 'text'
		),
		'lastEditUser' => array(
			'type' => 'int'
		),
		'lastEditIP' => array(
			'type' => 'varchar',
			'size' => 512
		),
		'lastEditDate' => array(
			'type' => 'date'
		)
	),
	
	// Article References
	'articleReferences' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
	    'article_id' => array (
	        'type' => 'int'
	    ),
	    'type' => array (
	        'type' => 'enum',
	        'options' => array('Website','Book','Magazine','Journal','Other')
	    ),
	    'author' => array(
			'type' => 'text'
		),
	    'title' => array(
			'type' => 'text'
		),
	    'publishDate' => array(
			'type' => 'date'
		),
	    'url' => array(
			'type' => 'text'
		),
	    'isbn' => array(
			'type' => 'text'
		),
	    'issn' => array(
			'type' => 'text'
		),
		'lastEditUser' => array(
			'type' => 'int'
		),
		'lastEditIP' => array(
			'type' => 'varchar',
			'size' => 512
		),
		'lastEditDate' => array(
			'type' => 'date'
		)
	),
	
	// Discussions
	'posts' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
	    'article_id' => array (
	        'type' => 'int'
	    ),
	    'template_id' => array (
	        'type' => 'int'
	    ),
	    'parent_id' => array (
	        'type' => 'int'
	    ),
		'owner_id' => array(
			'type' => 'int'
		),
		'postDate' => array(
			'type' => 'date'
		),
		'title' => array(
			'type' => 'varchar',
			'size' => 512
		),
		'content' => array(
			'type' => 'varchar',
			'size' => 2048
		)
	)
);