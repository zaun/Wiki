<?php

namespace Plugins\Sections;

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

        // external link
        $html = preg_replace_callback(
            '/(\[)(.*?)(\])(\(((http[s]?)|ftp):\/\/)(.*?)(\))/',
            function ($match) {
                $link = strtolower(str_replace(" ", "+", trim($match[7])));
                $ret = "<a target='_blank' href='" . strtolower($match[5]) . "://" . $link . "'>" . trim($match[2]) . "</a>";
                if (strtolower($match[5]) == "http") {
                    $ret .= "<img src='/images/link_http.png' class='link' />";
                } else if (strtolower($match[5]) == "https") {
                    $ret .= "<img src='/images/link_https.png' class='link' />";
                } else if (strtolower($match[5]) == "ftp") {
                    $ret .= "<img src='/images/link_ftp.png' class='link' />";
                }
                return $ret;
            },
            $html
        );

        // internal link
        $html = preg_replace_callback(
            '/(\[)(.*?)(\])/',
            function ($match) {
                $link = str_replace(" ", "+", trim($match[2]));
                return "<a href='" . $link . "'>" . trim($match[2]) . "</a>";
            },
            $html
        );
        
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
