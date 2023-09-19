<?php

$categorys = $result["data"]['categorys'];
$title = $result["data"]["title"];
$description = $result["data"]["description"];
// var_dump(App\Session::getUser());
?>

<h1>Les Catégories</h1>
<p><mark><a href="index.php?ctrl=forum&action=addFormCategory">Ajouter une catégorie</a></mark></p>
<?php
foreach($categorys as $category ){

    ?>
    <p><a href="index.php?ctrl=forum&action=listTopics&id=<?=$category->getId()?>"><?=$category->getNameCategory()?> qui contient <?=$category->getNumberTopic() ?> sujet<?= $category->getNumberTopic() > 1 ? "s" : "" ?> </a></p>
    <?php
}


  
