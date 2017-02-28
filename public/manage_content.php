<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page();?>

<div class="">
	<div class="row">
	<div class="col-md-3 col-sm-3 navbar" style="padding: 2% 5%;">
		<br />
		<a href="admin.php">&laquo; Main menu</a><br />

 		<?php echo navigation($current_subject, $current_page); ?>
 		 <a href="new_subject.php" class="btn btn-primary"> Add New Student</a>
 	</div>
 	<div class="col-md-9 col-sm-9">
 		<?php echo message(); ?>
 		<?php if($current_subject){ ?>
			<h2>Manage Students</h2>

 			Student Name: <?php echo htmlentities($current_subject["name"]); ?> <br>
 			Roll: <?php echo $current_subject["roll"]; ?><br />
 			Subject: <?php echo $current_subject["subjct_name"]; ?><br />

			<a class="btn btn-primary" href="edit_subject.php?subject=<?php echo urldecode($current_subject["id"]); ?>">Edit Subject</a>

			<div style="margin-top: 2em; border-top: 1px solid #000000;">
				<h3>Subject in this Student:</h3>
				<ul>
				<?php 
					$subject_pages = find_pages_for_subject($current_subject["id"]);
					while($page = mysqli_fetch_assoc($subject_pages)) {
						echo "<li>";
						$safe_page_id = urlencode($page["id"]);
						echo "<a href=\"manage_content.php?page={$safe_page_id}\">";
						echo htmlentities($page["name"]);
						echo "</a>";
						echo "</li>";
					}
				?>
				</ul>
				<br />
				<a class="btn btn-primary" href="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Add a new Subject Here</a>
			</div>


 		<?php } elseif ($current_page){ ?>
				<h2>Manage Pages</h2>
 				Subject Name: <?php echo $current_page["name"]; ?><br>
 				Subject id: <?php echo $current_page["result_id"]; ?><br>
 				Subject Position: <?php echo $current_page["position"]; ?><br>
				Subject message: 
 				<br>
 				<div class="panel panel-default">
 					<?php echo htmlentities($current_page["content"]); ?><br>
 				</div>

 				<br>
		      	<br>
		      	<a class="btn btn-primary" href="edit_page.php?page=<?php echo urlencode($current_page['id']); ?>">Edit page</a>

		<?php } else { ?>
				Please select a subject or a page.
			<?php } ?>
 		
 		
 	</div>
</div>
</div>

<?php include("../includes/layout/footer.php"); ?>
