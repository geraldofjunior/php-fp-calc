<?php
namespace Point_Calc_Php;


include "ui/model/components/head.html";

include "ui/model/components/sidebar.php";

$addr = "ui/model/pages/";
if (isset($_GET['p'])) {
    if (isset($_GET['p'])) {
        $addr .= "project.php";
    } else if (isset($_GET['f']) && !is_nan($_GET['f'])) {
        $addr .= "function.php";
    } else {
        $addr .= "main.php";
    }
} else {
    $addr .= "main.php";
}

include $addr;

include "ui/model/components/buttons.html";

include "ui/model/components/footer.html";

?>
