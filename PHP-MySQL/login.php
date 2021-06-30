
<?php
$title = 'Login';
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';

// منع المستخدم من الوصول لصفحة معينة 
if(isset($_SESSION['logged_in'])){
    header('location: index.php');
}

$errors = [];
$email = '';


// فلترة مدخلات المستخدمين 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli,$_POST['password']);
  

// التحقق من البيانات باستخدام مصفوفة الاخطاء
    if(empty($email)){ array_push($errors,"email is required"); }
    if(empty($password)){ array_push($errors,"Password is required"); }


    // التحقق من وجود المستخدمين قبل التسجيل
    if(!count($errors)){
        $userExists = $mysqli->query("select id, email, password, name from users where email='$email' limit 1");
        
        // التحقق من وجود المستخدم قبل تسجيل الدخول 
        if(!$userExists->num_rows){
            array_push($errors,"your email, $email does not exist in our records.");
        }else{
            // التحقق من صحة كلمة المرور password_verify
            $foundUser = $userExists->fetch_assoc();
            
            if($foundUser['password']){
                // login 
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $foundUser['id'];
                $_SESSION['user_name'] = $foundUser['name'];
                $_SESSION['success_message'] = "Welcome back, $foundUser[name]";
                  header('location: index.php');  
            }else{
                array_push($errors,'Wrong credentials');
            }
        }
    }
    
// create a new user  
//   if(!count($errors)){
// تشفير كلمة السر
//        $password = password_hash($password,PASSWORD_DEFAULT);
// ادخال معلومات المستخدمين في قاعدة البيانات 
//        $query = "insert into users (email, name, password) values ('$email','$name','$password')";
//        $mysqli->query($query);
// توثيق المستخدم وتسجيل دخوله بعد إنشاء الحساب
//         $_SESSION['logged_in'] = true;
//         $_SESSION['user_id'] = $mysqli->insert_id;
//         $_SESSION['user_name'] = $name;
//         $_SESSION['success_message'] = "Welcome back, $name";
//         header('location: index.php');        
//   }
}

?>
<!-- انشاء نموذج التسجيل  -->
<div id="login">
    <h4> Welcome back </h4>
    <h5 class="text-info"> Please fill in the form to login </h5>
    <hr>
    <?php include 'template/errors.php' ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="email"> your email </label>
            <input type="email" name='email' class="form-control" placeholder='your name' id="email">
        </div>
        <div class="form-group">
            <label for="password"> your password </label>
            <input type="password" name='password' class="form-control" placeholder='your password' id="password">
        </div>
        <div class="form-group">
            <button class="btn btn-success">Login</button>
            <a href="password_reset.php">Forget your password</a>
        </div>
    </form>
</div>

<?php 

include 'template/footer.php';