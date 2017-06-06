<?php require_once 'INC/includes.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$id =intval($_POST['id']);
	$validate = true;

	$data= array(
		'id' => $id,
		'name'=>$_POST['name'],
		
		);
	if(empty($_POST['name'])){
		$validate =false ;
		$erreur_description = "Veuillez entrer le nom de la catégorie";
	}
	
	if($validate){
		$nb= $DB->insert("UPDATE categories SET name=:name WHERE id=:id",$data);
		if($nb){
			$_SESSION['message'] = "la catégorie a été mise a jour avec succès.";
			header('location:categories.php');
			exit();
		}else{	
			$_SESSION['erreur'] = "Un problème de sauvegarde !";
		}
	}

}
if(isset($_GET['id'])){
	$cat = $DB->query("SELECT * FROm categories WHERE id=:id",array('id'=>$_GET['id']));

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

			<h2>Editer une catégorie </h2>
			<form action="editCat.php?id=<?php echo $cat[0]->id; ?>" method="POST" >

				<input type="hidden" name ="id" value ="<?php echo $cat[0]->id; ?>">

				<p>
					<label for="name">Nom</label>
					<input type="text" name="name" value ="<?php echo $cat[0]->name ;?>">
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