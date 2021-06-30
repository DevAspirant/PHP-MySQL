<!-- إنشاء نموذج استعادة كلمة المرور -->
<?php
$title = 'Password Reset';
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
  
// التحقق من البيانات باستخدام مصفوفة الاخطاء
    if(empty($email)){ array_push($errors,"email is required"); }
    
    // التحقق من وجود المستخدمين قبل التسجيل
    if(!count($errors)){
        $userExists = $mysqli->query("select id, email name from users where email='$email' limit 1");
    
        // التحقق من وجود المستخدم قبل تسجيل الدخول 
        if($userExists->num_rows){
         
            // إنشاء رموز استعادة كلمة المرور random_bytes + hash
            $userId = $userExists->fetch_assoc()['id'];
        
            $token = bin2hex(random_bytes(16));
            
            // حذف رموز الاستعادة من جدول password_resets
            $tokenExists = $mysqli->query("delete from password_resets where user_id='$userId'");

            // ضبط تاريخ إنتهاء رمز الاستعادة
            $expires_at = date('Y-m-d  H:i:s',strtotime('+1 day'));
            
            $mysqli->query("insert into password_resets (user_id,token,expires_at)values('$userId','$token','$expires_at')");
            
        }
           // إظهار رسالة النجاح بعد طلب الاستعادة
           $_SESSION['success_message'] = 'Please your email for password reset link';
           header('location: password_reset.php');
    }
    if($mysqli->error){
        die($mysqli->error);
    }
}

?>
<!-- انشاء نموذج التسجيل  -->
<div id="password_reset">
    
    <h5 class="text-info"> Please fill in the form to reset the password </h5>
    <hr>
    <?php include 'template/errors.php' ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="email"> your email </label>
            <input type="email" name='email' class="form-control" placeholder='your name' id="email" value="<?php echo $email ?>">
        </div>
    
        <div class="form-group">
            <button class="btn btn-primary">Request Password!</button>
        </div>
    </form>
</div>

<?php 
include 'template/footer.php';