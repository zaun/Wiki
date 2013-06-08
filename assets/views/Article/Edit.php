<script>
<?php echo $articleSectionJavascript; ?>
</script>

<h2>Title:</h2>
<input type='text' id='articleTitle' name='articleTitle' value="<?php echo str_replace('"','\"', $articleTitle); ?>" />

<h2>Summary (<span id='articleSummaryCount'></span>):</h2>
<textarea id='articleSummary' name='articleSummary' class='expanding' maxlength='2048'><?php echo $articleSummary; ?></textarea>

<?php if (count($templateList) > 0) { ?>
<h2>Template<br /><small>Once a template is choosen and the article is created it becomes more difficult to
chane the template. For a change to be made,<br />the article needs to be blank.</small></h1>
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

<?php if (isset($articleSections) > 0) { ?>
<div id='articleSections'>
<?php
foreach ($articleSections as $s) {
    echo $s;
}
?>
</div>
<?php } ?>

<?php echo $referenceSection; ?>

<div id="buttonbar">
    <button>Save Article</button>
</div>


<div class="display: none;">
<?php echo $articleSectionTemplates; ?>
</div>
