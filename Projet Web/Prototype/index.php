<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="iso-8859-1" />
<title>Kot &mdash; Présence</title>

<link rel="stylesheet" href="css/style.css" /> <!-- Ma mise en forme -->
<META HTTP-EQUIV="Refresh" CONTENT="60; URL=#"> 
<!-- jQuery pour l'intro avec l'effet "Fade Out" -->
<script src="jvs/jquery-1.10.2.min.js"></script>
<!-- Script pour le flash d'intro, on attend que le document soit chargé, ensuite
après 2000 milisecondes on le fade out lentement -->
<script>
  $( document ).ready(function() {
	$( "div#flash-intro-conteneur" ).delay(2000).fadeOut( "slow");
  });
</script>

<?php

function isAtHome($host)
{
	//$host="192.168.1.17";

	//exec("ping -c 4 " . $host, $output, $result); //Linux
	//exec("ping -n 1 " . $host, $output, $result); //Windows


	$output = shell_exec('fping ' . $host . '');
	//echo $output;
	
	if(strpos($output, "alive") === FALSE)
		return false;
	else
		return true;
	
}

?>
</head>
<body>
<!-- bloc en carte de visite affiché au début (Splash Screen). -->
<!-- class no-print afin qu'il ne soit pas affiché lors de l'impression -->
<div id="flash-intro-conteneur" class="no-print">
		<table id="flash-intro">
			<tr>
				<td>
					<!--<img src="img/2TL2_DEBUCK_Paul.png" alt="Photo de profil de Paul De Buck" />-->
				</td>
				<td>
					Kot'Nected by <br />
					<strong>Brainify</strong>
				</td>
			</tr>
		</table>
</div>

<br />


<!-- La zone du CV réellement commence ici -->
<div class="container_12">
<!-- Barre de navigation pour accès facile, comme demandé, en class no-print -->
	<div class="grid_9 prefix_3 no-print" style="">
		<p>
			<ul id="navbar">
				<li><a href="#mess" title="Voir les messages privés">Messages</a></li>
				<li><a href="#prefs" title="Changer mes préférences">Préférences</a></li>
				<li><a href="#courses" title="Voir la liste des courses à faire">Liste des courses</a></li>
				<li><a href="#taches" title="Voir les tâches communes">Tâches communes</a></li>
			</ul>
		</p>
	</div>  
<br />
<br />
<br />
  <h2>
    Qui est au kot ?
  </h2>
	
	<div class="clear"></div>
  
  <div class="grid_4 prefix_1 suffix_6">
    <h3 id="coords">Cokotteurs</h3>
  </div>
  
  <div class="grid_1" style="display:none;">
		<p>
			<!-- tous les "Remonter" sont en class no-print afin de ne pas s'afficher lors de l'impression -->
			<a class="gotop no-print" href="#" title="Remonter en haut de la page">Remonter</a>
		</p>
	</div>
  
  <div class="clear"></div>
  
  <!-- Photos -->
  <div class="grid_2 prefix_1">
    <p style="text-align: center;">
	<span class="contenu">Nicolas</span>
	<br />
			<?php
			if (isAtHome("10.99.0.83") == true){
			?>
			<img src="img/NicolasFougnies.jpg"/>
			<br />
			<br />
			<span class="present">Présent</span>
			<?php
			}
			else{
			?>
			<img src="img/NicolasFougniesAway.jpg"/>
			<br />
			<br />
			<span class="away">Absent</span>
			<?php
			}
			?>
		</p>
  </div>
  
  <div class="grid_2">
    <p style="text-align: center;">
	<span class="contenu">Lola</span>
	<br />
			<?php
			if (isAtHome("192.168.1.27") == true){
			?>
			<img src="img/Lola.jpg"/>
			<br />
			<br />
			<span class="present">Présente</span>
			<?php
			}
			else{
			?>
			<img src="img/LolaAway.jpg"/>
			<br />
			<br />
			<span class="away">Absente</span>
			<?php
			}
			?>
		</p>
  </div>
	
	<div class="grid_2">
    <p style="text-align: center;">
	<span class="contenu">Maria</span>
	<br />
			<?php
			if (isAtHome("192.168.1.5") == true){
			?>
			<img src="img/Maria.jpg"/>
			<br />
			<br />
			<span class="present">Présente</span>
			<?php
			}
			else{
			?>
			<img src="img/MariaAway.jpg"/>
			<br />
			<br />
			<span class="away">Absente</span>
			<?php
			}
			?>
		</p>
	</div>
	
	<div class="grid_2">
	<p style="text-align: center;">
	<span class="contenu">Mathilde</span>
	<br />
			<?php
			if (isAtHome("192.168.1.22") == true){
			?>
			<img src="img/Mathilde.jpg"/>
			<br />
			<br />
			<span class="present">Présente</span>
			<?php
			}
			else{
			?>
			<img src="img/MathildeAway.jpg"/>
			<br />
			<br />
			<span class="away">Absente</span>
			<?php
			}
			?>
		</p>
  </div>
  
  <div class="grid_2 suffix_1">
    <p style="text-align: center;">
	<span class="contenu">Paul</span>
	<br />
			<?php
			if (isAtHome("10.99.4.39") == true){
			exec("sudo python /var/www/LEDOn.py");
			?>
			<img src="img/Paul.jpg"/>
			<br />
			<br />
			<span class="present">Présent</span>
			<?php
			}
			else{
			exec("sudo python /var/www/LEDOff.py");
			?>
			<img src="img/PaulAway.jpg"/>
			<br />
			<br />
			<span class="away">Absent</span>
			<?php
			}
			?>
		</p>
  </div>
  
	<div class="clear"></div>
	
	<div class="grid_4 prefix_1 suffix_6">
    <h3 id="coords">Amis du Kot</h3>
  </div>
  
  <div class="grid_1" style="display:none;">
		<p>
			<!-- tous les "Remonter" sont en class no-print afin de ne pas s'afficher lors de l'impression -->
			<a class="gotop no-print" href="#" title="Remonter en haut de la page">Remonter</a>
		</p>
	</div>
  
  <div class="clear"></div>
  
  <!-- Amis -->
  <div class="grid_2 prefix_1">
   <p style="text-align: center;">
	<span class="contenu">Nicolas</span>
	<br />
			<?php
			if (isAtHome("192.168.1.33") == true){
			?>
			<img src="img/Nicolas.jpg"/>
			<br />
			<br />
			<span class="present">Présent</span>
			<?php
			}
			else{
			?>
			<img src="img/NicolasAway.jpg"/>
			<br />
			<br />
			<span class="away">Absent</span>
			<?php
			}
			?>
		</p>
  </div>
  
  <div class="grid_2">
   <p style="text-align: center;">
	<span class="contenu">Emir</span>
	<br />
			<?php
			if (isAtHome("192.168.1.25") == true){
			?>
			<img src="img/Emir.jpg"/>
			<br />
			<br />
			<span class="present">Présent</span>
			<?php
			}
			else{
			?>
			<img src="img/EmirAway.jpg"/>
			<br />
			<br />
			<span class="away">Absent</span>
			<?php
			}
			?>
		</p>
  </div>
  
  
	<!-- Séparateur -->
	<div class="grid_10 prefix_1 suffix_1">
		<hr />
	</div>
	<div class="clear"></div>
	<!-- Fin coordonnées -->
	
	<div class="grid_6 prefix_3 suffix_3 centered no-print">
		<p>
		&copy; 2013 <a href="mailto:paul.debuck@me.com" title="Envoyer un email à Paul De Buck">Paul De Buck</a>, tous droits réservés &dash; Réalisé en HTML5 & CSS3 avec <a href="http://960.gs/" title="960 Grid System">960 Grid System</a>.
		</p>
	</div>
	
  <div class="clear"></div>
</div>
</body>
</html>
