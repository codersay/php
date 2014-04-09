<?php
	// The Demos don't save files

	if (isset($_FILES["resume_file"]) && is_uploaded_file($_FILES["resume_file"]["tmp_name"]) && $_FILES["resume_file"]["error"] == 0) {
		//echo rand(1000000, 9999999);	// Create a pretend file id, this might have come from a database.
		echo $_FILES['resume_file']['tmp_name'];
		// move_uploaded_file($_FILES['resume_file']['tmp_name'], "E:\\".$_FILES['resume_file']['tmp_name']);
		 //print_r($_FILES['resume_file']);
	}
	
	exit(0);	// If there was an error we don't return anything and the webpage will have to deal with it.
?>