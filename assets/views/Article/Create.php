<form method='post' accept-charset="utf-8">

<h2>General Information</h2>
<p>
This will create a new article, please take a moment to think about the 
title of the page. Once create changing the title is not something that 
should happen often. The links to the article would need updated as the 
exiting links would no longer be accurate.
</p>

<h2>Page Title:</h2>
<input type='text' id='articleTitle' name='articleTitle' value='<?php echo $articleTitle; ?>' />

<h2>Page Summary (<span id='articleSummaryCount'></span>):</h2>
<textarea id='articleSummary' name='articleSummary' class='expanding' maxlength='2048'><?php echo $articleSummary; ?></textarea>

<?php if (count($templateList) > 0) { ?>
<h2>Template<br /><small>(Once a template is choosen and the articlege is created it becomes more difficult to
chane the template. For a change to be made, the article needs to be blank.)</small></h1>
<select id='articleTemplate' name='articleTemplate'>
<?php
foreach ($templateList as $t) {
    if($t->id == $selectedTemplateID) {
        echo "<option value='" . $t->id . "' selected>" . $t->name . " - " . $t->description . "</option>";
    } else {
        echo "<option value='" . $t->id . "'>" . $t->name . " - " . $t->description . "</option>";
    }
}
?>
</select>
<?php } ?>

<div id="buttonbar">
    <button>Create Article</button>
</div>

</form>
