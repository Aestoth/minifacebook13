<?php

    require("connexion.php");

    $obj = new Connexion();

    $connexion = $obj->getConnnexion();

    //$data = intval($_GET["id"]); 
    $data = (!empty($_GET["id"]))? $_GET["id"]:1; 
    $userid = $obj->selectPersonneBYid(intval($data));

    if(@(intval($data) == intval($userid->id))){
    $data = intval($data); 
    

    // Vérification de l'envoi des données

    if($_POST) {
        // insérer une personne
        $obj->insertPersonne($_POST["Nom"],$_POST["Prenom"],$_POST["PURL"],$_POST["Dnaissance"],$_POST["Statut"]);
        $hobby = $_POST["hobby"];
        $music = $_POST["music"];
        $relation = $_POST["relation"];
        $personne_id = $connexion->lastInsertId();
        
        // insert into relation personne
        foreach ($relation as $key=>$value) {
            if($value !="") {
            $obj->relationPersonne($personne_id,$key,$value); 
            }   
        }
        //insert into relation Musique  
        foreach ($music as $key => $value) {  
            $obj->RelationMusique($personne_id,$key);
        }
        //insert into relation Hobby
        foreach ($hobby as $key => $value) {  
            $obj->RelationHobby($personne_id,$key);
        }
    header('Location: profile.php?id='.$personne_id);
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
            <!-- musiques et hobbys -->
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
}
else{

        echo "<p><h1 style='color:red;text-align:center;font-size:40pt;'>page not found <h1></p>";
        echo "<p><h2 style='color:red;text-align:center;font-size:48pt;color:red;'>Error 404</h2></p>";
    }        
            ?>                    
            </div>  
        </div>
    </body>
</html>
