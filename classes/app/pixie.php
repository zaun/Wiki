<?php

namespace App;

/**
 * Pixie dependency container
 *
 * @property-read \PHPixie\DB $db Database module
 * @property-read \PHPixie\ORM $orm ORM module
 */
class Pixie extends \PHPixie\Pixie {
    protected $instance_classes = array(
		'config'  => '\PHPixie\Config',
		'debug'   => '\PHPixie\Debug',
		'router'  => '\App\Router',
		'session' => '\PHPixie\Session',
	);
	
	protected $modules = array(
		'db' => '\PHPixie\DB',
		'orm' => '\PHPixie\ORM',
		'migrate' => '\PHPixie\Migrate',
		'auth' => '\PHPixie\Auth',
	);
	
    public $util;
    public function after_bootstrap() {
        $this->util = new Util;
    }
}
