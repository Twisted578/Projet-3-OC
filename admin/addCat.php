<?php require_once 'INC/includes.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$validate = true;

	
	if(empty($_POST['name'])){
		$validate =false ;
		$erreur_description = "Veuillez entrer le nom de la catégorie";
	}
	
	if($validate){
		$data= array(
		'name'=>$_POST['name'],
		
		);
		$nb= $DB->insert("INSERT  INTO categories (name) values(:name)",$data);
		if($nb){
			$_SESSION['message'] = "la catégorie a été ajoutée avec succès.";
			header('location:categories.php');
			exit();
		}else{	
			$_SESSION['erreur'] = "Un problème de sauvegarde !";
		}
	}

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

			<h2>Ajouter une catégorie </h2>
			<form action="addCat.php" method="POST" >

				<p>
					<label for="name">Nom</label>
					<input type="text" name="name" value ="<?php echo isset($_POST['name'])?$_POST['name']: '' ;?>">
				</p>
				<?php if (!empty($erreur_name)): ?>
					<div class="error"><?php echo $erreur_name; ?></div>
				<?php endif ?>
				
				<p>
					<input type="submit" value="Enregistrer">
				</p>
			</form>
			</table>
	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>