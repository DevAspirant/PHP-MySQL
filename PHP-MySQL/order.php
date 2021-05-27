<?php

$title = 'order page'; 

require_once './template/header.php';
require './classes/Service.php';
require './classes/Product.php';

$Service = new Service;
$Service->taxRate = 0.5;

$Product = new Product;
$Product->taxRate = 0.5;

if (isset($Service->available)) { ?>
    <div class="row">
        <?php foreach ($Service->all() as $service) { ?>
            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header"><?php echo $service['name'] ?></h4>
                    <div class="card-body">
                        <p>Price <?php echo $Service->price($service['price']) ?></p>
                        <p>work days<?php foreach ($service['days'] as $day) { ?><span><?php echo $day ?></span><?php } ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
}
?>
<hr>
<div class="row">
        <?php foreach ($Product->all() as $product) { ?>
            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header"><?php echo $product['name'] ?></h4>
                    <div class="card-body">
                        <p>Price <?php echo $Product->price($product['price']) ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>