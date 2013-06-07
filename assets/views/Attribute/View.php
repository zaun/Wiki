<?php if ((isset($imageName) && !empty($imageName)) ||
          (isset($imageTitle) && !empty($imageTitle))) { ?>
<div class='pageImage'>
    <?php if (isset($imageName) && !empty($imageName)) {
        echo "<img src='" . $imageName . "' alt='Page Image'>";
    } ?>
    <?php if (isset($imageTitle) && !empty($imageTitle)) {
        echo "<label>" . $imageTitle . "</label>";
    } ?>
</div>
<?php } ?>

<?php
foreach ($articleAttributes as $a) {
    if ($a->type == "hdr") {
        echo "<h1>" . $a->title . "</h1>";
    } else {
        if ($a->value != "") {
            echo "<div class=\"row\">";
            switch($a->type) {
                default:
                    echo "<label>" . $a->title . "</label>";
                    echo "<data>" . $a->value . "</data>";
                    break;
            }
            echo "</div>";
        }
    }
}
?>

<h1>Article Information</h1>
<div class="row">
    <label>Template</label>
    <data><a href="!<?php echo $articleTemplate ?>"><?php echo $articleTemplate ?></a></data>
</div>
<?php if (!empty($lastUpdated)) { ?>
<div class="row">
    <label>Last Updated</label>
    <data><?php echo $lastUpdated ?></data>
</div>
<?php } ?>
