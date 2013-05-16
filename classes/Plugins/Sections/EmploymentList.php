<?php

namespace Plugins\Sections;

class EmploymentList extends SimpleList {
    public $abbr = "EmpList";
    public $name = "Employment List";
    
    protected $showTitleDate     = true;
    protected $showDetail        = true;
    protected $showAdditional    = true;

    protected $placeholderTitle         = "Company name";
    protected $placeholderTitleDate     = "YYYY-MM-DD";
    protected $placeholderDetail        = "Job title";
    protected $placeholderAdditional    = "Job description...";
}
