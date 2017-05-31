<?php 

include 'INC/includes.php';

if (!empty($_GET) && isset($_GET['token']) && isset($_GET['email'])) {
	$token = $_GET['token'];
	$email = $_GET['email'];

	$q = array(
		'token' => $token,
		'email' => $email
		 );

	$reponse = $DB -> query('SELECT email,token FROM users WHERE email=:email AND token=:token',$q);

	if (!empty($reponse)) {
		$q = array(
		'active' => 1,
		'email' => $email
		 );
		$rep = $DB -> query('SELECT email,active FROM users WHERE email=:email AND active=:active',$q);

		if ($rep) {
			$_SESSION['erreur'] = 'Utilisateur déjà actif.';
		}else{
			$nb = $DB -> insert('UPDATE users SET active=:active WHERE email=:email',$q);
			if ($nb) {
				$_SESSION['message'] = 'Votre compte a été activé avec succès !';
			}else{
				$_SESSION['erreur'] = "Un problème est survenu lors de l'activation de votre compte";
			}
		}
	}else{
		$_SESSION['erreur'] = 'Utilisateur inconnu dans notre base de données !';
	}
}else{
	header('location:index.php');
 }

 include 'INC/header.php';
 ?>

<!-- PAGE -->
<div id="page">
	<div id="contenuPage" class="container clearfix">
		<div class="single">
			<!-- Indicateur session -->
			<?php if (isset($_SESSION['message'])): ?>
				<div class="alert_success"<?php echo $_SESSION['message']; ?>></div>
				<?php unset($_SESSION['message']); ?>
			<?php endif ?>

			<?php if (isset($_SESSION['erreur'])): ?>
				<div class="alert_error"<?php echo $_SESSION['erreur']; ?>></div>
				<?php unset($_SESSION['erreur']); ?>
			<?php endif ?>

			<p>
				<a href="index.php"></a> Retour à la page d'acceuil du site. </a>
			</p>
		</div>
	</div>
</div>

<?php include 'INC/footer.php'; ?>