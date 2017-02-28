<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $layout_context = "public"; ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page(true);?>

<div class="">
	<div class="row">
	<div class="col-md-3 col-sm-3 navbar" style="padding: 2% 5%;">
		
 		<?php echo public_navigation($current_subject, $current_page); ?>
 		<a href="login.php" class="btn btn-primary">Admin Login</a>
 		
 	</div>
 	<div class="col-md-9 col-sm-9">
 		
 		<?php if ($current_page) { ?>
			<h2><?php echo htmlentities($current_page["name"]); ?></h2>
			<?php echo nl2br(htmlentities($current_page["content"])); ?>
			
		<?php } else { ?>
			<p>Welcome !</p>
		<?php }?>
 		
 	</div>
</div>
</div>

<?php include("../includes/layout/footer.php"); ?>
