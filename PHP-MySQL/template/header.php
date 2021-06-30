<!--تضمين ملف  app.php  -->
<?php require_once __DIR__ . '/../config/app.php';
/* الجلسة عبارة عن معلومات مؤقتة تخزن لغرض يخدم المستخدم 
تخزن معلومات الالجلسة على شكل مصفوفة
*/
session_start(); //  بداية الجلسة 
// <!-- مشاهدة الاخطاء في الصفحة -->
error_reporting(E_ALL);
ini_set('display_errors', 1);


?>

<!DOCTYPE html>
<!-- استدعاء عناصر مصفوفة config in app.php-->
<html dir="<?php echo $config['dir'] ?>" lang="<?php echo $config['lang'] ?>">

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
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo $config['app_url']?>"><?php echo $config['app_name'] ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo $config['app_url']?>">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url']?>/contact.php">Contact</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    <?php if(!isset($_SESSION['logged_in'])): ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url']?>/login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url']?>/register.php">Register</a>
      </li>
      <?php else: ?>
        <li class="nav-item">
        <a class="nav-link" href="#"><?php echo $_SESSION['user_name']?></a>
      </li>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url']?>/logout.php">Logout</a>
      </li>
      <?php endif ?>
    </ul>
  </div>
</nav>      
  <div class="container pt-5">
    <!-- اظهار نتائج الطلب -->
    <?php include 'message.php' ?>

    