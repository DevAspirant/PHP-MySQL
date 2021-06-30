
<?php
$title = 'Register';
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';

// منع المستخدم من الوصول لصفحة معينة 
if(isset($_SESSION['logged_in'])){
    header('location: index.php');
}

$errors = [];
$email = '';
$name = '';

// فلترة مدخلات المستخدمين 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name = mysqli_real_escape_string($mysqli,$_POST['name']);
    $password = mysqli_real_escape_string($mysqli,$_POST['password']);
    $password_confirmation = mysqli_real_escape_string($mysqli,$_POST['password_confirmation']);

// التحقق من البيانات باستخدام مصفوفة الاخطاء
    if(empty($email)){ array_push($errors,"email is required"); }
    if(empty($name)){ array_push($errors,"Name is required"); }
    if(empty($password)){ array_push($errors,"Password is required"); }
    if(empty($password_confirmation)){ array_push($errors,"Password confirmation is required"); }
    if($password != $password_confirmation){
        array_push($errors,"Passwords do not match ");
    }

    // التحقق من وجود المستخدمين قبل التسجيل
    if(!count($errors)){
        $userExists = $mysqli->query("select id,email from users where email='$email' limit 1");
        if($userExists->num_rows){
            array_push($errors,"Email already registered");
        }
    }
    
    // 
    if(!count($errors)){
        // تشفير كلمة السر
        $password = password_hash($password,PASSWORD_DEFAULT);
        
        // ادخال معلومات المستخدمين في قاعدة البيانات 
        $query = "insert into users (email, name, password) values ('$email','$name','$password')";
        $mysqli->query($query);

        // توثيق المستخدم وتسجيل دخوله بعد إنشاء الحساب
         $_SESSION['logged_in'] = true;
         $_SESSION['user_id'] = $mysqli->insert_id;
         $_SESSION['user_name'] = $name;
         $_SESSION['success_message'] = "Welcome back, $name";

         header('location: index.php');
        
    }
}

?>
<!-- انشاء نموذج التسجيل  -->
<div id="register">
    <h4> Welcome to our website </h4>
    <h5 class="text-info"> Please fill in the form below to register a new account </h5>
    <hr>
    <?php include 'template/errors.php' ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="email"> your email </label>
            <input type="email" name='email' class="form-control" placeholder='your name' id="email">
        </div>
        <div class="form-group">
            <label for="name"> your Name </label>
            <input type="text" name='name' class="form-control" placeholder='your name' id="name">
        </div>
        <div class="form-group">
            <label for="password"> your password </label>
            <input type="password" name='password' class="form-control" placeholder='your password' id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation"> Confirm password </label>
            <input type="password" name='password_confirmation' class="form-control" placeholder='confirm your password' id="password_confirmation">
        </div>
        <div class="form-group">
            <button class="btn btn-success">Register!</button>
            <a href="login.php">Already have an account ? Login in</a>
        </div>
    </form>
</div>



<!-- footer.php استدعاء ملف -->
<?php require_once 'template/footer.php' ?>