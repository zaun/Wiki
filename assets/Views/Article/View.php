<h1><?php echo $articleTitle; ?></h1>

<?php
if (count($articleSections) > 2) {
?>
<div class="toc">
<h1>Table of Contents</h1>
<ul>
<?php
foreach ($articleSections as $s) {
    echo "<li>" . $s->title . "</li>";
}
?>
</ul>
</div>
<?php } ?>

<p><?php echo $articleSummary; ?></p>
<div id='articleSections'>
<?php
foreach ($articleSections as $s) {
    if ($s->html != "") {
        echo "<h2>" . $s->title . "</h2>";
        echo $s->html;
    }
}
?>
</div>
