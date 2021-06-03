 <!-- هذا الملف خاص بنوع البينات الي راح ترتفع للسيرفر -->
<?php 

require_once __DIR__."/../config/database.php";


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
               'jpg' => 'image/jpg',
               'png' => 'image/png'
              
            ];
    
            // $fileType = $_FILES['document']['type']; /* نوع الملف */
           
            $fileMimeType = mime_content_type($file['tmp_name']); /* للتحقق من نوع الملف الحقيقي  */
    
            
            // حجم الملفات التي نقوم برفعها 
            $maxFileSize = 10 * 1024 *1024;
    
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
 
$nameError = $emailError = $documentError = $messageError = '';   // Error init variable

$name = $email = $message = ''; // init variable 
$uploadDir = 'uploads';
$fileName = $_FILES['document']['name'];


//  اظهار المعلومات في اعلى الصفحة عشان نعرف البيانات -->
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // التاكد من تعبئة خانة الاسم
    $name = filterString($_POST['name']);
    if(!$name){
        $_SESSION['contact_form']['name'] ="";
        $nameError = 'your name is required';
    }else{
        $_SESSION['contact_form']['name'] = $name; // save the visitor name session
    }
    // التاكد من تعبئة خانة الايميل
    $email = filterEmail($_POST['email']);
    if(!$email){
        $emailError = 'your email is invalid';
        $_SESSION['contact_form']['email'] = '';
    }else{
        $_SESSION['contact_form']['email'] = $email;
    }
    // التاكد من تعبئة خانة الرسالة
    $message = filterString($_POST['message']);
    if(!$message){
        $messageError = 'you must enter a message';
        $_SESSION['contact_form']['message'] = '';
    }else{
        $_SESSION['contact_form']['message'] = $message;
    }

    /* اعداد الملفات المسموح برفعها و نتاكد انه الملف نظيف  */  
    if(isset($_FILES['document']) && $_FILES['document']['error'] == 0){
        
        $canUpload = canUpload($_FILES['document']);

        if($canUpload === true){
            
            if(!is_dir($uploadDir)){
                umask(0);
                mkdir($uploadDir,0775);
            }

           

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

    /* مسح بيانات المتغيرات في حالة كانت جميع العمليات صحيحة  */

    if(!$nameError && !$emailError && !$messageError && !$documentError){ 

        // ادحال المعلومات 
        $fileName ? $filePath = $uploadDir.'/'.$fileName:$filePath = 'empty';
        $insertMessage = "insert into messages (contact_name,email,document,message,service_id)".
                         "values ('$name','$email','$fileName','$message',".$_POST['service_id'].")";

        $mysqli->query($insertMessage);

        // header الخاص بالايميل
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .='Content-type: text/html;charset=UTF-8' . "\r\n";
        $headers .='From: '.$email."\r\n" . 'Replay-To'.$email."\r\n".'X-Mailer: PHP/'.phpversion();

        $htmlMessage = '<html><body>';
        $htmlMessage .= '<p style="color:#ff0000;">'.$message.'</p>';
        $htmlMessage .='</body></html>';


    /*    if(mail($config['admin_email'],'you have new message',$message)){
             // unset($_SESSION['contact_form']); مسح بيانات المتغيرات في الجلسة 
             echo '<p class="text-success">message has been sent</p>';
             session_destroy(); // حذف كل البيانات من الجلسة 
             header('Location:http://localhost/php/php-startkit/'); // redirect the page
            die();
        }else{
            echo 'Error sending message';
        }
    */
    }
}
