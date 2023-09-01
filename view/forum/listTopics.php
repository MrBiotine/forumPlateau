<?php

$topics = $result["data"]['topics'];
$category = $result["data"]['category'];
    
?>

<h1><?=$category->getNameCategory() ?></h1>


<div class="">
    <table>
        <thead>
            <tr>
                <th>TITRES</th>
                <th>DATES&HEURES</th>
                <th>PSEUDOS</th>
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
                }
                // Afficher le nom de la Catégorie sélectionnée
                echo "<div class='titreT'>".$topic->getCategory()->getNameCategory()."</div>";

            }else{// Sinon afficher ci dessous (Page Liste Topics sans Topics)
               
                echo "<p> La catégorie ".$category->getNameCategory()." n'a pas encore de sujet</p>";

                 
            }

            ?>
                <!-- Lien pour créer un nouveau Topic selon la catégorie -->
                <a href="index.php?ctrl=forum&action=formulaireTopic&id=<?=$category->getId()?>">Créer un nouveau Topic</a>
            <?php 
        ?>

    </table>
</div>
  
