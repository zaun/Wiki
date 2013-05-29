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
	'inst-special2'  => array('/~Installer(/<action>)', array(
	                         'controller' => 'installer',
	                         'action'     => 'start')
	                        ),
	'view-special'  => array('/~<id>', array(
	                         'controller' => 'special',
	                         'action'     => 'view')
	                        ),
	'othr-special'  => array('/<action>/~<id>', array(
	                         'controller' => 'special')
	                        ),
	'view-article'  => array('(/<id>)', array(
	                         'controller' => 'article',
	                         'action'     => 'view',
	                         'id'         => 'Welcome')
	                        ),
	'othr-article'  => array('/<action>/<id>', array(
	                         'controller' => 'article')
	                        ),
);
