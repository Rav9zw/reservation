$(function() {

working_hours();
price_list();

  
//ajax //////////////////////////////////////////////////////////////////////


var client=1;
     


	 
$(document).on('click', function(e) {
  if($(e.target).closest('td').length === 0) {
		$('.fa_hours').removeClass('hidden');
		$('.select_fa_hours').addClass('hidden');
		$('.price').removeClass('hidden');
		$('.input_price').addClass('hidden');
  }
});

		
	  


	 
	 
$(document).on("click", "#table_working_hours td", function() {
	 



	$(this).children('.select_fa_hours').val($(this).children('.fa_hours').data('value'));
	 
	 
	 if($(this).children('.select_fa_hours').hasClass('hidden') && !$(this).children('.select_fa_hours').hasClass('temp')){
		$('.select_fa_hours').addClass('hidden');
		$(this).children('.select_fa_hours').removeClass('hidden').hide().fadeIn();
		
		$('.fa_hours').removeClass('hidden');
		$(this).children('.fa_hours').addClass('hidden').hide().fadeIn();
	 }

	 
	
	 
	 
	 
	
   });	
   
	

$(document).on('change', 'select', function() {
	
var value=$(this).val();	

var hour=$(this).parent('td').data('hour');	

var day=$(this).parent('td').data('day');	



update_hours(client,day,hour,value);



});

$(document).on('change', '.input_price', function() {
	
var value=$(this).children('input').val();	

var hour=$(this).parent('td').data('hour');	

var day=$(this).parent('td').data('day');	



update_price(client,day,hour,value);



});	

	
$(document).on("click", "#table_price_list td", function() {
	 


	
	
	 
	 if($(this).children('.input_price').hasClass('hidden') && !$(this).children('.input_price').hasClass('temp') ){
		 
		 $(this).children('.input_price').children('input').val($(this).children('.price').html());
	
		$('.price').removeClass('hidden');
		$('.input_price').addClass('hidden');
		
		
		$(this).children('.input_price').removeClass('hidden').hide().fadeIn();
		$(this).children('.price').addClass('hidden').hide().fadeIn();
	 }
	 

	
   });		
	

			
function working_hours(client,day,hour,value){

 

$.ajax({
            url: "config/workingHours",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
      
			
			},
            beforeSend: function() {
			
        
            },

            success: function(dane) {
				
				
				
			var table='';	
			var sel='<select class="hidden form-control select_fa_hours"><option value=2>&#xf111;</option><option value=1>&#xf042;</option><option value=0>&#xf00d;</option></select>';
			
			
				
			$.each(dane.table,function(i){

			
			
			
			table+='<tr>';		
			table+='<td>'+i+'</td>';	

			
			$.each(this,function(j){
				
			table+='<td data-hour="'+i+'" data-day="'+j+'">'+this+sel+'</td>';	
	
			
			});
			
			table+='</tr>';	
				
			});
			
			$('#table_working_hours>tbody').html(table);
			
			
			  },
            
          
 
            });


			



}





function price_list(client,day,hour,value){

 

$.ajax({
            url: "config/priceList",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
      
			
			},
            beforeSend: function() {
			
        
            },

            success: function(dane) {
				
		
  


				
			var table='';	
			var input='<div class="input_price hidden"><input type="text" class="form-control"></div>';
			
			
				
			$.each(dane.table,function(i){

			
			
			
			table+='<tr>';		
			table+='<td>'+i+'</td>';	

			
			$.each(this,function(j){
				
			table+='<td data-hour="'+i+'" data-day="'+j+'">'+this+input+'</td>';	
	
			
			});
			
			table+='</tr>';	
				
			});
			
			$('#table_price_list>tbody').html(table);
			
			
			  },
            
          
 
            });


			



}





function update_hours(client,day,hour,value){
	
var icon=$('[data-day="'+day+'"][data-hour="'+hour+'"]').children('.fa_hours');
var sel=$('[data-day="'+day+'"][data-hour="'+hour+'"]').children('.select_fa_hours');
	
	$.ajax({
            url: "config/updateConfig",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
			client:client,
			day:day,
			hour:hour,
			value:value,
			base:'a_config_hour'
			
			},
            beforeSend: function() {
				
				
			sel.addClass('hidden temp');
			
			icon.removeClass('hidden fa-circle fa-adjust fa-times');	
			icon.addClass('fa-spin fa-spinner').css("display", "");	
			
			
			
			
            },

            success: function(dane) {
				
				
			sel.removeClass('temp');
			icon.removeClass('fa-spin fa-spinner').addClass(dane.icons).hide().fadeIn('slow');	
			icon.data('value',dane.value);
			  },
            
          
 
            });
	
	
	
}





function update_price(client,day,hour,value){
	
	

	
var newValue=$('[data-day="'+day+'"][data-hour="'+hour+'"]').children('.price');
var input=$('[data-day="'+day+'"][data-hour="'+hour+'"]').children('.input_price');
	
	$.ajax({
            url: "config/updateConfig",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
			client:client,
			day:day,
			hour:hour,
			value:value,
			base:'a_config_price'
			
			},
            beforeSend: function() {
				
				
			input.addClass('hidden temp');
			
			newValue.html('');
			newValue.removeClass('hidden');	
			newValue.addClass('fa fa-spin fa-spinner').css("display", "");	
			
			
	
			
            },

            success: function(dane) {
				
			input.removeClass('temp');
	
			newValue.removeClass('fa fa-spin fa-spinner').html(dane.value).hide().fadeIn('slow');	

			  },
            
          
 
            });
	
	
	
}




















    });
	
	
