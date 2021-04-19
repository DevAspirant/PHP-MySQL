<!-- header.php استدعاء ملف -->
<?php
$title = 'Home Page';
require_once 'template/header.php' ?>

<!-- create form contact -->
<form action="" method="post">
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
        <input type="file" name="name">
    </div>

    <div class="form-group">
        <label for="message">your name</label>
        <textarea name="message" class="form-control" placeholder="your name"></textarea>
    </div>
    <button class="btn btn-primary">send</button>
</form>

<!-- footer.php استدعاء ملف -->
<?php require_once 'template/footer.php' ?>