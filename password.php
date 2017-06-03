 <?php 
 include 'INC/includes.php';
 
 if($_SERVER['REQUEST_METHOD'] == "POST"){
 	if(!empty($_POST['email'])){
 		if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
			$erreur_email = "Adresse Email non valide !";
		}else{
			$email = $_POST['email'];
			$req = $DB->tquery("SELECT * FROM users WHERE email=:email LIMIT 1",array('email'=>$email));
			if(!empty($req)){
					$password = Texte::generer(8);

					$to      = $email;
				    $subject = 'Réinitialisation du mot de passe';
				    $message = "Bonjour ,<br/> Vous avez fait une demande de changement de mot de pass sur notre site ,voici le nouveau mot de passe: ".$password."<br/>
								pensez à changer votre mot de passe pour éviter de l'oublier.<br/>  Equipe Site";
				    $headers = 'From: admin@guenole-lequentrec.ovh' . "\r\n" .
				    			'Reply-To: admin@guenole-lequentrec.ovh' . "\r\n" .
				    			'X-Mailer: PHP/' . phpversion();

					if(mail($to,$Subject,$message,$headers)){

						$pass=User::hashPassword($password);
						$sql ="UPDATE users SET password=:pass, updated_at=NOW() WHERE email=:email";
						$rep = $DB->insert($sql,array('email'=>$email,'pass'=>$pass));
						if($rep){
							$_SESSION['message'] = "Un nouveau mot de passe a été envoyé à votre messagerie avec des instructions .";
							unset($_POST);
							header('location:login.php');
							exit();
						}else{
							$_SESSION['erreur'] = "Un problème est survenu lors de l'envoi de votre email.";
						}
						
					}else{
						$_SESSION['erreur'] = "Un problème est survenu lors de la mise à jour de votre profil";
						
						}
				}
			}
		}
 	}else{
 		$erreur_email = "Adresse Email est requise !";
 	}

 include 'INC/header.php';?>
 <!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	
		<!-- <div id="content"> -->
			<div class="single">	
				<!--  message de la session -->
				<?php if (isset($_SESSION['message'])): ?>
					<div class="alert_success"><?php echo $_SESSION['message']; ?></div>
					<?php unset($_SESSION['message']); ?>
				<?php endif ?>

				<?php if (isset($_SESSION['erreur'])): ?>
					<div class="alert_error"><?php echo $_SESSION['erreur']; ?></div>
					<?php unset($_SESSION['erreur']); ?>
				<?php endif ?>
			
			<form action="password.php" id="contact" class="contact clearfix" method="POST">

				<h2>Mot de passe oublié</h2>
						<p>
							<label for="email">Email </label>
							<input type="text" name="email" >
						</p>
						<?php if(!empty($erreur_email)) :?>
							<div class="error"> <?php echo $erreur_email; ?></div>
						<?php endif ?>

						
						<p>
							<input type="submit" value="Envoyer">
						</p>
			</form>
			</div>




	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>