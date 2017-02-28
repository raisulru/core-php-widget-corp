<?php
	function redirect_to($new_location){
		header("Location: " . $new_location);
		exit;
	}
	function mysql_prep($string) {
		global $connection;

		$escaped = mysqli_real_escape_string($connection, $string);
		return $escaped;
	}
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}
	
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"alert alert-warning\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
		    $output .= htmlentities($error);
		    $output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	function find_all_from_result(){
		global $connection;
		$table  = "SELECT * ";
		$table .= "FROM result";
		$table .= " ORDER BY id ASC";
		$subject_set = mysqli_query($connection, $table);
		confirm_query($subject_set);
		return $subject_set;
	}
	function find_pages_for_subject($result_id){
		global $connection;
		
		$table  = "SELECT * ";
		$table .= "FROM pages ";
		$table .= "WHERE result_id = {$result_id} ";
		$table .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $table);
		confirm_query($page_set);
		return $page_set;
	}
	function find_all_admins() {
	    global $connection;
	    
	    $query  = "SELECT * ";
	    $query .= "FROM admins ";
	    $query .= "ORDER BY username ASC";
	    $admin_set = mysqli_query($connection, $query);
	    confirm_query($admin_set);
	    return $admin_set;
  }
	function find_subject_by_id($subject_id){
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		$table  = "SELECT * ";
		$table .= "FROM result ";
		$table .= "WHERE id = {$safe_subject_id} ";
		$table .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $table);
		confirm_query($subject_set);
		if($subject = mysqli_fetch_assoc($subject_set)){
			return $subject;
		}else{
			return null;
		}

		
	}

	function find_page_by_id($page_id){
		global $connection;
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		$table  = "SELECT * ";
		$table .= "FROM pages ";
		$table .= "WHERE id = {$safe_page_id} ";
		$table .= "LIMIT 1";
		$page_set = mysqli_query($connection, $table);
		confirm_query($page_set);
		if($page = mysqli_fetch_assoc($page_set)){
			return $page;
		}else{
			return null;
		}

		
	}
	function find_admin_by_id($admin_id) {
	    global $connection;
	    
	    $safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
	    
	    $query  = "SELECT * ";
	    $query .= "FROM admins ";
	    $query .= "WHERE id = {$safe_admin_id} ";
	    $query .= "LIMIT 1";
	    $admin_set = mysqli_query($connection, $query);
	    confirm_query($admin_set);
	    if($admin = mysqli_fetch_assoc($admin_set)) {
	      return $admin;
	    } else {
	      return null;
	    }
  }
  function find_admin_by_username($username) {
		global $connection;
		
		$safe_username = mysqli_real_escape_string($connection, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function find_default_page_for_subject($subject_id) {
		$page_set = find_pages_for_subject($subject_id);
		if($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		} else {
			return null;
		}
	} 

	function find_selected_page($public=false){
		global $current_subject;
		global $current_page;

		if (isset($_GET["subject"])) {
			$current_subject = find_subject_by_id($_GET["subject"]);
			if ($public) {
				$current_page = find_default_page_for_subject($current_subject["id"]);
			} else {
				$current_page = null;
			}
		} elseif (isset($_GET["page"])) {
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"]);
		} else {
			$current_subject = null;
			$current_page = null;
		}
	}


	function navigation($subject_array, $page_array){
		$output = "<ul class=\"subjects\">" ;
		$subject_set = find_all_from_result();
		// 3. Use returned data (if any)
		while($subject = mysqli_fetch_assoc($subject_set)) {
			// output data from each row
		
				$output .= "<li";
				if ($subject_array && $subject["id"] == $subject_array["id"]) {
					# code...
					$output .= " class=\"selected\"";
				}
					
				$output .= ">"; 
				
			    $output .= "<a href=\"manage_content.php?subject=";
			    $output .= urlencode($subject["id"]);
			    $output .= "\">";
			    $output .= htmlentities($subject["name"]);
			    $output .= "</a>";
				$page_set = find_pages_for_subject($subject["id"]);
				$output .= "<ul class=\"pages\">";
						
				while($page = mysqli_fetch_assoc($page_set)) {
			
					$output .= "<li";
					if ($page_array && $page["id"] == $page_array["id"]) {
						# code...
						$output .= " class=\"selected\"";
					}
						
					$output .= ">";
					$output .= "<a href=\"manage_content.php?page=";
					$output .= urlencode($page["id"]);
					$output .= "\">";
					$output .= htmlentities($page["name"]);
					$output .= "</a></li>";
				}
					mysqli_free_result($page_set);
					$output .= "</ul></li>";
	  
		}
		// 4. Release returned data
			mysqli_free_result($subject_set);
		
		$output .= "</ul>";
		return $output;
	}
	function public_navigation($subject_array, $page_array){
		$output = "<ul class=\"subjects\">" ;
		$subject_set = find_all_from_result();
		// 3. Use returned data (if any)
		while($subject = mysqli_fetch_assoc($subject_set)) {
			// output data from each row
		
				$output .= "<li";
				if ($subject_array && $subject["id"] == $subject_array["id"]) {
					# code...
					$output .= " class=\"selected\"";
				}
					
				$output .= ">"; 
				
			    $output .= "<a href=\"index.php?subject=";
			    $output .= urlencode($subject["id"]);
			    $output .= "\">";
			    $output .= htmlentities($subject["name"]);
			    $output .= "</a>";

			if($subject_array["id"] == $subject["id"] || $page_array["result_id"] == $subject["id"]){
				$page_set = find_pages_for_subject($subject["id"]);
				$output .= "<ul class=\"pages\">";
						
				while($page = mysqli_fetch_assoc($page_set)) {
			
					$output .= "<li";
					if ($page_array && $page["id"] == $page_array["id"]) {
						# code...
						$output .= " class=\"selected\"";
					}
						
					$output .= ">";
					$output .= "<a href=\"index.php?page=";
					$output .= urlencode($page["id"]);
					$output .= "\">";
					$output .= htmlentities($page["name"]);
					$output .= "</a></li>";
				}
					$output .= "</ul>";
					mysqli_free_result($page_set);
			}
					$output .= "</li>";
	  
		}
		// 4. Release returned data
			mysqli_free_result($subject_set);
		
		$output .= "</ul>";
		return $output;
	}
	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}
	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["hashed_password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}
	function logged_in() {
		return isset($_SESSION['admin_id']);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}
?>