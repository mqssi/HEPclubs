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
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css%22%3E">
    <link rel="stylesheet" href="page_accueil_dev_web.css">

</head>
<body>
    <div class="page-header">
        <h1>   <b><?php echo htmlspecialchars($_SESSION["username"]); ?>   </b>   </h1>
    </div>


    <ul class="navbar">
      <li><a class="active" href="#home">Accueil</a></li>
      <li><a href="#news">Mes Clubs</a></li>
      <li><a href="#contact">Paramètres</a></li>
      <li><a href="#about">Contact</a></li>
      <li id="recherche">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div id="bar">
  <input type="search" name="query" maxlenght="80" size="80" id="query"/><br/>

<div class="dialog">
  </div>

  </div>



<div id="rechercher">
     <input type="submit"  value="Rechercher" >
</div> </form></li>

    </ul>


<div id="centre">
  <h2>Club du moment</h2>
  <div id="para">
  <p>Foot</p>
  <p>Basket</p>
  </div>
</div>








    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>

<?php

//Initialisation de la variable contenant les résultats

$resultats = "";
$nbreParametres = 2; // nombre de paramètres à renseigner



// Traitement de la requête

if(isset($_POST['query']) &&!empty($_POST['query'])){
  //Si ll'utilisateur a entré quelque chose, on traite sa requête

// on rend clean la requête de l'utilisateur
  $query = preg_replace("#[^a-zA-Z ?0-9]#i", "", $_POST['query']);


      $nbreParametres = 4;
       $sql = "(SELECT id, blog_title AS title FROM blog WHERE blog_title LIKE ? OR blog_content LIKE ?)";


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
  echo "$count résultat(s) trouvé(s) pour <strong>$query</strong><hr/>";
  while($data = $req ->fetch(PDO::FETCH_OBJ)){
    echo '#'.$data->id.' - Titre: '.$data->title.'<br/>';
  }

} else{
  echo "0 résultat trouvé pour <strong>$query</strong><hr/>";
}


  }

 ?>
<?php echo $resultats; ?>
