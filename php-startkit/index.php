<!-- header.php استدعاء ملف -->
<?php
$title = 'Home Page';
require_once 'template/header.php';

    /* فلترة النصوص لمنع الحقن */
    function filterString($field){
        $field = filter_var(trim($field),FILTER_SANITIZE_STRING);
        if(empty($field)){
            return false;
        }else{
            return $field;
        }
    }
    /* فلترة الايميل  لمنع الحقن */
    function filterEmail($field){
        $field = filter_var(trim($field),FILTER_SANITIZE_EMAIL);
        if(filter_var($field,FILTER_VALIDATE_EMAIL)){
            return $field;
        }else{
            return false;
        }
    }
 
$nameError = $emailError = $documentError = $messageError = '';   // Error variable

$name = $email = $message = ''; // init variable 

//  اظهار المعلومات في اعلى الصفحة عشان نعرف البيانات -->
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // التاكد من تعبئة خانة الاسم
    $name = filterString($_POST['name']);
    if(!$name){
        $nameError = 'your name is required';
    }
    // التاكد من تعبئة خانة الايميل
    $email = filterEmail($_POST['email']);
    if(!$email){
        $emailError = 'your email is invalid';
    }
    // التاكد من تعبئة خانة الرسالة
    $message = filterString($_POST['message']);
    if(!$message){
        $messageError = 'you must enter a message';
    }

    /* اعداد الملفات المسموح برفعها و نتاكد انه الملف نظيف  */  
    if(isset($_FILES['document']) && $_FILES['document']['error'] == 0){
        
        echo "File is fine";

        /* نوع الملفات المسموح رفعها  */
        $allowed = [
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpg'
           // 'png' => 'image/png',
            //'gif' => 'image/gif'
            //'doc' => 'document/doc'
        ];

        $fileType = $_FILES['document']['type']; /* نوع الملف */
       
        $fileMimeType = mime_content_type($_FILES['document']['tmp_name']); /* للتحقق من نوع الملف الحقيقي  */

        
        // حجم الملفات التي نقوم برفعها 
        $maxFileSize = 10 * 1024;

        $fileSize=$_FILES['document']['size']; /* حجم الملف */
        /* التاكد من نوع الملف*/
        if(!in_array($fileType,$allowed)) {
            $documentError = 'File type is not allowed';
        }
        /* التاكد من حجم الملف */
        if($fileSize > $maxFileSize){
            $documentError = 'File size is not allowed';
        }
        
    }
}
?>
<!-- اظهار نتائج الطلب -->
<div class="card" style="width: 18rem;">
  <div class="card-body">
  <h5 class="card-title text-success">POST REQUEST : Result</h5>
    <p class="card-text"><?php  echo "<pre>"; print_r($_POST); echo "</pre>"; ?></p>
  </div>
</div>

<!-- create form contact -->
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">your name</label>
        <input type="text" name="name"  value="<?php echo $name ?>" class="form-control" placeholder="your name"></input>
        <span class="text-danger"><?php echo $nameError ?></span>
    </div>
    <div class="form-group">
        <label for="email">your email</label>
        <input type="email" name="email" value="<?php echo $email ?>" class="form-control" placeholder="your email"></input>
        <span class="text-danger"><?php echo $emailError ?></span>
    </div>
    <div class="form-group">
        <label for="document">your document</label>
        <input type="file" name="document">
        <span class="text-danger"><?php echo $documentError ?></span>
    </div>

    <div class="form-group">
        <label for="message">your message</label>
        <textarea name="message" class="form-control" placeholder="your message"><?php echo $message ?></textarea>
        <span class="text-danger"><?php echo $messageError ?></span>
    </div>
    <button class="btn btn-primary">send</button>
</form>

<!-- footer.php استدعاء ملف -->
<?php require_once 'template/footer.php' ?>