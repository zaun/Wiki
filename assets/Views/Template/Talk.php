<form method='post'>
<h1><?php echo $pageTitle; ?></h1>

<?php foreach($posts as $p) { ?>
    
    <div class="post">
    <div class="date"><?php echo $p->postDate; ?></div>
    <h1><?php echo $p->title; ?></h1>
    <?php if ($p->owner_id == -1) { ?>
       <div class="author">Post By: Anonymouse</div>
    <?php } ?>
    <div class="content"><?php echo $p->content; ?></div>
    </div>
    
<?php } ?>

<div class="newPost">
<div>Create a new comment:</div>
<input class="title" name="newTitle" placeholder="Post title" />
<textarea rows="10" class="body" name="newBody" placeholder="Post body..."></textarea>
<button>Post Comment</button>
</div>
</form>
