<?php

namespace App\Sections;

class Base {
    function __construct($request) {
        $this->request = $request;
    }
}
