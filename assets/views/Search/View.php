<h1>Search Results</h1>

<ul>
<?php
foreach ($results as $result) {
    echo "<li>";
    echo "<a href=\"/" . $result->title . "\">" . $result->title . "</a>";
    echo "</li>";
}
?>
</ul>