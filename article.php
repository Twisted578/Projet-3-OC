<?php 

include 'INC/includes.php';

if (isset($_GET['id'])) {
	$id = intval($_GET['id']);

	$post = $DB -> query("SELECT posts.id,posts.titre,posts.description,posts.image,posts.created_at,posts.category_id,users.username,categories.name FROM posts
			INNER JOIN categories ON category_id = categories.id
			INNER JOIN  users ON ueser_id = users.id
			WHERE posts.id = $id
			");
if (empty($post)) {
	header('location : index.php');
	exit();
	}
	$post = $post[0];
}else{
	header('location : index.php');
	exit();
}

include 'INC/header.php'; 

?>

<!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	
		<!-- <div id="content"> -->
			<div class="single">
			
			<div class="article">
				<div class="thumbnail"><img  src="<?php echo $post->image ?>" alt="<?php echo $post->titre ?>" title="<?php echo $post->titret ?>" /></div>
				<div class="infos" >
					<h1><?php echo $post->titre; ?></h1>	
					<p class="posted">Publié le <?php echo Texte::french_date($post->created_at); ?><span><a href="articles.php?categorie=<?php echo $post->category_id;?>"><?php echo $post->name; ?></a></span>
						<em class="com"><a href="" title="commentaires">(0) commentaires</a></em>
					</p>
				</div>
				
			</div>
				<div class="clearfix">
					<p><?php echo $post->description; ?></p>
					
				</div>
				<h2>Laisser un commentaire</h2>	
				<div class="commentaires">
					<div class="commentaire">
						<div class="avatar">
							<img src="img/avatar.png" alt="avatar">
						</div>	
						<div class="message">	
							<div class="author">athakim <span> 15 -12-2012 à 16h31</span></div>
							<div class="texte">
								In hendrerit quam vel erat luctus cursus. Proin congue aliquet purus sodales gravida. Fusce ligula elit, laoreet ac vestibulum in, lobortis id leo. Quisque nec massa lectus, lobortis laoreet ante. 
							</div>
						</div>
					</div>

					<div class="commentaire">
						<div class="avatar">
							<img src="img/avatar.png" alt="avatar">
						</div>	
						<div class="message">	
							<div class="author">athakim <span> 15 -12-2012 à 16h31</span></div>
							<div class="texte">
								In hendrerit quam vel erat luctus cursus. Proin congue aliquet purus sodales gravida. Fusce ligula elit, laoreet ac vestibulum in, lobortis id leo. Quisque nec massa lectus, lobortis laoreet ante. 
							</div>
						</div>
					</div>

					<div class="commentaire">
						<div class="avatar">
							<img src="img/avatar.png" alt="avatar">
						</div>	
						<div class="message">	
							<div class="author">athakim <span> 15 -12-2012 à 16h31</span></div>
							<div class="texte">
								In hendrerit quam vel erat luctus cursus. Proin congue aliquet purus sodales gravida. Fusce ligula elit, laoreet ac vestibulum in, lobortis id leo. Quisque nec massa lectus, lobortis laoreet ante. 
							</div>
						</div>
					</div>

					<form action="">
						<p>
							<label for="">Pseudo </label>
							<input type="text">
						</p>
						<p>
							<label for="">Email </label>
							<input type="text">
						</p>
						<p>
							<label for="">Commentaire</label>
							<textarea name="" id="" cols="30" rows="10"></textarea>
						</p>
						<p>
							<input type="submit" value="Envoyer">
						</p>
					</form>
					
				</div>
			</div>

	</div> <!-- contenuPage -->
</div> <!-- #page -->

<?php include 'INC/footer.php'; ?>