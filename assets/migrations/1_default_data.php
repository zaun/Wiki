<?php
return array(
	// Site Tempates
	'templates' => array (
		'_data' => array(
		    'up' => array(
		        'insert' => array(
		            array('id' => 0, 'name' => 'Default', 'description' => 'A simple default article template'  ),
		            array('id' => 1, 'name' => 'Person',  'description' => 'A teample for articles about people'),
		            array('id' => 2, 'name' => 'Book',    'description' => 'A teample for articles about books' ),
		            array('id' => 3, 'name' => 'Movie',   'description' => 'A teample for articles about movies'),
		        ),
		    ),
		),
	),
	
	// Site Tempate Sections
	'template_sections' => array (
		'_data' => array(
		    'up' => array(
		        'insert' => array(
		            array('template_id' => 0, 'title' => 'Details',                   'type' => 'mu',         'order' => 0),

		            array('template_id' => 1, 'title' => 'Early Life',                'type' => 'mu',         'order' => 0),
		            array('template_id' => 1, 'title' => 'Family',                    'type' => 'mu',         'order' => 1),
		            array('template_id' => 1, 'title' => 'Later Life',                'type' => 'mu',         'order' => 2),
		            array('template_id' => 1, 'title' => 'Education',                 'type' => 'EduList',    'order' => 3),
		            array('template_id' => 1, 'title' => 'Career',                    'type' => 'EmpList',    'order' => 4),
		            array('template_id' => 1, 'title' => 'Awards',                    'type' => 'SimpList',   'order' => 5),
		            
		            array('template_id' => 2, 'title' => 'Synopsis',                  'type' => 'mu',         'order' => 0),
		            array('template_id' => 2, 'title' => 'Primary Characters',        'type' => 'CastList',   'order' => 1),
		            array('template_id' => 2, 'title' => 'Controversies',             'type' => 'mu',         'order' => 2),
		            array('template_id' => 2, 'title' => 'Controversies',             'type' => 'mu',         'order' => 3),
		            array('template_id' => 2, 'title' => 'Style and Themes',          'type' => 'mu',         'order' => 4),
		            array('template_id' => 2, 'title' => 'Publication and Reception', 'type' => 'mu',         'order' => 5),
		            
		            array('template_id' => 3, 'title' => 'Plot',                      'type' => 'mu',         'order' => 0),
		            array('template_id' => 3, 'title' => 'Cast',                      'type' => 'CastList',   'order' => 1),
		            array('template_id' => 3, 'title' => 'Production',                'type' => 'mu',         'order' => 2),
		            array('template_id' => 3, 'title' => 'Production',                'type' => 'mu',         'order' => 3),
		            array('template_id' => 3, 'title' => 'Release',                   'type' => 'mu',         'order' => 4),
		            array('template_id' => 3, 'title' => 'Reception',                 'type' => 'mu',         'order' => 5),
		            array('template_id' => 3, 'title' => 'Awards',                    'type' => 'DetailList', 'order' => 6),
		            array('template_id' => 3, 'title' => 'Sequel Possibilities',      'type' => 'mu',         'order' => 7),
		            array('template_id' => 3, 'title' => 'Sequels',                   'type' => 'MovieList',  'order' => 8),
		        ),
		    ),
		),
    ),
	
	// Site Tempate Attributes
	'template_attributes' => array (
		'_data' => array(
		    'up' => array(
		        'insert' => array(
		        ),
		    ),
		),
	),
);