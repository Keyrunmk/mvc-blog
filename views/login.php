<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Login";

?>

<br>
<h1 class="text-center">Login</h1>

<div class="container w-25">
    <hr>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="text" name="email" class="form-control"><br>
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control"><br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <br>
    <p>Don't have an account ? <a href="/register">Register</a></p>
</div>