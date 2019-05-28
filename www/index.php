<?php

try {
	include('app.php');
} catch (Throwable $e) {
	echo $e->getMessage();
	exit();
}