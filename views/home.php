<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Home";
?>

<h1 class="text-center"><?php echo $name; ?></h1>
<hr class="line">
<div class="container">
    <?php foreach ($categories as $category) : ?>
        <a href="/posts?category_id=<?php echo  $category['id']?>">
            <h3><?php echo $category["name"] ?></h3>
        </a>
    <?php endforeach; ?>
</div>