<?php
namespace Point_Calc_Php;
use Point_Calc_Php\Services\SimpleRouter as SimpleRouter;
?>
<!DOCTYPE html>
<html>
<head>
    <link href="ui\style\home.css" rel="stylesheet" />
    <link href="ui\style\button.css" rel="stylesheet" />
    <link href="ui\style\card.css" rel="stylesheet" /> 
    <script src="https://kit.fontawesome.com/6e2301b883.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="main">
    <?php 
    
    include "ui/model/sidebar.php";
    include "services/simple_router.php";
    
    $router = SimpleRouter::getInstance();
    if (isset($_GET['P'])) {
        $router->route($_GET['P']);
    } else {
        $router->route("ui\model\main.php");
    }

    ?>
</div>
     
</body>
</html>