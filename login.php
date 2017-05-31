<?php 
require_once 'INC/includes.php';

if(isset($_GET['logout'])){
	if(isset($_SESSION['user'])){
		unset($_SESSION['user']);
	}

	if(isset($_SESSION['token'])){
		unset($_SESSION['token']);
	}

	if(isset($_SESSION['token_uncrypted'])){
		unset($_SESSION['token_uncrypted']);
	}

	$_SESSION['authentificated'] = false;
	$_SESSION['message'] = "A bientôt, Vous êtes maintenant déconnecté.";
	header('location:index.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(!empty($_POST['password']) && !empty($_POST['email'])){
		$email =$_POST['email'];
		$password = User::hashPassword($_POST['password']);

		$data = array(
			'email'=>$email,
			'password'=>$password
			);

		$req = $DB->tquery('SELECT * FROM  users WHERE email=:email AND password=:password LIMIT 1',$data);
		if(!empty($req)){
			if($req[0]['active'] == 1){
				session_name('mon_site');
				$_SESSION['user'] = $req[0];
				 $_SESSION['user']['role'] = User::hashPassword($_SESSION['user']['role']);
				$_SESSION['authentificated'] = true;
				$_SESSION['token_uncrypted']=uniqid();
				$_SESSION['token'] = User::hashPassword($_SESSION['token_uncrypted']);

				$_SESSION['message'] = "Bienvenue, Vous êtes maintenant connecté.";

				$n= $DB->insert('UPDATE users SET last_login=NOW() WHERE email=:email',array('email'=>$email));

				header('location:index.php');
				exit();
			}else{
				$_SESSION['erreur'] = "Compte user non Actif,Veuillez vérifier votre messagerie ...";
			}
		}else{
			$_SESSION['erreur'] = "Votre email et/ou mot de passe sont invcorrect";
		}
	}else{
		if(empty($_POST['password'])){
			 $erreur_password = "Un mot de passe est requis.";
		}

		if(empty($_POST['email'])){
			 $erreur_email = "Une adresse email est requise !.";
		}
		$_SESSION['erreur'] = "Veuillez entrer votre email et votre mot de passe ";
	}
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
			
			<form action="login.php" id="contact" class="contact clearfix" method="POST">

				<h2>Connexion</h2>
						<p>
							<label for="email">Email </label>
							<input type="text" name="email" value="<?php echo isset($_POST['email'])?$_POST['email']:''; ?>">
						</p>
						<?php if(!empty($erreur_email)) :?>
							<div class="error"> <?php echo $erreur_email; ?></div>
						<?php endif ?>

						<p>
							<label for="password">password </label>
							<input type="password" name="password" >
						</p>
						<?php if(!empty($erreur_password)) :?>
							<div class="error"> <?php echo $erreur_password; ?></div>
						<?php endif ?>
						<span> <a href="password.php">Mot de passe oublié ?</a></span>
						<p>
							<input type="submit" value="S'inscrire">
						</p>
			</form>
			</div>




	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>