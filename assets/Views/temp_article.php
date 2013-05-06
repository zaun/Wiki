<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $browserTitle; ?></title>
        <link rel="stylesheet" href="/css/layoutCommon.css" type="text/css" />
        <link rel="stylesheet" href="/css/<?php echo $cssLayout; ?>" type="text/css" />
        <link rel="stylesheet" href="/css/ui-lightness/jquery-ui-1.10.2.custom.css" />
        <script type="text/javascript" src="/js/json2.js"></script>
        <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.10.2.min.js"></script>
        <script type="text/javascript" src="/js/standard.js"></script>
        <?php if($mode === "edit") { ?>
        <link rel="stylesheet" href="/css/edit.css" type="text/css" />
        <script type="text/javascript" src="/js/expanding.js"></script>
        <script type="text/javascript" src="/js/articleEdit.js"></script>
        <?php } ?>
    </head>
    <body>
        <form method='post' accept-charset="utf-8">
        <div id="overlay">
        </div>

        <div id="loginBox">
            <h2>Login</h2>
            <input type="text" id="loginUsername" placeholder="Email">
            <input type="password" id="loginPassword" placeholder="Password">
            <div><span class='btnForgotDialog'>Forgot Password</span></div>
            <button class='btnLogin'>Login</button>
            <button class='btnLoginCancel'>Cancel</button>
        </div>

        <div id="forgotBox">
            <h2>Forgot Password</h2>
            <input type="text" id="forgotEmail" placeholder="Email">
            <div></div>
            <button class='btnForgot'>Send Email</button>
            <button class='btnLoginCancel'>Cancel</button>
        </div>

        <div class="page">
        <div class="topBar">
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
            Insert Media
            </div>
            <div class="options">
            Upload File
            </div>
            <?php } ?>
        </div>
        <div class="pageContent">
            <?php if (isset($pageView) && $pageView != '') { include($pageView); } ?>
            <div style="clear:left"></div>
        </div>
        <div class="pageFooter">
            <?php if (isset($pageFooter) && $pageFooter != '') { include($pageFooter); } ?>
        </div>
        </div>
        </form>
    </body>
</html>
