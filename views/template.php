<?php 
header("Content-Type:text/html;charset=utf-8;");
?>
<!doctype html>
<html lang="en" style="height:100%">



    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, shrink-to-fit=no">

        <!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css" type="text/css">

        <title><?=App::$pageTitle?></title>
        <!--title><?=App::$current_controller . "::" . App::$current_action?></title-->
    </head>



    <body class="overflow-hidden" style="height:100%; display:none;">

        <div class="sb-background-body"></div>

        <div class="sb-content-page-container">

            <div class="container" style="height:100%">

                <!-- шапка -->
                <?php /*if(App::$user != null)*/ include 'views/header.php'; ?>


                <!-- контент на странице -->
                <?php if(isset($content_view)) include 'views/'.$content_view; ?>


                <!-- футер -->
                <?php /*if(App::$user != null)*/ include 'views/footer.php'; ?>

            </div>

        </div>

        <!-- Bootstrap and jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://bitwiseshiftleft.github.io/sjcl/sjcl.js"></script>

        <script language="javascript">
            window.onload = function(e) {
                document.body.style.display = "block";
            };
        </script>

        <script src="js/toggles.js" language="javascript" type="text/javascript"></script>
    </body>



</html>