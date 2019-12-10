<html>
    <head>
        <link href="index.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro&display=swap" rel="stylesheet">
        <meta charset="utf-8">
        <title>Accueil</title>
    </head>
    <body id="index">
        <nav id="index">
        <?php 
            session_start();
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

        <main id="accueil">
            <article id="fb">
                <img src="facebook.png" alt="">
                <h2 id="txt">Bienvenu sur Facebook.>io<</h2>
            </article>
        </main>

    </body>
</html>
