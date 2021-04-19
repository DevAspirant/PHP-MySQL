<!--تضمين ملف  app.php  -->
<?php require_once __DIR__ .'/../config/app.php'?>

<!-- مشاهدة الاخطاء في الصفحة -->
<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
?>

<!DOCTYPE html>
<!-- استدعاء عناصر مصفوفة config in app.php-->
<html dir="<?php echo $config['dir']?>" lang="<?php echo $config['lang'] ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- طباعة اسم التطبيق من app.php -->
        <title><?php echo $config['app_name'] . " | " . $title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="template/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">