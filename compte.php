<?php 
require_once 'INC/includes.php';

if(User::islog($DB)){
	$id= $_SESSION['user']['id'];

	$posts = $DB->query("SELECT posts.id,posts.titre,posts.description,posts.image,posts.created_at FROM posts
						INNER JOIN users ON posts.user_id = users.id
						WHERE posts.user_id = $id ORDER BY posts.created_at DESC limit 6
						");

	$comments = $DB->query("SELECT comments.id,comments.texte,comments.created_at FROM comments 
							INNER JOIN users ON comments.user_id = users.id
							WHERE comments.user_id = $id ORDER BY comments.created_at DESC LIMIT 5
						");

	$nb_comments = count($comments);
}else{
	header('location:login.php');
	$_SESSION['erreur'] = "Espace réservé aux membres connectés .";
	exit();
}
include 'INC/header.php';?>
<!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	
		<div id="content">
			<!--  message de la session -->
				<?php if (isset($_SESSION['message'])): ?>
					<div class="alert_success"><?php echo $_SESSION['message']; ?></div>
					<?php unset($_SESSION['message']); ?>
				<?php endif ?>

				<?php if (isset($_SESSION['erreur'])): ?>
					<div class="alert_error"><?php echo $_SESSION['erreur']; ?></div>
					<?php unset($_SESSION['erreur']); ?>
				<?php endif ?>

			<article class="">
			
				<div class="article">
					<div class="thumbnail"><img  src="<?php echo $_SESSION['user']['avatar'] ?>" alt="<?php echo $_SESSION['user']['username'];?>" title="<?php echo $_SESSION['user']['username'];?>" /></div>	
					<div class="profil">
						<h2>Bienvenue, <?php echo $_SESSION['user']['username']; ?> </h2>
						<p class="posted">Inscrit depuis le <?php echo Texte::french_date($_SESSION['user']['created_at']);?>	<!-- <span>comme : admin</span> -->
							<em class="com">avec <a href="commentaires.php?id=<?php echo $_SESSION['user']['id']; ?>" title="commentaires">(<?php echo $nb_comments; ?>) commentaires</a></em>
						</p>
					</div>
					
				</div>

			</article>

			<div class="clearfix"></div>
			<section class="clearfix">
				<h2>Vos Informations </h2>
				<p>Nom : <span><?php echo $_SESSION['user']['name']; ?></span>  - <?php echo $_SESSION['user']['prenom']; ?></p>
				<p>Email : <span><?php echo $_SESSION['user']['email']; ?></span> </p>
				<p>Bio : <span><?php echo $_SESSION['user']['bio']; ?></span></p>
				<p>date de la dernière connexion : <span> le <?php echo Texte::french_date($_SESSION['user']['created_at']); ?> </span></p>
				
			</section>
						<div class="lastArticles">
				<h3>Vos derniers articles </h3>
				<ul>
					<?php foreach ($posts as $post): ?>
						<li>
							<a href="article.php?id=<?php echo $post->id; ?>">
								<div class="thumb"><img src="<?php echo $post->image ?>" alt ="<?php echo $post->titre ?>" /></div>
								<div class="detail">
									<h4><?php echo $post->titre; ?></h4>
									<p><?php echo Texte::limit($post->description,130);?> </p>
								</div>
							</a>
						</li>
					<?php endforeach ?>
					
				</ul>
			</div>
		</div> <!-- #content -->
			
		<!-- SIDEBAR -->
		<div id="sidebar">
			<div class="category">
			<h3>Informations</h3>
				<ul>
					<li><a href="profil.php">Modifier votre profil</a></li>
				</ul>
			</div>
			<div class="lastComments">
				<h3>Vos derniers commentaires</h3>
				<?php foreach ($comments as $comment): ?>
					<p><?php echo Texte::limit($comment->texte,150); ?></p>
				<?php endforeach ?>
			</div>

		</div> <!-- #sidebar -->


	</div> <!-- contenuPage -->
</div> <!-- #page -->

<?php include 'INC/footer.php'; ?>