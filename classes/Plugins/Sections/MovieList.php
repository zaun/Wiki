<?php

namespace Plugins\Sections;

class SimpleList extends \App\Sections\BaseList {
    public $abbr = "MovieList";
    public $name = "Movie List";

    protected $showTitleDate     = true;
    protected $showDetail        = true;
    protected $showSubdetail     = true;
    protected $showAdditional    = true;

    protected $placeholderDetail        = "Tag line";
    protected $placeholderSubdetail     = "Director";
    protected $placeholderAdditional    = "Short Synopsis...";
}
