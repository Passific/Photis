<?php

// Photis 1.5.0
// Date : 03/07/2013
// Licence Creative Commons 2.0 Fr
// http://creativecommons.org/licenses/by-nc-nd/2.0/fr/
//
// Fichier de configuration
// Vous pouvez l'éditer à volonter

/*** Titre du site affiché ***/

$titre_site = "Ma Gallerie sous Photis";


/*** Theme affiché ***/

$theme = "defaut";


/*** Type d'URL ***/

// 0 = Aucune réecriture d'url (Ex : index.php?dir=galerie/Paysages)
// 1 = Réecriture via htaaccess (Ex : /galerie-Paysages)
$turl = "1";


/*** Ordre d'affichage ***/

// 0 = Ordre naturel, dépend du serveur
// 1 = Ordre croissant
// 2 = Ordre décroissant
$oaff = "1";


/*** Miniatures ***/

// Activer les miniatures (nécessite GDLIB PHP sur le serveur)
// 0 = Pas de miniatures
// 1 = Miniatures actives
$amin = "1";

// Hauteur (max) miniature (en pixels)
// 150 par défaut
$hmin = "175";

/*** Foldericon ***/

// Permet d'afficher une icone pour les dossier
// 0 = pas d'icone pour les dossiers
// 1 = icone pour les dossiers activé
$option_folder = "0";

/*** Options visuelles (Javascript) ***/

// Effet d'affichage de la photo
// 0 = aucun effet, 1 = effet par defaut, 2 = effet elastique, 3 = effet fondu + elastique
$effeta = "3";

// Affichage de la description de la photo
// 0 = aucune description, 1 = par defaut, 2 = type 'polaroid', 3 = Black Over
$effetd = "3";

?>