<?php
if(!App\Session::getUser()){
    ?>
    <form action="index.php?ctrl=security&action=signUp" method="post">
        <h1>Inscription</h1>
        <p>Tous les champs sont requis</p>
        <div>
            <label for="pseudoUser">Pseudonyme :</label>
            <input type="text" name="pseudoUser" id="pseudoUser" required>
        </div>
        <div>
            <label for="emailUser">Adresse mel :</label>
            <input type="emailUser" name="emailUser" id="emailUser" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
        </div>
        <div>
            <label for="passWordUser">Mot de passe :</label>
            <input type="password" name="passWordUser" id="passWordUser" required>
        </div>
        <div>
            <label for="passWordConfirmed">Confirmation du mot de passe :</label>
            <input type="password" name="passWordConfirmed" id="passWordConfirmed" required>
        </div>
        <input type="submit" value="S'INSCRIRE" name="submitInscription" id="form-button">
    </form>
<?php
}