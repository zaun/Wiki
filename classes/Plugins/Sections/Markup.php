<?php

namespace Plugins\Sections;

class Markup {
    public $abbr = "mu";
    public $name = "Markup";
    
    
    public function edit($id, $title, $raw) {
        $out  = "<h2>" . $title . "</h2>";
        $out .= "<textarea class='markup expanding' id='section-" . $id . "' name='section-" . $id . "'>" . $raw . "</textarea>";
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

    
    // Basic markup, based on markdown
    public function rawToHtml($text, $items = array()) {
        $text = $this->cleanup($text);
        
        // Make it html safe
        $text = htmlentities($text, ENT_QUOTES, "UTF-8");
        
        // Add a newline after headers
        // so paragraphs work properly. Should figure out regex so it doesn't
        // add an extra \n if its not needed
        $text = preg_replace('{(^|\n)([=]+)(.*?)(\n)}', "$0\n", $text);
        
        // pre formated
        $text = preg_replace_callback(
            '/(^|\n)([ ][ ][ ][ ])((.|\n.)+)(?=(\n\n|$))/',
            function ($match) {
                $content = $match[0];
                $content = preg_replace_callback(
                    '/(^|\n)(.+?)(?=($|\n))/',
                    function ($match) {
                        if (substr($match[0],0,1) == "\n") {
                            return "\n" . substr($match[0], 5);
                        } else {
                            return substr($match[0], 4);
                        }
                    },
                    $content
                );
                return "\n<pre>" . $content . "\n</pre>\n";
            },
            $text
        );
        
        // Paragraphs
        // Ignore header lines
        $text = preg_replace_callback(
            '/(\n\n|^)(?=([^=][^=][^=][^=][^=][^=][^=]))((.|\n.)+)(?=(\n\n|$))/',
            function ($match) {
                $content = trim($match[0]);
                if (strlen($content) > 0) {
                    return "\n<div class='para'>\n" . $content . "\n\n</div>\n";
                } else {
                    return "";
                }
            },
            $text
        );

        // Headers
        // This works, but is there a cleaner way to go about it
        $text = preg_replace_callback(
            '/(^|\n)([=]+)(.*?)(?=(\n|$))/',
            function ($match) {
                $num = min(intval(strlen($match[2])) + 2, 6);
                return "\n<h" . $num . ">" . trim($match[3]) . "</h" . $num .">\n";
            },
            $text
        );
        
        // Bold
        $text = preg_replace('{(^|\n|\s|_|`|[<].*?[>])([*])(.+?)([*])($|\n|\s|_|`|[<].*?[>])}', "$1<strong>$3</strong>$5", $text);
        
        
        // Italic
        $text = preg_replace('{(^|\n|\s|[*]|`|[<].*?[>])([_])(.+?)([_])($|\n|\s|[*]|`|[<].*?[>])}', "$1<em>$3</em>$5", $text);
        
        // mono
        $text = preg_replace('{(^|\n|\s|[*]|_|[<].*?[>])([`])(.+?)([`])($|\n|\s|[*]|_|[<].*?[>])}', "$1<span style='font-family:monospace;'>$3</span>$5", $text);
        
        // bar
        $text = preg_replace('{(\n|^)([-]+)(\n|$)}', "<hr />", $text);
        
        // Special Chars
        // Have to use &gt; because everything is already made safe
        $text = preg_replace('{(&lt;--&gt;)}', "&harr;", $text);
        $text = preg_replace('{(&lt;--)}', "&larr;", $text);
        $text = preg_replace('{(--&gt;)}', "&rarr;", $text);
        $text = preg_replace('{(/c/)}', "&copy;", $text);
        $text = preg_replace('{(/r/)}', "&reg;", $text);
        $text = preg_replace('{(/tm/)}', "&trade;", $text);
        $text = preg_replace('{(/pi/)}', "&Pi;", $text);

        // Block Quote
        $text = preg_replace_callback(
            '/(^|\n)(\&gt;)([(](.+?)[)])?((.|\n.)+)(?=(\n\n|$))/',
            function ($match) {
                $content = str_replace("&gt;", "", trim($match[5]));
                $content = str_replace("\n", "<br />", $content);
                $attribution = trim($match[4]);
                if ($attribution == "") {
                    return "\n<blockquote>\n" . $content . "\n</blockquote>\n";
                } else {
                    return "\n<blockquote>\n" . $content . "\n<span class='attribution'>" . $attribution . "</span></blockquote>\n";
                }
            },
            $text
        );

        // ordered lists
        $text = preg_replace_callback(
            '/(^|\n)(#)((.|\n.)+)(?=(\n\n|$))/',
            function ($match) {
                $content = trim($match[0]);
                $lastLevel = 1;
                $content = preg_replace_callback(
                    '/(^|\n)([#]+)(\s?)(.*?)(?=(\n|$))/',
                    function ($match) use (&$lastLevel) {
                        $level = intval(strlen(trim($match[2])));
                        $ret =  "<li>" . trim($match[4]) . "</li>\n";
                        if ($level > $lastLevel) {
                            $ret = "<ol>\n" . $ret;
                        } else if ($level < $lastLevel) {
                            $ret = "</ol>\n" . $ret;
                        }
                        $lastLevel = $level;
                        return $ret;
                    },
                    $content
                );

                return "\n<ol>\n" . $content . "</ol>\n";
            },
            $text
        );
        
        // unordered lists
        $text = preg_replace_callback(
            '/(^|\n)([*])((.|\n.)+)(?=(\n\n|$))/',
            function ($match) {
                $content = trim($match[0]);
                $lastLevel = 1;
                $content = preg_replace_callback(
                    '/(^|\n)([*]+)(\s?)(.*?)(?=(\n|$))/',
                    function ($match) use (&$lastLevel) {
                        $level = intval(strlen(trim($match[2])));
                        $ret =  "<li>" . trim($match[4]) . "</li>\n";
                        if ($level > $lastLevel) {
                            $ret = "<ul>\n" . $ret;
                        } else if ($level < $lastLevel) {
                            $ret = "</ul>\n" . $ret;
                        }
                        $lastLevel = $level;
                        return $ret;
                    },
                    $content
                );

                return "\n<ul>\n" . $content . "</ul>\n";
            },
            $text
        );

        // Titled Links
        // [Digg](http://digg.com)
        // [Google](http://google.com)
        $text = preg_replace_callback(
            '/\[([^]]+)\]\(((?:https?|ftp):\/\/.*?)\)/',
            function ($match) {
                $title = trim($match[1]);
                $link = trim($match[2]);
                
                $ret = "";
                if (!strncmp(strtolower($link), "https", strlen($link))) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $title . "</a>";
                    $ret .= "&nbsp;<img src='/images/link_https.png' class='link' title='Secure HTTP external link' />";
                } else if (!strncmp(strtolower($link), "http", strlen($link))) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $title . "</a>";
                    $ret .= "&nbsp;<img src='/images/link_http.png' class='link' title='External link' />";
                } else if (!strncmp(strtolower($link),  "ftp", strlen($link))) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $title . "</a>";
                    $ret .= "&nbsp;<img src='/images/link_ftp.png' class='link' title='File Transfer Protocol link' />";
                } else {
                    $link = str_replace(" ", "_", $link);
                    $ret = "<a href='" . $link . "'>" . $title . "</a>";
                }
                return $ret;
            },
            $text
        );

        // Untitled Links
        // [Internal Page]
        // [http://google.com]
        $text = preg_replace_callback(
            '/(\[)(.*?)(\])/',
            function ($match) {
                $link = trim($match[2]);

                $ret = "";
                if (!strncmp(strtolower($link), "https", strlen($link))) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $link . "</a>";
                    $ret .= "&nbsp;<img src='/images/link_https.png' class='link' title='Secure HTTP external link' />";
                } else if (!strncmp(strtolower($link), "http", strlen($link))) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $link . "</a>";
                    $ret .= "&nbsp;<img src='/images/link_http.png' class='link' title='External link' />";
                } else if (!strncmp(strtolower($link),  "ftp", strlen($link))) {
                    $ret = "<a target='_blank' href='" . $link . "'>" . $link . "</a>";
                    $ret .= "&nbsp;<img src='/images/link_ftp.png' class='link' title='File Transfer Protocol link' />";
                } else {
                    $link = str_replace(" ", "_", $link);
                    $ret = "<a href='" . $link . "'>" . trim($match[2]) . "</a>";
                }
                return $ret;
            },
            $text
        );
        
        
        return "\n" . trim($text) . "\n";
    }
}
