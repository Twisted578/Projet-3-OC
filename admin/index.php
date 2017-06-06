<?php require_once 'INC/includes.php';

$comments = $DB->query("SELECT count(*) as nbr FROM comments");
$posts = $DB->query("SELECT count(*) as nbr FROM posts");
$cats = $DB->query("SELECT count(*) as nbr FROM categories");
$users = $DB->query("SELECT count(*) as nbr FROM users");


include 'INC/header.php'; ?>
	
<!-- PRESENTATION -->
<div id="dashboard">
	<div  class="container bande clearfix">	
		<h2>Quelques Chiffres</h2>	     
		<ul>
			<li>commentaires<span><?php echo $comments[0]->nbr; ?></span></li>
			<li>articles<span><?php echo $posts[0]->nbr; ?></span></li>
			<li>categories<span><?php echo $cats[0]->nbr; ?></span></li>
			<li>users<span><?php echo $users[0]->nbr; ?></span></li>

		</ul>
	</div> <!-- container-->
</div> <!-- presentation -->

<!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	
			<h2>Derniers commentaires</h2>
			<?php 
			$lastComments =  $DB->query("SELECT id,texte  FROM comments WHERE created_at>:mavisite",array('mavisite'=>$_SESSION['user']['last_login']));
			 ?>
			<?php if (!empty($lastComments)): ?>
				<?php foreach ($lastComments as $comment): ?>
				<div class="block">
				<p><?php echo $comment->texte; ?></p>
			</div>
			<?php endforeach ?>
			<?php else : ?>
			<p>Aucun nouveau commentaire ...</p>
			<?php endif ?>

			<h2>Derniers Inscrits</h2>
			<?php 
			$lastUsers = $DB->query("SELECT id,avatar,username FROM users WHERE created_at>:mavisite",array('mavisite'=>$_SESSION['user']['last_login']));
			 ?>
			<ul>
				<?php if (!empty($lastUsers)): ?>
					<?php foreach ($lastUsers as $user): ?>
						<li class="block">
						<img src="<?php echo '../'.$user->avatar; ?>" alt="<?php echo $user->username; ?>">
						<p><?php echo $user->username; ?></p>

					</li>
					<?php endforeach ?>
				<?php else : ?>
				<p>Aucun nouveau inscrit ...</p>
				<?php endif ?>
			
				
			</ul>
	</div> <!-- contenuPage -->
</div> <!-- #page -->

<?php include 'INC/footer.php'; ?>