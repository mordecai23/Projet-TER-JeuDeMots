<?php 

function globalranking()
{
  require_once "ConnectionBDD.php";
  $db = DataBase::getInstance(); //établir la connexion

  $queryUpdate = "SELECT r.score, u.userName, us.valueAttribute FROM ranking r, User u, UserAttributes us WHERE r.idUser = u.idUser AND u.idUser = us.idUser 
  AND us.nameAttribute = 'urlAvatar' AND r.type = 1 ORDER BY r.score DESC, u.userName ASC;";

  $s = $db->prepare($queryUpdate);
  $s->execute();
  

              
  $i = 1;
  $res = "";
  $firstScore;
  $firstName;
  $firstAvatar;
  $secondScore;
  $secondScore;
  $secondAvatar;

  while ($rows = $s->fetch(PDO::FETCH_LAZY))
  {
    if ($i == 1) {
      $firstScore = $rows['score'];
      $firstName = $rows['userName'];
      $firstAvatar = $rows["valueAttribute"];
    } else if ($i == 2) {
      $secondScore = $rows['score'];
      $secondName = $rows['userName'];
      $secondAvatar = $rows["valueAttribute"];

    } else if ($i == 3){
      $res .= '<div class="top3" id="top3">
      <div class="two item" id="second">
      <div class="pos">
        2
      </div>
      <div class="pic" style="background-image: url(&#39;'.$secondAvatar.'&#39;)"></div>
        <div class="name">
        '.$secondName.'
        </div>
        <div class="score">
        '.$secondScore.' points
        </div>
      </div> 
      <div class="one item" id="first">
        <div class="pos">
          1
        </div>
        <div class="pic" style="background-image: url(&#39;'.$firstAvatar.'&#39;)"></div>
        <div class="name">
          '.$firstName.'
        </div>
        <div class="score">
          '.$firstScore.' points
        </div>
      </div>
      <div class="three item" id="third">
          <div class="pos">
            3
            </div>
          <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
          <div class="name">
            '.$rows['userName'].'
          </div>
          <div class="score">
            '.$rows['score'].' points
          </div>
        </div>
        </div>';
    } else if ($i == 4){
      
      $res .= '<div class="list" style="max-height: 600px; overflow-y : auto; overflow-x: hidden;">
      <div class="item">
        <div class="pos">
          4
        </div>
        <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
        <div class="name">
          '.$rows['userName'].'
        </div>
        <div class="score">
          '.$rows['score'].'
        </div>
      </div>';
      
    } else {
      $res .= '<div class="item"><div class="pos">
      
        '.$i.'
      </div>
      <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
      <div class="name">
        '.$rows['userName'].'
      </div>
      <div class="score">
        '.$rows['score'].'
      </div>
      </div>';
    }

    $i++;

  }

  if ($i > 3) {
    $res .= '</div>';
  }

  echo $res;
}

function Monthlyranking()
{
  require_once "ConnectionBDD.php";
  $db = DataBase::getInstance(); //établir la connexion

  $queryUpdate = "SELECT r.score, u.userName, us.valueAttribute FROM ranking r, User u, UserAttributes us WHERE r.idUser = u.idUser AND u.idUser = us.idUser 
  AND us.nameAttribute = 'urlAvatar' AND r.type = 2 ORDER BY r.score DESC, u.userName ASC;";

  $s = $db->prepare($queryUpdate);
  $s->execute();
  

              
  $i = 1;
  $res = "";
  $firstScore;
  $firstName;
  $firstAvatar;
  $secondScore;
  $secondScore;
  $secondAvatar;

  while ($rows = $s->fetch(PDO::FETCH_LAZY))
  {
    if ($i == 1) {
      $firstScore = $rows['score'];
      $firstName = $rows['userName'];
      $firstAvatar = $rows["valueAttribute"];
    } else if ($i == 2) {
      $secondScore = $rows['score'];
      $secondName = $rows['userName'];
      $secondAvatar = $rows["valueAttribute"];

    } else if ($i == 3){
      $res .= '<div class="top3" id="top3">
      <div class="two item" id="second">
      <div class="pos">
        2
      </div>
      <div class="pic" style="background-image: url(&#39;'.$secondAvatar.'&#39;)"></div>
        <div class="name">
        '.$secondName.'
        </div>
        <div class="score">
        '.$secondScore.' points
        </div>
      </div> 
      <div class="one item" id="first">
        <div class="pos">
          1
        </div>
        <div class="pic" style="background-image: url(&#39;'.$firstAvatar.'&#39;)"></div>
        <div class="name">
          '.$firstName.'
        </div>
        <div class="score">
          '.$firstScore.' points
        </div>
      </div>
      <div class="three item" id="third">
          <div class="pos">
            3
            </div>
          <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
          <div class="name">
            '.$rows['userName'].'
          </div>
          <div class="score">
            '.$rows['score'].' points
          </div>
        </div>
        </div>';
    } else if ($i == 4){
      
      $res .= '<div class="list" style="max-height: 600px; overflow-y : auto; overflow-x: hidden;">
      <div class="item">
        <div class="pos">
          4
        </div>
        <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
        <div class="name">
          '.$rows['userName'].'
        </div>
        <div class="score">
          '.$rows['score'].'
        </div>
      </div>';
      
    } else {
      $res .= '<div class="item"><div class="pos">
      
        '.$i.'
      </div>
      <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
      <div class="name">
        '.$rows['userName'].'
      </div>
      <div class="score">
        '.$rows['score'].'
      </div>
      </div>';
    }

    $i++;

  }

  if ($i > 3) {
    $res .= '</div>';
  }
  

  echo $res;
}

function weeklyranking()
{
  require_once "ConnectionBDD.php";
  $db = DataBase::getInstance(); //établir la connexion

  $queryUpdate = "SELECT r.score, u.userName, us.valueAttribute FROM ranking r, User u, UserAttributes us WHERE r.idUser = u.idUser AND u.idUser = us.idUser 
  AND us.nameAttribute = 'urlAvatar' AND r.type = 3 ORDER BY r.score DESC, u.userName ASC;";

  $s = $db->prepare($queryUpdate);
  $s->execute();
  

              
  $i = 1;
  $res = "";
  $firstScore;
  $firstName;
  $firstAvatar;
  $secondScore;
  $secondScore;
  $secondAvatar;

  while ($rows = $s->fetch(PDO::FETCH_LAZY))
  {
    if ($i == 1) {
      $firstScore = $rows['score'];
      $firstName = $rows['userName'];
      $firstAvatar = $rows["valueAttribute"];
    } else if ($i == 2) {
      $secondScore = $rows['score'];
      $secondName = $rows['userName'];
      $secondAvatar = $rows["valueAttribute"];

    } else if ($i == 3){
      $res .= '<div class="top3" id="top3">
      <div class="two item" id="second">
      <div class="pos">
        2
      </div>
      <div class="pic" style="background-image: url(&#39;'.$secondAvatar.'&#39;)"></div>
        <div class="name">
        '.$secondName.'
        </div>
        <div class="score">
        '.$secondScore.' points
        </div>
      </div> 
      <div class="one item" id="first">
        <div class="pos">
          1
        </div>
        <div class="pic" style="background-image: url(&#39;'.$firstAvatar.'&#39;)"></div>
        <div class="name">
          '.$firstName.'
        </div>
        <div class="score">
          '.$firstScore.' points
        </div>
      </div>
      <div class="three item" id="third">
          <div class="pos">
            3
            </div>
          <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
          <div class="name">
            '.$rows['userName'].'
          </div>
          <div class="score">
            '.$rows['score'].' points
          </div>
        </div>
        </div>';
    } else if ($i == 4){
      
      $res .= '<div class="list" style="max-height: 600px; overflow-y : auto; overflow-x: hidden;">
      <div class="item">
        <div class="pos">
          4
        </div>
        <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
        <div class="name">
          '.$rows['userName'].'
        </div>
        <div class="score">
          '.$rows['score'].'
        </div>
      </div>';
      
    } else {
      $res .= '<div class="item"><div class="pos">
      
        '.$i.'
      </div>
      <div class="pic" style="background-image: url(&#39;'.$rows["valueAttribute"].'&#39;)"></div>
      <div class="name">
        '.$rows['userName'].'
      </div>
      <div class="score">
        '.$rows['score'].'
      </div>
      </div>';
    }

    $i++;

  }

  if ($i > 3) {
    $res .= '</div>';
  }

  echo $res;
}

?>