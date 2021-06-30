<!-- header.php استدعاء ملف -->
<?php
$title = 'Home Page';
require_once 'template/header.php';
require_once 'includes/uploader.php';
require 'classes/Service.php';
require 'classes/Product.php';
require 'config/app.php';
require_once 'config/database.php';

$s = new Service;

$s->available;

$s->taxRate = .05;

$p = new Product;

?>

<?php

/* اغلاق الاتصال بقاعدة البيانات 
$mysqli->close();*/

// عمل الكوكيز و تحديد قيمتها و وقتها
setcookie('username', 'Ammar', time() + 30 * 24 * 60 * 60);
// مسح الكوكيز بعد ساعة 
setcookie('usename', 'Ammar', time() - 3600);

// الحصول على الكوكيز
if (isset($_COOKIE['username'])) echo "HELLO " . $_COOKIE['username'];
// طباعة معلومات الجلسة المخزنة في السيرفر
//if (isset($_SESSION['contact_form'])) { ?>
    <!-- 
    <h1>
        <?php // print_r($_SESSION['contact_form']); ?>
    </h1>
<?php // } ?> -->
<hr>
<?php if ($s->available) { ?>
    <!-- قراءة البيانات من قاعدة البيانات -->
    <?php $product = $mysqli->query("select * from products order by name")->fetch_all(MYSQLI_ASSOC) ?>

    <div class="row">
        <?php foreach ($product as $product) { ?>
            <div class="col-md-4">
                <div class="card mb-3">
                   <div class="custom-card-image" style="background-image: url(<?php echo $config['app_url'].$product['image']?>)"></div>
                    <div class="card-body">
                        <div class="card-title"><?php echo $product['name'] ?></div>
                        <div><?php echo $product['description'] ?></div>
                        <div class="text-success"><?php echo $product['price'] ?>SAR</div>
                    </div>
                </div>
            </div>
    </div>
<?php }  ?>

<?php
    $mysqli->close(); // اغلاق الاتصال بقاعدة البيانات 
} ?>

<!-- footer.php استدعاء ملف -->
<?php require_once 'template/footer.php' ?>