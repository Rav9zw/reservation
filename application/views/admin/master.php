<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title>Admin panel</title>

	
	
  <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/admin/style.css?v=<?=time();?>">
  
   
  
	<!-- icons materialised --> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/plugins/jasny-bootstrap.min.css">
	
	<!-- Select2 Core CSS -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.css" >
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/animate.css">
	
	<link href="<?php echo base_url(); ?>static/css/font-awesome.css" rel="stylesheet">	
	
	<link href="<?php echo base_url(); ?>static/css/plugins/bootstrap-datepicker3.css" rel="stylesheet"> 
   
   <link href="<?php echo base_url(); ?>static/css/admin/pace.css" rel="stylesheet"> 
   
	<script   src="http://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
    
	<!-- Compiled and minified JavaScript -->

	<!-- Bootstrap Core JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
	
	<script src="<?php echo base_url(); ?>static/js/user/plugins/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>static/js/user/plugins/bootstrap-datepicker.pl.js" charset="UTF-8"></script>
	
	<script src="<?php echo base_url(); ?>static/js/admin/plugins/pace.min.js"></script>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/interact.js/1.2.6/interact.min.js"></script>
	 
</head>
<body>



<div class="sliding navmenu navmenu-default navmenu-fixed-left offcanvas-sm">
 
	
      <a class="navmenu-brand visible-md visible-lg" href="#"><?php echo $user; ?></a>
      <ul class="nav navmenu-nav">
        <li class="<?echo @$admin_active; ?>"><a href="<?php echo base_url(); ?>index.php/admin">Rezerwacje</a></li>
        <li class="<?echo @$usersadministration_active; ?>"><a href="<?php echo base_url(); ?>index.php/usersadministration">Użytkownicy</a></li>
        <li class="<?echo @$config_active; ?>"><a href="<?php echo base_url(); ?>index.php/config">Ustawienia</a></li>
        
      </ul>
     
	 
		<div class="row" >
	
				<div class="col-lg-1 col-md-1 col-sm-1"></div>
			<div class="col-lg-10 col-md-10 col-sm-10">
				
				
					<div id="start_date_picker" class="datepicker"></div>
				
				
			
			

			</div>
		<div class="col-lg-1 col-md-1 col-sm-1"></div>
		
			
		</div> 
	 
	 
	 
	 
	 
	 
	 
    </div>
 <button class="btn" id="show_hide_menu"><a  id="show_hide_menu_a" class="fa fa-2x fa-times"></a></button>
    <div class="sliding navbar navbar-default navbar-fixed-top hidden-md hidden-lg">
      <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".navmenu">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Admin panel</a>
	  
	  
	  
    </div>


    
	 <div id="main" class="container-fluid">
      <div class="page-header">
	 
 <?php


	$this->load->view("admin/$site");?>

	</div>
	</div><!-- /.container -->



   
    

</body>

<script src="<?php echo base_url(); ?>static/js/admin/<? echo $js.'.js?v='.time();?>"></script>  

   <script>

	
$(document).ready(function(){
	
$( ".select2" ).select2({
    theme: "bootstrap",
	placeholder: "Wybierz",
	allowClear: true
});
			
			
$('#show_hide_menu').click(function () {

$(".navbar").toggleClass('hidden_menu');
$(".navmenu").toggleClass('hidden_menu');
$("body").toggleClass('hidden_body');
$('#show_hide_menu_a').hide().fadeIn('slow').toggleClass("fa-times").toggleClass("fa-bars");			
					

	
   });
   
   
  $('[data-toggle="tooltip"]').tooltip();   


$('.config a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
  
});
	
    </script>
	  
	  
</html>