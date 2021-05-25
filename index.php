<!-- header.php استدعاء ملف -->
<?php
$title = 'Home Page';
require_once 'template/header.php';
require_once 'includes/uploader.php';

if(isset($_SESSION['contact_form'])){ ?>
<h1><?php  print_r($_SESSION['contact_form']); ?></h1>
<?php } ?>


<!-- create form contact -->
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="font-weight-bold" for="name">Name</label>
        <input type="text" name="name"  value="<?php if(isset($_SESSION['contact_form']['name'])) echo $_SESSION['contact_form']['name'] ?>" class="form-control" placeholder="your name"></input>
        <span class="text-danger"><?php echo $nameError ?></span>
    </div>
    <div class="form-group">
        <label for="email">your email</label>
        <input type="email" name="email" value="<?php if(isset($_SESSION['contact_form']['email'])) echo $_SESSION['contact_form']['email'] ?>" class="form-control" placeholder="your email"></input>
        <span class="text-danger"><?php echo $emailError ?></span>
    </div>
    <div class="form-group">
        <label for="document">your document</label>
        <input type="file" name="document">
        <span class="text-danger"><?php echo $documentError ?></span>
    </div>

    <div class="form-group">
        <label for="message">your message</label>
        <textarea name="message" class="form-control" placeholder="your message"><?php if(isset($_SESSION['contact_form']['message'])) echo $_SESSION['contact_form']['message'] ?></textarea>
        <span class="text-danger"><?php echo $messageError ?></span>
    </div>
  
    
   
   
    <button class="btn btn-primary">send</button>
</form>

<!-- footer.php استدعاء ملف -->
<?php require_once 'template/footer.php' ?>