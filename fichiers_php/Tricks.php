<?php



/**
 * Recupération d'une astuce aléatoirement
 */

  if ($_SESSION['boolTrick'] == false)
  
  {

    echo $_SESSION['trick'];

  }

  else

  {
    //Tableau des astuces 
    $tabTricks = [
      "Wikipedia, wikitionnaire et les autres ressources internet sont vos amis. Beaucoup de joueurs les utilisent et en profitent pour se cultiver. Certains préfèrent jouer à l'intuition. Chacun fait comme il veut, mais la première stratégie marche très bien, en achetant du temps.",
      "Faites ce qui vous parait le plus cohérent. Votre nombre de propositions est limité (en fonction de niveau, et aux alentours de 10), ne les gâchez pas !",
      "Les termes affichés en orange dans le tableau n'existent pas dans notre base de données.",
      "Vous pouvez insérer plusieurs mots à la fois en les séparant par * (ex : train*vélo*bâteau)",
      "Ajoutez du temps avec le bouton 'Ajouter temps', cela vous coûtera 200 Nyt, et vous gagnerez 30 secondes de plus.",
      "N'oubliez pas de dépensez vos Nyt durant une partie, cela aidera à améliorer votre score !",
      "Connectez vous pour pouvoir dépenser vos NYT, capturer des termes et plus encore !",
      "Vous avez atteint la limite de 10 mots ? Pas de soucis, augmentez cette limite grâce au bouton 'Ajouter mots' en dépensant quelques Nyt.",
      "Vous gagnez 10 NYT à chaque partie joué en fonction de votre niveau.",
      "Vous gagnez un pourcentage de 10 NYT sur le nombre de point total si vous capturez le terme !"
    ];

    $randomNumber = rand(0, sizeof($tabTricks)-1); 
    
    $trick = '<p class="note bg-secondary mt-2 text-center border border-white">
              <strong>Astuce : </strong>'.$tabTricks[$randomNumber].'</p>';

    $_SESSION['trick'] = $trick;

    echo $trick;
    
    $_SESSION['boolTrick'] = false;
    
}


?>