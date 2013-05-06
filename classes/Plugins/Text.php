<?php

namespace Plugins;

class Text {
    public $abbr = "txt";
    public $name = "Text";
    
    
    public function edit($id, $title, $raw) {
        $out  = "<h2>" . $title . "</h2>";
        $out .= "<textarea class='text expanding' id='section-" . $id . "' name='section-" . $id . "'>" . $raw . "</textarea>";
        return $out;
    }
    
    
    /*
     * Included once on the edit page
     */
    public function editOnce() {
    }
    
    
    public function jsEdit() {
    }
    
    
    public function jsView() {
    }
    
    
    public function rawValue($request, $id) {
        $sID = 'section-' . $id;
        return $request->post($sID, '', false);
    }
    
    
    public function htmlValue($request, $id) {
        $raw = $this->rawValue($request, $id);
        $html = $this->rawToHtml($raw);
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
}

return new Text();
