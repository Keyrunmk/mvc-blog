<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Home";
?>

<h1 class="text-center"><?php echo $name; ?></h1>
<hr class="line">
<div class="container">
    <?php foreach ($posts as $post) : ?>
        <a href="#">
            <h3><?php echo $post["name"] ?></h3>
        </a>
    <?php endforeach; ?>
</div>