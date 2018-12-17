<?php

    require("connexion.php");

    $obj = new Connexion();

    $connexion = $obj->getConnnexion();





        //$data = intval($_GET["id"]); 
    $data = (!empty($_GET["id"]))? $_GET["id"]:1; 
    $userid = $obj->selectPersonneBYid(intval($data));

if(@(intval($data) ==intval($userid->id))){

    $data = intval($data); 


    
        // Vérification de champs vides

    if(!empty($_POST['Nom']) AND !empty($_POST['Prenom']) AND !empty($_POST['PURL']) 
    AND !empty($_POST['Dnaissance']) AND !empty($_POST['Statut']) ){

        $Nom        = $_POST["Nom"];
        $Prenom     = $_POST["Prenom"];
        $PURL       = $_POST["PURL"];
        $Dnaissance = $_POST["Dnaissance"];
        $Statut     = $_POST["Statut"];




        //music 
        $music = array();

        $music_filter = array();

        


        $music[1]           = @$_POST["Rock"];   
        $music[2]           = @$_POST["Hip_Hop"];  
        $music[3]           = @$_POST["Metal"];  
        $music[4]           = @$_POST["Jazz"];       
        $music[5]           = @$_POST["R_and_B"];    
        $music[6]           = @$_POST["POP"];

        foreach ($music as $key => $value) {

            if($value == "on"){

                $music_filter[$key] = 1;
            }
        }

          




//hobby


$hobby = array();

$hobby_filter = array();


$hobby[1]           = @$_POST["Football"]; 
$hobby[2]           = @$_POST["Cinema"];
$hobby[3]           = @$_POST["Lire"];
$hobby[4]           = @$_POST["Jeux"];
$hobby[5]           = @$_POST["Fashion"];
$hobby[6]           = @$_POST["Hockey"];

foreach ($hobby as $key => $value) {

    if($value == "on"){
        $hobby_filter[$key] = 1;
    }
}

    


//personne
$personne_get = $obj->selectAllPersonne();

$per = array();

        foreach($personne_get as $value=>$key){

            if(@$_POST["$key->Prenom"]){
                $per["$key->id"] = @$_POST["$key->Prenom"];
            }

        }






// personne insertion    
$obj->insertPersonne($Nom,$Prenom,$PURL,$Dnaissance,$Statut);


//creer la relation entre personne

$personne_id = $connexion->lastInsertId();


    
        //insert into relation Personne 
        foreach ($per as $key => $value) {
            
            $obj->relationPersonne($personne_id,$key,$value);

        }

        
        //insert into relation Musique  
        foreach ($music_filter as $key => $value) {
            
            $obj->RelationMusique($personne_id,$key);

        }

        //insert into relation Hobby
        foreach ($hobby_filter as $key => $value) {
            
            $obj->RelationHobby($personne_id,$key);
            

        }

        header('Location: profile.php?id='.$personne_id);

      
}//la fin de premier if
?>


<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta charset="utf-8">
    </head>
    <body>
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
            
            <div id="user_friends">
                <h2 id="h2_friends">En Relation Avec</h2>
                
            <!--
            <a href="?id=1"><p><img src="user.png" alt="" srcset=""><span class="friendname_1">Vincent berset</span><span class="friendname_2">ami</span></p></a>
                -->
            <?php

                $ami = $obj->selectAllPersonneFriends($data);

                foreach($ami as $key){

                    echo "<a href='?id=".$key->id."'><p><img src='".$key->URL_Photo."'><span class='friendname_1'>".$key->Prenom."</span><span class='friendname_2'>".$key->Type."</span></p></a>";
            
                }

}//la fin de premier if
else{

        echo "<p><h1 style='color:red;text-align:center;font-size:40pt;'>page not found <h1></p>";
        echo "<p><h2 style='color:red;text-align:center;font-size:48pt;color:red;'>Error 404</h2></p>";
    }        
            ?>                    
            </div>  
        </div>
    </body>
</html>
