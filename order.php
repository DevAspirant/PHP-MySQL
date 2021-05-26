<?php
require_once './template/header.php';
require './classes/Service.php';

$service = new Service;

if (isset($service->available)) { ?>
    <div class="row">
        <?php foreach ($service->all() as $service) { ?>
            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header"><?php echo $service['name'] ?></h4>
                    <div class="card-body">
                        <p>Price <?php echo $service['price'] ?></p>
                        <p>work days<?php foreach ($service['days'] as $day) { ?><span><?php echo $day ?></span><?php } ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
}
?>