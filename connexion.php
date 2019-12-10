<?php 
$connexion = mysqli_connect("localhost", "root", "", "discussion");

session_start();
if(isset($_POST["buttonc"]))
{       
        $login = htmlspecialchars($_POST["login"]);
        $mdp = htmlspecialchars($_POST['password']);

        if(!empty($login) && !empty($mdp))
        {       
                $query = "SELECT login FROM utilisateurs WHERE login='$login'";
                $execquery = mysqli_query($connexion, $query);
                $rows = mysqli_num_rows($execquery);


                if($rows==0)
                {       $erreur = "Login ou mot de passe incorrect.";
                        echo $erreur;
                        
                }
                        else
                    {
                        $checkpass = "SELECT password FROM utilisateurs WHERE login = '$login'";
                        $checkpassquery = mysqli_query($connexion,$checkpass);
                        $cryptedpass = mysqli_fetch_all($checkpassquery);
                        $cryptedpass = $cryptedpass[0][0];
                        $passencrypt = password_verify($mdp, $cryptedpass);
                        
                            if($passencrypt == true)
                            {
                                $userinfo = mysqli_fetch_all($execquery);
                                $infos = "SELECT id,login FROM utilisateurs WHERE login ='$login'";
                                $query = mysqli_query($connexion, $infos);
                                $result = mysqli_fetch_all($query);
                                $_SESSION['id'] = $result[0][0];
                                $_SESSION['login'] = $_POST['login'];
                                $_SESSION['password'] = $_POST['password'];
                                header('Location: index.php');
                            }
                            
                            else
                            {
                                
                                $erreur = "Login ou mot de passe incorrect.";
                                echo $erreur;
                            }
                       
                }
                
       
        }

else
{
        $erreur = "Tous les champs doivent être complétés.";
        echo $erreur;
}


}

if(isset($_SESSION['login']))
{
    header('Location: index.php');
}
?>

<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css">
    <title>Connexion</title>
</head>
<body id="connexion">

<nav id="index">
        <?php 
            if(!isset($_SESSION['login']))
            {
        ?>
                <li><a href="inscription.php">Inscription</li></a>
                <li><a href="connexion.php">Se connecter</li></a>
        <?php 
            }
        ?>
        <li><a href="discussion.php">Discussion</a></li>
        <li><a href="index.php">Accueil</a></li>
                <?php 
                    if(isset($_SESSION['login']))
                    {
                ?>
                <li><a href="profil.php">Modifications profil</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>
                <?php 
                    }
                ?>
</nav>
    
<form method="POST" action="connexion.php" class="box">
    <h3>Connexion :</h3>
    <input type="text" name="login" placeholder="Login ?" class="input">
    <input type="password" name="password" placeholder="Mot de passe ?" class="input">
    <input type="submit" name="buttonc" value="Connexion !">
</form>
</body>
</html>

