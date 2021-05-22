<?php
if (!isset($_SESSION)) {
    session_start();
}
//supprimer le terme du tableau de la session
$supp = $_POST['supp'];
$tab = $_SESSION['tableauterme'];
if (($key = array_search($supp, $tab)) !== false) {
    unset($tab[$key]);
}
$_SESSION['tableauterme'] = $tab;
print_r($tab);

$tabbl=$_SESSION['tableaulangue'];

if (!(in_array($supp, $tab))){
unset($tabbl[$supp]);}


$_SESSION['tableaulangue']=$tabbl;
?>