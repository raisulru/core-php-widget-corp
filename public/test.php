<?php
	$query  = "UPDATE result SET ";
	$query .= "name = '{$student_name}', ";
	$query .= "roll = {$roll}, ";
	$query .= "subjct_name = '{$subject_name}' ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1";
	var_dump($query);
?>