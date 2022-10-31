<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Register";

?>

<br>
<h1 class="text-center">Register</h1>

<div class="container w-25">
    <hr class="line">

    <form action="" method="post">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" class="form-control"><br>
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" class="form-control"><br>
        <label for="email">Email</label>
        <input type="text" name="email" class="form-control"><br>
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control"><br>
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" name="confirmPassword" class="form-control"><br>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>