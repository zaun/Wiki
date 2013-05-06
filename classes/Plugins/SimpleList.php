<?php

namespace Plugins;

class SimpleList {
    public $abbr = "sl";
    public $name = "Simple List";
    
    /*
     * Included once per section to edit
     */
    public function edit($id, $title, $raw) {
        $out  = "<h2>" . $title . "<button id='add-section-" . $id . "' class='addSimpleList'>+</button></h2>";
        $out .= "<input type='hidden' id='section-" . $id . "' name='section-" . $id . "' />";
        $out .= "<ul id='list-section-" . $id . "' class='sortable simpleList'>";
        if ($raw != "") {
            $items = json_decode($raw);
            foreach ($items as $i) {
                $out .= "<li class='ui-state-default' data-can-delete='yes'>";
                $out .= "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
                $out .= "<span class='order'></span>";
                $out .= "<span class='title'>" . $i[1] . "</span>";
                $out .= "<span class='editTitle'><input value='" . $i[1] . "'/></span>";
                $out .= "<input type='hidden' value='' />";
                $out .= "<button>-</button>";
                $out .= "</li>";
            }
        }
        $out .= "</ul>";
        return $out;
    }
    
    
    /*
     * Included once on the edit page
     */
    public function editOnce() {
        $out  = "<div id='tmpSimpleList' class='template'>";
        $out .= "<li class='ui-state-default' data-can-delete='yes'>";
        $out .= "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
        $out .= "<span class='order'></span>";
        $out .= "<span class='title'>Untitled</span>";
        $out .= "<span class='editTitle'><input value='Untitled'/></span>";
        $out .= "<input type='hidden' value='' />";
        $out .= "<button>-</button>";
        $out .= "</li>";
        $out .= "</div>";
        return $out;
    }
    
    
    /*
     * Included once on the edit page
     */
    public function jsEdit() {
        $EOL = "\n";
        $out  = "$(document).ready(function() {" . $EOL;
        	// Initilize order of sortables
        $out .= "UpdateListCounts();" . $EOL;
        	// turn on sortable items
        $out .= "$('.sortable').sortable({" . $EOL;
        $out .= "    placeholder: 'ui-state-highlight', " . $EOL;
        $out .= "    update : function(event, ui) {" . $EOL;
        $out .= "        UpdateListCounts();" . $EOL;
        $out .= "    }" . $EOL;
        $out .= "});" . $EOL;
        $out .= "$('.sortable').disableSelection();" . $EOL;
        $out .= "$(document).on('change', '.sortable > li > select', function(e) {" . $EOL;
        $out .= "    UpdateListCounts();" . $EOL;
        $out .= "});" . $EOL;
        // Add to list buttons
        $out .= "$('.addSimpleList').on('click', function(e) {" . $EOL;
        $out .= "    $('#tmpSimpleList li').clone().appendTo('#' + $(this).attr('id').replace('add-', 'list-'));" . $EOL;
        $out .= "    UpdateListCounts();" . $EOL;
        $out .= "    e.preventDefault();" . $EOL;
        $out .= "});" . $EOL;
        // Edit
        $out .= "$(document).on('click', '.sortable > li > .title', function(e) {" . $EOL;
        $out .= "    $(this).hide();" . $EOL;
        $out .= "    $(this).parent().children('.editTitle').show().children('input').focus();" . $EOL;
        $out .= "});" . $EOL;
        $out .= "$(document).on('blur', '.sortable > li > .editTitle > input', function(e) {" . $EOL;
        $out .= "    $(this).parent().hide();" . $EOL;
        $out .= "    $(this).parent().parent().children('.title').show().html($(this).val());" . $EOL;
        $out .= "    UpdateListCounts();" . $EOL;
        $out .= "});" . $EOL;
        // Delete
        $out .= "$(document).on('click', '.sortable > li > button', function(e) {" . $EOL;
        $out .= "    if ($(this).parent().attr('data-can-delete') === 'yes') {" . $EOL;
        $out .= "        $(this).parent().remove();" . $EOL;
        $out .= "        UpdateListCounts();" . $EOL;
        $out .= "    } else {" . $EOL;
        $out .= "        alert('This item is in use by at least one page so it can not be removed.');" . $EOL;
        $out .= "    }" . $EOL;
        $out .= "    e.preventDefault();" . $EOL;
        $out .= "});" . $EOL;
        $out .= "});" . $EOL;
        // Update the order values on the list and
        // update the lists json data
        $out .= "function UpdateListCounts() {" . $EOL;
        $out .= "    $('.sortable').each(function(index) {" . $EOL;
        $out .= "        $(this).children('li').each(function(index) {" . $EOL;
        $out .= "            $(this).children('.order').text(index + 1);" . $EOL;
        $out .= "        });" . $EOL;
        $out .= "    });" . $EOL;
        $out .= "    UpdateSimpleListData();" . $EOL;
        $out .= "}" . $EOL;
        // Store the sections list in json
        $out .= "function UpdateSimpleListData() {" . $EOL;
        $out .= "    $('.simpleList').each(function(index) {" . $EOL;
        $out .= "        var data = Array();" . $EOL;
        $out .= "        $(this).children('li').each(function(index) {" . $EOL;
        $out .= "            $(this).children('.order').text(index + 1);" . $EOL;
        $out .= "            data[index] = Array(index, $(this).children('.title').html());" . $EOL;
        $out .= "        });" . $EOL;
        $out .= "        var dataText = JSON.stringify(data, null, 2);" . $EOL;
        $out .= "        $('#' + $(this).attr('id').replace('list-', '')).val(dataText);" . $EOL;
        $out .= "    });" . $EOL;
        $out .= "}" . $EOL;
        return $out;
    }
    
    
    public function jsView() {
        return "";
    }
    
    
    public function rawValue($request, $id) {
        $sID = 'section-' . $id;
        $val = $request->post($sID, '', false);
        if ($val == "[]") {
            $val = "";
        }
        return $val;
    }
    
    
    public function htmlValue($request, $id) {
        $raw = $this->rawValue($request, $id);
        if (empty($raw)) {
            return "";
        }
        
        $items = json_decode($raw);
        $html = "<ol>";
        // Add/Update attributes
        foreach ($items as $i) {
            $order = $i[0];
            $title = $i[1];
            $html .= "<li>" . $title . "</li>";
        }
        $html .= "</ol>";
        return $html;
    }
}

return new SimpleList();
