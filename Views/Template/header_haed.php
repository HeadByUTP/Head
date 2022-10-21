<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Sistema HAED">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Universidad Tecnológica de Puebla">
        <meta name="theme-color" content="#009688">
        <title><?= $data['page_tag']; ?></title>
        <link
        rel="shortcut icon" type="image/x-icon" href="assets/img/icons/favicon.ico">
        <!-- FontAwesome --> 
        <link
        rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous"/>
        <!-- Jquery -->
        <script src="<?= media(); ?>/haedclient/js/jquery-1.12.4.min.js"></script>

        <!-- MIS CSS -->
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/style.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/slicknav.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/slick.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/flaticon.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/themify-icons.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/animate.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/icofont.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/icofont.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/boxicons.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/venobox.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/haedclient/css/aos.css">
       
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&&family=Montserrat:wght@400;500&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

    </head>
    <body>
    <div id="divLoading" >
      <div>
        <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
      </div>
    </div>
    <?php require_once("nav_haed.php"); ?> 