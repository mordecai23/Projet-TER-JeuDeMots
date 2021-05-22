/**
 * Fonction qui met un compte à rebours de 3secondes avant le début d'une partie
 */ 
 function loadingGame() {
  
  document.getElementById("beginCountDown").innerHTML = `
  <h2 class="mt-5 mb-3 text-center">Veuillez patienter ...</h2>
  `;
  let timeleftBegin = 3;
  let beforeTimer = setInterval(function(){
    if(timeleftBegin <= 0){
      clearInterval(beforeTimer);
      window.location.replace("/View/html/gamePage.php");
    } else {
      document.getElementById("beginCountDown").innerHTML = `
      <h2 class="mt-5 mb-3 text-center">La partie va commencer dans `+timeleftBegin+` ...</h2>
      `;
    }
    timeleftBegin -= 1;
  }, 1000);

}



/**
 * Fonction qui redirige vers la page loadingPage
 */ 
function redirectLoadingPage(){
  var l=document.getElementsByName("checkboxl[]");
  let values = [];
  if (l[0].checked==true){
        values.push(l[0].value);}
  if (l[1].checked==true){
        values.push(l[1].value);}
  var data = {langa: values};
  $.post("/lang.php", data);
  
  $('<div class="alert alert-success">' +
    '<button type="button" class="close" data-dismiss="alert">' +
    '&times;</button><strong>Succès !</strong> Langue(s) sélectionnée(s) !</div>').hide().appendTo('#alert-validate').fadeIn(1000);

  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
  }, 2000);

  document.getElementById("connectGuest-btn").disabled = false;
 //window.location.replace("/View/html/loadingPage.php");
}

function redirectLoadingPage1(){
  window.location.replace("/View/html/loadingPage.php");
}







