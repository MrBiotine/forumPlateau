<?php

$categorys = $result["data"]['categorys'];
    
?>

<h1>Les Catégories</h1>
<p><a href="index.php?ctrl=forum&action=addFormCategory">Ajouter une catégorie</a></p>
<?php
foreach($categorys as $category ){

    ?>
    <p><a href="index.php?ctrl=forum&action=listTopics&id=<?=$category->getId()?>"><?=$category->getNameCategory()?></a></p>
    <?php
}


  
