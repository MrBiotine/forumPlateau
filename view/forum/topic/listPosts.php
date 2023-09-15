<?php
if(App\Session::getUser() && !App\Session::isBan){

    $topic = $result["data"]["topic"];
    $posts = $result["data"]["posts"];

?>
<--! displays view if a user is connected -->
<h1><?=$category->getNameCategory() ?></h1>
<p><mark><a href="index.php?ctrl=forum&action=editFormCategory&id=<?=$topic->getId()?>">Ajouter un message</a></mark></p>
<div class="">
    <table>
        <thead>
            <tr>
                <th>Auteur</th>
                <th>Sujet : <?=$topic->getNameTopic()?></th>
            </tr>
        </thead>
        <?php
        if($posts == true){                 
            foreach($posts as $post){                                    
        ?>
                 <tbody>
                     <tr>
                         <td><a href="index.php?ctrl=security&action=goProfil&id=<?=$post->getUser()->getId()?>"><?=$post->getUser()->getPseudoUser()?></a></td>
                         <td><?=$post->getDatepost()?>
                        
                        </td>
                         <td><?=$post->getUser()->getPseudoUser()?></td>
                         
                         <td>
                             <div class="">                                     
                                     
                              <!-- Pour supprimer le post sélectionné directement dans la liste -->
                              <a href="index.php?ctrl=topic&action=delTopic&id=<?= $topic->getId() ?>"><i class="far fa-trash-alt"></i></a>                                     
                             </div> 
                         </td>
                     </tr>
                 </tbody>
            <?php
                }
            ?>
    </table>
</div>   
            <?php
            }else{// Sinon afficher ci dessous (Page Liste Topics sans Topics)
               
                echo "<p> Ce sujet n'a pas de message et ce n'est pas normal</p>";
                 
            } 
            ?>








