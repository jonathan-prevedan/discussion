<?php
session_start();
$connexion = mysqli_connect("localhost", "root", "", "discussion");


$login=$_SESSION['login'];

    
if(isset($_POST['button']))
{   
    if(isset($_POST['login']))
    {
        if($_POST['login'] != $_SESSION['login'])
        {
            $userconnect = $_SESSION['id'];
            $login = htmlspecialchars($_POST['login']);
            $query = "UPDATE utilisateurs SET login='$login' WHERE id='$userconnect'";
            $execquery = mysqli_query($connexion, $query);
            $_SESSION['login'] = $login;
        }

    }
        
            if(isset($_POST['password']))
            {   
                $password = htmlspecialchars($_POST["password"]);
                $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
                $userconnect = $_SESSION['id'];
                $query = "UPDATE utilisateurs SET password='".$password."' WHERE id='$userconnect'";
                $execquery = mysqli_query($connexion, $query);
                $_SESSION['password'] = $password;

            }

      
}
                    if(empty($_SESSION['login']))
                    {
                        header('Location: index.php');
                    }

                        if(isset($_POST['buttond']))
                        {
                            unset($_SESSION['id']);
                            unset($_SESSION['login']);
                            unset($_SESSION['password']);
                            header('Location: index.php');
                        }

                    $admin_query= ("SELECT * FROM utilisateurs WHERE login = '$login'");
                    $exec_admin_query=mysqli_query($connexion,$admin_query);
                    $row= mysqli_fetch_array($exec_admin_query);

?>

<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css">
    <title>Connexion</title>
</head>

<body id="main_register">
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

<form method="POST" action="" class="login-box">

<h1>Modifications Profil</h1>


        <input type="text" placeholder="Login" name="login" value="<?php echo $row['login']?>" required>
        
        <input type="password" placeholder="Mot de passe" name="password" value="" required>
       
        <input type="password" placeholder="Confirmation Mdp" name="cpassword" value="" required>

        <input id="bouton" type="submit" value="Appliquer" name="button">
        <input id="buttond" type="submit" value="Déconnecter" name="buttond">

<?php if(isset($erreur)) 
    {
        $erreur = 'Non non';
        echo $erreur;
    }
?>

</form>
</html>
</body>