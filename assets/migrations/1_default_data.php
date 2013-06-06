<?php
return array(
	// Site Tempates
	'templates' => array (
		'_data' => array(
		    'up' => array(
		        'insert' => array(
		            array('id' => 1, 'name' => 'Default', 'description' => 'A simple default article template'  ),
		            array('id' => 2, 'name' => 'Person',  'description' => 'A teample for articles about people'),
		            array('id' => 3, 'name' => 'Book',    'description' => 'A teample for articles about books' ),
		            array('id' => 4, 'name' => 'Movie',   'description' => 'A teample for articles about movies'),
		        ),
		    ),
		),
	),
	
	// Site Tempate Sections
	'template_sections' => array (
		'_data' => array(
		    'up' => array(
		        'insert' => array(
		            array('id' => 1,  'template_id' => 1, 'title' => 'Details',                   'type' => 'mu',         'order' => 0),

		            array('id' => 2,  'template_id' => 2, 'title' => 'Early Life',                'type' => 'mu',         'order' => 0),
		            array('id' => 3,  'template_id' => 2, 'title' => 'Family',                    'type' => 'mu',         'order' => 1),
		            array('id' => 4,  'template_id' => 2, 'title' => 'Later Life',                'type' => 'mu',         'order' => 2),
		            array('id' => 5,  'template_id' => 2, 'title' => 'Education',                 'type' => 'EduList',    'order' => 3),
		            array('id' => 6,  'template_id' => 2, 'title' => 'Career',                    'type' => 'EmpList',    'order' => 4),
		            array('id' => 7,  'template_id' => 2, 'title' => 'Awards',                    'type' => 'DetailList', 'order' => 5),
		            
		            array('id' => 8,  'template_id' => 3, 'title' => 'Synopsis',                  'type' => 'mu',         'order' => 0),
		            array('id' => 9,  'template_id' => 3, 'title' => 'Primary Characters',        'type' => 'CastList',   'order' => 1),
		            array('id' => 10, 'template_id' => 3, 'title' => 'Controversies',             'type' => 'mu',         'order' => 2),
		            array('id' => 11, 'template_id' => 3, 'title' => 'Controversies',             'type' => 'mu',         'order' => 3),
		            array('id' => 12, 'template_id' => 3, 'title' => 'Style and Themes',          'type' => 'mu',         'order' => 4),
		            array('id' => 13, 'template_id' => 3, 'title' => 'Publication and Reception', 'type' => 'mu',         'order' => 5),
		            array('id' => 14, 'template_id' => 3, 'title' => 'Awards',                    'type' => 'DetailList', 'order' => 6),
		            
		            array('id' => 15, 'template_id' => 4, 'title' => 'Plot',                      'type' => 'mu',         'order' => 0),
		            array('id' => 16, 'template_id' => 4, 'title' => 'Cast',                      'type' => 'CastList',   'order' => 1),
		            array('id' => 17, 'template_id' => 4, 'title' => 'Production',                'type' => 'mu',         'order' => 2),
		            array('id' => 18, 'template_id' => 4, 'title' => 'Production',                'type' => 'mu',         'order' => 3),
		            array('id' => 19, 'template_id' => 4, 'title' => 'Release',                   'type' => 'mu',         'order' => 4),
		            array('id' => 20, 'template_id' => 4, 'title' => 'Reception',                 'type' => 'mu',         'order' => 5),
		            array('id' => 21, 'template_id' => 4, 'title' => 'Awards',                    'type' => 'DetailList', 'order' => 6),
		            array('id' => 22, 'template_id' => 4, 'title' => 'Sequel Possibilities',      'type' => 'mu',         'order' => 7),
		            array('id' => 23, 'template_id' => 4, 'title' => 'Sequels',                   'type' => 'MovieList',  'order' => 8),
		        ),
		    ),
		),
    ),
	
	// Site Tempate Attributes
	'template_attributes' => array (
		'_data' => array(
		    'up' => array(
		        'insert' => array(
                    array('id' => 1,  'template_id' => 2, 'title' => 'Personal',                  'type' => 'hdr',        'order' => 0),
                    array('id' => 2,  'template_id' => 2, 'title' => 'Birth Date',                'type' => 'date',       'order' => 1),
                    array('id' => 3,  'template_id' => 2, 'title' => 'Birth Location',            'type' => 'text',       'order' => 2),
                    array('id' => 4,  'template_id' => 2, 'title' => 'Death Date',                'type' => 'date',       'order' => 3),
                    array('id' => 5,  'template_id' => 2, 'title' => 'Death Location',            'type' => 'text',       'order' => 4),
                    array('id' => 6,  'template_id' => 2, 'title' => 'Gender',                    'type' => 'text',       'order' => 5),
                    array('id' => 7,  'template_id' => 2, 'title' => 'Occupation',                'type' => 'text',       'order' => 6),
                    array('id' => 8,  'template_id' => 2, 'title' => 'Known For',                 'type' => 'text',       'order' => 7),
                    array('id' => 9,  'template_id' => 2, 'title' => 'Nationality',               'type' => 'text',       'order' => 8),
                    array('id' => 10, 'template_id' => 2, 'title' => 'Religion',                  'type' => 'text',       'order' => 9),
                    array('id' => 11, 'template_id' => 2, 'title' => 'Family',                    'type' => 'hdr',        'order' => 10),
                    array('id' => 12, 'template_id' => 2, 'title' => 'Mother',                    'type' => 'text',       'order' => 11),
                    array('id' => 13, 'template_id' => 2, 'title' => 'Father',                    'type' => 'text',       'order' => 12),
                    array('id' => 14, 'template_id' => 2, 'title' => 'Siblings',                  'type' => 'attrLst',    'order' => 13),
                    array('id' => 15, 'template_id' => 2, 'title' => 'Spouse',                    'type' => 'text',       'order' => 14),
                    array('id' => 16, 'template_id' => 2, 'title' => 'Wedding Date',              'type' => 'date',       'order' => 15),
                    array('id' => 17, 'template_id' => 2, 'title' => 'Divorce Date',              'type' => 'date',       'order' => 16),
                    array('id' => 18, 'template_id' => 2, 'title' => 'Children',                  'type' => 'attrLst',    'order' => 17),
                    
                    array('id' => 19, 'template_id' => 3, 'title' => 'Author(s)',                 'type' => 'attrLst',    'order' => 0),
                    array('id' => 20, 'template_id' => 3, 'title' => 'Genre',                     'type' => 'text',       'order' => 1),
                    array('id' => 21, 'template_id' => 3, 'title' => 'Series Name',               'type' => 'text',       'order' => 2),
                    array('id' => 22, 'template_id' => 3, 'title' => 'Book Number',               'type' => 'text',       'order' => 3),
                    array('id' => 23, 'template_id' => 3, 'title' => 'Preceded By',               'type' => 'text',       'order' => 4),
                    array('id' => 24, 'template_id' => 3, 'title' => 'Followed By',               'type' => 'text',       'order' => 5),
                    array('id' => 25, 'template_id' => 3, 'title' => 'First Edition',             'type' => 'hdr',        'order' => 6),
                    array('id' => 26, 'template_id' => 3, 'title' => 'Country',                   'type' => 'text',       'order' => 7),
                    array('id' => 27, 'template_id' => 3, 'title' => 'Illustrator(s)',            'type' => 'attrLst',    'order' => 8),
                    array('id' => 28, 'template_id' => 3, 'title' => 'Cover Artist',              'type' => 'attrLst',    'order' => 9),
                    array('id' => 29, 'template_id' => 3, 'title' => 'Publisher',                 'type' => 'text',       'order' => 10),
                    array('id' => 30, 'template_id' => 3, 'title' => 'Published',                 'type' => 'date',       'order' => 11),
                    array('id' => 31, 'template_id' => 3, 'title' => 'Chapters',                  'type' => 'text',       'order' => 12),
                    array('id' => 32, 'template_id' => 3, 'title' => 'Pages',                     'type' => 'text',       'order' => 13),
                    array('id' => 33, 'template_id' => 3, 'title' => 'ISBN',                      'type' => 'text',       'order' => 14),
                    array('id' => 34, 'template_id' => 3, 'title' => 'OCLC Number',               'type' => 'text',       'order' => 16),
                ),
		    ),
		),
	),

    // Site articles
	'articles' => array (
		'_data' => array(
		    'up' => array(
		        'insert' => array(
                    array('template_id' => 1, 'title' => 'Welcome', 'url' => 'Welcome', 'summary' => '', 'summary_html' => ''),
                ),
		    ),
		),
	),

);