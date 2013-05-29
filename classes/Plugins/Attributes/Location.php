<?php

namespace Plugins\Attributes;

class Location {
    public $abbr = "loc";
    public $name = "Location";
    
    
    public function edit($id, $title, $raw) {
        if ($raw == "") {
            $raw = ["", "", ""];
        }
        $out = "<div class='row'>";
        $out .= "<label>" . $title . "</label>";
        $out .= "<data>";
        $out .= "<input class='location small' id='attr-" . $id . "' name='attr-" . $id . "' value='" . $raw[0] . "' placeholder='Name' />";
        $out .= "<img class='icon' id='for-atte-" . $id . "' src='/images/loc.png' alt='Location Icon' />";
        $out .= "</data>";
        $out .= "</div>";
        $out .= "<div class='row'>";
        $out .= "<data>";
        $out .= "<input class='lat' id='attr-" . $id . "-lat' name='attr-" . $id . "-lat' value='" . $raw[1] . "' placeholder='Latitude' />";
        $out .= "</data>";
        $out .= "</div>";
        $out .= "<div class='row'>";
        $out .= "<data>";
        $out .= "<input class='lon' id='attr-" . $id . "-lon' name='attr-" . $id . "-lon' value='" . $raw[2] . "' placeholder='Longitude' />";
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
        $html = $this->rawToHtml($raw);

        // Titled Links
        // [Digg](http://digg.com)
        // [Google](http://google.com)
        $html = preg_replace_callback(
            '/\[([^]]+)\]\(((?:https?|ftp):\/\/.*?)\)/',
            function ($match) {
                $title = trim($match[1]);
                $link = trim($match[2]);
                
                $ret = "";
                if ($this->startsWith(strtolower($link), "https")) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $title . "</a>";
                    $ret .= "<img src='/images/link_https.png' class='link' />";
                } else if ($this->startsWith(strtolower($link), "http")) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $title . "</a>";
                    $ret .= "<img src='/images/link_http.png' class='link' />";
                } else if ($this->startsWith(strtolower($link),  "ftp")) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $title . "</a>";
                    $ret .= "<img src='/images/link_ftp.png' class='link' />";
                } else {
                    $link = str_replace(" ", "_", $link);
                    $ret = "<a href='" . $link . "'>" . $title . "</a>";
                }
                return $ret;
            },
            $html
        );

        // Untitled Links
        // [Internal Page]
        // [http://google.com]
        $html = preg_replace_callback(
            '/(\[)(.*?)(\])/',
            function ($match) {
                $link = trim($match[2]);

                $ret = "";
                if ($this->startsWith(strtolower($link), "https")) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $link . "</a>";
                    $ret .= "<img src='/images/link_https.png' class='link' />";
                } else if ($this->startsWith(strtolower($link), "http")) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $link . "</a>";
                    $ret .= "<img src='/images/link_http.png' class='link' />";
                } else if ($this->startsWith(strtolower($link),  "ftp")) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $link . "</a>";
                    $ret .= "<img src='/images/link_ftp.png' class='link' />";
                } else {
                    $link = str_replace(" ", "_", $link);
                    $ret = "<a href='" . $link . "'>" . trim($match[2]) . "</a>";
                }
                return $ret;
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
    
    private function startsWith($haystack, $needle) {
        return !strncmp($haystack, $needle, strlen($needle));
    }
}
