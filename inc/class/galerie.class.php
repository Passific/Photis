<?php

class Galerie
{
	public $url;
	public $dossier;
	public $titre;
	public $turl;
	public $afurl;
	public $oaff;
	public $amin;
	public $hmin;
	public $theme;
	public $effeta;
	public $effetd;
	
	public function __construct()
	{
		include("config.php");
		$this->url = str_replace("index.php", "", $_SERVER['PHP_SELF']);
		if(@$_GET['dir'] == "")
		{
			$this->dossier = "galerie";
		}
		else
		{
			$this->dossier = str_replace("-", "/",$_GET['dir']);
		}
		
		$this->titre = $titre_site;
		$this->theme = $theme;
		$this->oaff = $oaff;
		$this->amin = $amin;
		$this->hmin = $hmin;
		$this->turl = $turl;
		$this->option_folder = $option_folder;
		
		if($this->turl == "0")
		{
			$this->afurl = "?dir=";
		}
		elseif($this->turl == "1")
		{
			$this->afurl = "";
		}
		
		switch($effeta)
		{
			case "0":
				$this->effeta = "'transitionIn' : 'none',\n'transitionOut' : 'none',";
				break;
			case "1":
				$this->effeta = "";
				break;
			case "2":
				$this->effeta = "'transitionIn' : 'elastic',\n'transitionOut' : 'elastic',";
				break;
			default: // 3
				$this->effeta = "'opacity' : true,\n'transitionIn' : 'elastic',\n'transitionOut' : 'elastic',";
				break;
		}
		
		switch($effetd)
		{
			case "0":
				$this->effetd = "0";
				break;
			case "1":
				$this->effetd = "";
				break;
			case "2":
				$this->effetd = "'titlePosition' : 'inside',";
				break;
			default: // 3
				$this->effetd = "'titlePosition' : 'over',";
				break;
		}
	}
	
	
	// Fonctions enlevant les accents
	// Depuis la version 1.4.0
	public function desaccents($string)
	{
		$string = utf8_encode($string);
		$string = str_replace(array("à","â","ä"), "a", $string);
		$string = str_replace(array("é","è","ê","ë"), "e", $string);
		$string = str_replace(array("î","ï"), "i", $string);
		$string = str_replace(array("ô","ö"), "o", $string);
		$string = str_replace(array("ù","û","ü"), "u", $string);
		$string = str_replace("ç", "c", $string);
		$string = str_replace("'", "", $string);
		return $string;
	}
	
	// Fonctions creant une url
	// Depuis la version 1.4.0
	public function maurl($string)
	{
		$string = strtolower($string);
		$string = $this->desaccents($string);
		$string = str_replace(" ", "-", $string);
		return $string;
	}
	
	// Inclut les fichiers javascript necessaires a photis
	// Depuis la version 1.0 - Modifié version 1.4.0
	public function js()
	{
		echo '<script type="text/javascript" src="inc/js/jquery-1.6.2.js"></script>
	<script type="text/javascript" src="inc/js/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="inc/js/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("a[rel=photis_group]").fancybox({
				\'padding\'	: \'0\',
				\'overlayColor\' : \'#111\',';
				echo $this->effeta;
				if($this->effetd != "0") { echo $this->effetd; }
				echo '
			});
		});
	</script>'."\n";
	}
	
	// Inclut les fichiers css necessaires a photis
	// Depuis la version 1.4.0
	public function css()
	{
		echo'	<link rel="stylesheet" type="text/css" href="inc/css/fancybox-1.3.4.css" media="screen" />'."\n";
	}

	// Inclut les fonctions dans la balise body
	// Depuis la version 1.0 - LEGACY : Retiré depuis la version 1.4.0
	public function body()
	{
		return '';
	}
	
	// Affichage de la liste des dossiers
	// Depuis la version 1.0 - Modifié version 1.3.1
	// Moded by Pasific
	public function dossiers($avant="", $apres="")
	{
		$dir = $this->dossier;
		if(@$dossier = opendir($dir))
		{
			while($fichier = readdir($dossier))
			{
				$lien = $fichier;
				if($this->test_dossier($lien))
				{
					if($this->dossier == "galerie")
					{
						$url = $this->afurl . "galerie-$fichier";
					}
					else
					{
						$url = $this->url . $this->afurl . str_replace("/", "-", $this->dossier ) . "-$fichier";
					}
					
					if($this->option_folder == "0")
					{
						echo $avant . "<a href='$url'>$fichier</a>" . $apres . "\n";
					}
					elseif($this->option_folder == "1")
					{
						echo $avant . "<a href='$url'><div id='folder'>$fichier</div><div>";
						echo '<img id="icon" src="';
						
						$foldericon = $this->dossier."/".$fichier."/foldericon.png";
						if(file_exists($foldericon)==true)
						{
							echo $this->dossier."/".$fichier;
						}
						else
						{
							echo "themes/".$this->theme."";
						}
						echo '/foldericon.png"></div></a>'. $apres. "\n";
					}
				}
			}
		}
	}
	
	// Retourne le dossier inferieur a celui visite
	// Depuis la version 1.0 - Modifié version 1.1
	public function dossier_ant($avant="", $contenu="", $apres="")
	{
		if($this->dossier != "galerie")
		{
			$dossiers = explode("/", $this->dossier ."/");
			$nbd = count($dossiers);
			$i = "0";
			$url = "";
			while($i < ($nbd - 2))
			{
				$url .=  $dossiers[$i] . "-";
				$i++;
			}
			$final = substr($url, 0, -1);
			if($final == "galerie")
			{
				if($avant!="" && $contenu!="" && $apres!="")
				{
					echo $avant . "<a href='". $this->url ."'>" . $contenu . "</a>" . $apres;
				} else
				{
					return $url_site;
				}
			}
			else
			{
				if($avant!="" && $contenu!="" && $apres!="")
				{
					echo $avant . "<a href='". $this->afurl . $final ."'>" . $contenu . "</a>" . $apres;
				}
				else
				{
					return $final;
				}
			}
		}
	}
	
	// Voir si fichier est un dossier
	// Depuis la version 1.0 - Modifié version 1.3.2
	// Moded by Pasific
	public function test_dossier($dossier)
	{
		if($dossier != "." && $dossier != ".." && !preg_match("/Thumbs.db/",$dossier) && $dossier!="index.html" && !preg_match("#.jpg$#i",$dossier) && !preg_match("#.jpeg$#i",$dossier) && !preg_match("#.png$#i",$dossier) && !preg_match("#.gif$#i",$dossier))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// Test pour savoir si le fichier est une image
	// Depuis la version 1.0 - Modifié version 1.3.1
	// Moded by Pasific
	public function test_image($fichier)
	{
		if(!preg_match("/foldericon.png/",$fichier) && (preg_match("#.jpg$#i",$fichier) || preg_match("#.jpeg$#i",$fichier) || preg_match("#.png$#i",$fichier) || preg_match("#.gif$#i",$fichier)))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// Affichage de la liste des images du dossier selectionne
	// Depuis la version 1.0 - Modifié version 1.4.1
	// Moded by Pasific
	public function images($avant, $apres)
	{
		if(@$dos = opendir($this->dossier))
		{
			if($this->amin == "1")
			{
				$dossiers = explode("/", $this->dossier);
				$ids = "0";
				$ant = "";
				while($ids < count($dossiers))
				{
					if(!is_dir("thumb/".$ant."/".strtolower($dossiers[$ids])))
					{
						mkdir("thumb/".$ant."/".strtolower($dossiers[$ids]));
					}
					$ant = strtolower($ant . "/". $dossiers[$ids]);
					$ids++;
				}
			}
			$i=0;
			while($fichier = readdir($dos))
			{       
				if($this->test_image($fichier))
				{
					$liens[$fichier] = $this->dossier;
					$i++;
				}
			}
			if($i==0)
			{
				if($this->dossier != "galerie")
				{
					echo $avant . "<div id='erreur'>Il n'y a pas d'images dans ce dossier !</div>" . $apres . "\n";
				}
			}
			else
			{
				if($this->oaff == "1")
				{
					ksort($liens);
				}
				elseif($this->oaff == "2")
				{
					krsort($liens); 
				} 
				foreach ($liens as $fichier => $this->dossier)
				{
					$lien = $this->dossier . '/' . utf8_encode($fichier);
					echo $avant . "<a rel=\"photis_group\" "; 
					if($this->effetd != "0")
					{
						echo "title=\"".$this->nom(utf8_encode($fichier))."\" ";
					}
					echo "href=\"$lien\">";
					if($this->amin == "1")
					{
						include("thumb/image.php");
					}
					else
					{
						echo "<img src=\"$lien\" />";
					}
					echo"</a>" . $apres . "\n";
				}
			}
		}
		else
		{
			echo $avant . "<div id='erreur'>Ce dossier n'existe pas !</div>" . $apres . "\n";
		}
	}
	
	// Recuperation du nom de l'image
	// Depusi la version 1.0
	public function nom($fichier)
	{
		if(strrpos($fichier, ".")===false)
		{
			return $fichier;
		}
		else
		{
			return substr($fichier, 0, strrpos($fichier, "."));
		}
	}
}

?>