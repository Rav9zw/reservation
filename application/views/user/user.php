<div class="modal fade" id="reservation_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
   


   <div class="modal-content main">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
       
	   
	    <div class="form-group">
		
	<h5 id="message" >W celu rezerwacji prosimy o wypełnienie formularza</h5>	
  <label for="phone_reserv">Telefon:</label>
  
  <input type="text" id="phone_reserv" class="form-control phone" >


		  <label for="court">Kort:</label>
		  <select class="form-control" id="court">
			
		  </select>
		</div>
	<div class="checkbox">
  <label><input id="regulamin" type="checkbox" value="">akceptuję regulamin klubu "nazwa klubu" </label>
</div>	

<div class="alert alert-success hidden" id="message_reservation">

</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default cancelation" data-dismiss="modal">Anuluj</button>
        <button type="button"  class="btn btn-success hidden confirmation" data-dismiss="modal">Ok <i class="fa fa-check" aria-hidden="true"></i></button>
        <button type="button" id="reservation_button" class="btn btn-primary save">Zarezerwuj</button>
      </div>
    </div><!-- /.modal-content -->
	
	
	<div class="modal-content user_add hidden">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nowy użytkownik</h4>
      </div>
      <div class="modal-body">
       
	   
	    <div class="form-group">
		
	<h5 id="messagephone" >Brak telefonu w bazie</h5>	
  <label for="name_new">Imie:</label>
  
  <input type="text" id="name_new" class="form-control " >
  
    <label for="surname_new">Nazwisko:</label>
  <input type="text" id="surname_new" class="form-control " >
  
   <label for="mail_new">Email:</label>
  <input type="text" id="mail_new" class="form-control " >
  
   <label for="code_new">Kod weryfikacyjny:</label>
  <input type="text" id="code_new" class="form-control " >


		</div>


<div class="alert alert-success hidden" id="message_newuser">

</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default cancelation" data-dismiss="modal">Anuluj</button>
        <button type="button"  class="btn btn-success hidden confirmation" data-dismiss="modal">Ok <i class="fa fa-check" aria-hidden="true"></i></button>
        <button type="button" id="reservation_button_newuser" class="btn btn-primary save">Zarezerwuj</button>
      </div>
    </div><!-- /.modal-content -->
	
	
	
	
	
	
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="queue_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Brak wolnych kortów</h4>
      </div>
      <div class="modal-body">
       
	   
	    <div class="form-group">
		<div class="alert alert-danger " id="message_occupied">
		<strong>Niestety na tą chwilę wszystkie korty są zajęte.</strong><br>Wypełnij formularz, <br> powiadomimy Cie SMS-em gdy ktoś odwoła rezerwacje.
		</div>
		  <label for="phone_queue">Telefon:</label>
		  
		  <input id="phone_queue" type="text" class="form-control phone" >


  
  
		</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
        <button type="button" class="btn btn-primary save">Zapisz</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container-fluid">
  <div class="panel panel-default panel_date">
		<div class="row">
		
		
	

    <div class="panel-body col-lg-8">



		
		
		
		
		
		
		
		<div class="col-lg-2">
		
		<button type="button" class="btn btn-default button_date minus" data-time='6'  aria-label="Left Align">
		 <span class="glyphicon  glyphicon-backward" aria-hidden="true"></span>
		</button>
	
		<button type="button" class="btn btn-default button_date minus" data-time='1' aria-label="Left Align">
		<span class="glyphicon  glyphicon-chevron-left" aria-hidden="true"></span>
		</button>
	
	</div>
			
			<div class="col-lg-6">
				
				<div class="input-group date " >
					<input type="text" id="start_date" class="form-control datepicker">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-calendar open-datepicker"></span>
					</div>
				</div>
			

	</div>

		
				<div class="col-lg-2">
		
				<button type="button" class="btn btn-default button_date plus" data-time='1' aria-label="Right Align">
				  <span class="glyphicon  glyphicon-chevron-right" aria-hidden="true"></span>
				</button>
					<button type="button" class="btn btn-default button_date plus" data-time='6' aria-label="Right Align">
				  <span class="glyphicon  glyphicon-forward" aria-hidden="true"></span>
				</button>
				
				</div>

</div>
		</div>
		   </div> 

 <div id="main_table" >          

  </div>
</div>



