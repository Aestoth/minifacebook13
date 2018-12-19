<?php 
require("connexion.php");

$obj = new Connexion();
$connexion = $obj->getConnnexion();
?>

<!DOCTYPE html>
<html>
<head>
<title>Mini Facebook</title>
<!-- metatags-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Meta tag Keywords -->
<!-- css files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- //css files -->
</head>
<body>
<h1>Ajouter un nouveau profil</h1>
	<div class="form">
		<form action="profile.php" method="post">	
			<div class="lastname">
				<label class="titre">Nom</label>
				<input type="text" name="Nom" placeholder="Votre Nom" required="">
			</div>
			<div class="firstname">
				<label class="titre">Prenom</label>
				<input type="text" name="Prenom" placeholder="Votre prénom" required="">
			</div>
			<div class="clear"></div>
			<div class="userdetails">
			<div class="date">
				<label class="titre">Date de naissance</label>
					<div class="styled-input">
					<input class="date" required type="date" name="Dnaissance" id="date" required="">
					</div>
				</div>
				<div class="photo">
					<label class="titre">Votre photo</label>
					<input required id="profile_photo" type="url" placeholder="lien de votre avatar" name="PURL" id="photo">
				</div>	
			<div class="clear"></div>
			<div class="etatcivil">
				<label class="titre">Etat Civil</label>	
					<select class="form-control" required="" name="Statut">
						<option value="celibataire">Célibataire</option>
						<option value="en couple">En couple</option>
						<option value="non défini">Non défini</option>
					</select>
			</div>
			<div class="clear"></div>
				<div class="musicdetail">					
					<label class="titre">Musiques Préférées</label>
					<input type="checkbox" name="music[]" value="Rock" />Rock
					<input type="checkbox" name="music[]" value="Hip_Hop" />Hip_Hop
					<input type="checkbox" name="music[]" value="Metal" />Metal
					<input type="checkbox" name="music[]" value="Jazz" />Jazz
					<input type="checkbox" name="music[]" value="R&B" />R&B
					<input type="checkbox" name="music[]" value="Pop" />PoP
				</div>
				<div class="hobbiesdetail">
					<label class="titre">Hobbys Préférés</label>	
						<input type="checkbox" name="hobby[]" value="Football" />Football
						<input type="checkbox" name="hobby[]" value="Cinema" />Cinema
						<input type="checkbox" name="hobby[]" value="Lire" />Lire
						<input type="checkbox" name="hobby[]" value="Jeux" />Jeux
						<input type="checkbox" name="hobby[]" value="Fashion" />Fashion
						<input type="checkbox" name="hobby[]" value="Hockey" />Hockey
				</div>
			</div>
				<div class="clear"></div>
			<div id="friend_list">
					<h2 class="white">En Relation Avec</h2>
					<div id="friend_list_option">
				<?php
					$personne = $obj->selectAllPersonne();
					foreach($personne as $key){
						echo '<p><label name="'.$key->Prenom.'">'.$key->Prenom.' '.$key->Nom.'
							<select id="select_option" name="'.$key->Prenom.'">
								<option default></option>
								<option>ami</option>
								<option>famille</option>
								<option>collège</option>

							</select>
							</label></p>';
					} 

					//<input type="text" name="'.$key->Prenom.'">						
				?>

				</div>
					</fieldset>
					<input id="register_button" type="submit"  value="Enregistrer">
					<input id="cancel_button" type="reset"  value="Anuler">				
			<div class="clear"></div>
		</form>
	</div>
</body>
</html>