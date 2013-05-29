<html>
    <head>
        <title>Setup Wizard</title>
        <style>
            .wizard {
                width: 600px;
                height: 400px;
                margin: 50px auto 0 auto;
                border: 1px solid black;
                padding: 25px;
            }
            .wizard .content {
                height: 324px;
            }
            .wizard h1 {
                margin: 0px;
                padding: 15px;
                font-size: 20px;
                height: 25px;
                border-bottom: 1px solid black;
                margin-left: -25px;
                margin-top: -25px;
                margin-right: -25px;
            }
            .wizard .buttons {
                margin: 0px;
                padding: 15px;
                height: 25px;
                border-top: 1px solid black;
                margin-left: -25px;
                margin-right: -25px;
                text-align: right;
            }
            .wizard .buttons button {
                margin-left: 30px;
                width: 75px;
                height: 100%;
            }
        </style>
        <script type='text/javascript'>
            function setAction(url) {
                f = document.getElementById('wizardFrom');
                f.action = url;
            }
        </script>
    </head>
    <body>
        <form id='wizardFrom' method='post' action='/install'>
        <div class='wizard'>
            <h1><?php echo $pageTitle; ?></h1>
            
            <div class='content'>
                <?php if (isset($pageView) && !empty($pageView)) { include($pageView); } ?>
            </div>
            
            <div class='buttons'>
                <?php if ($btnBack) { ?>
                <button type='submit' onclick="setAction('<?php echo $btnBackUrl; ?>')">Back</button>
                <?php } ?>
                <?php if ($btnNext) { ?>
                <button type='submit' onclick="setAction('<?php echo $btnNextUrl; ?>')">Next</button>
                <?php } ?>
                <?php if ($btnFinished) { ?>
                <button type='submit' onclick="setAction('<?php echo $btnFinishUrl; ?>')">Finish</button>
                <?php } ?>
                <?php if ($btnReturn) { ?>
                <button onclick="window.location.href='/'; return false;" style="width: 100px;">Visit Website</button>
                <?php } ?>
            </div>
        </div>
        </form>
    </body>
</html>