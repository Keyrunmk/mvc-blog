<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Home";
?>

<h1 class="text-center"><?php echo $name; ?></h1>
<hr class="line">
<div class="container d-flex justify-content-around">
    <div class="">
        <h3>Notices</h3>
        <?php
        foreach ($notices as $notice) {
            echo "<a href='#'>$notice[name]</a><br>";
        }
        ?>
    </div>
    <div class="">
        <h3>Standard Posts</h3>
        <?php
        foreach ($posts as $post) {
            echo "<a href='#'>$post[name]</a><br>";
        }
        ?>
    </div>
</div>