<?php
require_once 'template/header.php';
require_once 'config/app.php';
require_once 'config/database.php';
ob_start();
// استخدام as لاعطاء اسم مستعار
/* $query = "select *, m.id as message_id, s.id as service_id from messages m 
left join service s 
on m.service_id = s.id
order by m.id";
$messages = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC); */

 // select الاستعلام في  prepare عن طريق الامر 
    $st = $mysqli->prepare("select *,m.id as message_id,s.id as service_id from messages m left join service s on m.service_id = s.id order by m.id limit ?");

    $st->bind_param('i',$limit);

    isset($_GET['limit']) ? $limit = $_GET['limit'] : $limit = 3;

    $st->execute();

    $messages = $st->get_result()->fetch_all(MYSQLI_ASSOC);

if (!isset($_GET['id'])) {
?>
    <h2>Recived response </h2>
    <div class="table responsive">
        <table class="table table-hover table strip">
            <thead>
                <tr>
                    <th>#</th>
                    <th>sender name</th>
                    <th>sender email</th>
                    <th>Service</th>
                    <th>file</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($messages as $message) {
                ?>
                    <tr>
                        <td><?php echo $message['message_id'] ?></td>
                        <td><?php echo $message['contact_name'] ?></td>
                        <td><?php echo $message['email'] ?></td>
                        <td><?php echo $message['name'] ?></td>
                        <td><?php echo $message['document'] ?></td>
                        <td>
                            <a href="?id=<?php echo $message['message_id'] ?>" class="btn btn-sm btn-primary">View</a>
                            <form onsubmit="return confirm('are you sure?')" action="" method="post" style="display: inline-block;">
                                <input type="hidden" name="message_id" value="<?php echo $message['message_id'] ?>">
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    // عرض الرسالة في صفحة مستقلة  
     $messageQuery = "select * from messages m left join service s on m.service_id = s.id where m.id=" . $_GET['id'] . " limit 1 ";

    $message = $mysqli->query($messageQuery)->fetch_array(MYSQLI_ASSOC); 

    // select الاستعلام في  prepare عن طريق الامر 
    /*$st = $mysqli->prepare("select *,m.id as message_id,s.id as service_id from messages m
    left join services s
    on m.service_id = s.id
    order by m.id limit ?
    ");

    $st->bind_param('i',$limit);

    isset($_GET['limit']) ? $limit = $_GET['limit'] : $limit =  1;

    $st->execute();

    $message = $st->get_result()->fetch_all(MYSQLI_ASSOC);*/
?>

    <div class="card">
        <h5 class="card-header">
            Message from <?php echo $message['contact_name'] ?>
            <div class="small"><?php echo $message['email'] ?></div>
        </h5>
        <div class="card-body">
            <div><h4>Service: <?php if($message['name']){echo $message['name'];}else{echo 'no service';} ?></h4></div> 
            <?php echo $message['message'] ?>
        </div>
        <?php if($message['document']) {?>
        <div class="card-footer">
            <h4>Attachment : <a href="<?php echo $config['app_url'].$config['upload_dir'].$message['document'];?>">Download attchment</a></h4>
        </div>
        <?php } ?>
    </div>
<?php
}

if(isset($_POST['message_id'])){

    // تنفيذ استعلام حذف مع prepared
    $st = $mysqli->prepare("delete from messages where id= ?");
    $st->bind_param('i',$messageId);
    $messageId = $_POST['message_id'];
    $st->execute();

    if($_POST['document']){
        unlink($config['upload_dir'].$_POST['document']);
    }

    /* $mysqli->query("delete from messages where id=".$_POST['message_id']);
    header('location: messages.php');
    die(); */
    echo "<script>location.href='messages.php'</script>";
}

ob_end_flush();
require_once 'template/footer.php';

?>