<?php require_once 'INC/includes.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$id =intval($_POST['id']);
	$validate = true;
	if(isset($_POST['active'])){
		$active =1;
	}else{
		$active =0;
	}
	$data= array(
		'id' => $id,
		'username'=>$_POST['username'],
		'email'=>$_POST['email'],
		'name'=>$_POST['name'],
		'prenom'=>$_POST['prenom'],
		'role'=>$_POST['role'],
		'bio'=>$_POST['bio'],
		'active'=>$active,
		'avatar'=>$_POST['avatar_old']
		);
	if(empty($_POST['username'])){
		$validate =false ;
		$erreur_username = "Veuillez entrer le login de l'utilisateur";
	}
	if(empty($_POST['email'])){
		$validate =false ;
		$erreur_email = "Veuillez entrer l' email de l'utilisateur";
	}

	if(!empty($_FILES['avatar']['name']) && $validate){
			$extensions = array('.png','.gif','.jpg','.jpeg');
			$extension = strrchr($_FILES['avatar']['name'], '.');

			$dossier =UPLOAD;
			if(!in_array($extension,$extensions)){
				$erreur_avatar = "Vous devez uploader une avatar de type png, jpg, gif ,jpeg";
				$validate = false;
			}else{
				$avatar =md5($_FILES['avatar']['name'])."$extension";
				if(!move_uploaded_file($_FILES['avatar']['tmp_name'],'../'.$dossier.$avatar)){
					$validate = false;
					$_SESSION['erreur'] = "Un problème est survenu lors de l'Upload de l'avatar.";
				}else{
					$data['avatar'] =$dossier.$avatar;	
				}
			}
		}

	if($validate){
		$nb= $DB->insert("UPDATE users SET username=:username,email=:email,name=:name,prenom=:prenom,active=:active,bio=:bio,role=:role,avatar=:avatar WHERE id=:id",$data);
		if($nb){
			$_SESSION['message'] = "le profil de l'utilisateur a été mis a jour avec succès.";
			header('location:users.php');
			exit();
		}else{	
			$_SESSION['erreur'] = "Un problème de sauvegarde !";
		}
	}

}
if(isset($_GET['id'])){
	$user = $DB->query("SELECT * FROm users WHERE id=:id",array('id'=>$_GET['id']));

}
include 'INC/header.php' ?>

<!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	

    	<!--  message de la session -->
			<?php if (isset($_SESSION['message'])): ?>
				<div class="alert_success"><?php echo $_SESSION['message']; ?></div>
				<?php unset($_SESSION['message']); ?>
			<?php endif ?>

			<?php if (isset($_SESSION['erreur'])): ?>
				<div class="alert_error"><?php echo $_SESSION['erreur']; ?></div>
				<?php unset($_SESSION['erreur']); ?>
			<?php endif ?>

			<h2>Editer un utilisateur </h2>
			<form action="editUser.php?id=<?php echo $user[0]->id; ?>" method="POST" enctype="multipart/form-data">

				<input type="hidden" name ="id" value ="<?php echo $user[0]->id; ?>">

				<p>
					<label for="username">Username</label>
					<input type="text" name="username" value ="<?php echo $user[0]->username ;?>">
				</p>
				<?php if (!empty($erreur_username)): ?>
					<div class="error"><?php echo $erreur_username; ?></div>
				<?php endif ?>
				<p>
					<label for="email">email</label>
					<input type="text" name="email" value ="<?php echo $user[0]->email ;?>">
				</p>
				<?php if (!empty($erreur_email)): ?>
					<div class="error"><?php echo $erreur_email; ?></div>
				<?php endif ?>

				<p>
					<label for="name">Nom</label>
					<input type="text" name="name" value ="<?php echo $user[0]->name ;?>">
				</p>
				<p>
					<label for="prenom">prenom</label>
					<input type="text" name="prenom" value ="<?php echo $user[0]->prenom ;?>">
				</p>
				<p>
					<label for="role">Rôle</label>
					<input type="text" name="role" value ="<?php echo $user[0]->role ;?>">
				</p>
				<p>
					<label for="active">Compte activé</label>
					<input type="checkbox" name="active" <?php echo ( $user[0]->active  == 1)?'checked="checked"':'' ; ?>value ="<?php echo $user[0]->active ;?>">
				</p>

				<input type="hidden" name="avatar_old" value ="<?php echo !empty($user[0]->avatar)?$user[0]->avatar:'' ?>">
				<?php if (!empty($user[0]->avatar)): ?>
					<p class="visu">
						<img src="../<?php echo $user[0]->avatar; ?>">
					</p>
				<?php else:  ?>
				<p>Aucun avatar.</p>
				<?php endif ?>
				<p>
					<label for="avatar">avatar</label>
					<input type="file" name="avatar">
				</p>
				<?php if (!empty($erreur_avatar)): ?>
					<div class="error"><?php echo $erreur_avatar; ?></div>
				<?php endif ?>
				<p>
					<label for="bio">Bio</label>
					<textarea name="bio"  cols="30" rows="10"> <?php echo $user[0]->bio; ?></textarea>
				</p>
				<?php if (!empty($erreur_bio)): ?>
					<div class="error"><?php echo $erreur_bio; ?></div>
				<?php endif ?>
				<p>
					<input type="submit" value="Enregistrer">
				</p>
			</form>
			</table>
	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>