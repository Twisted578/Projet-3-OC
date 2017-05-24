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

	$sql = "SELECT comments.id,comments.texte,comments.created_at,comments.pseudo,users.avatar FROM comments
			LEFT JOIN users ON user_id =user.id
			WHERE post_id = $id";
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
					<?php foreach ($comment as $kcomment): ?>
						<div class="commentaire">
						<div class="avatar">
							<img src="<?php echo $comment->avatar; ?>" alt="<?php echo $comment->pseudo; ?>">
						</div>	
						<div class="message">	
							<div class="author"><?php echo $comment->pseudo; ?><span><?php echo Texte::french_date_time($comment->created_at); ?></span></div>
							<div class="texte">
								<?php echo $comment->texte; ?>
							</div>
						</div>
					</div>
					<?php endforeach ?>
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