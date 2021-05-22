<?php 


// Calcul du nouveau crédit
if (isset($_SESSION['loggedIn'])) {

  $query = "SELECT userName,score FROM UserNode INNER JOIN User on User.idUser=UserNode.idUser where idNode=".$_SESSION['iddonne'];
  $s = $db->prepare($query);
  $s->execute();
  $tuple = $s->fetch(PDO::FETCH_LAZY);
  if($s->rowCount()>0)
  {
  $un = $tuple['userName'];
  $score=$tuple['score'];

  $retry='<p class="note bg-secondary mt-2 text-center border border-dark">
  <strong></strong>"'.$un.'" détient le meilleur score avec '.$score.' points</p>';

  echo $retry;
  }
}

?>