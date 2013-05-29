<?php

namespace App;

class Router extends \PHPixie\Router {
    public function match($uri, $method = 'GET') {
        $clean = str_replace(' ','_', $uri);
        $clean = str_replace('+','_', $clean);
        $clean = str_replace('%20','_', $clean);
        
        if ($clean != $uri) {
            header("HTTP/1.1 301 Moved Permanently"); 
            header("Location: " . $clean);
            exit();
        } else {
            return parent::match($uri, $method);
        }
    }
}
