<h1><?php echo $pageTitle; ?></h1>
<h2>Description</h2>
<p><?php echo $pageSummary; ?></p>

<?php if (count($templateSections) > 0) { ?>
<h2>Sections</h2>
<ol>
<?php
foreach ($templateSections as $s) {
    echo "<li>";
    echo $s->title;
    echo "</li>";
}?>
</ol>
<?php } ?>

<?php if (count($templateAttributes) > 0) { ?>
<h2>Attributes</h2>
<ol>
<?php
foreach ($templateAttributes as $a) {
    echo "<li>";
    echo $a->title;
    echo "</li>";
}?>
</ol>
<?php } ?>

<h2>Pages <small>(<?php echo count($templateArticles); ?>)</small></h2>
<ul>
<?php
foreach ($templateArticles as $a) {
    echo "<li>";
    echo "<a href='" . $a->title . "'>" . $a->title . "</a>";
    echo "<dd>" . $a->summary_html . "</dd>";
    echo "</li>";
}?>
</ul>

