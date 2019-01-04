$(document).ready(function(){  
      function autoSave()  
      {  
           
           var post_description = $('#post_description').val(); 
           var post_ticker = $('#ticker').val();
           var post_rating = $('#post_rating').val(); 
          
           if(post_description !== '' || post_rating !== '')  
           {  
                $.ajax({  
                     url:"/stock/comment",  
                     method:"POST",  
                     data:{postDescription:post_description,ticker:post_ticker,postExtRating:post_rating},  
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
  $(document).ready(function(){
        $("input:checkbox").change(function() { 
            var isChecked = $("input:checkbox").is(":checked") ? 1:0; 
            var post_ticker = $('#ticker').val();
            $.ajax({
                url: '/stock/filter',
                type: 'POST',
                data: {postState:isChecked,ticker:post_ticker }
            });        
        });        
    });