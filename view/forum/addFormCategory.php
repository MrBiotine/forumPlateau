<h2>AJOUTER UNE CATEGORIE</h2>

<div class="">

    
    <!-- L'action du formulaire exécute addCategory -->
    <form class="form" action="index.php?ctrl=forum&action=addCategory" method="post">
                    
        <label class="" for="nameCat">Intitulé de la catégorie</label>
        <input name="nameCategory" type="text" id="nameCat" required> 

        <input  class="add-button" id="submit" type="submit" name="addCategory" value="AJOUTER">

    </form>

</div>
