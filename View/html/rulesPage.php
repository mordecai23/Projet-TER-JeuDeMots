<?php
  if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="fr">
<?php include "partials/headerPartial.php" ?>
<body>
  <div class="container-fluid container-body">
    <?php include $_SERVER['DOCUMENT_ROOT']."/View/html/partials/alertsPartial.php" ?>
    <div class="row">
      <div class="col-2"></div>
      <div class="col-8 text-center">
        <h1 class="mt-5 mb-3">Règles</h1>
        
      </div>
      <div class="col-2"></div>
    </div>
    <div class="row mt-5">
      <div class="col-2">

      </div>
      <div class="col-3">
        <div id="list-example" class="list-group">
          <a class="list-group-item list-group-item-action rounded text-center" href="#list-item-1">But du jeu</a>
          <a class="list-group-item list-group-item-action rounded text-center mt-5" href="#list-item-2">Principe général</a>
          <a class="list-group-item list-group-item-action rounded text-center mt-5" href="#list-item-3">Jeu</a>
          <a class="list-group-item list-group-item-action rounded text-center mt-5" href="#list-item-4">Fin de jeu</a>
          <a class="list-group-item list-group-item-action rounded text-center mt-5" href="#list-item-5">Crédits du joueur</a>
          <a class="list-group-item list-group-item-action rounded text-center mt-5" href="#list-item-6">S'enregistrer, pourquoi?</a>
        </div>
      </div>
      <div class="col-5">
        <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example" style="height: 535px; overflow-y: auto;">
          <section>
            <h3 id="list-item-1" class="h3 text-bold ">But du jeu</h3>
            <p class="text-justify ">L'objectif de <strong>Wordz</strong> est de collectionner des termes. Votre Boîte à termes est votre coffre à trésors. Pour cela, il faut jouer sur les termes et tenter de les capturer en 
              faisant de bonnes parties. N'hésitez pas à voler des mots possédés par d'autres joueurs.
            </p>
          </section>

          <section>
            <h3 id="list-item-2" class="h3 text-bold mt-5">Principe général</h3>
            <p class="text-justify ">Lorsqu'une partie démarre, un terme sera proposé, et le but est d'insérer des mots ayant lien avec le terme, plus vous aurez de réponses en commun avec un autre joueur, meilleurs seront vos gains. 
              Les réponses spécifiques et peu rencontrées rapportent plus que des réponses générales. 
            </p>
          </section>

          <section>
            <h3 id="list-item-3" class="h3 text-bold mt-5">Jeu</h3>
            <p class="text-justify ">Lorsque le joueur lance une partie , un choix de langue lui est proposé, il peut insérer jusqu'à 10 mots en respectant la consigne affichée en haut de la page par rapport au mot de référence demandé. 
              Le délai accordé est de 1 minute, mais il est possible d'acheter du temps supplémentaire (200 crédits les 30 secondes).
              Un tableau sera affiché à droite de la page de jeu, ce tableau contiendra les mots que le joueur aura insérer durant sa partie, avec la possibilité de les supprimer.
              Le joueur peut choisir la langue du mot avant de le valider. Le joueur peut terminer la partie quand il le voudra en appuyant sur le bouton "Terminer la partie", sinon la partie est terminée si le délai s'est écoulé.
            </p>
          </section>

          <section>
            <h3 id="list-item-4" class="h3 text-bold mt-5">Fin de jeu</h3>
            <p class="text-justify ">A la fin d'une partie, le score final sera affiché ainsi qu'un tableau récapitulatif des mots que le joueur aura proposé durant la partie. 
              Une bannière s'affichera si le joueur aura réussi à capturer le terme, et s'ajoutera à la collection du joueur.
            </p>
          </section>

          <section>
            <h3 id="list-item-5" class="h3 text-bold mt-5">Crédits du joueur</h3>
            <p class="text-justify ">L'argent virtuel de Wordz est représenté par des crédits NYT. Ceux-ci sont gagnés lors des parties, en fonction de la pertinence de vos réponses. Les crédits vous servent à plusieurs choses, notamment à acheter du temps 
              lors d'une partie, ou même augmenter la limite de mot.
            </p>
          </section>

          <section>
            <h3 id="list-item-6" class="h3 text-bold mt-5">S'enregistrer, pourquoi?</h3>
            <p class="text-justify">Jouer comme invité est limité, vous pourrez choisir que les langues : Français et Anglais. En vous enregistrant, vous pourrez (en vrac) jouer sur les langues qui vous plait, vous la péter dans le classement et collectionner des mots... et découvrir plein d'autres choses encore. Une fois enregistré, vous pouvez également modifier vos options de langues. 
            </p>
          </section>
        </div>
        
      </div>
      <div class="col-2">

      </div>
    </div>

    <?php include "partials/backgroundAnimation.php" ?>
</body>
<footer>
</footer>
</html>

