<?php
return array(
	'view-template' => array('/!<id>', array(
	                         'controller' => 'template',
	                         'action'     => 'view')
	                        ),
	'othr-template' => array('/<action>/!<id>', array(
	                         'controller' => 'template')
	                        ),
	'api-special'   => array('/~api/<action>(/<object>)', array(
	                         'controller' => 'api')
	                        ),
	'inst-special'  => array('/~installer(/<action>)', array(
	                         'controller' => 'installer',
	                         'action'     => 'start')
	                        ),
	'view-sandbox'  => array('/~sandbox', array(
	                         'controller' => 'sandbox',
	                         'action'     => 'view')
	                        ),
	'othr-sandbox'  => array('/<action>/~sandbox', array(
	                         'controller' => 'sandbox')
	                        ),
	'view-special'  => array('/~<id>', array(
	                         'controller' => 'special',
	                         'action'     => 'view')
	                        ),
	'othr-special'  => array('/<action>/~<id>', array(
	                         'controller' => 'special')
	                        ),
	'view-article'  => array(array('/(<id>)', array('id'=>'[^/]+')), array(
	                         'controller' => 'article',
	                         'action'     => 'view',
	                         'id'         => 'Welcome')
	                        ),
	'othr-article'  => array(array('/<action>/<id>', array('id'=>'[^/]+')), array(
	                         'controller' => 'article')
	                        ),
);
