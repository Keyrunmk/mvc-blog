<?php

/**
 * @var $exception \Exception
 */

?>

<h1>
    <?php echo $exception->getCode() ?> - <?php echo $exception->getMessage() ?>
</h1>
<h4><?php echo $exception->getFile() ?> - <?php echo $exception->getLine() ?></h4>