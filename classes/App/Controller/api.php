<?php
namespace App\Controller;

class Api extends \PHPixie\Controller {    
    
    function action_login() {
	    $username = $this->request->post('user', '');
	    $password = $this->request->post('pass', '');
	    
	    // Authenticate the user
        $auth = false;
        $user = ORM::factory('user')->where('email', $username)
                                    ->where('passwordHash', hash("sha512", $password))
                                    ->find();
        if($user->loaded()) {
            $auth = true;
        }
        
        if ($auth === true) {
            // Setup session
            $this->pixie->session->set('auth', true);
            $this->pixie->session->set('username', $user->nickname?:$user->email);
	    } else {
	        // Clear session
	        $this->pixie->session->reset();
	    }
		
    }
    
    
    function action_logout() {
        // Clear session
        $this->pixie->session->reset();
    }
	
	
	function action_upload() {
	    $valid = "image/jpeg,image/png";
	    $tempfile = $_FILES['mediaFile']['tmp_name'];
	    $finfo = finfo_open(FILEINFO_MIME);
	    $filetype = explode(";", finfo_file($finfo, $tempfile))[0];
	    if (strpos($valid, $filetype) === false) {
            $this->response->body = json_encode(array(
                'error' => "The file mime type, " . $filetype . " is not permitted.",
            ));
            return;
	    }
	    $fileHash = md5_file($tempfile);
	    $fileData = addslashes(fread(fopen($tempfile, "rb"), filesize($tempfile)));
	    
        $this->response->body = json_encode(array(
            'error' => $filetype,
        ));
	}
	
	
	function update_top_bar() {
//		$bar = View::get('pageTopBar');
//		$bar->auth = Session::get('auth',false);
//		$this->response->body=json_encode(array(
//			'auth' => Session::get('auth', false),
//			'username' => Session::get('username', false),
//			'bar' => $bar->render()
//		));
	}
}
