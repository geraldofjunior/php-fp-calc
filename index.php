<?php
namespace Point_Calc_Php;


include "src/ui/model/components/head.php";

include "src/ui/model/components/sidebar.php";

$addr = "src/ui/model/pages/";
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

include "src/ui/model/components/buttons.html";

include "src/ui/model/components/footer.html";

?>
