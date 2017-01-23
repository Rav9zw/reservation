$(function() {

// zmienne


//obsługa datepickera
var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());


//wywołanie modala do wprowadzania
 $("#admin_main_table").on("click", ".td_free", function() {
	 
	 day=$('#start_date').val();
	 court=$(this).data('court').substring(5);;
	 hour=$(this).data('hour');
	 
	 
	 
	if($(this).data('ishalf')=='undefined')
	$('.time_row').addClass('hidden');

	
	$('#save_admin_reservation').data('day',day);
	$('#save_admin_reservation').data('court',court);
	$('#save_admin_reservation').data('hour',hour); 
	 
	$('#admin_reservation').modal()	;

	
	
	
	
   });

   
   //wywołanie modala do edycji
 $("#admin_main_table").on("click", ".td_occupied", function() {
	 
	var id=$(this).data('id');
	 

	$('#confirm_realisation').data('id',id); 
	 	

	
	load_modal_details(id);
	
	
	
	
   });
   
    $("#admin_main_table").on("click", ".td_free", function() {
	 

	var hour=$(this).data('hour');
			
	var day=$('#start_date').val();
		
	get_price(client,day,hour);

	
   });
   
   $(".modal").on("click", "#confirm_realisation", function() {
	 
	var id=$(this).data('id'); 
	
	confirm_realisation(id);
	
   }); 
   
   

	
$('.datepicker').datepicker({
        
		format: 'yyyy-mm-dd',
	    calendarWeeks: true,
		todayHighlight: true,
        autoclose: true,
		weekStart:1,
		 language: 'pl'
		
});



$('.open-datepicker').click(function(event){
    event.preventDefault();
    $('#start_date').datepicker('show');
});

$('#start_date').datepicker('update', today);




//czyszczenie modala po zamknięciu
$('.modal').on('hidden.bs.modal', function () {


$('.admin_new_user').addClass('hidden');
$('#admin_reservation_content').removeClass('hidden');

$('#cancel_reservation').addClass('hidden');
$('#main_edit').removeClass('hidden');

$('.messages').addClass('hidden');
$('.confirm').addClass('hidden');
$('.basic').removeClass('hidden');

$('.time_row').removeClass('hidden');

$('#comment').val('');

$('#message_penalty').addClass('hidden');	
$('#confirm_ok').addClass('hidden');	
   
   
})







var client=1;
var date_start=$('#start_date').val();



admin_available_courts(client,date_start,sub='0',1);

setInterval(function(){ 
if($('#showdeleted').children('.fa').hasClass('fa-trash-o'))
admin_available_courts(client,date_start,sub='0',0);

 }, 15000);


      
$('.panel_date').on('change', '.datepicker', function() {

date_start=$('#start_date').val();

if($('#showdeleted').children('.fa').hasClass('fa-trash-o'))
admin_available_courts(client,date_start,sub='0',1,0);
else
admin_available_courts(client,date_start,sub='0',1,1);
  
});


$('.panel_date').on('click', '.button_date', function() {


date_start=$('#start_date').val();
var date = new Date(date_start);


if($(this).hasClass('plus'))
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate()+$(this).data('time'));
if($(this).hasClass('minus'))
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate()-$(this).data('time'));


$('#start_date').datepicker('update', today);


  
});





$("#admin_main_table").on("click", "#showdeleted", function(){

			var faobject=$('#showdeleted').children('.fa');
			
		
			var date_start=$('#start_date').val();
			if(faobject.hasClass('fa-trash-o')){
			admin_available_courts(client,date_start,sub='0',1,1);
			}else{
			admin_available_courts(client,date_start,sub='0',1,0);
				
				
				
			}
			
			});







//rysowania modala do rezerwacji
$("#main_table").on("click", ".td_click", function(){


			var hour=$(this).data('hour');
			
			var day=$(this).data('day');
				
				
				
			var availability=$(this).data('availability');

			
			
			$('.modal-title').html(day+' ,'+hour);
			
			$('.save').data('hour',hour);
			$('.save').data('day',day);
			
			if(availability=='free')
			fill_modal(client,day,hour);
			else
			$('#queue_modal').modal() 
		
			
			});

			
			
	$(".modal").on("click", "#save_admin_reservation", function(){


			
			
			var court=$(this).data('court');
			
			var player=$('#player').val();
			
			var reservation_length=$('#reservation_length').val(); 
			
			var comment=$('#comment').val();
			
			var day=$(this).data('day');
			
			var hour=$(this).data('hour');
			
			
			
			
			
			
			insert_reservation(client,court,player,reservation_length,comment,day,hour);
		
			
			});	


			
			$(".modal").on("click", "#admin_new_user_btn", function(){


			$('#admin_reservation_content').addClass('hidden');
			
			$('.admin_new_user').removeClass('hidden').hide().fadeIn('slow');;
			
			
		
			
			});	

			
			$(".modal").on("click", "#admin_back", function(){

			
			if($('#cancel_admin_new_user').hasClass('hidden'))
			{
			$('#cancel_admin_new_user').removeClass('hidden');
			$('#save_admin_new_user').removeClass('hidden');
			$('#ok_admin_new_user').addClass('hidden');
			$('#message_new_player').addClass('hidden');
			
			}
			
			$('.admin_new_user').addClass('hidden');
			
			$('#admin_reservation_content').removeClass('hidden').hide().fadeIn('slow');
			
			
		
			
			});		
			
			$(".modal").on("click", "#save_admin_new_user", function(){

			var phone=$('#admin_new_phone').val();
			var surname=$('#admin_new_surname').val();
			var name=$('#admin_new_name').val();
			var email=$('#admin_new_email').val();
			
			
			
			insert_new_player(phone,surname,name,email);
			
			
		
			
			});	
			
			$(".modal").on("click", "#delete_reserv", function(){
				
			var date_start=$('#start_date').val();	
			
			var hour=$(this).data('hour');;
			
			var now=new Date();	
			var reservtime=new Date(date_start+' '+hour);	
			
			
			//anulowanie ponizej 24h
			if((reservtime-now)<86400000)
			$('#message_penalty').removeClass('hidden');	
		
				
			var id=$(this).data('id');	
				
			$('#delete_reserv_confirm').data('id',id);	
			$('#main_edit').addClass('hidden')
			$('#cancel_reservation').removeClass('hidden').hide().fadeIn('slow');
			
			
			
		
			
			});	
			
			
			
			
			$(".modal").on("click", "#cancel_penalty", function(){
				
			$('#message_penalty').addClass('hidden');
			
		
			
			});	
			
			
			
			
			$(".modal").on("click", "#delete_reserv_confirm", function(){
				
				
			var id=$(this).data('id');	
			
			if($('#message_penalty').hasClass('hidden'))
			var penalty=0;
			else
			var penalty=1;
		
			var reason=$('#delete_reason').val();
			
			var reservation_comment=$('#delete_reason_comment').val();
			
			var reservation_user=$('#delete_reason_user').val();
		
		
			delete_reservation(id,penalty,reason,reservation_comment,reservation_user);
			
			
			
		
			
			});	
			
			
			$(".modal").on("click", "#admin_delete_back", function(){
				
				
			$('#cancel_reservation').addClass('hidden')
			$('#main_edit').removeClass('hidden').hide().fadeIn('slow');
			
			
			
			
		
			
			});	
			
			
			
			
//ajax //////////////////////////////////////////////////////////////////////
			
			

	
			
//pobieranie informacji o dostępności kortów klubu za dany okres czasowy
function admin_available_courts(client,date_start,sub,fade,deleted){

 if (typeof(fade)==='undefined') fade = null;
 if (typeof(deleted)==='undefined') deleted = null;


$.ajax({
            url: "admin/admin_available_courts",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
            client:client,
			date_start:date_start,
			sub:sub,
			deleted:deleted
			
			},
            beforeSend: function() {
				
			if(fade==1){
			$('#table_loader').removeClass('hidden').hide().fadeIn('slow');
			$('#admin_main_table').addClass('hidden');
			}

        
            },

            success: function(dane) {
			
				if(fade==1){
				$('#table_loader').addClass('hidden');
				$('#admin_main_table').removeClass('hidden');
				}
				
				
				var first_key=Object.keys(dane.table)[0];
				
				
				if(deleted==1)	{
				var deletedfa='fa-eye';							
				var deletedmess='aktywne';							
				}else{
				var deletedfa='fa-trash-o';	
				var deletedmess='usunięte';	
				}				
				
				var deletedbutton='<button id="showdeleted" style="background-color:#455a64" data-toggle="tooltip" title="Pokaż '+deletedmess+'" class="btn"><i class="fa fa-lg '+deletedfa+'" aria-hidden="true"></i></button>';	
				
				//rysowanie tablicy
				var tabela='<table class="table table-bordered ">';
					tabela+='<tr><th>'+deletedbutton+'</th>';
					
				//nagłówek (dni)
				$.each(dane.table[first_key],function(i){
						
					tabela+='<th>'+i+'</th>';

					
					});
					
					tabela+='</tr>';
					tabela+='<tbody>';
			
				//reszta tabeli
				$.each(dane.table,function(i){
						
						tabela+='<tr><td>'+i+'</td>';
							$.each(this,function(k){
						
					
						
					if (typeof dane.config.halfs != "undefined") {
						var godzina=Number(i.substring(0,2));
						var isHalf=dane.config.halfs[godzina];
					}
						
							if(this.lvl==9)
							{
									tabela+='<td  data-ishalf="'+isHalf+'" data-availability="free" data-hour="'+i+'" data-court="'+k+'" class="td_free td_click">'+this.text+'</td>';
							
							
							}else if(this.lvl==0 || this.lvl==1){
								
									tabela+='<td data-ishalf="'+isHalf+'" data-id="'+this.id+'" data-availability="occupied" data-hour="'+i+'" data-court="'+k+'" class="td_occupied td_click">'+this.text+'</td>';
								
							}else if(this.lvl==2 || this.lvl==3){
								
									tabela+='<td data-ishalf="'+isHalf+'" data-id="'+this.id+'" data-hour="'+i+'" data-court="'+k+'" class="td_deleted td_click">'+this.text+'</td>';
								
							}
									
									
					
							});
							tabela+='</tr>';
					
					});
			tabela+='</tbody></table>';
			
		
			if(fade==1){
			$('#admin_main_table').hide().fadeIn('slow').html(tabela);
			fill_players();
			}
			else
			$('#admin_main_table').html(tabela);
			
			$('#showdeleted').tooltip();   				
			
			
			
			
			  },
            
          
 
            });


			



}




function 	insert_reservation(client,court,player,reservation_length,comment,day,hour){



$.ajax({
            url: "admin/insert_reservation",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
            client:client,
            court:court,
            player:player,
			reservation_length:reservation_length,
            comment:comment,
			day:day,
			hour:hour
			},
            beforeSend: function(xhr, opts) {
				
				
				
			
					
				

				

        
            },

            success: function(dane) {
			
			
			
				
				if(dane.result.status=='success'){
				$('#reservation_button').addClass('hidden').hide().fadeIn('slow');
				$('.cancelation').addClass('hidden').hide().fadeIn('slow');
				$('.confirmation').removeClass('hidden').hide().fadeIn('slow');
				
				var date_start=$('#start_date').val();
				
				$('#admin_reservation').modal('hide');
				admin_available_courts(client,date_start,sub='0',0);
				

				}else{
					
				$('#message_reservation').removeClass('alert-danger');
			
				$('#message_reservation').removeClass('hidden').hide().fadeIn('slow').html(dane.result.message);
				
				$('#message_reservation').addClass('alert-'+dane.result.status);	
					
					
				}


			
		
			  },
            
          
 
            });


			



}





function 	insert_new_player(phone,surname,name,email){



$.ajax({
            url: "admin/insertNewPlayer",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
				
            phone:phone,
            surname:surname,
            name:name,
			email:email
			
			
			},
            beforeSend: function() {
				

            },

            success: function(dane) {
			
			
			
			
				$('#message_new_player').removeClass('alert-danger');
			
				$('#message_new_player').removeClass('hidden').hide().fadeIn('slow').html(dane.result.message);
				
				$('#message_new_player').addClass('alert-'+dane.result.status);
				
				if(dane.result.status=='success'){
					
				$('#save_admin_new_user').addClass('hidden').hide().fadeIn('slow');
				$('#cancel_admin_new_user').addClass('hidden').hide().fadeIn('slow');
				$('#ok_admin_new_user').removeClass('hidden').hide().fadeIn('slow');
				fill_players();
				}
		
		
			  },
            
          
 
            });


			



}








function 	load_modal_details(id){



$.ajax({
            url: "admin/loadModalDetails",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
            id:id
			},
            beforeSend: function() {
				
				
			
        
            },

            success: function(dane) {
			

			
			$('#player_edit').val(dane.dane.player).trigger("change");;
			
			
			$('#comment_edit').val(dane.dane.note);
			
			
			$('#delete_reserv').data('id',id);
			$('#delete_reserv').data('hour',dane.dane.hour);
			$('#price_confirm').html(dane.dane.price);
			
			
			
			$('#admin_edit_reservation').modal();

			if(dane.dane.confirmed=='1'){
				
			$('#confirm_realisation').addClass('hidden').hide().fadeIn('slow');	
			$('#confirm_ok').removeClass('hidden').hide().fadeIn('slow');	
				
				
			}else{
			$('#confirm_realisation').removeClass('hidden').hide().fadeIn('slow');	
			$('#confirm_ok').addClass('hidden').hide().fadeIn('slow');		
				
			}
			
		
			  },
            
          
 
            });


			



}


function 	get_price(client,day,hour){



$.ajax({
            url: "admin/Price",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
            client:client,
            day:day,
            hour:hour
			},
            beforeSend: function() {
				
				
			
        
            },

            success: function(dane) {
				
				
				$('#price').html(dane.price);
			

			  },
            
          
 
            });


			



}


function confirm_realisation(id){



$.ajax({
            url: "admin/confirmRealisation",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
            id:id
			},
            beforeSend: function() {
				
				
			
        
            },

            success: function(dane) {
				
			$('#confirm_realisation').addClass('hidden').hide().fadeIn('slow');	
			$('#confirm_ok').removeClass('hidden').hide().fadeIn('slow');	
			
			admin_available_courts(client,date_start,sub='0',0);
			

			  },
            
          
 
            });


			



}

function 	fill_players(){



$.ajax({
            url: "admin/getPlayers",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
          
			},
            beforeSend: function() {
				
				
			
        
            },

            success: function(dane) {

			var players='<option></option>';
			
			
			$.each(dane.players,function(i){
			
			players+='<option value="'+this.id+'">'+this.player+'</option>';
			
				
			});
			
			
				
			$('#player').html(players);
			$('#player_edit').html(players);

		

			  },
            
          
 
            });


			



}


function 	delete_reservation(id,penalty,reason,reservation_comment,reservation_user){



$.ajax({
            url: "admin/deleteReservation",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
			id:id,
			penalty:penalty,
			reason:reason,
			reservation_comment:reservation_comment,
			reservation_user:reservation_user
			},
            beforeSend: function() {
				
				
			
        
            },

            success: function(dane) {

	
				$('#message_delete_reservation').removeClass('alert-danger');
			
				$('#message_delete_reservation').removeClass('hidden').hide().fadeIn('slow').html(dane.result.message);
				
				$('#message_delete_reservation').addClass('alert-'+dane.result.status);
				
				if(dane.result.status=='success'){
					
				$('#admin_delete_cancel').addClass('hidden').hide().fadeIn('slow');
				$('#delete_reserv_confirm').addClass('hidden').hide().fadeIn('slow');
				$('#delete_reserv_ok').removeClass('hidden').hide().fadeIn('slow');
		
		
				var date_start=$('#start_date').val();
				
				
				admin_available_courts(client,date_start,sub='0',0);
		
				}
	
	
			},
            
          
		  
		  
 
            });


			



}







    });
	
	
