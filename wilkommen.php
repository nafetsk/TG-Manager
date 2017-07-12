<html>
<h2>Hat geklappt!!!</h2>
<?php
session_start();
echo "{$_SESSION["name"]} {$_SESSION["login"]}";
?>
</html>