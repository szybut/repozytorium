<?php
// Start the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
//require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
<head>
  <link href="C:/Users/SB/lightbox2-master(1)/lightbox2-master/dist/css/lightbox.css" rel="stylesheet">
  <title>Wielcy polacy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  body {
      position: relative; 
  }
  .affix {
      top:0;
      width: 100%;
      z-index: 9999 !important;
  }
  .navbar {
      margin-bottom: 0px;
  }

  .affix ~ .container-fluid {
     position: relative;
     top: 50px;
  }
  #section1 {padding-top:50px;height:500px;color: #fff; background-color: #1E88E5;}
  #section2 {padding-top:50px;height:800px;color: #fff; background-color: #673ab7;}
  #section3 {padding-top:50px;height:500px;color: #fff; background-color: #ff9800;}
  #section41 {padding-top:50px;height:500px;color: #fff; background-color: #00bcd4;}
  #section42 {padding-top:50px;height:500px;color: #fff; background-color: #009688;}
  </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">

<div class="container-fluid" style="background-color:#F44336;color:#fff;height:400px;">
  <h1>KATALOG WIELKICH POLAKOW</h1>
</div>

<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="400">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="#section1">KATEGORIA 1</a></li>
          <li><a href="#section2">KATEGORIA 2</a></li>
          <li><a href="#section3">KATEGORIA 3</a></li>
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">KONTAKT<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#section41">TELEFON</a></li>
              <li><a href="#section42">EMAIL</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>    

<div id="section1" class="container-fluid">
  <h1>KATEGORIA 1</h1>
     <div class="col-md-4">
      <div class="thumbnail">
        <a href="gortat.jpg" target="_blank">
          <img src="gortat.jpg" alt="Lights" style="width:100%">
          <div class="caption">
          </div>
        </a>
      </div>
    </div> 
  

  <p>Marcin Gortat</p>   
  </div>
  
  <div id="section2" class="container-fluid">
  <h1>KATEGORIA 2</h1>
     <div class="col-md-4">
      <div class="thumbnail">
        <a href="kubica.jpg" target="_blank">
          <img src="kubica.jpg" alt="Lights" style="width:100%">
          <div class="caption">
          </div>
        </a>
      </div>
    </div> 
<p>Robert Kubica</p>   
  </div>
  
  
<div id="section3" class="container-fluid">
  <h1>KATEGORIA 3</h1>

<!--
//Dynamiczne menu (dane z bazy)
  $polaczenie = @mysqli_connect('localhost', 'root', '', 'pai_butnicki');
  if (!$polaczenie) {
    die('Wystąpił błąd połączenia: ' . mysqli_connect_errno());
  }
  @mysqli_query($polaczenie, 'SET NAMES utf8');

  $sql = 'SELECT `id`, `nazwa`
               FROM `kategorie`
               ORDER BY `nazwa`';
  $wynik = mysqli_query($polaczenie, $sql);
  /*if (mysqli_num_rows($wynik) > 0) {
  	echo "<ul>" . PHP_EOL;
    while (($kategoria = @mysqli_fetch_array($wynik))) {
      echo '<li><a href="' . $_SERVER["PHP_SELF"] . '?kat_id=' . $kategoria['id'] . '">' . $kategoria['nazwa'] . '</a></li>' . PHP_EOL;
    }
    echo "</ul>" . PHP_EOL;
  } else {
    echo 'wyników 0';
  }*/

  //Pobieramy dane produktów z bazy dla wybranej (metodą GET) kategorii
  $id = isset($_GET['1']) ? (int)$_GET['1'] : 1;
  $sql = 'SELECT `nazwa`, `opis`
               FROM `produkty`
               WHERE `id` = ' . $id .
               ' ORDER BY `nazwa`';
  $wynik = mysqli_query($polaczenie, $sql);
  if (mysqli_num_rows($wynik) > 0) {
    while (($produkt = @mysqli_fetch_array($wynik))) {
        echo '<p><b>' . $produkt['nazwa'] . '</b>: ' . $produkt['opis'] . '</p>' . PHP_EOL;
    }
  } else {
    echo 'wyników 0';
  }
mysqli_close($polaczenie);  

  
  
  <form method="POST" action="rejestracja.php">
<b>Login:</b> <input type="text" name="login"><br><br>
<b>Hasło:</b> <input type="password" name="haslo1"><br>
<b>Powtórz hasło:</b> <input type="password" name="haslo2"><br><br>
<b>Email:</b> <input type="text" name="email"><br>
<input type="submit" value="Utwórz konto" name="rejestruj">
</form>

 

 mysql_connect("localhost","admin","haslo");
mysql_select_db("baza");
 
function filtruj($zmienna)
{
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe
 
   // usuwamy spacje, tagi html oraz niebezpieczne znaki
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}
 
/if (isset($_POST['rejestruj']))
{
   $login = filtruj($_POST['login']);
   $haslo1 = filtruj($_POST['haslo1']);
   $haslo2 = filtruj($_POST['haslo2']);
   $email = filtruj($_POST['email']);
   $ip = filtruj($_SERVER['REMOTE_ADDR']);
 
   // sprawdzamy czy login nie jest już w bazie
   if (mysql_num_rows(mysql_query("SELECT login FROM uzytkownicy WHERE login = '".$login."';")) == 0)
   {
      if ($haslo1 == $haslo2) // sprawdzamy czy hasła takie same
      {
         mysql_query("INSERT INTO `uzytkownicy` (`login`, `haslo`, `email`, `rejestracja`, `logowanie`, `ip`)
            VALUES ('".$login."', '".md5($haslo1)."', '".$email."', '".time()."', '".time()."', '".$ip."');");
 
         echo "Konto zostało utworzone!";
      }
      else echo "Hasła nie są takie same";
   }
   else echo "Podany login jest już zajęty.";
} 
 -->
  
</div>

<div id="section41" class="container-fluid">
  <h1>TELEFON</h1>
  <p>997, TEN NUMER TO KŁOPOTY</p>

</div>

<div id="section42" class="container-fluid">
  <h1>EMAIL</h1>
  <p>NIE PODAM, BO SIĘ WSTYDZĘ</p>

</div>


<script src="C:/Users/SB/lightbox2-master(1)/lightbox2-master/dist/js/lightbox.js"></script>
</body>
</html>
