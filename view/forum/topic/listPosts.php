<?php
if(App\Session::getUser() && !App\Session::isBan){

    $topic = $result["data"]["topic"];
    $posts = $result["data"]["posts"];

?>
<--! displays view if a user is connected -->
<h1><?=$category->getNameCategory() ?></h1>
<p><mark><a href="index.php?ctrl=forum&action=editFormCategory&id=<?=$category->getId()?>">Ajouter un message</a></mark></p>
<div class="">
    <table>
        <thead>
            <tr>
                <th>A</th>
                <th>Date de création</th>
                <th>Auteur</th>
                <th>Action</th>
            </tr>
        </thead>

</table>
<?php
}else{}
?>








