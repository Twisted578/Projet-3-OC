<?php require_once 'INC/includes.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$validate = true;


	if(empty($_POST['description'])){
		$validate =false ;
		$erreur_description = "Veuillez entrer le contenu de l'artilce";
	}
	if(empty($_POST['titre'])){
		$validate =false ;
		$erreur_titre = "Veuillez entrer le titre de l'artilce";
	}
	if(empty($_FILES['image']['name'])){
		$validate =false ;
		$erreur_image = "Veuillez entrer le visuel de l'artilce";
	}

	if(!empty($_FILES['image']['name']) && $validate){
			$extensions = array('.png','.gif','.jpg','.jpeg');
			$extension = strrchr($_FILES['image']['name'], '.');

			$dossier =UPLOAD;
			if(!in_array($extension,$extensions)){
				$erreur_image = "Vous devez uploader une image de type png, jpg, gif ,jpeg";
				$validate = false;
			}else{
				$image =md5($_FILES['image']['name'])."$extension";
				if(!move_uploaded_file($_FILES['image']['tmp_name'],'../'.$dossier.$image)){
					$validate = false;
					$_SESSION['erreur'] = "Un problème est survenu lors de l'Upload de l'image.";
				}else{
					$image =$dossier.$image;	
				}
			}
		}

	if($validate){

	$data= array(
		'user_id' => $_POST['user_id'],
		'titre'=>$_POST['titre'],
		'description'=>$_POST['description'],
		'category_id'=>$_POST['categorie'],
		'image'=>$image
		);

		$nb= $DB->insert("INSERT INTO  posts (titre,description,category_id,user_id,image,created_at) VALUES (:titre,:description,:category_id,:user_id,:image,NOW())",$data);

		if($nb){
			$_SESSION['message'] = "l'article a été ajouté avec succès.";
			header('location:articles.php');
			exit();
		}else{	
			$_SESSION['erreur'] = "Un problème de sauvegarde !";
		}
	}

}


	$cats = $DB->query("SELECT * FROm categories ");

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

			<h2>Ajouter un article </h2>
			<form action="addArticle.php" method="POST" enctype="multipart/form-data">

				<input type="hidden" name ="user_id" value ="<?php echo $_SESSION['user']['id']; ?>">

				<p>
					<label for="titre">Titre</label>
					<input type="text" name="titre" value ="<?php echo isset($_POST['titre'])?$_POST['titre']:'';?>">
				</p>
				<?php if (!empty($erreur_titre)): ?>
					<div class="error"><?php echo $erreur_titre; ?></div>
				<?php endif ?>
				<p>
					<label for="categorie">Catégorie</label>
					<select name="categorie" >
						<?php foreach ($cats as $cat): ?>
							<option value="<?php echo $cat->id; ?>" ><?php echo $cat->name; ?></option>
						<?php endforeach ?>
						
					</select>
				</p>
				
				<p>
					<label for="image">image</label>
					<input type="file" name="image">
				</p>
				<?php if (!empty($erreur_image)): ?>
					<div class="error"><?php echo $erreur_image; ?></div>
				<?php endif ?>
				<p>
					<label for="description">Contenu</label>
					<textarea name="description"  cols="30" rows="10"> <?php echo isset($_POST['description'])?$_POST['description']:'';?></textarea>
				</p>
				<?php if (!empty($erreur_description)): ?>
					<div class="error"><?php echo $erreur_description; ?></div>
				<?php endif ?>
				<p>
					<input type="submit" value="Enregistrer">
				</p>
			</form>
			</table>
	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>