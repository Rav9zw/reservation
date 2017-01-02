<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Reservation booking squash">
        <meta name="author" content="Rafał Schneider">
	<title>Rezerwacje</title>
	<!-- fonts -->
	
	<link href="https://fonts.googleapis.com/css?family=Dosis%7CTrirong" rel="stylesheet">
   <!-- css -->

    <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/style.css">
	
	<link href="<?php echo base_url(); ?>static/css/animate.css" rel="stylesheet">
	
    <link href="<?php echo base_url(); ?>static/css/font-awesome.css" rel="stylesheet">
	

	 
  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link href="<?php echo base_url(); ?>static/css/plugins/bootstrap-datepicker3.css" rel="stylesheet"> 
	

	<!-- javascripts -->
	<script   src="http://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
	 
	  
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script src="<?php echo base_url(); ?>static/js/user/plugins/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>static/js/user/plugins/bootstrap-datepicker.pl.js" charset="UTF-8"></script>


	 
</head>
<body>

	<?php

	$this->load->view("user/user");
	
	?>
	
<script src="<?php echo base_url(); ?>static/js/user/user.js"></script>  
  
</body>



	 

	  
	  
</html>