<!-- header.php استدعاء ملف -->
<?php
$title = 'Home Page';
require_once 'template/header.php';

//  اظهار المعلومات في اعلى الصفحة عشان نعرف البيانات -->
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   echo "<pre>";
    print_r($_POST);
    // print_r($_FILES);
    echo "</pre>";

    /* اعداد الملفات المسموح برفعها و نتاكد انه الملف نظيف  */  
    if(isset($_FILES['document']) && $_FILES['document']['error'] == 0){
        
        echo "File is fine";

        /* نوع الملفات المسموح رفعها  */
        $allowed = [
           // 'jpg' => 'image/jpeg',
           // 'png' => 'image/png',
            //'gif' => 'image/gif'
            //'doc' => 'document/doc'
        ];

        $fileType = $_FILES['document']['type'];
        echo $fileType;

        $fileMimeType = mime_content_type($_FILES['document']['tmp_name']);

        echo $fileMimeType;
        

        $maxFileSize = 10 * 1024;
        $fileSize=$_FILES['document']['size'];

        if(!in_array($fileType,$allowed)) die('File type not allowed');
        
        if($fileSize > $maxFileSize) die('File size not allowed'. $maxFileSize);
        
        
    }
}
?>
<!-- create form contact -->
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">your name</label>
        <input type="text" name="name" class="form-control" placeholder="your name"></input>
    </div>
    <div class="form-group">
        <label for="email">your email</label>
        <input type="email" name="email" class="form-control" placeholder="your name"></input>
    </div>
    <div class="form-group">
        <label for="document">your document</label>
        <input type="file" name="document">
    </div>

    <div class="form-group">
        <label for="message">your name</label>
        <textarea name="message" class="form-control" placeholder="your name"></textarea>
    </div>
    <button class="btn btn-primary">send</button>
</form>

<!-- footer.php استدعاء ملف -->
<?php require_once 'template/footer.php' ?>