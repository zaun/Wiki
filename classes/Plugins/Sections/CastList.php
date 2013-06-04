<?php

namespace Plugins\Sections;

class CastList extends \App\Sections\BaseList {
    public $abbr = "CastList";
    public $name = "Cast List";

    protected $showDetail        = true;
    protected $showAdditional    = true;

    protected $placeholderTitle         = "Character Name";
    protected $placeholderDetail        = "Actor or Actress Name";
    protected $placeholderAdditional    = "Short description of role...";
}
