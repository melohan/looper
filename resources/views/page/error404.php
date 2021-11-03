<?php
$headerText = "<h1>Exercise<br>Looper</h1>";
$headerClass = "dashboard";
?>

<?php ob_start(); ?>
<h1>Error 404</h1>
<p>The page you were looking for does not exist :(</p>
<a class="button answering column" href="/">Go home</a>
<?php
$content = ob_get_clean();
require_once 'view/layout.php';

?>
