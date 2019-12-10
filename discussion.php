<html>


<head>
<title>Discussions</title>
<link href="index.css" rel="stylesheet">
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
 
<?php

if((isset($_SESSION['login']))&&(isset($_SESSION['password'])))
{
?>
		
<?php	
	
	$connexion= mysqli_connect("localhost", "root", "", "discussion"); 
	$query="SELECT login, DATE_FORMAT(date,'%a%e%b%Y'), id_utilisateur, message FROM `utilisateurs` ,`messages` WHERE utilisateurs.id = id_utilisateur  ORDER BY `messages`.`id` ASC";
	$result= mysqli_query($connexion, $query);
		

	$requete="SELECT id, message FROM `messages`";
	$idresult= mysqli_query($connexion, $requete);
?>
<article class="espacemessages">
	<table>
		<tr>
			<th><center><strong>Utilisateur(s)</strong></center></th>
			<th><center><strong>Commentaires</strong></center></th>
		</tr>
<?php	
while(($row = mysqli_fetch_array($result)) && ($id = mysqli_fetch_array($idresult))){
?>
	<tr>
		<td><?php echo "Posté par : ";echo "<strong>".$row['login']."</strong>"; echo " le "; echo $row[1];?></td>
		<td><?php echo $row['message'];?></td>
		<?php
		
		if(isset($_SESSION['login']))
		{
		if(($_SESSION['login'] == $row['login'])||($_SESSION['login']=="admin"))
		{
		?>
		</tr>

		<form method="post" action="discussion.php">
				<input type="submit" id="bouton" name="effacer" value="Supprimer">
				<input type="hidden" name="suppr" value="<?php echo $id['id'] ?>">
				 
		</form>

		<?php
		}
		if(isset($_POST['effacer']))
		{
			$message= $_POST['suppr'];
			$connexion= mysqli_connect("localhost", "root", "", "discussion"); 
			$query2="DELETE FROM `messages` WHERE messages . id = '$message'";
			$result2= mysqli_query($connexion, $query2);
			header ('location: discussion.php');			
		}
		}
		?>

<?php
		
}
?>
</table>
		<form class="ajout" method="post" action="discussion.php">
			<textarea name="text" placeholder="Ajoutez un message"></textarea>
			<input type="submit" id="bouton" name="ajout" value="Ajouter">
		</form>
<?php
	if(isset($_POST['ajout']))
	{
		$connexion= mysqli_connect("localhost", "root", "", "discussion"); 
		$login=$_SESSION['login'];
		$query1="SELECT  id from utilisateurs WHERE login='$login'";
		$resultat= mysqli_query($connexion, $query1);
		$row = mysqli_fetch_array($resultat);
		
		$id_user=$row['id'];
		
		$query1 = "INSERT INTO `messages` (`id`, `message`, `id_utilisateur`, `date`) VALUES (NULL, '".$_POST['text']."', '".$id_user."', CURRENT_TIMESTAMP());";		
		mysqli_query($connexion, $query1);		 
		mysqli_close($connexion);
		$_SESSION['message']=$_POST['text'];
		header('Location: discussion.php');
		mysqli_close($connexion);
	}
}
else
{
 $_SESSION['connexion']="connecté";
 header ('location: connexion.php');
 
}
?>

	
</article>
	
	</body>
</html>