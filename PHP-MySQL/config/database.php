<!--  تخزين المعلومات الاتصال -->
<?php 

$connection = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'app'
];

// الاتصال بقاعدة البيانات
$mysqli = new mysqli($connection['host'], $connection['user'], $connection['password'], $connection['database']);

// التحقق من الاتصال بقاعدة البيانات
if ($mysqli->connect_error) {
    die('connect has been failed ' . $mysqli->connect_error);
}