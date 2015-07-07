<?php
$name = "";
$pass = "";
$error = "";

if(isset($_POST['pass'])) { 
    $pass = $_POST['pass'];
}
if(isset($_POST['name'])) { 
    $name = $_POST['name'];
}

if (isset($_POST['name']) || isset($_POST['pass'])) {
    if (empty($name)) {
        $error = "Please enter username!";
    }
    if (empty($pass)) {
        $error = "Please enter password!";
    }
    
    if($error == ""){
        session_start();
        if ($name == "admin" && $pass == "g1g2g3") {
            // Authentication successful - Set session
            $_SESSION['auth'] = 1;
            setcookie("username", $_POST['name'], time() + (84600 * 30));
            header('Location: ../index.php');
            exit;
        } else {
            $error = "Incorrect username or password!";
        }
    }
}
?>
    <!DOCTYPE HTML>
    <html>
    <head>
    <title>League | Login</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/structure.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/ie-emulation-modes-warning.js"></script>
    </head>

    <body>
    <form class="box login" method="post" action="<?php
        echo $_SERVER['PHP_SELF']; ?>">
        <fieldset class="boxBody">
          <label>Username</label>
          <input type="text" tabindex="1" value="admin" required name="name">
          <input type="password" tabindex="2" required name="pass">
        </fieldset>
        <footer>
            <input type="submit" class="btnLogin" value="Login" tabindex="4">
            <hr>
            <?php if($error != ""){?>
            <div class="alert alert-danger" role="alert">
              <span class="sr-only">Error:</span>
              <?php echo "$error"; ?>
            </div>
            <?php } ?>
        </footer>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/changeLeague.js"></script>
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    </body>
    </html>