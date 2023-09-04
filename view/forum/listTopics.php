<?php
//var initialisation
$numberTopic = 0 ;

$topics = $result["data"]['topics'];
$category = $result["data"]['category'];
    
?>

<h1><?=$category->getNameCategory() ?></h1>

<div class="">
    <table>
        <thead>
            <tr>
                <th>Intitulé</th>
                <th>Date de création</th>
                <th>Auteur</th>
                <th>OPTIONS</th>
            </tr>
        </thead>
        <?php

            if($topics == true){// Créer une condition pour afficher une catégorie vide si il y a un ou plusieurs topics alors afficher ci desous)
                
                foreach($topics as $topic){// On fait un foreach pour afficher tous les Topics dans un tableau
                    
                    ?>
                        <tbody>
                            <tr>
                                <td><a href="index.php?ctrl=forum&action=listPosts&id=<?=$topic->getId()?>"><?=$topic->getNameTopic()?></a></td>
                                <td><?=$topic->getDateTopic()?></td>
                                <td><?=$topic->getUser()->getPseudoUser()?></td>
                                
                                <td>
                                    <div class="">

                                        
                                            
                                     <!-- Pour supprimer le topic sélectionné directement dans la liste -->
                                     <form action="index.php?ctrl=forum&action=delTopic&id=<?=$topic->getId()?>" method="post">
                        
                                         <!-- Mettre une icône dans l'input -->
                                         <input type="image" class="suppT" alt="Supprimer" src="./public/img/supp.jpg">
                                     </form>

                                        

                                    </div> 
                                </td>
                            </tr>
                        </tbody>  
                <?php
                $numberTopic ++;
                }
                ?>
                <!-- Afficher le nombre de sujet dans la catégorie -->
                <p>Il y a <?= $numberTopic ?> sujet<?= $numberTopic > 1 ? "s" : "" ?> dans cette catégorie</p>
            <?php
            }else{// Sinon afficher ci dessous (Page Liste Topics sans Topics)
               
                echo "<p> La catégorie ".$category->getNameCategory()." n'a pas encore de sujet</p>";

                 
            }

            ?>
                <!-- Lien pour créer un nouveau Topic selon la catégorie -->
               <p> <a href="index.php?ctrl=forum&action=addFormTopic&id=<?=$category->getId()?>">Créer un nouveau Topic</a> </p>
            
        

    </table>
</div>
  
