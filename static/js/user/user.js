$(function() {

// zmienne


//obsługa datepickera
var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

	
$('.datepicker').datepicker({
        
		format: 'yyyy-mm-dd',
        startDate: '0d',
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
$('.main').removeClass('hidden');
$('.confirmation').addClass('hidden');
$('.user_new_user').addClass('hidden');
$('#regulamin').prop('checked', false); // Unchecks it
$('#save_user_new_user').removeClass('hidden').hide().fadeIn('slow');
$('#back_user_new_user').addClass('hidden').hide().fadeIn('slow');
   
   
})







var client=1;
var date_start=$('#start_date').val();



available_courts(client,date_start,sub='0');











      
$('.panel_date').on('change', '.datepicker', function() {

date_start=$('#start_date').val();


available_courts(client,date_start,sub='0');
  
  
});


$('.panel_date').on('click', '.button_date', function() {


date_start=$('#start_date').val();
var date = new Date(date_start);
var min_date = new Date();

if($(this).hasClass('plus'))
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate()+$(this).data('time'));
if($(this).hasClass('minus'))
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate()-$(this).data('time'));


if(today<min_date)
$('#start_date').datepicker('update', min_date);
else
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

			
			
	$(".modal").on("click", "#reservation_button", function(){


			
			
			var court=$('#court :selected').val();
			
			var phone=$('#phone_reserv').val();
			
			
			var day=$(this).data('day');
			
			var hour=$(this).data('hour');
			
			var regulamin=$('#regulamin').is(":checked");
			
			
			
			
			check_phone(phone,court,day,hour,regulamin);
		
			
			});		
			
	$(".modal").on("click", "#save_user_new_user", function(){


				var phone=$('#user_new_phone').val();
				var surname=$('#user_new_surname').val();
				var name=$('#user_new_name').val();
				var email=$('#user_new_email').val();
				
				
				
				insert_new_player(phone,surname,name,email);
			
				
				});				
			
	$(".modal").on("click", "#back_user_new_user", function(){


				$('.user_new_user').addClass('hidden').hide().fadeIn('slow');
				$('.main').removeClass('hidden').hide().fadeIn('slow');;	
			
				
				});				
			
			
		
			
//ajax //////////////////////////////////////////////////////////////////////
			
			
			
			
			
			
//pobieranie informacji o dostępności kortów klubu za dany okres czasowy
function available_courts(client,date_start,sub){



$.ajax({
            url: "index.php/user/available_courts",
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
				
				var first_key=Object.keys(dane)[0];
				
				
				//rysowanie tablicy
				var tabela='<table class="table table-bordered"">';
					tabela+='<tr><td></td>';
					
				//nagłówek (dni)
				$.each(dane[first_key],function(i){
						
					tabela+='<td>'+i+'</td>';

					
					});
					
					tabela+='</tr>';
					tabela+='<tbody>';
			
			
				$.each(dane,function(i){
						
						tabela+='<tr><td>'+i+'</td>';
							$.each(this,function(k){
						
							if(this.lvl==9)
							{
									tabela+='<td data-availability="free" data-hour="'+i+'" data-day="'+k+'" class="td_free td_click">'+this.text+'</td>';
							}else if(this.lvl==2){
								
									tabela+='<td  data-availability="closed" data-hour="'+i+'" data-day="'+k+'" class="td_closed">'+this.text+'</td>';
								
							}else if(this.lvl==1){
							
							
							
							tabela+='<td data-availability="free" data-hour="'+i+'" data-day="'+k+'" class="td_lastfree td_click">'+this.text+'</td>';
								
							
							
							}else{
								
									tabela+='<td data-availability="occupied" data-hour="'+i+'" data-day="'+k+'" class="td_occupied td_click">'+this.text+'</td>';
								
							}
									
									
					
							});
							tabela+='</tr>';
					
					});
			tabela+='</tbody></table>';
			
			//console.log(tabela);
			
$('#main_table').hide().fadeIn('slow').html(tabela);

			
			
			
			
			
			
		
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			  },
            
          
 
            });


			



}



//wypełnianie modala za dany dzień
function 	fill_modal(client,day,hour){



$.ajax({
            url: "index.php/user/fill_modal",
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
				
			$('#reservation_modal').modal() 
			
			var options='';
			$.each(dane,function(){
			
			options+='<option value="'+this+'">Kort '+this+'</option>';
			
			
			});
			
			$('#court').html(options);
		
		
		
		
		
			  },
            
          
 
            });


			



}

//koniec ajaxa do wypełniania modala



//wypełnianie modala za dany dzień
function 	insert_reservation(client,court,player,regulamin,day,hour){



$.ajax({
            url: "index.php/user/insert_reservation",
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
				
				
				
				
				if(regulamin==false){
			
				$('#message_reservation').removeClass('hidden').hide().fadeIn('slow').html('<strong>Regulamin </strong> W celu rezerwacji należy zaakceptować regulamin');
				$('#message_reservation').addClass('alert-danger');
					
				xhr.abort();
				}
					
				

				

        
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
				available_courts(client,date_start,sub='0');
				

			}


			
		
			  },
            
          
 
            });


			



}

//koniec ajaxa do wypełniania modala

//sprawdzamy czy użytkownik jest juz w bazie
function 	check_phone(phone,court,day,hour,regulamin){



$.ajax({
            url: "index.php/user/checkPhone",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
          
            phone:phone
			
			},
            beforeSend: function() {

        
            },

            success: function(dane) {
			
			if(dane=='brak'){
				$('.user_new_user').removeClass('hidden').hide().fadeIn('slow');
				$('.main').addClass('hidden').hide().fadeIn('slow');
				$('#user_new_phone').val($('#phone_reserv').val());
				
			}
			else{
				insert_reservation(client,court,dane[0],regulamin,day,hour);
			}
			
		
			  },
            
          
 
            });


			



}





function 	insert_new_player(phone,surname,name,email){



$.ajax({
            url: "index.php/user/insertNewPlayer",
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
			
			
				$('#message_user_new_user').removeClass('alert-danger');
			
				//console.log(dane.result.message);
			
				$('#message_user_new_user').removeClass('hidden').hide().fadeIn('slow').html(dane.result.message);
				
				$('#message_user_new_user').addClass('alert-'+dane.result.status);
		
				if(dane.result.status=='success'){
					
				$('#save_user_new_user').addClass('hidden').hide().fadeIn('slow');
				$('#back_user_new_user').removeClass('hidden').hide().fadeIn('slow');
			
				
				
				

			}
		
		
		
		
		
		
			  },
            
          
 
            });


			



}




















    });
	
	
