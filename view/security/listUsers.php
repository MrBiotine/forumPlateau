<?php

$users = $result["data"]['users'];
    
?>

<h1>liste des users</h1>

<?php
foreach($users as $user ){
/*var_dump($user) : use to debug errors*/
    ?>
    <p><?=$user->getPseudoUser()?></p>
    
    <?php
}


  
