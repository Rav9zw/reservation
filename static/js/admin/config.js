$(function() {

working_hours();
  
  
//ajax //////////////////////////////////////////////////////////////////////


var client=1;
     


$(document).on("click", "td", function() {
	 



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



function update_hours(client,day,hour,value){
	
var icon=$('[data-day="'+day+'"][data-hour="'+hour+'"]').children('.fa_hours');
var sel=$('[data-day="'+day+'"][data-hour="'+hour+'"]').children('.select_fa_hours');
	
	$.ajax({
            url: "config/updateHours",
//          async: false,
            async: true,
            method: 'post',
            dataType: "json",
            data: {
			client:client,
			day:day,
			hour:hour,
			value:value
			
			},
            beforeSend: function() {
				
				
			sel.addClass('hidden temp');
			
			icon.removeClass('hidden fa-circle fa-adjust fa-times');	
			icon.addClass('fa-spin fa-spinner').css("display", "");	
			
			
	
			
            },

            success: function(dane) {
				
				
			sel.removeClass('temp');
			icon.removeClass('fa-spin fa-spinner').addClass(dane.icon).hide().fadeIn('slow');	
			
			
			//$('[data-day="'+day+'"][data-hour="'+hour+'"]').children('.fa_hours').removeClass('fa-spin fa-spinner').addClass(dane.icon);	
			
			//	var changed=$('[data-day="'+day+'"][data-hour="'+hour+'"]');
			
			//changed.removeClass('hidden').css("background-color", "#a5d6a7 ").hide().fadeIn('slow');
			/*
			setTimeout(function(){
			//changed.html(dane.icon).css("background-color", "white ");
			//changed.children('.fa_hours').hide().fadeIn('slow');
			
			}, 2000);
			*/
			  },
            
          
 
            });
	
	
	
}





















    });
	
	
