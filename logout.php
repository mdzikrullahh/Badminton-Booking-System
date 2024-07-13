<?php	
	session_start();
	if(isset($_SESSION['customer_id']))
	{
		unset($_SESSION['customer_id']);
		// unset($_SESSION['customer_name']);
		// unset($_SESSION['customer_email']);

	}
	else if(isset($_SESSION['user_id']))
	{
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);
		unset($_SESSION['user_role']);

	}

	header( "Refresh:1; url=login.php", true, 303);
	session_destroy(); 
?>
