<?php require_once 'INC/includes.php';
if(User::islog($DB)){
	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$validate =true;
		if(empty($_POST['email'])){
		$erreur_email = "Veuillez indiquer votre email .";
		$validate = false;
		}elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
				$erreur_email = "Adresse Email non valide !";
				$validate = false;
			}else{
				$email = $_POST['email'];
			}
		
		if(empty($_POST['password'])){
			$password= $_SESSION['user']['password'];
		}elseif(empty($_POST['confirm_password'])){
				$erreur_Cpassword = "Confirmer votre mot de passe!";
				$validate = false;
			}elseif($_POST['confirm_password'] != $_POST['password']){
					$erreur_Cpassword = "Le mot de passe et le mot de passe de confirmation sont différents ";
					$validate = false;
			}else{
				$password=User::hashPassword($_POST['password']);
			}

		if(!empty($_FILES['avatar']['name']) && $validate){
			$extensions = array('.png','.gif','.jpg','.jpeg');
			$extension = strrchr($_FILES['avatar']['name'], '.');

			$dossier =UPLOAD;
			if(!in_array($extension,$extensions)){
				$erreur_avatar = "Vous devez uploader une image de type png, jpg, gif ,jpeg";
				$validate = false;
			}else{
				$avatar = $dossier.md5($_FILES['avatar']['name'])."$extension";
				if(!move_uploaded_file($_FILES['avatar']['tmp_name'],$avatar)){
					$validate = false;
					$_SESSION['erreur'] = "Un problème est survenu lors de l'Upload de l'image.";
				}
			}
		}else{
			$avatar = $_SESSION['user']['avatar'];	
		}
		if(!empty($_POST['name']))
			$name= $_POST['name'];
		else 
			$name = $_SESSION['user']['name'];

		if(!empty($_POST['prenom']))
			$prenom= $_POST['prenom'];
		else 
			$prenom = $_SESSION['user']['prenom'];

		if(!empty($_POST['bio']))
			$bio= $_POST['bio'];
		else 
			$bio = $_SESSION['user']['bio'];

		if($validate){
			$data = array(
				'id'=>$_SESSION['user']['id'],
				'name'=>$name,
				'prenom'=>$prenom,
				'email'=>$email,
				'bio'=>$bio,
				'password'=>$password,
				'avatar'=>$avatar
				);

			$nb= $DB->insert("UPDATE users SET name=:name,prenom=:prenom,email=:email,password=:password,bio=:bio,avatar=:avatar,updated_at=NOW() WHERE id=:id",$data);
			if($nb){
				$_SESSION['message'] = "Votre profil à été mis à jour avec succès .";
				$_SESSION['user'] = array_merge($_SESSION['user'],$data);
			}else{
				$_SESSION['erreur'] = "Un problème de sauvegarde avec votre profil";
			}
			header('location:compte.php');
			exit();
		}

	}
}else{
		header('location:login.php');
		$_SESSION['erreur'] = "Espace réservé aux membres connectés";
		exit();
	}
include 'INC/header.php';?>
<!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	
		<!-- <div id="content"> -->
			<div class="single">
			<div class="article">
				<div class="thumbnail"><img  src="<?php echo $_SESSION['user']['avatar']; ?>" alt="<?php echo $_SESSION['user']['username']; ?>" title="<?php echo $_SESSION['user']['username']; ?>" /></div>
				<div class="infos" >
					<h2>Bienvenue, <?php echo $_SESSION['user']['username']; ?></h2>
						<p class="posted">Inscrit depuis le <?php echo Texte::french_date($_SESSION['user']['created_at']); ?>	
							</p>
						<p class="posted">Username : <?php echo $_SESSION['user']['username']; ?></p>
						
				</div>
				
			</div>
				<div class="clearfix">
					</div>
				<h2 id="commentaires">Modifier vos informations </h2>	
				<div class="commentaires">

					<!-- Message dans la session -->
				  	<?php if (isset($_SESSION['message'])): ?>
				    <div class="alert_success"> <?php echo $_SESSION['message']; ?></div>
				    <?php unset( $_SESSION['message']); ?>
				  	<?php endif ?>
				   	<?php if (isset($_SESSION['erreur'])): ?>
				    <div class="alert_error"> <?php echo $_SESSION['erreur']; ?></div>
				    <?php unset( $_SESSION['erreur']); ?>
				  	<?php endif ?>


					<form action="profil.php" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $_SESSION['user']['id'] ?>">

						<p>
							<label for="name">name </label>
							<input type="text" name="name" value="<?php  echo isset($_POST['name'])?$_POST['name']:$_SESSION['user']['name']; ?>">
						</p>
						<?php if (!empty($erreur_name)): ?>
							<div class="error"><?php echo $erreur_name; ?></div>
						<?php endif ?>
						<p>
							<label for="premnom">Prénom </label>
							<input type="text" name="prenom" value="<?php echo isset($_POST['prenom'])?$_POST['prenom']:$_SESSION['user']['prenom'];  ?>" >
						</p>
						<?php if (!empty($erreur_premnom)): ?>
							<div class="error"><?php echo $erreur_premnom; ?></div>
						<?php endif ?>
						<p>
							<label for="email">Email </label>
							<input type="text" name="email" value="<?php  echo isset($_POST['email'])?$_POST['email']:$_SESSION['user']['email']; ?>">
						</p>
						<?php if (!empty($erreur_email)): ?>
							<div class="error"><?php echo $erreur_email; ?></div>
						<?php endif ?>
						<p>
						<label for="password">Mot de passe </label>
						<input type="password" name="password">
						</p>
						<?php if (!empty($erreur_password)): ?>
							<div class="error"><?php echo $erreur_password; ?></div>
						<?php endif ?>
						<p>
							<label for="confirm_password">Confirmation du mot de passe </label>
							<input type="password" name="confirm_password">
						</p>
						<?php if (!empty($erreur_Cpassword)): ?>
							<div class="error"><?php echo $erreur_Cpassword; ?></div>
						<?php endif ?>
						<p>
							<label for="bio">Votre Bio </label>
							<textarea name="bio"  cols="30" rows="10"><?php echo isset($_POST['bio'])?$_POST['bio']:$_SESSION['user']['bio'];?></textarea>
						</p>
						<?php if (!empty($erreur_bio)): ?>
							<div class="error"><?php echo $erreur_bio; ?></div>
						<?php endif ?>

						<p>
							<label for="avatar">avatar </label>
							<input type="file" name="avatar" >
						</p>
						<?php if (!empty($erreur_avatar)): ?>
							<div class="error"><?php echo $erreur_avatar; ?></div>
						<?php endif ?>
						<p>
							<input type="submit" value="Envoyer">
						</p>
					</form>
					
				</div>
			</div>

	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>