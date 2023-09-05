
<?php

$category = $result["data"]['category'];
    
?>
<h2>EDITER la  catégorie : <?=$category->getNameCategory() ?></h2>

<div class="">

    
    <!-- L'action du formulaire exécute editCategory -->
    <form class="form" action="index.php?ctrl=forum&action=editCategory&id=<?=$category->getId()?>" method="post">
                    
        <label class="" for="nameCat">Nouvel Intitulé </label>
        <input name="nameCategory" type="text" id="nameCat" value="<?=$category->getNameCategory() ?>" required> 

        <input  class="add-button" id="submit" type="submit" name="editCategory" value="EDITER">

    </form>

</div>
