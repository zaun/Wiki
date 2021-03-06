<?php

namespace Plugins\Attributes;

class SimpleList extends \App\Attributes\Base {
    public $abbr = "attrLst";
    public $name = "List";
    
    
    public function edit($id, $title, $raw) {
        if ($raw == "") {
            $raw = "[\"\"]";
        }
        
        $out = "";
        $items = json_decode($raw);
        $first = true;
        foreach ($items as $i) {
            $out .= "<div class='row'>";
            if ($first) {
                $out .= "<label>" . $title . "</label>";
            }
            $out .= "<data>";
            $out .= "<input type='hidden' class='listValue' id='attr-" . $id . "' name='attr-" . $id . "' value='" . $i . "' />";
            $out .= "<input class='text small listItem' value='" . $i . "' />";
            if ($first) {
                $out .= "<button class='btn" . $this->abbr . "Add' title='Add item to list'>+</button>";
            } else {
                $out .= "<button class='btn" . $this->abbr . "Delete' title='Remove item to list'>-</button>";
            }
            $out .= "</data>";
            $out .= "</div>";
            $first = false;
        }
        return $out;
    }
    
    
    /*
     * Included once on the edit page
     */
    public function editOnce() {
        $out  = "<div id='tmp" . $this->abbr . "' class='template'>";
        $out .= "<div class='row'>";
        $out .= "<data>";
        $out .= "<input class='listItem small' value='' />";
        $out .= "<button class='btn" . $this->abbr . "Delete' title='Remove item to list'>-</button>";
        $out .= "</data>";
        $out .= "</div>";
        $out .= "</div>";
        return $out;
    }
    
    
    public function jsEdit() {
        $EOL = "\n";
        $out  = "$(document).ready(function() {" . $EOL;
        $out .= "$(document).find('.btn" . $this->abbr . "Add').each(function(index) {" . $EOL;
        $out .= "    UpdateAttr" . $this->abbr . "ListData($(this).parent().parent().parent());" . $EOL;
        $out .= "});" . $EOL;
        // Add to list buttons
        $out .= "$(document).on('click', '.btn" . $this->abbr . "Add', function(e) {" . $EOL;
        $out .= "    $('#tmp" . $this->abbr . " div').clone().appendTo($(this).parent().parent().parent());" . $EOL;
        $out .= "    e.preventDefault();" . $EOL;
        $out .= "    UpdateAttr" . $this->abbr . "ListData($(this).parent().parent().parent());" . $EOL;
        $out .= "});" . $EOL;
        // Delete
        $out .= "$(document).on('click', '.btn" . $this->abbr . "Delete', function(e) {" . $EOL;
        $out .= "    $(this).parent().parent().remove();" . $EOL;
        $out .= "    e.preventDefault();" . $EOL;
        $out .= "    UpdateAttr" . $this->abbr . "ListData($(this).parent().parent().parent());" . $EOL;
        $out .= "});" . $EOL;
        // Update
        $out .= "$(document).on('change', '.pageAttributes > div > div > data > .listItem', function(e) {" . $EOL;
        $out .= "    UpdateAttr" . $this->abbr . "ListData($(this).parent().parent().parent());" . $EOL;
        $out .= "});" . $EOL;
        $out .= "});" . $EOL;
        $out .= "function UpdateAttr" . $this->abbr . "ListData(elm) {" . $EOL;
        $out .= "    var data = Array();" . $EOL;
        $out .= "    elm.find('.listItem').each(function(index) {" . $EOL;
        $out .= "        if ($.trim($(this).val()) != '') {" . $EOL;
        $out .= "            data[index] = $(this).val();" . $EOL;
        $out .= "        }" . $EOL;
        $out .= "    });" . $EOL;
        $out .= "    var dataText = JSON.stringify(data, null, 2);" . $EOL;
        $out .= "    elm.find('.listValue').val(dataText);" . $EOL;
        $out .= "};" . $EOL;
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
        $items = json_decode($raw);
        $html = "";
        foreach ($items as $i) {
            $html .= $i . "<br />";
        }

        // Titled Links
        // [Digg](http://digg.com)
        // [Google](http://google.com)
        $html = preg_replace_callback(
            '/\[([^]]+)\]\(((?:https?|ftp):\/\/.*?)\)/',
            function ($match) {
                $title = trim($match[1]);
                $link = trim($match[2]);
                
                $ret = "";
                if (!strncmp(strtolower($link), "https", 5)) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $title . "</a>";
                    $ret .= "<img src='/images/link_https.png' class='link' />";
                } else if (!strncmp(strtolower($link), "http", 4)) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $title . "</a>";
                    $ret .= "<img src='/images/link_http.png' class='link' />";
                } else if (!strncmp(strtolower($link),  "ftp", 3)) {
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
                if (!strncmp(strtolower($link), "https", 5)) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $link . "</a>";
                    $ret .= "<img src='/images/link_https.png' class='link' />";
                } else if (!strncmp(strtolower($link), "http", 4)) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $link . "</a>";
                    $ret .= "<img src='/images/link_http.png' class='link' />";
                } else if (!strncmp(strtolower($link),  "ftp", 3)) {
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
