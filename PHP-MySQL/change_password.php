<!-- إنشاء نموذج استعادة كلمة المرور -->
<?php
$title = 'Change Password';
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';

// منع المستخدم من الوصول لصفحة معينة 
if(isset($_SESSION['logged_in'])){
    header('location: index.php');
}

// إغلاق صفحة الاستعادة في حال عدم وجود رمز
if(!isset($_GET['token']) || !$_GET['token']){
    die('Token parameter is missing');
}

// التحقق من صحة رمز استعادة كلمة المرور
$now = date('Y-m-d H:i:s');

// stmt mean = statment 
$stmt = $mysqli->prepare("select * from password_resets where token = ? and expires_at > '$now'");
$stmt->bind_param('s',$token);
$token = $_GET['token'];

$stmt->execute();

$result = $stmt->get_result();

if(!$result->num_rows){
    die('Token is not valid');
}


$errors = [];

// فلترة مدخلات المستخدمين 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli,$_POST['password']);
    $password_confirmation = mysqli_real_escape_string($mysqli,$_POST['password_confirmation']);
    if(empty($password)){ array_push($errors,"Password is required"); }
    if(empty($password_confirmation)){ array_push($errors,"Password confirmation is required"); }
    if($password != $password_confirmation){
        array_push($errors,"Passwords do not match ");
    }
  
// التحقق من البيانات باستخدام مصفوفة الاخطاء
    // if(empty($email)){ array_push($errors,"email is required"); }
    
    // التحقق من وجود المستخدمين قبل التسجيل
    if(!count($errors)){
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $userId = $result->fetch_assoc()['user_id'];
        $mysqli->query("update users set password = '$hashed_password' where id = '$userId'");
        $mysqli->query("delete from password_resets where user_id='$userId'");
        $_SESSION['success_message'] = 'your password has been changed, please log in';
        header('location: login.php');
        die();
    }
        // إظهار رسالة النجاح بعد طلب الاستعادة
    //    $_SESSION['success_message'] = 'Please your email for password reset link';
    //    header('location: password_reset.php');

}

?>
<!-- انشاء نموذج التسجيل  -->
<div id="password_reset">
    
    <h5 class="text-info"> Change Password </h5>
    <hr>
    <?php include 'template/errors.php' ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="password"> your new password </label>
            <input type="password" name='password' class="form-control" placeholder='your password' id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation"> Password confirmation </label>
            <input type="password" name='password_confirmation' class="form-control" placeholder='Confirm your password' id="password_confirmation">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Request Password!</button>
        </div>
    </form>
</div>

<?php 
include 'template/footer.php';