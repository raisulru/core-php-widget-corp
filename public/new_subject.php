<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page();?>
<div class="">
<div class="row">
	<div class="col-md-3 col-sm-3">
 		<?php echo navigation($current_subject, $current_page); ?>
 	</div>
 	<div class="col-md-9 col-sm-9">
 	
 		<?php echo message(); ?>
		<?php $errors = errors(); ?>
		<?php echo form_errors($errors); ?>

		<h2>Create Subject</h2>
 		<form class="form-group" action="create_subject.php" method="POST">
 			<p>Student Name:
				<input type="text" class="form-control" name="student_name" value="">
 			</p>
 			<p>Roll:
				<input type="number" class="form-control" name="roll_number" value="">
 			</p>
 			<p>Subject Name:
				<input type="text" class="form-control" name="subject_name" value="">
 			</p>
 			<input type="submit" name="submit" class="btn btn-primary" value="Create New">
 		</form>
 		<br>
 		<a href="manage_content.php" class="btn btn-danger">Cancel</a>
 		
 	</div>
</div>
</div>
<?php include("../includes/layout/footer.php"); ?>