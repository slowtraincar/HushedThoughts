    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      
    <script type="text/javascript">
        $(".toggleForms").click(function(){
            
            $("#signUpForm").toggle();
            $("#logInForm").toggle();
            
        
  });
        
        
        $('#diary').bind('input propertychange', function() {

            $.ajax({
                method: "POST",
                url:"updateDatabase.php",
                data: { content: $('#diary').val() }
            })
                //.done(function(msg){
                  //  alert("Data Saved: " + msg);
                    
            });
       

     
      
      
    </script>
      
  </body>
</html>
