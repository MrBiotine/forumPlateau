<?php
if(!App\Session::getUser()){
    ?>
    <form action="index.php?ctrl=security&action=signIn" method="post">
        <h1>Connecter vous !</h1>
        <div>
            <label for="email">Email : </label>
            <input type="email" name="emailUser" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
        </div>
        <div>
            <label for="passWordUser">Mot de passe :</label>
            <input type="password" name="passWordUser" id="passWordUser" required>
        </div>
        <input type="submit" value="SE CONNECTER" name="submitSignIn" id="form-button">
    </form>
<?php
}