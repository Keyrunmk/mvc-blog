<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="/backend/css/main.css" />
    <link rel="stylesheet" type="text/css" href="/backend/css/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title><?php echo $this->title; ?></title>
</head>

<body class="app sidebar-mini rtl">
    <?php

    use app\core\Application;

    include_once(Application::$ROOT_DIR . '/views/admin/partials/header.php');
    include_once(Application::$ROOT_DIR . '/views/admin/partials/sidebar.php');
    ?>
    <main class="app-content">
        {{content}}
    </main>
    <script src="/backend/js/jquery-3.2.1.min.js"></script>
    <script src="/backend/js/popper.min.js"></script>
    <script src="/backend/js/bootstrap.min.js"></script>
    <script src="/backend/js/main.js"></script>
    <script src="/backend/js/plugins/pace.min.js"></script>
</body>

</html>