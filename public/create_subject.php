<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php 
if(isset($_POST['submit'])){

	$student_name = mysql_prep($_POST["student_name"]);
	$roll = (int) $_POST["roll_number"];
	$subject = mysql_prep($_POST["subject_name"]);
	
	// validations
	$required_fields = array("student_name", "roll_number", "subject_name");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("student_name" => 30, "subject_name" => 50);
	validate_max_lengths($fields_with_max_lengths);
	
	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_subject.php");
	}

	$query = "INSERT INTO result (";
	$query .= " name, roll, subjct_name";
	$query .= ") VALUES (";
	$query .= " '{$student_name}', {$roll}, '{$subject}'";
	$query .= ")";
	$result = mysqli_query($connection, $query);

	if($result){
		$_SESSION["message"] = "Subject created";
		redirect_to("manage_content.php");
	}else{
		$_SESSION["message"] = "Subject creation failed";
		redirect_to("new_subject.php");
	}

}else{
	redirect_to("new_subject.php");
}

 ?>


<?php 
if (isset($connection)) {
	mysqli_close($connection);
}