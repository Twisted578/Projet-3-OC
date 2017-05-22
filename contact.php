<?php

include 'INC/includes.php';

include 'INC/header.php';

?>

<!-- PRESENTATION -->
<div id="presentation">
	<div  class="container presentation clearfix">		     
		<!-- Carte Google -->
		<iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=95150+taverny&amp;aq=&amp;sll=46.75984,1.738281&amp;sspn=16.819874,20.324707&amp;ie=UTF8&amp;hq=&amp;t=m&amp;ll=49.027457,2.22353&amp;spn=0.01407,0.073814&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
	</div> <!-- container-->
</div> <!-- presentation -->

<!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	
			<div class="accueil">
				<h2>Pour me contacter,</h2>
				<p>Il suffit de remplir le formulaire ci-dessous et je me ferais une joie de vous répondre 
				   pour n'importe quelle question, qu'elle traite sur mon livre ou bien sur mes voyages.</br>
				   N'hésitez pas aussi à lire mon livre que je mettrais à jour régulièrement.</p>
			</div>
			<section class="lastArticles boxArticles">
				<form action="contact.html" id="contact" method="post">
					<p>
						<label for="nom">Nom : </label>
						<input type="text" name="nom" >
					</p>
					<p>
						<label for="email">Email : </label>
						<input type="email" name="email" >
					</p>
					<p>
						<label for="sujet">Sujet : </label>
						<input type="text" name="sujet" >
					</p>
					<p>
						<label for="message">Message : </label>
						<textarea name="message" > </textarea>
					</p>
					<p>
						<input type="submit" value="Envoyer" >
					</p>
				</form>
			</section>
			
			<div class="clearfix"></div>
			
			

	</div> <!-- contenuPage -->
</div> <!-- #page -->

<?php 

include 'INC/footer.php';

?>
