<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bonjour</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css%22%3E">
    <link rel="stylesheet" href="page_accueil_dev_web.css">

</head>
<body>
    <ul class="navbar">
      <li><a class="active" href="#home">Accueil</a></li>
      <li><a href="#club">Mes Clubs</a></li>
      <li><a href="#param">Paramètres</a></li>
      <li><a href="#contact">Contact</a></li>
      <li id="recherche">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div id="bar">
  <input type="search" name="query" maxlenght="80" size="80" id="query" /><br/>

<div class="dialog">
  </div>

  </div>



<div id="rechercher">
     <input type="submit"  value="Rechercher" >
</div> </form></li>

    </ul>

<div id="home">
<div class="page-header">
        <h1>   <b>Bonjour, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>   </b>   </h1>
    </div>
<div id="centre">
  <h2>Club du moment</h2>
  <div id="para">
  <p>Foot</p>
  <p>Basket</p>
  </div>
</div>

</div>
<div id="club">
<div id="centre">
  <h2>Vous faites actuellement parti des clubs suivants :</h2>
  <br>
  <p>Football</p>
</div>
</div>
<div id="param">
<div id="centre">
<h2>Paramètres de compte</h2>
<br>
<p style="display:inline-block;">
        <a href="reset-password.php" class="btn btn-warning" style="display:inline-block; padding-right: 10px;">Réinitialiser votre mot de passe</a>
        <p style="display:inline-block;">|</p>
        <a href="logout.php" class="btn btn-danger" style="display:inline-block; padding-left: 10px;">Déconnexion</a>
    </p>
</div>
</div>
<div id="contact">
<div id="centre">
  <h2>Clubs EPSI</h2> 
</div>
</div>
<div id="result">
</div>
</body>
</html>

<?php

//Initialisation de la variable contenant les résultats
$result = "Aucun Club";
$res = "";
$resultats = "test";
$nbreParametres = 2; // nombre de paramètres à renseigner



// Traitement de la requête

if(isset($_POST['query']) &&!empty($_POST['query'])){
  //Si ll'utilisateur a entré quelque chose, on traite sa requête

// on rend clean la requête de l'utilisateur
  $query = preg_replace("#[^a-zA-Z ?0-9]#i", "", $_POST['query']);


      $nbreParametres = 4;
       $sql = "(SELECT id, blog_title AS title FROM blog WHERE blog_title LIKE ?)";


// Connexion à la bdd

include("includes/connect_db.php");

$req = $db->prepare($sql);
if($nbreParametres == 2){

$req->execute(array('%'.$query.'%', '%'.$query.'%'));
} else {
  $req->execute(array('%'.$query.'%', '%'.$query.'%'));
}


$count = $req->rowCount();

if($count >= 1){
  $result = "<p id=\"top\">$count résultat(s) trouvé(s) pour <strong>$query</strong><hr/></p>";
  while($data = $req ->fetch(PDO::FETCH_OBJ)){
    echo '#'.$data->id.' - Titre: '.$data->title.'<br/>';
  }

} else{
  echo "<p id=\"top\">0 résultat trouvé pour <strong>$query</strong><hr/></p>";
}


  }

 ?>
