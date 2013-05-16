<?php

namespace Plugins\Sections;

class EducationList extends SimpleList {
    public $abbr = "EduList";
    public $name = "Edutcation List";
    
    protected $showTitleDate = true;
    protected $showDetail    = true;

    protected $placeholderTitle     = "Educational institution";
    protected $placeholderTitleDate = "YYYY-MM-DD";
    protected $placeholderDetail    = "Degree earned";

    protected $dataTitle     = "institution";
    protected $dataTitleDate = "gradDate";
    protected $dataDetail    = "degree";


    public function convertRawToHtml($raw) {
        $items = json_decode($raw);
        $html = "<ol>";
        foreach ($items as $i) {
            $order = $i->itemOrder;
            $html .= "<li>" . $i->{$this->dataTitle} . " (" . $i->{$this->dataTitleDate} . ")<br />" . $i->{$this->dataDetail} . "</li>";
        }
        $html .= "</ol>";
        return $html;
    }
}
