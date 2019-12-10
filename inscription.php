<?php 
session_start();
$connexion = mysqli_connect('Localhost','root','','discussion');

if(isset($_POST['buttonc']))
{
    $login = htmlspecialchars($_POST['login']);
    $psd = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $cpsd = password_hash($_POST['cpassword'], PASSWORD_BCRYPT);

        if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['cpassword']))
        {
           $query = "SELECT login FROM utilisateurs WHERE login ='$login'";
           $execquery_exist = mysqli_query($connexion, $query);
           $result_exist = mysqli_num_rows($execquery_exist); 


                    if(mysqli_num_rows($execquery_exist) == 0)
                    {
                            if($_POST['password'] == $_POST['cpassword'])
                            {
                                    $insertmbr ="INSERT INTO utilisateurs(login,password) VALUES ('$login','$psd')";
                                    $query= mysqli_query($connexion, $insertmbr);
                                    $eror = "Votre compte à bien été crée ! ";
                                    header('Location: index.php');
                            }

                                else
                                {
                                    $eror = "Vos mots de passes ne correspondent pas !";
                                }
                    }
                                    else
                                    {
                                        $erreur = "Ce login n'est pas disponnible";
                                        echo "<b>".$erreur."</b>";
                                    }

        }

        else
        {
            $eror = "Tous les champs doivent être complétés.";
        }
}

        if(isset($eror))
        {
            echo $eror;
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
            <title>Inscription</title>
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
        <form method="POST" action="inscription.php" class="box">
            <h3>Inscription :</h3>
            <input type="text" name="login" placeholder="Votre login" required>

            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="cpassword" placeholder="Confirmer" required>
            <input type="submit" name="buttonc" value="S'inscrire">
            <?php 
                    if(isset($eror))
                        {
                            echo $eror;
                        } 
            ?>

        </form>

    </body>
</html>