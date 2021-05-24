<?php 
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
    /* رفع الملفات */
    function canUpload($file){

            /* نوع الملفات المسموح رفعها  */
            $allowed = [
               'jpeg' => 'image/jpeg',
               'jpg' => 'image/jpg'
              
            ];
    
            // $fileType = $_FILES['document']['type']; /* نوع الملف */
           
            $fileMimeType = mime_content_type($file['tmp_name']); /* للتحقق من نوع الملف الحقيقي  */
    
            
            // حجم الملفات التي نقوم برفعها 
            $maxFileSize = 10 * 1024;
    
            $fileSize=$file['size']; /* حجم الملف */
            /* التاكد من نوع الملف*/
            if(!in_array($fileMimeType,$allowed)) {
                return 'File type is not allowed';
            }
            /* التاكد من حجم الملف */
            if($fileSize > $maxFileSize){
                return 'File size is not allowed';
            }

            return true;

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
        
        $canUpload = canUpload($_FILES['document']);

        if($canUpload === true){
            $uploadDir = 'uploads';
            if(!is_dir($uploadDir)){
                umask(0);
                mkdir($uploadDir,0775);
            }

            $fileName = $_FILES['document']['name'];

            // to solve the duplicate it $fileName = time().$_FILES['document']['name'];

            if(file_exists($uploadDir.'/'.$fileName)){
                $documentError = 'File already exists';
            }else{
                move_uploaded_file($_FILES['document']['tmp_name'],$uploadDir.'/'.$fileName);
            }

        }else{
            $documentError = $canUpload;
        }    
    }
}