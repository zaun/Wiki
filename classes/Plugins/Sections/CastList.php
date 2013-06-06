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

    protected $dataTitle      = "charachter";
    protected $dataDetail     = "actor";
    protected $dataAdditional = "description";

    public function convertRawToHtml($raw) {
        $items = json_decode($raw);
        $html = "<ul>";
        foreach ($items as $i) {
            $order = $i->itemOrder;
            $character = $i->{$this->dataTitle};
            $actor = $i->{$this->dataDetail};
            $description = $i->{$this->dataAdditional};
            
            if (!empty($character)) {
                $html .= "<li><strong>" . $character . "</strong>";
                if (!empty($actor)) {
                    $html .= " portrayed by <em>" . $actor . "</em>";
                }
                if (!empty($description)) {
                    $html .= "<div>" . $description . "</div>";
                }
                $html .= "</li>";
            }
        }
        $html .= "</ul>";
        return $html;
    }
}
