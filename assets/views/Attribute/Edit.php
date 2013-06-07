<script>
<?php echo $articleAttributeJavascript; ?>
</script>

<div class='pageImage'>
    <img src='<?php echo $pageImage; ?>' />
    <?php
    echo "<input class='image-title' name='imageTitle' id='imageTitle' value='" . $imageTitle . "' />";
    ?>
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

