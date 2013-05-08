<div class='pageImage'>
    <img src='<?php echo $pageImage; ?>' />
    <?php
    echo "<input class='image-title' name='imageTitle' id='imageTitle' value='" . $imageTitle . "' />";
    ?>
</div>

<?php
if (isset($articleAttributes)) {
    foreach ($articleAttributes as $a) {
        if ($a->type == "hdr") {
            echo "<h1>" . $a->title . "</h1>";
        } else {
            echo "<div class=\"row\">";
            switch($a->type) {
                case 'int':
                    echo "<label>" . $a->title . "</label>";
                    echo "<input class='attribute-int' name='attribute-" . $a->id . "' id='attribute-" . $a->id . "' value='" . $a->value . "' />";
                    break;
                case 'float':
                    echo "<label>" . $a->title . "</label>";
                    echo "<input class='attribute-float' name='attribute-" . $a->id . "' id='attribute-" . $a->id . "' value='" . $a->value . "' />";
                    break;
                case 'text':
                    echo "<label>" . $a->title . "</label>";
                    echo "<input class='attribute-text' name='attribute-" . $a->id . "' id='attribute-" . $a->id . "' value='" . $a->value . "' />";
                    break;
                case 'date':
                    echo "<label>" . $a->title . "</label>";
                    echo "<input class='attribute-date' name='attribute-" . $a->id . "' id='attribute-" . $a->id . "' value='" . $a->value . "' />";
                    echo "<span class='ui-icon ui-icon-calendar'></span>";
                    break;
                case 'cur':
                    echo "<label>" . $a->title . "</label>";
                    echo "<input class='attribute-cur' name='attribute-" . $a->id . "' id='attribute-" . $a->id . "' value='" . $a->value . "' />";
                    break;
                case 'link':
                    echo "<label>" . $a->title . "</label>";
                    echo "<input class='attribute-link' name='attribute-" . $a->id . "' id='attribute-" . $a->id . "' value='" . $a->value . "' />";
                    break;
                case 'img':
                    echo "<label>" . $a->title . "</label>";
                    echo "<input class='attribute-img' name='attribute-" . $a->id . "' id='attribute-" . $a->id . "' value='" . $a->value . "' />";
                    break;
                default:
                    echo "<label>" . $a->title . "</label>";
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
    <data><a href="../!<?php echo $articleTemplate ?>"><?php echo $articleTemplate ?></a></data>
</div>
<div class="row">
    <label>Last Updated</label>
    <data><?php echo $lastUpdated ?></data>
</div>
