<?php

namespace App\Attributes;

class Base {
    function __construct($request) {
        $this->request = $request;
    }
    
    function templateValues($raw) {
        // assume just text, this should be overridden
        // remove links
        $text = str_replace("[", "", $raw);
        $text = str_replace("]", "", $text);
        return $text;
    }
}
