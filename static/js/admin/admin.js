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
	 
	$('#save_admin_reservation').data('day',day);
	$('#save_admin_reservation').data('court',court);
	$('#save_admin_reservation').data('hour',hour); 
	 
	$('#admin_reservation').modal()	;

	
	
	
	
   });

   
   //wywołanie modala do edycji
 $("#admin_main_table").on("click", ".td_occupied", function() {
	 
	var id=$(this).data('id');
		
	load_modal_details(id);
	
	
	
	
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

$('#message_reservation').removeClass('alert-succes alert-danger');
$('.confirmation').addClass('hidden');
$('#message_reservation').addClass('hidden');
$('.phone').val('');
$('#reservation_button').removeClass('hidden');
$('.cancelation').removeClass('hidden');
$('.confirmation').addClass('hidden');
$('#regulamin').prop('checked', false); // Unchecks it
   
   
})







var client=1;
var date_start=$('#start_date').val();



admin_available_courts(client,date_start,sub='0',1);


      
$('.panel_date').on('change', '.datepicker', function() {

date_start=$('#start_date').val();


admin_available_courts(client,date_start,sub='0',1);
  
  
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
			
			var day=$(this).data('day');
			
			var hour=$(this).data('hour');
			
			
			
			
			
			
			insert_reservation(client,court,player,day,hour);
		
			
			});		
			
//ajax //////////////////////////////////////////////////////////////////////
			
			
			
			
function fill_players(id_modal,dane_players){
	
	var players='';
			
			$.each(dane_players,function(i){
			
			players+='<option value="'+this.id+'">'+this.player+'</option>';
			
				
			});
				
			$('#'+id_modal).html(players);
}	


	
			
//pobieranie informacji o dostępności kortów klubu za dany okres czasowy
function admin_available_courts(client,date_start,sub,fade=null){



$.ajax({
            url: "admin/admin_available_courts",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
            client:client,
			date_start:date_start,
			sub:sub
			
			},
            beforeSend: function() {
				
				

				

        
            },

            success: function(dane) {
				
				var first_key=Object.keys(dane.table)[0];
				
				
				//rysowanie tablicy
				var tabela='<table class="table table-bordered ">';
					tabela+='<tr><th></th>';
					
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
						
						
						
							if(this.lvl==9)
							{
									tabela+='<td  data-availability="free" data-hour="'+i+'" data-court="'+k+'" class="td_free td_click">'+this.text+'</td>';
							
							
							}else{
								
									tabela+='<td data-id="'+this.id+'" data-availability="occupied" data-hour="'+i+'" data-court="'+k+'" class="td_occupied td_click">'+this.text+'</td>';
								
							}
									
									
					
							});
							tabela+='</tr>';
					
					});
			tabela+='</tbody></table>';
			
		
			if(fade==1)
			$('#admin_main_table').hide().fadeIn('slow').html(tabela);
			else
			$('#admin_main_table').html(tabela);

			//uzupełniam graczy w modalu
			
			var id_modal='player';
			
			fill_players(id_modal,dane.players);
			
			

			
			
			
			
			
			
			  },
            
          
 
            });


			



}




function 	insert_reservation(client,court,player,day,hour){



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
			day:day,
			hour:hour
			},
            beforeSend: function(xhr, opts) {
				
				
				
			
					
				

				

        
            },

            success: function(dane) {
			
			
				$('#message_reservation').removeClass('alert-danger');
			
				$('#message_reservation').removeClass('hidden').hide().fadeIn('slow').html(dane.result.message);
				
				$('#message_reservation').addClass('alert-'+dane.result.status);
				
				if(dane.result.status=='success'){
				$('#reservation_button').addClass('hidden').hide().fadeIn('slow');
				$('.cancelation').addClass('hidden').hide().fadeIn('slow');
				$('.confirmation').removeClass('hidden').hide().fadeIn('slow');
				
				var date_start=$('#start_date').val();
				
				$('#admin_reservation').modal('hide');
				admin_available_courts(client,date_start,sub='0');
				

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
			
			
			
			
			var id_modal='player_edit';
			
			fill_players(id_modal,dane.players);
			
			
			
			$('#player_edit').val(dane.dane.player).trigger("change");
			$('#comment_edit').val(dane.dane.note);
			
			
			$('#admin_edit_reservation').modal();


			
		
			  },
            
          
 
            });


			



}



    });
	
	
