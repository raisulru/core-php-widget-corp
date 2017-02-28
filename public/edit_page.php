<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_page(); ?>

<?php
  // Unlike new_page.php, we don't need a subject_id to be sent
  // We already have it stored in pages.subject_id.
  if (!$current_page) {
    // page ID was missing or invalid or 
    // page couldn't be found in database
    redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  $id = $current_page["id"];
  $name = mysql_prep($_POST["name"]);
  $position = (int) $_POST["position"];

  $content = mysql_prep($_POST["content"]);

  // validations
  $required_fields = array("name", "position", "result_id", "content");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("name" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $query  = "UPDATE pages SET ";
    $query .= "name = '{$name}', ";
    $query .= "position = {$position}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Page updated.";
      redirect_to("manage_content.php?page={$id}");
    } else {
      // Failure
      $_SESSION["message"] = "Page update failed.";
    }
  
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php include("../includes/layout/header.php"); ?>

<div id="main">
  <div id="navigation" class="col-md-3">
    <?php echo navigation($current_subject, $current_page); ?>
  </div>
  <div id="page" class="col-md-9">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Edit Page: <?php echo htmlentities($current_page["name"]); ?></h2>
    <form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
      <p>Menu name:
        <input type="text" name="name" value="<?php echo htmlentities($current_page["name"]); ?>" />
      </p>
      <p>Position:
        <select name="position">
        <?php
          $page_set = find_pages_for_subject($current_page["position"]);
          $page_count = mysqli_num_rows($page_set);
          for($count=1; $count <= $page_count; $count++) {
            echo "<option value=\"{$count}\"";
            if ($current_page["position"] == $count) {
              echo " selected";
            }
            echo ">{$count}</option>";
          }
        ?>
        </select>
      </p>
     
      <p>Content:<br />
          <textarea name="content" rows="10" cols="40"><?php echo htmlentities($current_page["content"]); ?></textarea>
      </p>
      <input class="btn btn-primary" type="submit" name="submit" value="Edit Page" />
    </form>
    <br />
    <a class="btn btn-danger" href="manage_content.php?page=<?php echo urlencode($current_page["id"]); ?>">Cancel</a>
    &nbsp;
    &nbsp;
    <a class="btn btn-danger" href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure?');">Delete page</a>
    
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
