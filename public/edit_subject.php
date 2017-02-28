<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_page(); ?>

<?php
	if (!$current_subject) {
		// subject ID was missing or invalid or 
		// subject couldn't be found in database
		redirect_to("manage_content.php");
	}
?>
<?php
	if (isset($_POST['submit'])) {
		// Process the form
		
		// validations
		$required_fields = array("student_name", "roll_number", "subject_name");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("student_name" => 30, "subject_name" => 50);
		validate_max_lengths($fields_with_max_lengths);

		if (empty($errors)) {
			
			// Perform Update

			$id = $current_subject["id"];
			$student_name = mysql_prep($_POST["student_name"]);
			$roll = (int) $_POST["roll_number"];
			$subject_name = mysql_prep($_POST["subject_name"]);
		
			$query  = "UPDATE result SET ";
			$query .= "name = '{$student_name}', ";
			$query .= "roll = {$roll}, ";
			$query .= "subjct_name = '{$subject_name}' ";
			$query .= "WHERE id = {$id} ";
			$query .= "LIMIT 1";
			$result = mysqli_query($connection, $query);

			if ($result && mysqli_affected_rows($connection) >= 0) {
				// Success
				$_SESSION["message"] = "Subject updated.";
				redirect_to("manage_content.php");
			} else {
				// Failure
				$message = "update failed.";
			}
		
		}
	} else {
		// This is probably a GET request
		
	} // end: if (isset($_POST['submit']))

?>

<?php include("../includes/layout/header.php"); ?>
<div class="">
<div class="row">
	<div class="col-md-3 col-sm-3">
 		<?php echo navigation($current_subject, $current_page); ?>
 	</div>
 	<div class="col-md-9 col-sm-9">
 		<?php // $message is just a variable, doesn't use the SESSION
			if (!empty($message)) {
				echo "<div class=\"alert alert-success\">" . htmlentities($message) . "</div>";
			}
		?>
		<?php echo form_errors($errors); ?>
 	

		
		<h2>Edit Student Information: <?php echo htmlentities($current_subject["name"]); ?></h2>
		<form action="edit_subject.php?subject=<?php echo urldecode($current_subject["id"]); ?>" method="post">
		  <p>Student name:
		    <input type="text" class="form-control" name="student_name" value="<?php echo htmlentities($current_subject["name"]); ?>" >
		  </p>
		  <p>Roll Number:
		     <input type="number" class="form-control" name="roll_number" value="<?php echo $current_subject["roll"]; ?>" >
		  </p>
		  <p>Subject name:
		    <input type="text" class="form-control" name="subject_name" value="<?php echo htmlentities($current_subject["subjct_name"]); ?>" >
		  </p>

		  
		  <input type="submit" name="submit" class="btn btn-primary" value="Confirm">
		</form>
		<br />
		<a href="manage_content.php" class="btn btn-danger">Cancel</a>
 		&nbsp;
		&nbsp;
		<a class="btn btn-danger" href="delete_student.php?subject=<?php echo urldecode($current_subject["id"]); ?>" onclick="return confirm('Are you sure?');">Delete subject</a>
 	</div>
</div>
</div>
<?php include("../includes/layout/footer.php"); ?>