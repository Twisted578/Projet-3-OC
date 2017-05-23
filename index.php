<?php

include 'INC/includes.php';

include 'INC/header.php';

ini_set('display_errors',1); 
?>

<!-- PRESENTATION -->
<div id="presentation">
	<div  class="container presentation clearfix">		     
		<!-- SLIDER -->
		<div class="slider-wrapper theme-default">				
				  <div id="slider" class="nivoSlider">				
											
						<a href="">
							<img src="img/alaska1.jpg" alt="" /></a>
					
											
						<a href="">
							<img src="img/alaska2.jpg" alt=""/></a>
					
											
						<a href="">
							<img  src="img/alaska3.jpg" alt=""  /></a>

				</div>
		</div>
	</div> <!-- container-->
</div> <!-- presentation -->

<!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	
			<div class="accueil">
				<h2>Bienvenue,</h2>
				<p>
                    Bonjour, je m'appelle Jean Forteroche et je suis acteur et écrivain. J'écris essentiellement des livres qui parlent de mes voyages en tant qu'acteur et comme vous pouvez le constater, j'ai tourné mon dernier film en Alaska dont le titre de mon livre.
                </p>
                <p>
                Cela fait 20 ans que je fais ces deux métier et aujourd'hui j'ai envie de vous faire partager mon expérience à travers un livre totalement en ligne qui je l'espère plairont au plus grand nombres d'entre vous. 
                </p>
                <h3>
                	<strong>Je vous laisse donc suivre mon incroyable voyage et bonne lecture !</strong>
                </h3>
                </br>
                </br>
			</div>
			<section class="lastArticles boxArticles">
			<?php include 'INC/lastPosts.php'; ?>
			</section>
			<section class="lastComments boxComments">
				<?php include 'INC/lastComments.php'; ?>
			</section>
			<div class="clearfix"></div>
			<div class="accueil">
				<h3>Les 6 raisons qui m'ont poussé à faire ces deux métiers !</h3>
				<ul>
					<li><strong>Voyager :</strong></br>Oui j'adore voyager et découvrir des paysages absolument majesteux à travers le monde.</li>
					<li><strong>Rencontrer :</strong></br>Dans le cadre de mon travail j'ai la chance de rencontrer des gens de différentes cultures.</li>
					<li><strong>Progresser :</strong></br>Après 10 ans de voyage à travers le monde j'ai une très bonne maîtrise de l'anglais aujour'd'hui.</li>
					<li><strong>Apprendre :</strong></br>Dans ce genre de métier on ne cesse jamais d'apprendre et pour quelqu'un qui à soif de savoir c'est le graal.</li>
					<li><strong>Vivre :</strong></br>Depuis 10 ans je vis une expérience inpensable et je suis conscient de la chance que j'ai.</li>
					<li><strong>Transmettre :</strong></br>A travers mes livres je peux transmettre tout l'apprentissage d'une passé à voyager dans le monde.</li>
				</ul>
			</div>
			

	</div> <!-- contenuPage -->
</div> <!-- #page -->

<?php 

include 'INC/footer.php';

?>
