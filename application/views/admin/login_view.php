 <!DOCTYPE html>
<html lang="pl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <!-- CORE CSS-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
	


<style type="text/css">
html,
body {
    height: 100%;
}
html {
    display: table;
    margin: auto;
}
body {
    display: table-cell;
    vertical-align: middle;
}
.margin {
  margin: 0 !important;
}
#logo{
	height:221;
	width:308;
	
}

</style>
  
</head>

<body class="grey lighten-2">

			

  <div id="login-page" class="row ">
    <div class="col s12 z-depth-6 card-panel ">
	
			
	

        <div class="row ">
          <div class="input-field col s12 center">
            <img src="<?php echo base_url(); ?>static/image/logo2.jpg" id="logo" alt="" class="responsive-img valign profile-image-login">
            <p class="center login-form-text"> </p>
          </div>
        </div>
		<?php echo validation_errors(); ?>
			<?php echo form_open('verifylogin'); ?>
		      <form class="login-form" >
        <div class="row margin">
          <div class="input-field col s12">
            <i class="material-icons prefix">perm_identity</i>
	 
            <label for="username">Użytkownik:</label>
     <input type="text" size="20" id="username" name="username"/>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="material-icons prefix"><i class="material-icons">lock_outline</i></i>
          <label for="password">Hasło:</label>
		<input type="password" size="20" id="password" name="password" autocomplete="new-password" />
          </div>
        </div>
    
        <div class="row">
          <div class="input-field col s12">
		  <button class="btn waves-effect waves-light col s12" type="submit" >Login</button>
        
          </div>
        </div>
		
		
		 <div class="row">
          <div class="col s12">
        
          </div>
        </div>
       

      </form>
    </div>
  </div>






  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
<script   src="http://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
       
  <!--materialize js-->
 	 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>

	 
	 
	 
	<script src="<?php echo base_url(); ?>static/js/scripts/login.js"></script>


</body>

</html>