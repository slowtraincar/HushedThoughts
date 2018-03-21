<?php 
//save user info w/cookie
    session_start();
    
     $error="";

//log user out with cookie unset
    if(array_key_exists("logout", $_GET)){
        unset($_SESSION);
        setcookie("id","", time() - 60*60);
        $_COOKIE["id"]= "";
        
        session_destroy();
        
        
//if signed in user attempts to get to sign up page, redirect to logged in page 
/* Also verifies logout sticks to make user log in again if they log out and then attempt to go to logged in page*/        
    }else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: loggedinpage.php");
    }

//check to make sure php is connecting to html input on site
    if (array_key_exists("submit", $_POST)){

//connect to mySQL database on server       
        include("connection.php");
            
        
//check that form is filled out completely        
       
//no email        
        if (!$_POST['email']){
            
            $error .= "An email address is required<br>";
        }
//no password        
        if (!$_POST['password']){
            
            $error .= "A password is required<br>";
        }
//heading to explain what is missing in form        
        if ($error != ""){
            
            $error = "<p> There were error(s) in your form:</p>".$error;
//form filled out, check that email is not already in mySQL database            
        } else {
            
            if ($_POST['signUp'] == '1'){
            
            
            
//            check from database sect. listed        stop bad script    use link connect    
            $query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
// check for email in linked database            
            $result = mysqli_query($link, $query);
            
            if (mysqli_num_rows($result) > 0){
// if email is already stored                
                $error = "That email address is taken.";
                
            } else {
// email not already stored. set up account with email and password submited                
                $query = "INSERT INTO users (email, password) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."',
                '".mysqli_real_escape_string($link, $_POST['password'])."')";
// if unable to add user                
                    if (!mysqli_query($link, $query)) {
                        
                        $error = "<p>Could not sign you up - please try again later.</p>";
                    
                    } else {

//encrypt new user's password                        
                        $query = "UPDATE users SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1"; 
                        
                        $id= mysqli_insert_id($link);
                        
                        mysqli_query($link, $query);

//set session                        
                        $_SESSION['id'] = $id; 

//set cookie timeframe if user checks stay logged in                         
                        if ($_POST['stayLoggedIn'] == '1'){
                            
                            setcookie("id",$id, time() + 60*60*24*365);
                            
                        }
// confirmation of account creation sends user to logged in page                        
                        header("Location:loggedinpage.php");
                        
                    } 
            } 
            
          } else {
 //log into account validation               
                $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                $result = mysqli_query($link, $query);
                
                $row = mysqli_fetch_array($result);
                
                if (isset($row)){
                    
                    $hashedPassword = md5(md5($row['id']).$_POST['password']);
                    
                    if($hashedPassword == $row['password']){
                        
                        $_SESSION['id'] = $row['id'];
                        
                        if (isset($_POST['stayLoggedIn'])AND $_POST['stayLoggedIn'] == '1'){
                            
                            setcookie("id", $row['id'], time() + 60*60*24*365);
                        }
//confirmed credentials, logged in page redirect                       
                        header("Location:loggedinpage.php");
                    } else {
//wrong email/password error                       
                        $error = "That email/password combination could not be found.";
                        
                    }
                } else {
//wrong email/password error
                    $error = "That email/password combination could not be found.";
                    
                }
            } 
        }
    }







?>

<?php include("header.php");?>
  <body>
      
      
      
      <h1 class="whiteText" id= "title">Hushed Thoughts</h1>
      <p class="whiteText" id="titleTwo">Store your thoughts permanently and securely</p> 
      <div class="container" id="homePageContainer">
          
          <div class="whiteText" id="error"><?php if ($error!=""){
  echo '<div class="alert alert-dark" role="alert">'.$error.'</div>';  
    
} ?></div>

            <form method="post" id="signUpForm">
                <h2 class="whiteText" id="titleThree">Want to give it a try? Sign up below</h2>
                <div class="form-group">
                    <input type="email" name="email" class="form-control bg-light" placeholder=" Your Email">
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control bg-light" name="password" placeholder="Password">
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1"><label class="form-check-label whiteText">Stay logged in</label>
                </div>      
                
                <input type="hidden" name="signUp" value=1>
                <br>
                <input type="submit" class="btn btn-secondary" name="submit" value="Sign Up!">
                
                <p><a class= "toggleForms">Log in</a></p>
             </form>
          
            
          
            <form method="post" id="logInForm">
                <h2 class="whiteText" id="titleThree">Ready to get writing? Log in below!</h2>
                <div class="form-group">
                    <input type="email" class="form-control bg-light" name="email" placeholder=" Your Email">
                </div>
                    
                <div class="form-group">    
                    <input type="password" class="form-control bg-light" name="password" placeholder="Password">
                </div>    
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1"><label class="form-check-label whiteText">Stay logged in</label>
                </div>    
                    
                <input type="hidden" name="signUp" value=0> 
                <br>
                <input type="submit" class="btn btn-secondary" name="submit" value="Log In">
                
                <p><a class= "toggleForms whiteText">Sign Up</a></p>
            </form>
           
      </div>
          
<?php include("footer.php")?>
