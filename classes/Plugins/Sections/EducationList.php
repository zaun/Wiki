<?php

namespace Plugins\Sections;

class EducationList extends \App\Sections\BaseList {
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
            $school = $i->{$this->dataTitle};
            $gradDate = $i->{$this->dataTitleDate};
            $degree = $i->{$this->dataDetail};
            if (!empty($school) || !empty($gradDate) || !empty($degree)) {
                if (empty($school)) {
                    $school = "Unknown Institution";
                }
                $html .= "<li>" . $school;
                if (!empty($gradDate)) {
                    $html .= " (" . $gradDate . ")";
                }
                if (!empty($degree)) {
                    $html .= "<br />" . $degree;
                }
                $html .= "</li>";
            }
        }
        $html .= "</ol>";
        return $html;
    }
}
