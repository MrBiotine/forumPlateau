<?php
if(App\Session::getUser() && !App\Session::getUser()->hasRole("ROLE_BAN")){

    $topic = $result["data"]["topic"];
    $posts = $result["data"]["posts"];
    ?>

    