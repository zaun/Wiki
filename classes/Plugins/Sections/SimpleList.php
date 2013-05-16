<?php

namespace Plugins\Sections;

class SimpleList {
    public $abbr = "SimpList";
    public $name = "Simple List";
    
    // Field options
    protected $showTitleDate     = false;
    protected $showDetail        = false;
    protected $showDetailDate    = false;
    protected $showSubdetail     = false;
    protected $showSubdetailDate = false;
    protected $showAdditional    = false;
    protected $showTitleSelect   = false;
    protected $showTopSelect     = false;
    protected $showMiddleSelect  = false;
    protected $showBottomSelect  = false;
    
    // Field placeholders
    protected $placeholderTitle         = "Title";
    protected $placeholderTitleDate     = "YYYY-MM-DD";
    protected $placeholderDetail        = "Detail";
    protected $placeholderDetailDate    = "YYYY-MM-DD";
    protected $placeholderSubdetail     = "Subdetail";
    protected $placeholderSubdetailDate = "YYYY-MM-DD";
    protected $placeholderAdditional    = "Additional information...";
    
    // Selections options
    protected $optionsTitleSelect   = array('Select an option...', '---', 'Item A', 'Item B', 'Item C');
    protected $optionsTopSelect     = array('Select an option...', '---', 'Item A', 'Item B', 'Item C');
    protected $optionsMiddleSelect  = array('Select an option...', '---', 'Item A', 'Item B', 'Item C');
    protected $optionsBottomSelect  = array('Select an option...', '---', 'Item A', 'Item B', 'Item C');
    
    // Field Datanames
    protected $dataTitle          = "title";
    protected $dataTitleDate      = "titleDate";
    protected $dataDetail         = "detail";
    protected $dataDetailDate     = "detailDate";
    protected $dataSubdetail      = "subdetail";
    protected $dataSubdetailDate  = "subdetailDate";
    protected $dataAdditional     = "additional";
    protected $dataTitleSelect    = "titleSelect";
    protected $dataTopSelect      = "topSelect";
    protected $dataMiddleSelect   = "middleSelect";
    protected $dataBottomSelect   = "bottomSelect";
    
    /*
     * Included once per section to edit
     */
    public function edit($id, $title, $raw) {
        $out  = "<h2>" . $title . "<button id='add-section-" . $id . "' class='add" . $this->abbr . "'>+</button></h2>";
        $out .= "<input type='hidden' id='section-" . $id . "' name='section-" . $id . "' />";
        $out .= "<ul id='list-section-" . $id . "' class='sortable " . $this->abbr . "List'>";
        if ($raw != "") {
            $items = json_decode($raw);
            foreach ($items as $i) {
                $out .= "<li class='ui-state-default' data-can-delete='yes'>";
                $out .= "<div class='listItemContent'>";
                $out .="<div class='row'>";
                $out .= "<button class='btnDelete btn" . $this->abbr . "Delete'>-</button>";
                $out .= "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
                $out .= "<span class='order'></span>";
                if ($this->showTitleDate === false) {
                    if ($this->showTitleSelect === true) {
                        $out .= "<select class='inpTitleSelect'>";
                        foreach($this->optionsTitleSelect as $opt) {
                            if ($opt == '---') {
                                $out .= "<option disabled>---</option>";
                            } else {
                                $out .= "<option>" . $opt . "</option>";
                            }
                        }
                        $out .= "</select>";
                    } else {
                        $out .= "<input class='inpTitle' placeholder='" . $this->placeholderTitle . "' value='" . $i->{$this->dataTitle} . "' />";
                    }
                } else {
                    $out .= "<input class='inpTitleDate dateField' placeholder='" . $this->placeholderDetailDate . "' value='" . $i->{$this->dataTitleDate} . "' />";
                    if ($this->showTitleSelect === true) {
                        $out .= "<select class='inpTitleSelectSmall'>";
                        foreach($this->optionsTitleSelect as $opt) {
                            if ($opt == '---') {
                                $out .= "<option disabled>---</option>";
                            } else {
                                $out .= "<option>" . $opt . "</option>";
                            }
                        }
                        $out .= "</select>";
                    } else {
                        $out .= "<input class='inpTitleSmall' placeholder='" . $this->placeholderTitle . "' value='" . $i->{$this->dataTitle} . "' />";
                    }
                }
                $out .= "</div>";
                if ($this->showTopSelect === true) {
                    $out .= "<div class='row'>";
                    $out .= "<select class='inpTopSelect'>";
                    foreach($this->optionsTopSelect as $opt) {
                        if ($opt == '---') {
                            $out .= "<option disabled>---</option>";
                        } else {
                            $out .= "<option>" . $opt . "</option>";
                        }
                    }
                    $out .= "</select>";
                    $out .= "</div>";
                }
                if ($this->showDetailDate === false && $this->showDetail === true) {
                    $out .="<div class='row'>";
                    $out .= "<input class='inpDetailFull' placeholder='" . $this->placeholderDetail . "' value='" . $i->{$this->dataDetail} . "' />";
                    $out .= "</div>";
                } else if ($this->showDetailDate === true) {
                    $out .="<div class='row'>";
                    $out .= "<input class='inpDetailDate dateField' placeholder='" . $this->placeholderDetailDate . "' value='" . $i->{$this->dataDetailDate} . "' />";
                    if ($this->showDetail === true) {
                        $out .= "<input class='inpDetailSmall' placeholder='" . $this->placeholderDetail . "' value='" . $i->{$this->dataDetail} . "' />";
                    }
                    $out .= "</div>";
                }
                if ($this->showMiddleSelect === true) {
                    $out .= "<div class='row'>";
                    $out .= "<select class='inpTopSelect'>";
                    foreach($this->optionsMiddleSelect as $opt) {
                        if ($opt == '---') {
                            $out .= "<option disabled>---</option>";
                        } else {
                            $out .= "<option>" . $opt . "</option>";
                        }
                    }
                    $out .= "</select>";
                    $out .= "</div>";
                }
                if ($this->showSubdetailDate === false && $this->showSubdetail === true) {
                    $out .= "<div class='row'>";
                    $out .= "<input class='inpSubdetailFull' placeholder='" . $this->placeholderSubdetail . "' value='" . $i->{$this->dataSubdetail} . "' />";
                    $out .= "</div>";
                } else if ($this->showSubdetailDate === true) {
                    $out .= "<div class='row'>";
                    $out .= "<input class='inpSubdetailDate dateField' placeholder='" . $this->placeholderSubdetailDate . "' value='" . $i->{$this->dataSubdetailDate} . "' />";
                    if ($this->showSubdetail === true) {
                        $out .= "<input class='inpSubdetailSmall' placeholder='" . $this->placeholderSubdetail . "' value='" . $i->{$this->dataSubdetail} . "' />";
                    }
                    $out .= "</div>";
                }
                if ($this->showBottomSelect === true) {
                    $out .= "<div class='row'>";
                    $out .= "<select class='inpTopSelect'>";
                    foreach($this->optionsBottomSelect as $opt) {
                        if ($opt == '---') {
                            $out .= "<option disabled>---</option>";
                        } else {
                            $out .= "<option>" . $opt . "</option>";
                        }
                    }
                    $out .= "</select>";
                    $out .= "</div>";
                }
                if ($this->showAdditional === true) {
                    $out .= "<div class='rowBig'>";
                    $out .= "<textarea class='inpMore' placeholder='" . $this->placeholderAdditional . "'>" . $i->{$this->dataAdditional} . "</textarea>";
                    $out .= "</div>";
                }
                $out .= "</div>";
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
        $out  = "<div id='tmp" . $this->abbr . "' class='template'>";
        $out .= "<li class='ui-state-default' data-can-delete='yes'>";
        $out .= "<div class='listItemContent'>";
        $out .="<div class='row'>";
        $out .= "<button class='btnDelete btn" . $this->abbr . "Delete'>-</button>";
        $out .= "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
        $out .= "<span class='order'></span>";
        if ($this->showTitleDate === false) {
            if ($this->showTitleSelect === true) {
                $out .= "<select class='inpTitleSelect'>";
                foreach($this->optionsTitleSelect as $opt) {
                    if ($opt == '---') {
                        $out .= "<option disabled>---</option>";
                    } else {
                        $out .= "<option>" . $opt . "</option>";
                    }
                }
                $out .= "</select>";
            } else {
                $out .= "<input class='inpTitle' placeholder='" . $this->placeholderTitle . "' value='' />";
            }
        } else {
            $out .= "<input class='inpTitleDate dateField' placeholder='" . $this->placeholderDetailDate . "' value='' />";
            if ($this->showTitleSelect === true) {
                $out .= "<select class='inpTitleSelectSmall'>";
                foreach($this->optionsTitleSelect as $opt) {
                    if ($opt == '---') {
                        $out .= "<option disabled>---</option>";
                    } else {
                        $out .= "<option>" . $opt . "</option>";
                    }
                }
                $out .= "</select>";
            } else {
                $out .= "<input class='inpTitleSmall' placeholder='" . $this->placeholderTitle . "' value='' />";
            }
        }
        $out .= "</div>";
        if ($this->showTopSelect === true) {
            $out .= "<div class='row'>";
            $out .= "<select class='inpTopSelect'>";
            foreach($this->optionsTopSelect as $opt) {
                if ($opt == '---') {
                    $out .= "<option disabled>---</option>";
                } else {
                    $out .= "<option>" . $opt . "</option>";
                }
            }
            $out .= "</select>";
            $out .= "</div>";
        }
        if ($this->showDetailDate === false && $this->showDetail === true) {
            $out .= "<div class='row'>";
            $out .= "<input class='inpDetailFull' placeholder='" . $this->placeholderDetail . "' value='' />";
            $out .= "</div>";
        } else if ($this->showDetailDate === true) {
            $out .= "<div class='row'>";
            $out .= "<input class='inpDetailDate dateField' placeholder='" . $this->placeholderDetailDate . "' value='' />";
            if ($this->showDetail === true) {
                $out .= "<input class='inpDetailSmall' placeholder='" . $this->placeholderDetail . "' value='' />";
            }
            $out .= "</div>";
        }
        if ($this->showMiddleSelect === true) {
            $out .= "<div class='row'>";
            $out .= "<select class='inpMiddleSelect'>";
            foreach($this->optionsMiddleSelect as $opt) {
                if ($opt == '---') {
                    $out .= "<option disabled>---</option>";
                } else {
                    $out .= "<option>" . $opt . "</option>";
                }
            }
            $out .= "</select>";
            $out .= "</div>";
        }
        if ($this->showSubdetailDate === false && $this->showSubdetail === true) {
            $out .= "<div class='row'>";
            $out .= "<input class='inpSubdetailFull' placeholder='" . $this->placeholderSubdetail . "' value='' />";
            $out .= "</div>";
        } else if ($this->showSubdetailDate === true) {
            $out .= "<div class='row'>";
            $out .= "<input class='inpSubdetailDate dateField' placeholder='" . $this->placeholderSubdetailDate . "' value='' />";
            if ($this->showSubdetail === true) {
                $out .= "<input class='inpSubdetailSmall' placeholder='" . $this->placeholderSubdetail . "' value='' />";
            }
            $out .= "</div>";
        }
        if ($this->showBottomSelect === true) {
            $out .= "<div class='row'>";
            $out .= "<select class='inpBottomSelect'>";
            foreach($this->optionsBottomSelect as $opt) {
                if ($opt == '---') {
                    $out .= "<option disabled>---</option>";
                } else {
                    $out .= "<option>" . $opt . "</option>";
                }
            }
            $out .= "</select>";
            $out .= "</div>";
        }
        if ($this->showAdditional === true) {
            $out .= "<div class='rowBig'>";
            $out .= "<textarea class='inpMore' placeholder='" . $this->placeholderAdditional . "'></textarea>";
            $out .= "</div>";
        }
        $out .= "</div>";
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
        $out .= "Update" . $this->abbr . "ListCounts();" . $EOL;
        	// turn on sortable items
        $out .= "$('." . $this->abbr . "List').sortable({" . $EOL;
        $out .= "    placeholder: 'ui-state-highlight', " . $EOL;
        $out .= "    update : function(event, ui) {" . $EOL;
        $out .= "        Update" . $this->abbr . "ListCounts();" . $EOL;
        $out .= "    }" . $EOL;
        $out .= "});" . $EOL;
        $out .= "$('.sortable').disableSelection();" . $EOL;
        $out .= "$(document).on('change', '.inpTitle, .inpTitleSmall, .inpTitleDate, .inpDetailFull, .inpDetailSmall, .inpDetailDate, .inpSubdetailFull, .inpSubdetailSmall, .inpSubdetailDate, .inpMore', function(e) {" . $EOL;
        $out .= "    Update" . $this->abbr . "ListData();" . $EOL;
        $out .= "});" . $EOL;
        // Add to list buttons
        $out .= "$(document).on('click', '.add" . $this->abbr . "', function(e) {" . $EOL;
        $out .= "    $('#tmp" . $this->abbr . " li').clone().appendTo('#' + $(this).attr('id').replace('add-', 'list-'));" . $EOL;
        $out .= "    Update" . $this->abbr . "ListCounts();" . $EOL;
        $out .= "    $('.dateField').datepicker({" . $EOL;
        $out .= "        changeMonth: true," . $EOL;
        $out .= "        changeYear: true," . $EOL;
        $out .= "        dateFormat: 'yy-mm-dd'" . $EOL;
        $out .= "    });" . $EOL;
        $out .= "    e.preventDefault();" . $EOL;
        $out .= "});" . $EOL;
        // Delete
        $out .= "$(document).on('click', '.btn" . $this->abbr . "Delete', function(e) {" . $EOL;
        $out .= "    if ($(this).parent().parent().parent().attr('data-can-delete') === 'yes') {" . $EOL;
        $out .= "        $(this).parent().parent().parent().remove();" . $EOL;
        $out .= "        Update" . $this->abbr . "ListCounts();" . $EOL;
        $out .= "    } else {" . $EOL;
        $out .= "        alert('This item is in use by at least one page so it can not be removed.');" . $EOL;
        $out .= "    }" . $EOL;
        $out .= "    e.preventDefault();" . $EOL;
        $out .= "});" . $EOL;
        $out .= "});" . $EOL;
        // Update the order values on the list and
        // update the lists json data
        $out .= "function Update" . $this->abbr . "ListCounts() {" . $EOL;
        $out .= "    $('." . $this->abbr . "List').each(function(index) {" . $EOL;
        $out .= "        $(this).find('.listItemContent').each(function(index) {" . $EOL;
        $out .= "            $(this).find('.order').text(index + 1);" . $EOL;
        $out .= "        });" . $EOL;
        $out .= "    });" . $EOL;
        $out .= "    Update" . $this->abbr . "ListData();" . $EOL;
        $out .= "}" . $EOL;
        // Store the sections list in json
        $out .= "function Update" . $this->abbr . "ListData() {" . $EOL;
        $out .= "    $('." . $this->abbr . "List').each(function(index) {" . $EOL;
        $out .= "        var data = Array();" . $EOL;
        $out .= "        $(this).find('.listItemContent').each(function(index) {" . $EOL;
        $out .= "            obj = {};" . $EOL;
        $out .= "            obj['itemOrder'] = index;" . $EOL;
        if ($this->showTitleDate === false) {
            if ($this->showTitleSelect === true) {
                $out .= "            if ($(this).find('.inpTitleSelect').val() !== undefined) {" . $EOL;
                $out .= "                obj['" . $this->dataTitleSelect . "'] = $(this).find('.inpTitleSelect').val();" . $EOL;
                $out .= "            }" . $EOL;
            } else {
                $out .= "            if ($(this).find('.inpTitle').val() !== undefined) {" . $EOL;
                $out .= "                obj['" . $this->dataTitle . "'] = $(this).find('.inpTitle').val();" . $EOL;
                $out .= "            }" . $EOL;
            }
        } else {
            if ($this->showTitleSelect === true) {
                $out .= "            if ($(this).find('.inpTitleSelectSmall').val() !== undefined) {" . $EOL;
                $out .= "                obj['" . $this->dataTitleSelect . "'] = $(this).find('.inpTitleSelectSmall').val();" . $EOL;
                $out .= "            }" . $EOL;
            } else {
                $out .= "            if ($(this).find('.inpTitleSmall').val() !== undefined) {" . $EOL;
                $out .= "                obj['" . $this->dataTitle . "'] = $(this).find('.inpTitleSmall').val();" . $EOL;
                $out .= "            }" . $EOL;
            }
            $out .= "            if ($(this).find('.inpTitleDate').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataTitleDate . "'] = $(this).find('.inpTitleDate').val();" . $EOL;
            $out .= "            }" . $EOL;
        }
        if ($this->showDetailDate === false) {
            $out .= "            if ($(this).find('.inpDetailFull').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataDetail . "'] = $(this).find('.inpDetailFull').val();" . $EOL;
            $out .= "            }" . $EOL;
        } else {
            $out .= "            if ($(this).find('.inpDetailSmall').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataDetail . "'] = $(this).find('.inpDetailSmall').val();" . $EOL;
            $out .= "            }" . $EOL;
            $out .= "            if ($(this).find('.inpDetailDate').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataDetailDate . "'] = $(this).find('.inpDetailDate').val();" . $EOL;
            $out .= "            }" . $EOL;
        }
        if ($this->showSubdetailDate === false) {
            $out .= "            if ($(this).find('.inpSubdetailFull').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataSubdetail . "'] = $(this).find('.inpSubdetailFull').val();" . $EOL;
            $out .= "            }" . $EOL;
            $out .= "            if ($(this).find('.inpSubdetailSmall').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataSubdetail . "'] = $(this).find('.inpSubdetailSmall').val();" . $EOL;
            $out .= "            }" . $EOL;
        } else {
            $out .= "            if ($(this).find('.inpSubdetailDate').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataSubdetailDate . "'] = $(this).find('.inpSubdetailDate').val();" . $EOL;
            $out .= "            }" . $EOL;
        }
        if ($this->showAdditional === true) {
            $out .= "            if ($(this).find('.inpMore').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataAdditional . "'] = $(this).find('.inpMore').val();" . $EOL;
            $out .= "            }" . $EOL;
        }
        if ($this->showTopSelect === true) {
            $out .= "            if ($(this).find('.inpTopSelect').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataTopSelect . "'] = $(this).find('.inpTopSelect').val();" . $EOL;
            $out .= "            }" . $EOL;
        }
        if ($this->showMiddleSelect === true) {
            $out .= "            if ($(this).find('.inpMiddleSelect').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataMiddleSelect . "'] = $(this).find('.inpMiddleSelect').val();" . $EOL;
            $out .= "            }" . $EOL;
        }
        if ($this->showBottomSelect === true) {
            $out .= "            if ($(this).find('.inpBottomSelect').val() !== undefined) {" . $EOL;
            $out .= "                obj['" . $this->dataBottomSelect . "'] = $(this).find('.inpBottomSelect').val();" . $EOL;
            $out .= "            }" . $EOL;
        }
        $out .= "            data[index] = obj;" . $EOL;
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
        if (empty($raw) || $raw == '[]') {
            return "";
        }
        return $this->convertRawToHtml($raw);
    }
    
    
    public function convertRawToHtml($raw) {
        $items = json_decode($raw);
        $html = "<ol>";
        foreach ($items as $i) {
            $order = $i->itemOrder;
            $html .= "<li>" . $i->{$this->dataTitle} . "</li>";
        }
        $html .= "</ol>";
        return $html;
    }
}
