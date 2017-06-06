<?php require_once 'INC/includes.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$id =intval($_POST['id']);
	$validate = true;

	$data= array(
		'id' => $id,
		'texte'=>$_POST['texte'],
		
		);
	if(empty($_POST['texte'])){
		$validate =false ;
		$erreur_description = "Veuillez entrer le contenu du commentaire";
	}
	
	if($validate){
		$nb= $DB->insert("UPDATE comments SET texte=:texte WHERE id=:id",$data);
		if($nb){
			$_SESSION['message'] = "le commentaire a été mis a jour avec succès.";
			header('location:comments.php');
			exit();
		}else{	
			$_SESSION['erreur'] = "Un problème de sauvegarde !";
		}
	}

}
if(isset($_GET['id'])){
	$comment = $DB->query("SELECT * FROm comments WHERE id=:id",array('id'=>$_GET['id']));

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

			<h2>Editer un commentaire </h2>
			<form action="editComment.php?id=<?php echo $comment[0]->id; ?>" method="POST" >

				<input type="hidden" name ="id" value ="<?php echo $comment[0]->id; ?>">

				<p>
					<label for="texte">texte</label>
					<input type="text" name="texte" value ="<?php echo $comment[0]->texte ;?>">
				</p>
				<?php if (!empty($erreur_texte)): ?>
					<div class="error"><?php echo $erreur_texte; ?></div>
				<?php endif ?>
				
				<p>
					<input type="submit" value="Enregistrer">
				</p>
			</form>
			</table>
	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>