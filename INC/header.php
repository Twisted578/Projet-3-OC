<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Billet simple pour l'Alaska</title>
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/main.css">
<!-- nivo slider  -->
  <link rel="stylesheet" href="js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
</head>

<body>
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->		
<div class="wrap">
	<!-- NAVIGATION -->		
	<div id="nav"> 
    <div class="container clearfix">

		<!-- MENU -->		
		<div id="navigation">
				<ul id="menu" class="menu">
					<li ><a href="index.php">Accueil</a></li>
					<li ><a href="articles.php">Livre</a></li>
					<li ><a href="contact.php">Contact</a></li>
					
				</ul>	

				<div class="membres">
					<ul>
						<?php if (User::auth()): ?>
							<li><a href="login.php?logout">Se déconnecter</a></li>
							<li><a href="compte.php">Mon compte</a></li>
							<?php if (User::isadmin($DB)): ?>
								<li><a href="admin/">Administration</a></li>
							<?php else: ?>
							<?php endif ?>
						<?php else: ?>
							<li><a href="login.php">Se connecter</a></li>
							<li><a href="signup.php">S'inscrire</a></li>
						<?php endif ?>
					</ul>
				</div>		
	
		</div> <!-- #navigation -->

		<div id="search">
			
			<form method="get" id="searchform" action="search.php">
				<div>
					<input type="text" value="Chercher" name="q" id="q" onfocus="if (this.value == 'Chercher') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Chercher';}" />
					<input type="submit" id="searchsubmit" value="Go" />
				</div>
			</form>
		</div> <!--#search -->

    </div> <!-- container -->
	</div> <!--#nav -->

	<!-- HEADER -->
	<header>
	    <div class="container clearfix">

			<div id="logo">
				<a href="index.php" title="Mon blog"><img  src="img/logo4.png" alt="Mon blog" /></a>
			</div>
			<div id="reseaux">
				<ul>
					<li><a href="#" class="fb"></a></li>
					<li><a href="#" class="tt"></a></li>
					<li><a href="#" class="gg"></a></li>
					<li><a href="#" class="yt"></a></li>
				</ul>
			</div>		
	    </div> <!-- container -->
	</header>