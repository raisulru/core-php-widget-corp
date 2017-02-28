<?php 
	if (!isset($layout_context)) {
		$layout_context = "public";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Widget Corp <?php if ($layout_context == "admin") { echo "Admin"; } ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="bootstrap.min.js"></script>
</head>
<body class="container">
<div class="text-center jumbotron">
		 <h1>Widget Corp <?php if ($layout_context == "admin") { echo "Admin"; } ?></h1>
</div>