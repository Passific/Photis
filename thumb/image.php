<?php

if(preg_match("/image.php/i", $_SERVER['PHP_SELF'])) { echo "Vous ne pouvez pas acceder directement &agrave; cette page !"; exit(); }
	
$lien = utf8_decode($lien);
$thumb = $this->maurl($lien);

if(!file_exists("thumb/$thumb")) {				
	image::ResizeImage($lien, "thumb/".$thumb, 0, $this->hmin);
} else {
	$dimm = getimagesize("thumb/$thumb");
	if($dimm[1] != $this->hmin) {
		image::ResizeImage($lien, "thumb/".$thumb, 0, $this->hmin);
	}
}

echo "<img src=\"thumb/$thumb\" />";

?>