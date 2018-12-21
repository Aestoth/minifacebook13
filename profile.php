<?php

    require("connexion.php");

    $obj = new Connexion();

    $connexion = $obj->getConnnexion();

    $data = (!empty($_GET["id"]))? $_GET["id"]:1; 
    $userid = $obj->selectPersonneBYid(intval($data));

    // Si il y a un envoi de données
    if($_POST) {
        $obj->inscription();
    }
    // Si il n'y a pas d'utilisateur ou si il y une lettre alors page 404
    if($userid == null && $_GET["id"] != int) {
        header("location:404.html");
    }    
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta charset="utf-8">
    </head>
    <body>
        <!-- container principale -->
        <div id="profil_container">
            <p id="searchprofile"><a href="contact_search.php">Chercher</a></p>
            <div id="profile">
                <?php              
                    $personne = $obj->selectPersonneBYid($data);
                    echo '<img  id="user_image" src="'.$personne->URL_Photo.'">';
                    echo "<h1>".$personne->Nom."</h1>";
                    echo "<h2>".$personne->Prenom."</h2>";
                    echo "<p>Date de naissance:".$personne->Date_Naissance."</p>";
                    echo "<p>Status:".$personne->Status_couple."</p>";
                ?>   
            </div>
            <!-- musiques-->
            <div id="userdetails">
                <div id="hobbies_details">
                    <h2>Hobbies</h2>
                    <ul>                        
                        <?php
                        $hobi = $obj->selectAllHobbiesById($data);

                        foreach($hobi as $key){
                                echo "<li>".$key->Type."</li>";
                            } 
                        ?>               
                    </ul>
                </div>

            <!-- hobbys-->
                <div id="music_details">
                    <h2>Music</h2>
                    <ul>
                        <?php
                            $hob = $obj->selectAllMusiqueById($data);

                            foreach($hob as $key){
                                echo "<li>".$key->Type."</li>";
                                }
                        ?>
                    </ul>
                </div>  
            </div>
            
            <!-- liste des utilisateurs dans la base -->
            <div id="user_friends">
                <h2 id="h2_friends">En Relation Avec</h2>

            <?php
                $ami = $obj->selectAllPersonneFriends($data);
                foreach($ami as $key){
                    echo "<a href='?id=".$key->id."'><p><img src='".$key->URL_Photo."'><span class='friendname_1'>".$key->Prenom."</span><span class='friendname_2'>".$key->Type."</span></p></a>";         
                }
            ?>                     
            </div>  
        </div>
    </body>
</html>
