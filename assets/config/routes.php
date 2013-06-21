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
	'view-special'  => array('/~<action>', array(
	                         'controller' => 'special')
	                        ),
	'othr-special'  => array('/<action>/~<id>', array(
	                         'controller' => 'special')
	                        ),
	'view-article'  => array(array('/(<id>)', array('id'=>'[^/]+')), array(
	                         'controller' => 'article',
	                         'action'     => 'view',
	                         'id'         => 'Welcome')
	                        ),
	'media-article' => array(array('/<id>/media/<title>(/<size>)', array('id'=>'[^/]+', 'title'=>'[^/]+')), array(
	                         'controller' => 'article',
	                         'action'     => 'media',
	                         'size'       => '450')
	                        ),
	'othr-article'  => array(array('/<action>/<id>', array('id'=>'[^/]+')), array(
	                         'controller' => 'article')
	                        ),
);
