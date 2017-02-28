<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_page(); ?>

<?php
  // Can't add a new page unless we have a subject as a parent!
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
  $required_fields = array("name", "position", "content");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("name" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create

    // make sure you add the subject_id!
    $result_id = $current_subject["id"];
    $name = mysql_prep($_POST["name"]);
    $position = (int) $_POST["position"];
    
    // be sure to escape the content
    $content = mysql_prep($_POST["content"]);
  
    $query  = "INSERT INTO pages (";
    $query .= " result_id, name, position, content";
    $query .= ") VALUES (";
    $query .= " {$result_id}, '{$name}', {$position}, '{$content}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Page created.";
      redirect_to("manage_content.php?subject=" . urlencode($current_subject["id"]));
    } else {
      // Failure
      $_SESSION["message"] = "Page creation failed.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php include("../includes/layout/header.php"); ?>
<div class="">
  <div class="row">
    <div class="col-md-3">
      <?php echo navigation($current_subject, $current_page); ?>
    </div>

    <div class="col-md-9">
      <?php echo message(); ?>
      <?php echo form_errors($errors); ?>
      
      <h2>Create Page</h2>
      <form class="form-group" action="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
        <p>Subject name:
          <input type="text" class="form-control" name="name" value="">
        </p>
        <p>Position:
          <select name="position">
          <?php
            $page_set = find_pages_for_subject($current_subject["id"]);
            $page_count = mysqli_num_rows($page_set);
            for($count=1; $count <= ($page_count + 1); $count++) {
              echo "<option value=\"{$count}\">{$count}</option>";
            }
          ?>
          </select>
        </p>
       
        <p>Content:<br />
          <textarea name="content" rows="10" cols="40"></textarea>
        </p>
        <input type="submit" class="btn btn-primary" name="submit" value="Create Page">
      </form>
      <br />
      <a class="btn btn-danger" href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Cancel</a>
    </div>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
