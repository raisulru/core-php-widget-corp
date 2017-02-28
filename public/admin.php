<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php"); ?>
<div class="row">
	<div class="col-md-3 menu"></div>
	<div class="container col-md-9">
		<h2>Admin Menu</h2>
    <p>Welcome to the admin area, <?php echo htmlentities($_SESSION["username"]); ?>.</p>
		<ul>
			<li><a href="manage_content.php">manage_content</a></li>
			<li><a href="manage_admins.php">manage_admin</a></li>
			<li><a href="logout.php">logout</a></li>
		</ul>
	</div>
</div>
<?php include("../includes/layout/footer.php"); ?>