<form method='post'>
<h2>Template Name:<br /><small>(No spaces permitted, names are care insensitive but are case preserving)</small></h2>
<input type='text' id='templateName' name='templateName' value='<?php echo $templateName; ?>' />
<h2>Description (<span id='templateDescriptionCount'></span>):<br /><small>(Please briefly describe what this kinds of pages this template should be used for)</small></h2>
<textarea id='templateDescription' name='templateDescription' class='expanding' maxlength='512'><?php echo $templateDescription; ?></textarea>
<h2>Sections:<br /><small>(Every page has a summary, there is no need to add a summary section)</small><button id="btnAddSection">+</button></h2>
<input type='hidden' id='templateSections' name='templateSections' value='' />
<ol id='lstSections' class='sortable'>
<?php
foreach ($templateSections as $s) {
    if ($s->inuse === 0) {
        echo "<li class='ui-state-default' data-can-delete='yes'>";
    } else {
        echo "<li class='ui-state-default' data-can-delete='no'>";
    }
    echo "<div class='listItemContent'>";
    echo "<div class='row'>";
    echo "<button class='btnDelete'>-</button>";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    if ($s->inuse === 0) {
        echo "<select class='inpType'>";
        foreach ($sectionTypeObjects as $st) {
            if ($s->type == $st->abbr) {
                echo "<option value='" . $st->abbr . "' selected>" . $st->name . "</option>";
            } else { 
                echo "<option value='" . $st->abbr . "'>" . $st->name . "</option>";
            }
        }
    } else {
        echo "<select class='inpType' disabled>";
        foreach ($sectionTypeObjects as $st) {
            if ($s->type == $st->abbr) {
                echo "<option value='" . $st->abbr . "' selected>" . $st->name . "</option>";
            }
        }
    }
    echo "</select>";
    echo "<input class='inpSection' placeholder='Section Title' value='" . $s->title . "'>";
    echo "<input class='inpID' type='hidden' value='" . $s->id . "'>";
    echo "</div>";
    echo "</div>";
    echo "</li>";
}
?>
</ol>
<h2>Attributes:<br /><small>(Each attribute is a single definitive item, a brithdate, coordinates, name, etc.)</small><button id="btnAddAttribute">+</button></h2>
<input type='hidden' id='templateAttributes' name='templateAttributes' value='' />
<ol id='lstAttributes' class='sortable smallColumns'>
<?php
foreach ($templateAttributes as $a) {
    if ($a->inuse === 0) {
        echo "<li class='ui-state-default' data-can-delete='yes'>";
    } else {
        echo "<li class='ui-state-default' data-can-delete='no'>";
    }
    
    echo "<div class='listItemContent'>";
    echo "<div class='row'>";
    echo "<button class='btnDelete'>-</button>";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    if ($a->inuse === 0) {
        echo "<select class='inpType'>";
        foreach ($attributeTypeObjects as $at) {
            if ($a->type == $at->abbr) {
                echo "<option value='" . $at->abbr . "' selected>" . $at->name . "</option>";
            } else {
                echo "<option value='" . $at->abbr . "'>" . $at->name . "</option>";
            }
        }
    } else {
        echo "<select class='inpType' disabled>";
        foreach ($attributeTypeObjects as $at) {
            if ($a->type == $at->abbr) {
                echo "<option value='" . $at->abbr . "' selected>" . $at->name . "</option>";
            }
        }
    }
    echo "</select>";
    echo "<input class='inpAttribute' placeholder='Section Title' value='" . $a->title . "'>";
    echo "<input class='inpID' type='hidden' value='" . $s->id . "'>";
    echo "</div>";
    echo "</div>";
    echo "</li>";
}
?>
</ol>
<div></div>
<div id="buttonbar">
    <button>Save Template</button>
</div>


<?php
    echo "<div id='tmpAttribute' class='template'>";
    echo "<li class='ui-state-default' data-can-delete='yes'>";
    echo "<div class='listItemContent'>";
    echo "<div class='row'>";
    echo "<button class='btnDelete'>-</button>";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<select class='inpType'>";
    foreach ($attributeTypeObjects as $at) {
        echo "<option value='" . $at->abbr . "'>" . $at->name . "</option>";
    }
    echo "</select>";
    echo "<input class='inpAttribute' placeholder='Section Title' value=''>";
    echo "</div>";
    echo "</div>";
    echo "</li>";
    echo "</div>";

    echo "<div id='tmpSection' class='template'>";
    echo "<li class='ui-state-default' data-can-delete='yes'>";
    echo "<div class='listItemContent'>";
    echo "<div class='row'>";
    echo "<button class='btnDelete'>-</button>";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<select class='inpType'>";
    foreach ($sectionTypeObjects as $st) {
        echo "<option value='" . $st->abbr . "'>" . $st->name . "</option>";
    }
    echo "</select>";
    echo "<input class='inpSection' placeholder='Section Title' value=''>";
    echo "</div>";
    echo "</div>";
    echo "</li>";
    echo "</div>";
?>

</form>

