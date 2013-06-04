<?php
namespace App\Controller;

class Installer extends \App\Wizard {

    protected $template = "installer";

    public function before() {
        parent::before();

        // If we are already initilized then back out to the website
        if ($this->pixie->config->get('application.initilized', false) === true) {
            $this->redirect('/');
 
            // Prevent action and after() from firing
            $this->execute=false;
            return;
        }

        $this->wizardName = "Installer";
    }
    
    
    public function action_start() {
        $this->pageView = 'start';
        $this->view->pageTitle = "Welcome to the installation wizard";

        // Buttons
		$this->urlNext = 'database';
    }
    

	public function action_database() {
		$this->pageView = 'database';
		$this->view->pageTitle = 'Database Configuration';

        // Buttons
		$this->view->btnBack = true;
		$this->urlBack = '';
		$this->urlNext = 'application';
		
		// Set the current values
		if ($this->pixie->session->get('temp.dbServer', '--__--None--__--') == '--__--None--__--') {
		    $this->view->dbServer = $this->pixie->config->get('db.default.host', 'localhost');
		} else {
		    $this->view->dbServer = $this->pixie->session->get('temp.dbServer');
		}
		
		if ($this->pixie->session->get('temp.dbName', '--__--None--__--') == '--__--None--__--') {
		    $this->view->dbName = $this->pixie->config->get('db.default.db', 'localhost');
		} else {
		    $this->view->dbName = $this->pixie->session->get('temp.dbName');
		}
		
		if ($this->pixie->session->get('temp.dbUser', '--__--None--__--') == '--__--None--__--') {
    		    $this->view->dbUser = $this->pixie->config->get('db.default.user', 'root');
		} else {
		    $this->view->dbUser = $this->pixie->session->get('temp.dbUser');
		}
		$this->view->dbPass = '';
	}
    

	public function action_application() {
		$this->pageView = 'application';
		$this->view->pageTitle = 'Application Configuration';
		
		// Validate input
		$this->pixie->session->set('temp.dbServer', $this->request->post('dbServer', $this->pixie->session->get('temp.dbServer', '')));
		$this->pixie->session->set('temp.dbName', $this->request->post('dbName', $this->pixie->session->get('temp.dbName', '')));
		$this->pixie->session->set('temp.dbUser', $this->request->post('dbUser', $this->pixie->session->get('temp.dbUser', '')));
		$this->pixie->session->set('temp.dbPass', $this->request->post('dbPass', $this->pixie->session->get('temp.dbPass', '')));
		
	    if ($this->pixie->session->get('temp.dbServer', '') == '' || 
	        $this->pixie->session->get('temp.dbName', '') == '' || 
	        $this->pixie->session->get('temp.dbUser', '') == '')
	    {
            $this->redirect('/~installer/database');
            $this->execute=false;
            return;
	    }
	    
	    // Set the database temp config to the new information
        $this->pixie->config->set('db.test.host', $this->pixie->session->get('temp.dbServer'));
        $this->pixie->config->set('db.test.db', $this->pixie->session->get('temp.dbName'));
        $this->pixie->config->set('db.test.user', $this->pixie->session->get('temp.dbUser'));
        $this->pixie->config->set('db.test.password', $this->pixie->session->get('temp.dbPass'));
        $this->pixie->config->set('db.test.connection', 'mysql:host='.$this->pixie->session->get('temp.dbServer').';dbname='.$this->pixie->session->get('temp.dbName').'');

        // Test the connection
        $valid = true;

        if ($valid === true) {
            // Write it to file
            $this->pixie->config->set('db.test.host', '');
            $this->pixie->config->set('db.test.db', '');
            $this->pixie->config->set('db.test.user', '');
            $this->pixie->config->set('db.test.password', '');
            $this->pixie->config->set('db.test.connection', '');

            $this->pixie->config->set('db.default.host', $this->pixie->session->get('temp.dbServer'));
            $this->pixie->config->set('db.default.db', $this->pixie->session->get('temp.dbName'));
            $this->pixie->config->set('db.default.user', $this->pixie->session->get('temp.dbUser'));
            $this->pixie->config->set('db.default.password', $this->pixie->session->get('temp.dbPass'));
            $this->pixie->config->set('db.default.connection', 'mysql:host='. $this->pixie->session->get('temp.dbServer').';dbname='. $this->pixie->session->get('temp.dbName').'');
            $this->pixie->config->write('db');
        } else {
            // Couldn't connect
            $this->redirect('/~installer/database');
            $this->execute=false;
            return;
        }

        
		// Set the current values
		if ($this->pixie->session->get('temp.appName', '--__--None--__--') == '--__--None--__--') {
		    $this->view->appName = $this->pixie->config->get('application.name', 'Wiki');
		} else {
		    $this->view->appName = $this->pixie->session->get('temp.appName') . "dd";
		}
		if ($this->pixie->session->get('temp.appEmail', '--__--None--__--') == '--__--None--__--') {
		    $this->view->appEmail = $this->pixie->config->get('application.email', '');;
		} else {
		    $this->view->appEmail = $this->pixie->session->get('temp.appEmail');
		}
		if ($this->pixie->session->get('temp.appNickname', '--__--None--__--') == '--__--None--__--') {
		    $this->view->appNickname = $this->pixie->config->get('application.nickname', '');
		} else {
		    $this->view->appNickname = $this->pixie->session->get('temp.appNickname');
		}

        // Buttons
        $this->view->btnBack = true;
        $this->urlBack = 'database';
        $this->view->btnNext = false;
        $this->view->btnFinished = true;
    	}
    

	public function action_save() {
        $this->pageView = 'finish';
        $this->view->pageTitle = 'Thank You';
        $this->view->btnNext = false;
        $this->view->btnReturn = true;
        
        // Read in the application settings
        $appName = $this->request->post('appName', '--__--None--__--');
        $appEmail = $this->request->post('appEmail', '--__--None--__--');
        $appNickname = $this->request->post('appNickname', '--__--None--__--');
        $appPass = $this->request->post('appPassword', '');
        $appLicense = "by" . $this->request->post('appCommercial', '') . $this->request->post('appModification', '');
        
	    if ($appName == '--__--None--__--' || $appEmail == '--__--None--__--' || $appPass == '')
	    {
            $this->response->redirect('/~installer/application');
            $this->execute=false;
            return;
	    }

		$this->pixie->session->set('temp.appName', $appName);
		$this->pixie->session->set('temp.appEmail', $appEmail);
		$this->pixie->session->set('temp.appNickname', $appNickname);
		$this->pixie->session->set('temp.appLicense', $appLicense);
	    
	    // Write config to file
        $this->pixie->config->set('application.name', $appName);
        $this->pixie->config->set('application.license', $appLicense);
        $this->pixie->config->write('application');

        // Install the database
        $migrate = $this->pixie->migrate->get('default');
        $last_version=end($migrate->versions)->name;
        $migrate->migrate_to($last_version);
        
        // Update the system table with the new database scheme version
        $system = $this->pixie->orm->get('system')->where('name','db_scheme_version')->find();
        $system->name = 'db_scheme_version';
        $system->value = $migrate->current_version;
        $system->save();
        
        // Set as application initilaze
        $this->pixie->config->set('application.initilized', true);
        $this->pixie->config->write('application');
    }
}
