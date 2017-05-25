<?php

include 'INC/includes.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$validate =true;

	if(empty($_POST['message'])){
			$erreur_message = "Veuillez entrer votre message";
			$validate = false;
		}elseif(strlen($_POST['message']) < 5){
				$erreur_message = "Le message doit contenir plus de 5 caractères .";
				$validate = false;
			}

	if(empty($_POST['nom'])){
		$erreur_nom = "Veuillez indiquer votre nom.";
		$validate = false;
	}

	if(empty($_POST['email'])){
		$erreur_email = "Veuillez indiquer votre email .";
		$validate = false;
	}elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
			$erreur_email = "Adresse Email non valide !";
			$validate = false;
		}

	if(empty($_POST['sujet'])){
		$erreur_sujet = "Veuillez indiquer votre sujet.";
		$validate = false;
	}

	if($validate){

		$mail_to= 'guenole578@gmail.com';
		$mail_Subject = "Sujet :".htmlspecialchars($_POST['sujet']);
		$headers = "From :".$_POST['email']."\n";
		$headers .="Reply-To: ".$_POST['email']."\n";
		$headers .="MIME-Vsersion: 1.0 \n";
		$headers .="Content-Transfer-Encoding: 8bit \n";
		$headers .="Content-type: text/html; charset=utf-8 \n";

		$mail_body = "Message d'un utilisateur :".htmlspecialchars(nl2br($_POST['message']));

		if(mail($mail_to,$mail_Subject,$mail_body,$headers)){
			$_SESSION['message'] = "Votre émail a bien été envoyé";
			unset($_POST);
		}else{
			$_SESSION['erreur'] = "Un problème est survenu lors de l'envoi de votre email.";
			
			}
	}

}

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

    <!-- indicateur de session -->
    		<?php if (isset($_SESSION['message'])): ?>
    			<div class="alert_success"><?php echo $_SESSION['message']; ?></div>
    			<?php unset($_SESSION['message']); ?>
    		<?php endif ?>

    		<?php if (isset($_SESSION['erreur'])): ?>
    			<div class="alert_error"><?php echo $_SESSION['message']; ?></div>
    			<?php unset($_SESSION['erreur']); ?>
    		<?php endif ?>

			<div class="accueil">
				<h2>Pour me contacter,</h2>
				<p>Il suffit de remplir le formulaire ci-dessous et je me ferais une joie de vous répondre 
				   pour n'importe quelle question, qu'elle traite sur mon livre ou bien sur mes voyages.</br>
				   N'hésitez pas aussi à lire mon livre que je mettrais à jour régulièrement.</p>
			</div>
			<section class="lastArticles boxArticles">
				<form action="contact.php" id="contact" method="post">
					<p>
						<label for="nom">Nom</label>
						<input type="text" name="nom" value="<?php echo isset($_POST['nom'])?$_POST['nom']:''; ?>">
					</p>
					<?php if (!empty($erreur_nom)): ?>
						<div class="error"><?php echo $error_nom; ?></div>
					<?php endif ?>
					<p>
						<label for="email">Email</label>
						<input type="text" name="email" value="<?php echo isset($_POST['email'])?$_POST['email']:''; ?>">
					</p>
					<?php if (!empty($erreur_email)): ?>
						<div class="error"><?php echo $error_email; ?></div>
					<?php endif ?>
					<p>
						<label for="sujet">Sujet</label>
						<input type="text" name="sujet" value="<?php echo isset($_POST['sujet'])?$_POST['sujet']:''; ?>">
					</p>
					<?php if (!empty($erreur_sujet)): ?>
						<div class="error"><?php echo $error_sujet; ?></div>
					<?php endif ?>
					<p>
						<label for="message">Message</label>
						<textarea name="message" id="" cols="30" rows="10"><?php echo isset($_POST['message'])?$_POST['message']:''; ?></textarea>
					</p>
					<?php if (!empty($erreur_message)): ?>
						<div class="error"><?php echo $error_message; ?></div>
					<?php endif ?>
					<p>
							<input type="submit" value="Envoyer">
					</p>
				</form>
			</section>
			
			<div class="clearfix"></div>
			
			

	</div> <!-- contenuPage -->
</div> <!-- #page -->

<?php 

include 'INC/footer.php';

?>
