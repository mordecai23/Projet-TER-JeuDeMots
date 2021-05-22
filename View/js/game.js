var x = 1;
var nbwords = 0;
var sizeTab = 0;
var tabdoub=[];

document.addEventListener("DOMContentLoaded", function(event) {
    nbwords = 10 + getLevel();
    sizeTab = nbwords;
});

/**
 * Fonction qui permet de valider un mot
 */
 async function fonctionvalider()
 {
  var value = document.getElementById("search").value;
  var valangue = document.getElementById("langue_values").value;

  value = value.trim();

  if(value !== ""){

    if (x <= sizeTab) {
        document.getElementById("search").value = "";
        var table = document.getElementById("tableau");

        if (value.includes("*")) {
            var termeres = value.split("*");

            for (let i = 0; i < termeres.length; i++) {
                termeres[i]=termeres[i].trim();

                if (x <= sizeTab && !(tabdoub.includes(termeres[i])) && termeres[i]!=="") {
                    var data = {
                        search: termeres[i],
                        lang : valangue
                    };
                    var param = "this,"+"'"+ String(termeres[i]) + "'";
                    var bouton = '<button onclick="supprimer(' + String(param) + ')" type="button" class="btn btn-danger btn-sm" name="' + x + '"><i class="fa fa-trash-o"></i></button>';
                    bouton=bouton+'<button onclick="modifier(' + String(param) + ')" type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>';

                    $.post("envoie.php", data);
                    const response = await fetch('/fichiers_php/VerificationTerme.php'); // Récupere infos depuis une URL de manière asynchrone d'une requete HTTP
                    const body = await response.text();
                    var res = parseInt(body, 10);
                    var row = table.insertRow(x);

                    var cell2 = row.insertCell(0);
                    var cell4 =row.insertCell(1);
                    var cell3 = row.insertCell(2);

                    cell3.innerHTML = bouton;
                    if (res != 0) {
                        cell2.innerHTML = '<p class="font-weight-bold text-white text-right">' + termeres[i] + '</p>';
                        cell4.innerHTML = '<p class="font-weight-bold text-white text-right">' + valangue + '</p>';
                    } else {
                        cell2.innerHTML = '<p class="font-weight-bold text-warning text-right">' + String(termeres[i]) + '</p>';
                        cell4.innerHTML = '<p class="font-weight-bold text-white text-right">' + valangue + '</p>';
                    }

                    x++;

                    nbwords--;
                    document.getElementById("nb-words").className = "font-weight-bold text-white"
                    document.getElementById("nb-words").innerHTML = "Il vous reste "+ nbwords +" termes à proposer.";
                    if(nbwords == 0){
                      document.getElementById("nb-words").className = "font-weight-bold text-danger"
                      document.getElementById("nb-words").innerHTML = "Il ne vous reste plus de termes à proposer.";
                    }
                    var count=tabdoub.push(termeres[i]);
                }
            }
        } else if(!(tabdoub.includes(value))){
            var param = "this,"+"'"+ String(value) + "'";
            var bouton = '<button onclick="supprimer(' + String(param) + ')" type="button" class="btn btn-danger btn-rounded btn-sm" name="' + x + '"><i class="fa fa-trash-o"></i></button>';
            bouton=bouton+'<button onclick="modifier(' + String(param) + ')" type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>';
            var data = {
                search: value,
                lang : valangue
            };

            $.post("envoie.php", data);
            const response = await fetch('/fichiers_php/VerificationTerme.php'); // Récupere infos depuis une URL de manière asynchrone d'une requete HTTP
            const body = await response.text();
            var res = parseInt(body, 10);
            var row = table.insertRow(x);
            var cell2 = row.insertCell(0);
            var cell4 =row.insertCell(1);
            var cell3 = row.insertCell(2);



            cell3.innerHTML = bouton;

            if (res != 0) {
                cell2.innerHTML = '<p class="font-weight-bold text-white text-right">' + value + '</p>';
                cell4.innerHTML = '<p class="font-weight-bold text-white text-right">' + valangue + '</p>';
            } else {
                cell2.innerHTML = '<p class="font-weight-bold text-warning text-right">' + value + '</p>';
                cell4.innerHTML = '<p class="font-weight-bold text-white text-right">' + valangue + '</p>';
            }

            x++;
            nbwords--;
            document.getElementById("nb-words").className = "font-weight-bold text-white"
            document.getElementById("nb-words").innerHTML = "Il vous reste "+ nbwords +" termes à proposer.";
            if(nbwords == 0){
              document.getElementById("nb-words").className = "font-weight-bold text-danger"
              document.getElementById("nb-words").innerHTML = "Il ne vous reste plus de termes à proposer.";
            }
            var count=tabdoub.push(value);
        }
        document.getElementById("search").value = "";
    }
  }
}

/**
 * Fonction qui permet de supprimer un mot du tableau
 */
 function supprimer(objet,terme) {
     var data = {
         supp: terme
     };

     $.post("supprimer.php", data);

     var table = document.getElementById("tableau");
     var i = objet.parentNode.parentNode.rowIndex;
     
     table.deleteRow(i);
     x--;
     nbwords++;
     document.getElementById("nb-words").className = "font-weight-bold text-white"
     document.getElementById("nb-words").innerHTML = "Il vous reste "+ nbwords +" termes à proposer.";

     const index = tabdoub.indexOf(terme);
     
     if (index > -1) {
      tabdoub.splice(index, 1);
     }
 }

 function modifier(objet, terme)
 {
    var table = document.getElementById("tableau");
    var i = objet.parentNode.parentNode.rowIndex;
    var langue=table.rows[i].cells[1].innerHTML;
    var l=langue.split(">");
    var l1=l[1].split("<");
    var lang=l1[0];

    var listLang = document.getElementById("langue_values");
    
    var tabLang = [];
    for (let index = 0; index < listLang.length; index++) {
      tabLang[index] = listLang.options[index].text;
    }

    var indice=tabLang.indexOf(lang);
    if(indice==tabLang.length-1)
    {
      indice=0;
    }
    else{
      indice++;
    }

   langue=tabLang[indice];
    var data = {
        search: terme,
        lang : langue
    };

    $.post("modif.php", data);
    table.rows[i].cells[1].innerHTML='<p class="font-weight-bold text-white text-right">'+langue+'</p>';

 }

/**
 * Fonction qui redirige vers la fin de partie
 */
function redirectEndGame()
{
  window.location.replace("/View/html/endGamePage.php");
}

/**
 * Fonction qui ajoute du temps.
 */
async function addTimeLimit() {

  const response = await fetch('/View/html/creditPrint.php'); // Récupere infos depuis une URL de manière asynchrone d'une requete HTTP
  const body = await response.text();
  var valueCredit = parseInt(body, 10);

  if (valueCredit >= 200) {

    valueCredit -= 200;
    timePassed -= 30; // Ajout 30secondes sur le temps
    
    document.getElementById("credit-nyt").value = valueCredit + " NYT";

    var data = {
      valueCredit: valueCredit,
    };

    $.post("creditGame.php", data);

    // Get the snackbar DIV
    var sucess = document.getElementById("snackbarSuccessCredit");

    // Add the "show" class to DIV
    sucess.className = "show";

    setTimeout(function(){ sucess.className = sucess.className.replace("show", ""); }, 2000);


  } else {
      // Get the snackbar DIV
      var notEnough = document.getElementById("snackbarNotEnoughCredit");

      // Add the "show" class to DIV
      notEnough.className = "show";

      setTimeout(function(){ notEnough.className = notEnough.className.replace("show", ""); }, 2000);
  }

}

/**
 * Fonction qui augmente la limite des mots.
 */
 async function addWordsLimit() {

  const response = await fetch('/View/html/creditPrint.php'); // Récupere infos depuis une URL de manière asynchrone d'une requete HTTP
  const body = await response.text();
  var valueCredit = parseInt(body, 10);

  if (valueCredit >= 200) {

    valueCredit -= 200;
    nbwords += 1;
    sizeTab += 1;
    document.getElementById("credit-nyt").value = valueCredit + " NYT";

    var data = {
      valueCredit: valueCredit,
    };

    $.post("creditGame.php", data);

    // Get the snackbar DIV
    var sucess = document.getElementById("snackbarSuccessCredit");

    // Add the "show" class to DIV
    sucess.className = "show";

    setTimeout(function(){ sucess.className = sucess.className.replace("show", ""); }, 2000);
    document.getElementById("nb-words").className = "font-weight-bold text-white"
    document.getElementById("nb-words").innerHTML = "Il vous reste "+ nbwords +" termes à proposer.";

  } else {
      // Get the snackbar DIV
      var notEnough = document.getElementById("snackbarNotEnoughCredit");

      // Add the "show" class to DIV
      notEnough.className = "show";

      setTimeout(function(){ notEnough.className = notEnough.className.replace("show", ""); }, 2000);
  }

}

/**
 * Récupère le niveau de l'utilisateur.
 * @returns {*} Le niveau de l'utilisateur.
 */
function getLevel() {

    var element = document.getElementById("level");
    var level;
    if(element){

        level = parseInt(element.value);
        if (level > 25) {
          level = 25;
        } 

    }else {
      level = 0;
    }
    
    return level;
}
