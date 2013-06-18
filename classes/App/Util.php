<?php
namespace App;

class Util {
    public function replaceValues($kvPairs, $text) {
        $attrTest = 'date';
        $text = preg_replace_callback(
            '/(\{{)(.*?)(\}})/',
            function ($match) use ($kvPairs) {
                $attr = trim($match[2]);
                if (isset($kvPairs[strtolower($attr)])) {
                    return $kvPairs[strtolower($attr)];
                } else {
                    return $attr;
                }
            },
            $text
        );
	    return $text;
    }

    public function summaryHtml($text) {
        $html = $text;
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
}


