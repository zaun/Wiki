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
	
	
	function action_media() {
        $articleURL = $this->request->param('object', 'welcome');
        $articleORM = $this->articleORM = $this->pixie->orm->get('article')->where('url', $articleURL)->find();
		if ($articleORM->loaded()) {
            $resp = array('article' => $articleORM->title, 'article_url' => $articleORM->url);
            $media = array();
            $items = $articleORM->media->find_all();
            foreach ($items as $item) {
                $obj = array('title' => $item->title, 'url' => $item->url);
                array_push($media, $obj);
            }
            
            $resp['media'] = $media;
            $this->response->body = json_encode($resp);
		}
	}
	
	
	function action_upload() {
    	    $article = $this->request->post('mediaArticle', '');
    	    $title = $this->request->post('mediaTitle', '');
        $url = str_replace(' ','_', $article);
        $url = str_replace("'",'', $url);

		$articleORM = $this->articleORM = $this->pixie->orm->get('article')->where('url', $url)->find();
        if (!$articleORM->loaded()) {
            $this->response->body = json_encode(array(
                'error' => "Could not find artilce: " . $article,
            ));
            return;
        }
	    
	    $valid = "image/jpeg,image/png";
	    $tempfile = $_FILES['mediaFile']['tmp_name'];
        $name = $_FILES["mediaFile"]["name"];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

	    $finfo = finfo_open(FILEINFO_MIME);
	    $fileparts = explode(";", finfo_file($finfo, $tempfile));
	    $filetype = $fileparts[0];
	    if (strpos($valid, $filetype) === false) {
            $this->response->body = json_encode(array(
                'error' => "The file mime type, " . $filetype . " is not permitted.",
            ));
            return;
	    }
	    $fileHash = strtolower(md5_file($tempfile));
	    $fileData = addslashes(fread(fopen($tempfile, "rb"), filesize($tempfile)));
        
	    $scriptPath = dirname(__FILE__);
	    $mediaPath = dirname(dirname(dirname($scriptPath))) . "/assets/media/";
	    if (!file_exists($mediaPath)) {
            mkdir($mediaPath, 0700, true);
        }
        move_uploaded_file($tempfile, $mediaPath . "/" . $fileHash . "." . $ext);
        
        if (class_exists('Imagick')) {
            $im = new Imagick($mediaPath . "/" . $fileHash . "." . $ext);
            $im->thumbnailImage(250, 99999, TRUE);
            $im->writeImage($mediaPath . "/" . $fileHash . "-250." . $ext);
            
            $im = new Imagick($mediaPath . "/" . $fileHash . "." . $ext);
            $im->thumbnailImage(450, 99999, TRUE);
            $im->writeImage($mediaPath . "/" . $fileHash . "-450." . $ext);
        } else if (extension_loaded('gd')) {
            ini_set("memory_limit","1024M");
            list($source_image_width, $source_image_height, $source_image_type) = getimagesize($mediaPath . "/" . $fileHash . "." . $ext);
            switch ($source_image_type) {
                case IMAGETYPE_GIF:
                    $source_gd_image = @imagecreatefromgif($mediaPath . "/" . $fileHash . "." . $ext);
                    break;
                case IMAGETYPE_JPEG:
                    $source_gd_image = @imagecreatefromjpeg($mediaPath . "/" . $fileHash . "." . $ext);
                    break;
                case IMAGETYPE_PNG:
                    $source_gd_image = @imagecreatefrompng($mediaPath . "/" . $fileHash . "." . $ext);
                    break;
            }
            if ($source_gd_image === false) {
                $this->response->body = json_encode(array(
                    'error' => "Unknown Source: " . $source_image_type . ".",
                ));
                return false;
            }
            
            $source_aspect_ratio = $source_image_width / $source_image_height;
            $thumbnail_aspect_ratio = 250 / 99999;
            if ($source_image_width <= 250 && $source_image_height <= 99999) {
                $thumbnail_image_width = $source_image_width;
                $thumbnail_image_height = $source_image_height;
            } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                $thumbnail_image_width = (int) (99999 * $source_aspect_ratio);
                $thumbnail_image_height = 99999;
            } else {
                $thumbnail_image_width = 250;
                $thumbnail_image_height = (int) (250 / $source_aspect_ratio);
            }
            $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
            imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
                return false;
            switch ($source_image_type) {
                case IMAGETYPE_GIF:
                    imagegif($thumbnail_gd_image, $mediaPath . "/" . $fileHash . "-250." . $ext);
                    break;
                case IMAGETYPE_JPEG:
                    imagejpeg($thumbnail_gd_image, $mediaPath . "/" . $fileHash . "-250." . $ext, 90);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($thumbnail_gd_image, $mediaPath . "/" . $fileHash . "-250." . $ext, 9);
                $this->response->body = json_encode(array(
                    'error' => "Debug ",
                ));
                    break;
            }
            imagedestroy($thumbnail_gd_image);

            $thumbnail_aspect_ratio = 450 / 99999;
            if ($source_image_width <= 450 && $source_image_height <= 99999) {
                $thumbnail_image_width = $source_image_width;
                $thumbnail_image_height = $source_image_height;
            } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                $thumbnail_image_width = (int) (99999 * $source_aspect_ratio);
                $thumbnail_image_height = 99999;
            } else {
                $thumbnail_image_width = 450;
                $thumbnail_image_height = (int) (450 / $source_aspect_ratio);
            }
            $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
            imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
            switch ($source_image_type) {
                case IMAGETYPE_GIF:
                    imagegif($thumbnail_gd_image, $mediaPath . "/" . $fileHash . "-450." . $ext, 90);
                    break;
                case IMAGETYPE_JPEG:
                    imagejpeg($thumbnail_gd_image, $mediaPath . "/" . $fileHash . "-450." . $ext, 90);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($thumbnail_gd_image, $mediaPath . "/" . $fileHash . "-450." . $ext, 90);
                    break;
            }
            imagedestroy($source_gd_image);
            imagedestroy($thumbnail_gd_image);
        } else {
            $this->response->body = json_encode(array(
                'error' => "Could not scale.",
            ));
            return;
        }
        
        // Register media to article
        $articleMedia = $this->pixie->orm->get('articleMedia')->where('article_id', $articleORM->id)->where('hash', $fileHash)->find();
        $articleMedia->article = $articleORM;
        $articleMedia->hash = $fileHash;
        $articleMedia->url = $title;
        $articleMedia->url = str_replace(' ','_', $articleMedia->url);
        $articleMedia->url = str_replace("'",'', $articleMedia->url);
        $articleMedia->title = $title;
        $articleMedia->description = $title;
        $articleMedia->lastEditIP = $_SERVER['REMOTE_ADDR'];
        $articleMedia->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
        $articleMedia->save();

        $this->response->body = json_encode(array(
            'done' => "Everything OK",
        ));
        return;
    	}
	
	
	function action_phpinfo() {
	    phpinfo();
	    exit();
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
