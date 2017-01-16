  <div id="admin_reservation" class="modal fade"  role="dialog">
  <div class="modal-dialog" role="document">
    <div id="admin_reservation_content"   class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rezerwacja kortu</h4>
      </div>
      <div class="modal-body">
	  
	  
	  
	  
      <label for="player">Gracz</label>
	  
	  <div class="row">
	  <div class="col-lg-10">
	   <select id="player" class="select2 js-example-basic-single">
		
		</select>
		</div>
		<div class="col-lg-2">
		<button id="admin_new_user_btn" data-toggle="tooltip" title="Nowy użytkownik" class="btn btn-success"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
		</div>
		</div>
		
		
		<label class="time_row" for="reservation_length">Czas</label>
	  
	  <div  class="row time_row">
	  <div class="col-lg-12">
	   <select id="reservation_length" class="select2 js-example-basic-single">
		<option value="30">30min</option>
		<option value="60">1h</option>
		</select>
		</div>
		
		</div>
		
	  <div class="form-group">
	  <label for="comment">Komentarz:</label>
	  <textarea class="form-control" rows="3" id="comment"></textarea>
	  </div>
	  <div class="alert alert-success hidden messages" id="message_reservation">

</div>
	  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
        <button type="button" id="save_admin_reservation" class="btn btn-primary">Zapisz</button>
      </div>
    </div><!-- /.modal-content -->
	
	
 <div  class="admin_new_user modal-content hidden">
    
	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nowy użytkownik</h4>
      </div>
      <div class="modal-body">
     
	 
	 
	 <form class="form-horizontal">
  <div class="form-group">
    <label for="admin_new_phone"  class="col-sm-2 control-label">Telefon</label>
    <div class="col-sm-10">
      <input class="form-control" id="admin_new_phone" type="text" value="">
    </div>
  </div>
 
   <div class="form-group">
    <label for="admin_new_surname"  class="col-sm-2 control-label">Nazwisko</label>
    <div class="col-sm-10">
      <input class="form-control" id="admin_new_surname" type="text" value="">
    </div>
  </div>
  
    <div class="form-group">
    <label for="admin_new_name"  class="col-sm-2 control-label">Imię</label>
    <div class="col-sm-10">
      <input class="form-control" id="admin_new_name" type="text" value="">
    </div>
  </div>
  
  
    <div class="form-group">
    <label for="admin_new_email"  class="col-sm-2 control-label">E-mail</label>
    <div class="col-sm-10">
      <input class="form-control" id="admin_new_email" type="text" value="">
    </div>
  </div>
 
	</form>
	 
<div class="alert alert-success hidden messages" id="message_new_player">

</div>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancel_admin_new_user" class="btn btn-default basic" data-dismiss="modal">Anuluj</button>
        <button type="button" id="admin_back" class="btn btn-warning basic">Cofnij</button>
        <button type="button" id="save_admin_new_user" class="btn btn-primary basic">Dodaj</button>
        <button type="button" id="ok_admin_new_user" class="btn btn-success hidden confirm" data-dismiss="modal">Ok</button>
      </div>
	  
	  
    </div><!-- /.modal-content -->
	
	
	
	
	
	
	
	
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




  <div id="admin_edit_reservation" class="modal fade"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="main_edit">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rezerwacja kortu</h4>
      </div>
      <div class="modal-body">
      <label for="player_edit">Gracz</label>
	   <select id="player_edit" class="select2 js-example-basic-single" disabled>
		
		</select>
	  <div class="form-group">
	  <label for="comment">Komentarz:</label>
	  <textarea disabled class="form-control" rows="3" id="comment_edit"></textarea>
	  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default basic" data-dismiss="modal">Anuluj</button>
		
        <button type="button" id="delete_reserv" class="btn btn-danger">Usuń <i class="fa fa-trash" aria-hidden="true"></i></button>
		
        <!-- <button type="button"  class="btn btn-primary">Zapisz <i class="fa fa-floppy-o" aria-hidden="true"></i></button> -->
      </div>
    </div><!-- /.modal-content -->
	
	
	    <div class="modal-content hidden" id="cancel_reservation">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Anulowanie rezerwacji</h4>
		  </div>
		  <div class="modal-body">
		
		<div class="alert alert-danger hidden" id="message_penalty">
		
		<strong>Uwaga! </strong>
		
		Zbyt późno anulowana rezerwacja, zostanie naliczona opłata karna. <button data-toggle="tooltip" title="Anuluj kare"  class="btn btn-warning"><i style="color:white;" class="fa fa-times" aria-hidden="true"></i></button>

		</div>
			
			
	
		
		  <label for="player_edit">Powód anulowania rezerwacji</label>
		   <select id="delete_reason" class="form-control">
			<option>Rezygnacja klienta</option>
			<option>Błąd</option>
			</select>
	
		
		
		
		
	
		 <div class="form-group row_user_comment">
		  <label for="delete_reason_user">Komentarz do użytkownika:</label>
		  <textarea class="form-control" rows="3" id="delete_reason_user"></textarea>
		  </div>
		
		 
		  <div class="form-group">
		  <label for="delete_reason_comment">Komentarz do anulowanej rezerwacji:</label>
		  <textarea class="form-control" rows="3" id="delete_reason_comment"></textarea>
		  </div>
		  
		  <div class="alert alert-success hidden messages" id="message_delete_reservation">

			</div>
		  
		  </div>
      <div class="modal-footer">
        <button type="button" id="admin_delete_cancel" class="btn btn-default basic" data-dismiss="modal">Anuluj</button>
		<button type="button" id="admin_delete_back" class="btn btn-warning">Cofnij</button>
        <button type="button" id="delete_reserv_confirm" class="btn btn-danger basic">Usuń <i class="fa fa-trash" aria-hidden="true"></i></button>
         <button type="button" id="delete_reserv_ok" class="btn btn-success hidden confirm" data-dismiss="modal">Ok</button>
      </div>
    </div><!-- /.modal-content -->
	
	
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



  
  <!-- Page Content -->
    
            <div class="container-fluid" id="admin_main_reservation">
               
 <div id="panel_reservation_admin" class="panel panel-default panel_date">
		<div class="row">
		
		
	

    <div class="panel-body col-lg-5">



		
		
		
		
		
		
		<div class="row" >
		<div class="col-lg-2 col-sm-2 col-md-2">
		
		
	
		<button type="button" class="btn btn-default button_date minus" data-time='1' aria-label="Left Align">
		<span class="glyphicon  glyphicon-chevron-left" aria-hidden="true"></span>
		</button>
	
	</div>
			
			<div class="col-lg-6 col-md-6 col-sm-6">
				
				<div class="input-group date " >
					<input type="text" id="start_date" class="form-control datepicker">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-calendar open-datepicker"></span>
					</div>
				</div>
			

	</div>

		
				<div class="col-lg-2 col-sm-2 col-md-2">
		
				<button type="button" class="btn btn-default button_date plus" data-time='1' aria-label="Right Align">
				  <span class="glyphicon  glyphicon-chevron-right" aria-hidden="true"></span>
				</button>
				
				
				</div>
			</div>

</div>


<div id="legend" class="col-lg-7">

		
			   <span class="label label-success" >Rezerwacja klubowa</span>
			   <span class="label label-info ">Rezerwacja online</span>
			   <span class="label label-danger ">Rezerwacja anulowana za późno</span>
			   <span class="label label-warning ">Rezerwacja anulowana</span>
			    <span class="label label-default">Godziny niedostępne</span>
		   
		   
		  


		</div>
		   </div> 
		   
		   
		
		
		
		<div id="admin_main_table" class="hidden" >          

			</div>
		<div id="table_loader" class="hidden" ><img src="http://swiatrakei.cluster005.ovh.net/reserv/static/image/loader.svg"></div>


           







		   </div>
        </div>
