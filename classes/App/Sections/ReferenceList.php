<?php

namespace App\Sections;

class ReferenceList extends \App\Sections\BaseList {
    public $abbr = "RefList";
    public $name = "Reference List";

    protected $showTitleDate = true;
    protected $showDetail    = true;
    protected $showSubdetail = true;
    protected $showTopSelect = true;
    
    protected $placeholderTitle         = "Author";
    protected $placeholderTitleDate     = "YYYY-MM-DD";
    protected $placeholderDetail        = "Title";
    protected $placeholderSubdetail     = "URL or ISBN";

    protected $optionsTopSelect     = array('Select a reference type...', '---', 'Website','Book','Magazine','Journal','Other');

    protected $dataTitle     = "author";
    protected $dataTitleDate = "publishDate";
    protected $dataDetail    = "title";
    protected $dataSubdetail = "url";
}
