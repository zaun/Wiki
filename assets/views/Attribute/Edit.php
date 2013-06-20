<script>
<?php echo $articleAttributeJavascript; ?>
</script>

<h1>Article Image</h1>
<div class="row">
    <label>Image Name</label>
    <data><input name='imageName' id='imageName' value='<?php echo $imageName ?>' placeholder='Image Name' /></data>
</div>
<div class="row">
    <label>Image Title</label>
    <data><input name='imageTitle' id='imageTitle' value='<?php echo $imageTitle ?>' placeholder='Image Title' /></data>
</div>


<?php if (isset($articleAttributes) > 0) { ?>
<?php
foreach ($articleAttributes as $a) {
    echo "<div>";
    echo $a;
    echo "</div>";
}
?>
<?php } ?>


<?php if (!empty($articleTemplate)) { ?>
<h1>Article Information</h1>
<div class="row">
    <label>Template</label>
    <data><a href="../!<?php echo $articleTemplate ?>"><?php echo $articleTemplate ?></a></data>
</div>
<?php if (!empty($lastUpdated)) { ?>
<div class="row">
    <label>Last Updated</label>
    <data><?php echo $lastUpdated ?></data>
</div>
<?php } ?>
<?php } ?>

<div class="display: none;">
<?php echo $articleAttributeTemplates; ?>
</div>

