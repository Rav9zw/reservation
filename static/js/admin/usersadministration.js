$(function() {

load_users();

function 	load_users(client,court,player,comment,day,hour){



$.ajax({
            url: "usersadministration/loadUsers",
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
			
			
			$.each(dane,function(){
			
			table+='<tr>';
			
			table+='<td>'+this.user+'</td><td>'+this.phone+'</td><td>'+this.email+'</td><td>'+this.registered+'</td>';

			table+='</tr>';	
					
			
				
			});
			
			
			$('#table_users>tbody').hide().fadeIn('slow').html(table);
			
			
		
			  },
            
          
 
            });


			



}




    });
	
	
