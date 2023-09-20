<?php
$user = $result["data"]['users'];
if(!App\Session::getUser()){
?>

<div class="card" style="width:400px">
  <img class="card-img-top" src="img_avatar1.png" alt="Card image">
  <div class="card-body">
    <h4 class="card-title"><?=$user->getPeudoUser() ?></h4>
    <p class="card-text">Some example text.</p>
    <a href="#" class="btn btn-primary">See Profile</a>
  </div>
</div>



<?php
}
?>