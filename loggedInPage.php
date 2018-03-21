<?php

    session_start();
    $diaryContent= "";

    if(array_key_exists('id', $_COOKIE)){
        
        $_SESSION['id'] = $_COOKIE['id'];
    }
    
    if (array_key_exists('id', $_SESSION) && $_SESSION['id']){
        
        include("connection.php");
        
        $query = "SELECT diary FROM users WHERE id= ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
        
          $row = mysqli_fetch_array(mysqli_query($link, $query));
        
          $diaryContent = $row['diary'];  
          
    } else {
        
        header("Location: index.php");
    }

    include("header.php");
?>
    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><h1 style="
            font-family: 'Lovers Quarrel', cursive" >Hushed Thoughts</h1></a>
    <a href='index.php?logout=1'><button class="btn btn-secondary my-2 my-sm-0" type="submit">Logout</button></a>
</nav>
<br>

    <div class="container-fluid" id="containerLoggedIn">
        
        <textarea class= form-control id="diary"><?php echo $diaryContent;?></textarea>
           
    </div>
              
<?php
         
    include("footer.php");

?>
