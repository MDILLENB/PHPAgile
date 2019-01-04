$(document).ready(function(){  
      function autoSave()  
      {  
           
           var post_description = $('#description').val(); 
           var post_region = $('#region').val(); 
           var post_id = $('#id').val();
           var post_dividend = $('#dividend').val(); 
          
           if(post_description !== '' || post_dividend !== '')  
           {  
                $.ajax({  
                     url:"/portfolio/comment",  
                     method:"POST",  
                     data:{description:post_description,id:post_id,dividend:post_dividend,region:post_region},  
                     dataType:"text",  
                     success:function(data)  
                     {                            
                          $('#autoSave').text("Post saved");  
                           setInterval(function(){  
                               $('#autoSave').text('');  
                          }, 5000); 
                     }  
                });  
           }            
      }  
      setInterval(function(){   
           autoSave();   
           }, 10000);  
 });  