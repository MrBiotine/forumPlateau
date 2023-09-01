<?php

$categorys = $result["data"]['categorys'];
    
?>

<h1>Les Catégories</h1>

<?php
foreach($categorys as $category ){

    ?>
    <p><a href="index.php?ctrl=forum&action=listTopics&id=<?=$category->getId()?>"><?=$category->getNameCategory()?></a></p>
    <?php
}


  
