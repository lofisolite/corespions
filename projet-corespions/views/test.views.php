<?php
ob_start();
?>

<?php 
echo "<pre>";
print_r ($test);
echo "</pre>";
?>


<?php
$content = ob_get_clean();

$preContent = "";
$titleh2 = "test";
$titleHead = "test Corespions";
$src = "";

require "views/common/template.php";