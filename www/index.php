<?php
if(isset($_GET['jsHandler'])) {
	header("Content-Type: application/javascript");
	echo file_get_contents('ProductSizeHandler.js');
	exit();
}
try {
	include('app.php');
} catch (Throwable $e) {
	echo $e->getMessage();
	exit();
}