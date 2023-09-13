<?php
if(App\Session::getUser() && !App\Session::isBan()){

    $category = $result["data"]["category"]
    ?>
    <form action="index.php?ctrl=topic&action=addTopic&id=<?= $category->getId() ?>" method="post">
        <h1>Créer un sujet dans la catégorie "<?= $category->getNameCategory() ?>"</h1>
        <div>
            <label for="titre">Titre du sujet : </label>
            <input type="text" name="nameTopic" id="titre" required>
        </div>
        <div>
            <label for="contenu">Contenu du premier post :</label>
            <textarea name="textPost" id="contenu" cols="30" rows="10" required></textarea>
        </div>
        <input type="submit" value="Ajouter un sujet" name="submitTopicInCategory" class="lienAjout ajoutFormulaire">
    </form>
<?php
}