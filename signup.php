<?php 

include 'INC/includes.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$validate = true;

	if (empty($_POST['pseudo'])) {
		$erreur_pseudo = "Veuillez entrer un pseudo.";
		$validate = false;
	}elseif (!User::pseudo_unique($DB,$_POST['pseudo'])) {
		$erreur_pseudo = "Ce pseudo est déjà utilisé .";
		$validate = false;
	}

	if (empty($_POST['email'])) {
		$erreur_email = "Veuillez entrer une adresse Email .";
		$validate = false;
	}elseif (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
		$erreur_email = "Cette adresse Email est non valide .";
		$validate = false;
		}elseif (!User::email_unique($DB,$_POST['email'])) {
			$erreur_email = "Cette adresse Email est déjà utilisée .";
			$validate = false;
		}

	if (empty($_POST['password'])) {
		$erreur_password = "Veuillez entrer un mot de passe .";
		$validate = false;
	}elseif (empty($_POST['confirm_password'])) {
		$erreur_confirm_password = "Confirmer votre mot de passe .";
		$validate = false;
	}elseif ($_POST['confirm_password'] != $_POST['password']) {
		$erreur_confirm_password = "Les deux mots de passe ne sont pas identiques .";
		$validate = false;
	}

	if ($validate) {
		$token = sha1(uniqid(rand()));

		$data = array(
			'username' => htmlspecialchars($_POST['pseudo']),
			'email' => htmlspecialchars($_POST['email']),
			'password' => User::hashPassword($_POST['password']),
			'token' => $token
			);
		$rep = $DB -> insert('INSERT INTO users (username,email,password,token,created_at,updated_at) VALUES (:username,:email,:password,:token,NOW(),NOW())',$data);

		if ($rep) {
				$_SESSION['message'] = "Bravo votre compte à bien été crée .";
		}else{
			$_SESSION['erreur'] = "Un problème est survenu lors de l'enregistrement de votre compte, Veuillez réessayer ultérieurement .";
		}
	}

}



include 'INC/header.php';

?>

<!-- Corps de la page -->
<div id="page">
	<div id="contenuPage" class="container clearfix">
		<div class="single">
				<!-- indicateur de session -->
    		<?php if (isset($_SESSION['message'])): ?>
    			<div class="alert_success"><?php echo $_SESSION['message']; ?></div>
    			<?php unset($_SESSION['message']); ?>
    		<?php endif ?>

    		<?php if (isset($_SESSION['erreur'])): ?>
    			<div class="alert_error"><?php echo $_SESSION['message']; ?></div>
    			<?php unset($_SESSION['erreur']); ?>
    		<?php endif ?>

			<form action="signup.php" id="contact" class="contact clearfix" method="POST">

				<h2>Inscription</h2>
				<p>
					<label for="pseudo">Pseudo</label>
					<input type="text" name="pseudo" value="<?php echo isset($_POST['pseudo'])?$_POST['pseudo']:''; ?>">
				</p>
				<?php if (!empty($erreur_pseudo)) :?>
					<div class="error"><?php echo $erreur_pseudo; ?></div>
				<?php endif ?>
				<p>
					<label for="email">Email</label>
					<input type="text" name="email" value="<?php echo isset($_POST['email'])?$_POST['email']:''; ?>">
				</p>
				<?php if (!empty($erreur_email)) :?>
					<div class="error"><?php echo $erreur_email; ?></div>
				<?php endif ?>
				<p>
					<label for="password">Mot de passe</label>
					<input type="password" name="password">
				</p>
				<?php if (!empty($erreur_password)) :?>
					<div class="error"><?php echo $erreur_password; ?></div>
				<?php endif ?>
				<p>
					<label for="confirm_password">Confirmer votre mot de passe</label>
					<input type="password" name="confirm_password">
				</p>
				<?php if (!empty($erreur_confirm_password)) :?>
					<div class="error"><?php echo $erreur_confirm_password; ?></div>
				<?php endif ?>
				<input type="submit" name="S'inscrire">
			</form>
			
		</div>
		
	</div>	
</div>
<?php include 'INC/footer.php'; ?>