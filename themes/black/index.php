<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $galerie->titre; ?></title>

<?php $galerie->js(); ?>

<link rel="stylesheet" type="text/css" href="themes/black/style.css" />
<?php $galerie->css(); ?>
<style type="text/css">
#images li img {
	max-height:<?php echo $galerie->hmin; ?>px;
}
</style>

</head>

<body>

<div id="menu">
	<ul>
        <?php $galerie->dossier_ant("<li id='return'>","<img rel='nozoom' src='themes/black/up.png' />","</li>"); ?>
		<?php $galerie->dossiers("<li>", "</li>"); ?>
	</ul>
</div>

<div id="content">

	<ul id="images">
		<?php $galerie->images("<li>", "</li>"); ?>
	</ul>
    
</div>


<div id="footer">
	Propuls&eacute; par <a href="https://github.com/Passific/Photis">Photis</a>
</div>

</body>
</html>