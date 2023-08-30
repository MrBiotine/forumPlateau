<?php

$topics = $result["data"]['users'];
    
?>

<h1>liste des users</h1>

<?php
foreach($topics as $topic ){

    ?>
    <p><?=$topic->getPseudoUser()?></p>
    <?php
}


  
