<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $browserTitle; ?></title>
        <link rel="stylesheet" href="/css/layoutCommon.css" type="text/css" />
        <link rel="stylesheet" href="/css/<?php echo $cssLayout; ?>" type="text/css" />
        <link rel="stylesheet" href="/css/ui-lightness/jquery-ui-1.10.2.custom.css" />
        <script type="text/javascript" src="/js/json2.js"></script>
        <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="/js/standard.js"></script>
<?php if($mode === "edit") { ?>
        <link rel="stylesheet" href="/css/edit.css" type="text/css" />
        <link rel="stylesheet" href="/css/jquery.datepick.css" type="text/css" />
        <link rel="stylesheet" href="/css/ui-ui-lightness.datepick.css" type="text/css" />
        <script type="text/javascript" src="/js/expanding.js"></script>
        <script type="text/javascript" src="/js/ajaxfileupload.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.10.2.min.js"></script>
        <!-- http://keith-wood.name/datepickRef.html -->
        <script type="text/javascript" src="/js/jquery.datepick.min.js"></script>
        <script type="text/javascript" src="/js/jquery.datepick.validation.min.js"></script>
        <script type="text/javascript" src="/js/jquery.datepick.ext.min.js"></script>
        <script type="text/javascript" src="/js/articleEdit.js"></script>
<?php } ?>
    </head>
    <body>
        <form method='post' accept-charset="utf-8" enctype="multipart/form-data">
        <div id="overlay">
        </div>

        <div id="loginBox" class="dialog">
            <h2>Login</h2>
            <input type="text" id="loginUsername" placeholder="Email" />
            <input type="password" id="loginPassword" placeholder="Password" />
            <div><span class='btnForgotDialog'>Forgot Password</span></div>
            <button class='btnLogin'>Login</button>
            <button class='btnLoginCancel'>Cancel</button>
        </div>

        <div id="forgotBox" class="dialog">
            <h2>Forgot Password</h2>
            <input type="text" id="forgotEmail" placeholder="Email" />
            <div></div>
            <button class='btnForgot'>Send Email</button>
            <button class='btnLoginCancel'>Cancel</button>
        </div>
        
        <?php if ($canEdit === true && $mode === "edit") { ?>
        <div id="uploadBox" class="dialog">
            <h2>Upload Media</h2>
            <input type="hidden" id="mediaArticle" name="mediaArticle" value="<?php echo str_replace('"','\"', $articleTitle); ?>" />
            <input type="text" id="mediaTitle" name="mediaTitle" placeholder="Title" />
            <input type="file" id="mediaFile" name="mediaFile" />
            <button class='btnUploadSend'>Upload</button>
            <button class='btnUploadCancel'>Cancel</button>
        </div>
        <?php } ?>

        <div class="page">
        <div class="topBar">
            <div class="logo"><a href="/" alt="Site Logo">Site Logo</a></div>
            <?php include('pageTopBar.php'); ?>
        </div>
        <div class="pageAttributes">
            <?php if (isset($attributeView) && $attributeView != '') { include($attributeView); } ?>
        </div>
        <div class="pageMenu">
            <?php if ($canEdit === true || $canTalk === true) { ?>
                <?php if($mode === "view") { ?>
                <div class="button selected">View</div>
                <?php } else { ?>
                <div class="button" onclick="window.location.href='/<?php echo $id; ?>'">View</div>
                <?php } ?>
                <?php if ($canEdit === true) { if($mode === "edit") { ?>
                <div class="button selected">Edit</div>
                <?php } else { ?>
                <div class="button" onclick="window.location.href='/edit/<?php echo $id; ?>'">Edit</div>
                <?php } } ?>
                <?php if ($canTalk === true) { if($mode === "talk") { ?>
                <div class="button selected">Talk</div>
                <?php } else { ?>
                <div class="button" onclick="window.location.href='/talk/<?php echo $id; ?>'">Talk</div>
                <?php } } ?>
            <?php } ?>
            
            <?php if($mode === "view") { ?>
            <div class="search">
            Search:&nbsp;&nbsp;
            <input type="text" id="searchItem" />
            </div>
            <?php } else if($mode === "edit") { ?>
            <div class="options">
            Media Browser
            </div>
            <div class="options" id="btnUpload">
            Upload File
            </div>
            <?php } ?>
        </div>
        <div class="pageContent">
            <div class="pageContentInner">
                <?php if (isset($pageView) && $pageView != '') { include($pageView); } ?>
                <div style="clear:both"></div>
            </div>
        </div>
        <div class="pageFooter">
            <?php if (isset($pageFooter) && $pageFooter != '') { include($pageFooter); } ?>
        </div>
        </div>
        </form>
    </body>
</html>
