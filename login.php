<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Merci d'entrer votre nom d'utilisateur.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Merci d'entrer votre mot de passe.";
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
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Le mot de passe est invalide.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Acun compte avec ce nom d'utilisateur n'a été créé.";
                }
            } else{
                echo "Quelque chose s'est mal passé :(";
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
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title> HEP CLUBS </title>
  <link href="acceuil.css" type="text/css" rel="stylesheet" media="all" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
        body{ font: 14px sans-serif; text-align:center;}
        .wrapper{ width: 250px; position:fixed; text-align:center; margin-top:30vh; margin-left: -125px; left:50%;}
    </style>
</head>

<body>
  <div id="gauche">
    <img id="photo" src="HEPCLUBS.jpg" alt="test" />
    <ul id="ul-gauche">
      <li> Partage tes passions ! </li>
      <br>
      <li> Rejoins ou crée ton activité ! </li>
      <br>
      <li>Fais de nouvelles rencontres ! </li>
    </ul>
  </div>

  <div id="droite">
    <div id="champ">
        <h2>Connexion</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Nom d'utilisateur" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Mot de passe" type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Connexion">
            </div>
            <p>Pas encore de compte? <a id="inscrire" href="register.php">Inscrivez-vous</a>.</p>
        </form>
    </div>
  </div>



</body>

</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align:center;}
        .wrapper{ width: 250px; position:fixed; text-align:center; margin-top:30vh; margin-left: -125px; left:50%;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Connexion</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Nom d'utilisateur" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Mot de passe" type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Connexion">
            </div>
            <p>Pas encore de compte? <a href="register.php">Inscrivez-vous</a>.</p>
        </form>
    </div>
</body>
</html>
 -->
