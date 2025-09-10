<?php include 'html5_page.php'; begin_html('Exercice 1.2'); ?>
<h2>Script 1.2 : Utilisation d'un tableau</h2>

<?php
$continents = array(    /* instanciation dun tableau avec array*/
  "Europe" => array ("de","fr","uk"),  /* création de colonne Europe avec 3 élément */
  "Amérique du Nord" => array ("ca","us"), // création d'une colonne Amérique du nord avec 2 éléments ca et us
  1 => array ("eins","un","one"), // colonne création 1 avec 3 éléments
);

echo $continents["Europe"][1]."<br>"; /*affichage de tous les éléments de europe et de 1.  */

echo "Domaine canada : {$continents['Amérique du Nord'][0]}<br><br>"; /*Affichage Domaine canada: un tableau  */

/*lorsque l'on écrit : foreach ($tab as $elt), on parcourt le tableau $tab
  élément par élément. A chaque fois, la valeur de l'élément courant 
  est mis dans la variable $elt pour être utilisé dans la boucle*/

echo "<br>Premier exemple de boucle foreach<br>";
foreach ($continents as $soustab)   /*boucle pour chaque clé du tableau continents */
  foreach ($soustab as $val) {   /* définiton de soustab en tant valeur des clés du tableau */
    echo "- $val<br>\n"; /* affichage des valeus à chaque ligne */
  }

/*lorsque l'on écrit : foreach ($tab as $key=>$val), on parcourt le tableau 
  $tab élément par élément. A chaque fois, la clé de l'élément courant 
  est mis dans la variable $key et sa valeur dans $val*/

echo "<br>Deuxième exemple de boucle foreach<br>";
foreach ($continents as $key => $soustab) {   /*  */
  echo("$key:<br>\n");
  foreach ($soustab as $val) {
    echo "- $val<br>\n";
  }
}

echo "<br>Exemple de boucle for<br>count=".count($continents)."<br>";

//Expliquez les erreurs obtenues lors de l'exécution
for ($i=0;$i<count($continents);$i++) {
  $soustab = $continents[$i];
  for ($j=0;$j<count($soustab);$j++) {
    echo "- $soustab[$j]<br>\n";
  }
}
?>
<?php end_html(); ?>