<?php

namespace App\Attributes;

class Date extends Base {
    public $abbr = "date";
    public $name = "Date";
    
    
    public function edit($id, $title, $raw) {
        $out = "<div class='row'>";
        $out .= "<label>" . $title . "</label>";
        $out .= "<data>";
        $out .= "<input class='date small' id='attr-" . $id . "' name='attr-" . $id . "' value='" . $raw . "' placeholder='YYYY-MM-DD' />";
        $out .= "<div style='display:none;'><img class='icon' id='trigger-for-attr-" . $id . "' src='/images/cal.png' alt='Calendar Icon' /></div>";
        $out .= "</data>";
        $out .= "</div>";
        return $out;
    }
    
    
    /*
     * Included once on the edit page
     */
    public function editOnce() {
    }
    
    
    public function jsEdit() {
        $EOL = "\n";
        $out  = "$(document).ready(function() {" . $EOL;
        $out .= "    $('.pageAttributes .date').each(function() {" . $EOL;
        $out .= "        var \$trigger = $('#trigger-for-' + $(this).attr('id'));" . $EOL;
//        $out .= "        alert(\$trigger[0]);";
        $out .= "        $(this).datepick({" . $EOL;
        $out .= "            showOnFocus: false," . $EOL;
        $out .= "            showTrigger: \$trigger," . $EOL;
        $out .= "            dateFormat: 'yyyy-mm-dd' " . $EOL;
        $out .= "        });" . $EOL;
        $out .= "    });" . $EOL;
        $out .= "});" . $EOL;
        return $out;
    }
    
    
    public function jsView() {
    }
    
    
    public function rawValue($request, $id) {
        $sID = 'attr-' . $id;
        return $request->post($sID, '', false);
    }
    

    public function htmlValue($request, $id) {
        $raw = $this->rawValue($request, $id);
        if (empty($raw) || $raw == '[]') {
            return "";
        }
        return $this->convertRawToHtml($raw);
    }
    
    
    public function convertRawToHtml($raw) {
        $html = Date("F jS, Y", strtotime($raw));
        return $html;
    }
    
    
    private function cleanup($text) {
        $text = preg_replace('{^\xEF\xBB\xBF|\x1A}', '', $text);
        $text = preg_replace('{\r\n?}', "\n", $text);
        $text = trim($text);
        $text .= "\n";
        return $text;
    }


    public function rawToHtml($text) {
        $text = $this->cleanup($text);
	    $text = htmlspecialchars($text, ENT_COMPAT, "UTF-8");
	    $text = str_replace("\n", "<br />", $text);
	    return $text;
    }
    
    
    public function templateValues($raw) {
        $text = $this->convertRawToHtml($raw);
        return $text;
    }

    private function startsWith($haystack, $needle) {
        return !strncmp($haystack, $needle, strlen($needle));
    }
}
