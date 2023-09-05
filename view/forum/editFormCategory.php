
<?php

$category = $result["data"]['categorys'];
    
?>
<h2>EDITER UNE CATEGORIE</h2>

<div class="">

    
    <!-- L'action du formulaire exécute addCategory -->
    <form class="form" action="index.php?ctrl=forum&action=addCategory&id=<?=$category->getId()?>" method="post">
                    
        <label class="" for="nameCat">Nouvel Intitulé </label>
        <input name="nameCategory" type="text" id="nameCat" value="<?=$category->getNameCategory() ?>" required> 

        <input  class="add-button" id="submit" type="submit" name="editCategory" value="EDITER">

    </form>

</div>
