  <div id="admin_reservation" class="modal fade"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rezerwacja kortu</h4>
      </div>
      <div class="modal-body">
      <label for="player">Gracz</label>
	   <select id="player" class="select2 js-example-basic-single">
		
		</select>
	  <div class="form-group">
	  <label for="comment">Komentarz:</label>
	  <textarea class="form-control" rows="3" id="comment"></textarea>
	  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
        <button type="button" id="save_admin_reservation" class="btn btn-primary">Zapisz</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




  <div id="admin_edit_reservation" class="modal fade"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rezerwacja kortu</h4>
      </div>
      <div class="modal-body">
      <label for="player_edit">Gracz</label>
	   <select id="player_edit" class="select2 js-example-basic-single">
		
		</select>
	  <div class="form-group">
	  <label for="comment">Komentarz:</label>
	  <textarea class="form-control" rows="3" id="comment_edit"></textarea>
	  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



  
  <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
               
 <div id="panel_reservation_admin" class="panel panel-default panel_date">
		<div class="row">
		
		
	

    <div class="panel-body col-lg-5">



		
		
		
		
		
		
		
		<div class="col-lg-2">
		
		
	
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
		   
		   
		
		
		
		<div id="admin_main_table"  >          

			</div>



           







		   </div>
        </div>
