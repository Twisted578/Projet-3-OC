<?php include 'INC/includes.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET'){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$id= intval($_POST['id']);
		$validate = true;

		if(empty($_POST['commentaire'])){
			$erreur_commentaire = "Veuillez entrer votre commentaire";
			$validate = false;
		}elseif(strlen($_POST['commentaire']) < 5){
				$erreur_commentaire = "Le commentaire doit contenir plus de 5 caractères .";
				$validate = false;
			}

		if(empty($_POST['pseudo'])){
			$erreur_pseudo = "Un pseudo est requis.";
			$validate = false;
		}elseif(!User::pseudo_unique($DB,$_POST['pseudo']) && !User::islog($DB)){
				$erreur_pseudo = "Pseudo déja pris .";
				$validate = false;
			}

		if(empty($_POST['email'])){
			$erreur_email = "Un Email est requis.";
			$validate = false;
		}elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
				$erreur_email = "Adresse Email non valide !";
				$validate = false;
			}elseif(!User::email_unique($DB,$_POST['email']) && !User::islog($DB)){
				$erreur_email = "Adresse Email déja utilisée par un membre .";
				$validate = false;
			}


		if($validate){
			// authentification ?
			if(User::auth()){
				$user_id = $_SESSION['user']['id'];
			}else 
				$user_id = 0;

			$data =array(
					'pseudo' => htmlspecialchars(addslashes($_POST['pseudo'])),
					'mail' => htmlspecialchars(addslashes($_POST['email'])),
					'texte' => htmlspecialchars(addslashes($_POST['commentaire'])),
					'post_id'=>intval($_POST['id']),
					'user_id'=>$user_id
				);

			$sql ="INSERT INTO comments (texte,pseudo,mail,post_id,user_id,created_at) VaLUES(:texte,:pseudo,:mail,:post_id,:user_id,NOW())";

			$rep = $DB->insert($sql,$data);

			if($rep){
				$_SESSION['message'] = "Merci pour le commentaire .";
				unset($_POST);
			}else{
				$_SESSION['erreur'] = "Il y a eu un problème de sauvegarde avec votre commentaire .";
			}


		}


	}

	if(isset($_GET['id'])){
		$id =intval($_GET['id']);

		$post = $DB->query("SELECT posts.id,posts.titre,posts.description,posts.image,posts.created_at,posts.category_id,users.username,categories.name FROM posts 
				INNER JOIN categories ON category_id = categories.id
				INNER JOIN  users On user_id = users.id
				WHERE posts.id = $id;
			");
		if(empty($post)){
			header('location: index.php');
			exit();
		}
		$post = $post[0];

		$sql ="SELECT comments.id,comments.texte,comments.created_at,comments.pseudo,users.avatar FROM comments
		 	LEFT JOIN users ON user_id = users.id
		 	Where post_id = $id";

		 $comments = $DB->query($sql);
		 $num = count($comments);

	}else{
		header('location: index.php');
		exit();
	}
}else{
	header('location: index.php');
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
				<div class="thumbnail"><img  src="<?php echo $post->image ?>" alt="<?php echo $post->titre; ?>" title="<?php echo $post->titre; ?>" /></div>
				<div class="infos" >
					<h1><?php echo $post->titre; ?></h1>	
					<p class="posted">Publié le <?php echo Texte::french_date($post->created_at); ?>	<span><a href="articles.php?categorie=<?php echo $post->category_id;?>"><?php echo $post->name; ?></a></span>
						<em class="com"><a href="" title="commentaires">(<?php echo $num; ?>) commentaires</a></em>
					</p>
				</div>
				
			</div>
				<div class="clearfix">
					<p><?php echo $post->description; ?> </p>
					
				</div>
				<h2>Laisser un commentaire</h2>	
				<div class="commentaires">
					<?php foreach ($comments as $comment): ?>
						<div class="commentaire">
						<div class="avatar">
							<img src="<?php echo !empty($comment->avatar)?$comment->avatar:'img/avatar.png'; ?>" alt="<?php echo $comment->pseudo; ?>">
						</div>	
						<div class="message">	
							<div class="author"><?php echo $comment->pseudo; ?> <span> <?php echo Texte::french_date_time($comment->created_at); ?></span></div>
							<div class="texte">
								<?php echo $comment->texte; ?> 
							</div>
						</div>
					</div>
					<?php endforeach ?>
					<!--  message de la session -->
					<?php if (isset($_SESSION['message'])): ?>
						<div class="alert_success"><?php echo $_SESSION['message']; ?></div>
						<?php unset($_SESSION['message']); ?>
					<?php endif ?>

					<?php if (isset($_SESSION['erreur'])): ?>
						<div class="alert_error"><?php echo $_SESSION['erreur']; ?></div>
						<?php unset($_SESSION['erreur']); ?>
					<?php endif ?>


					<form action="article.php?id=<?php echo $post->id; ?>" method="POST">
						<input type="hidden" name="id" value="<?php echo $post->id ;?>">
						<p>
							<label for="pseudo">Pseudo </label>
							<input type="text" name="pseudo" value="<?php if(User::islog($DB)) echo $_SESSION['user']['username']; else echo isset($_POST['pseudo'])?$_POST['pseudo']:''; ?>">
						</p>
						<?php if(!empty($erreur_pseudo)) :?>
							<div class="error"> <?php echo $erreur_pseudo; ?></div>
						<?php endif ?>
						<p>
							<label for="email">Email </label>
							<input type="text" name="email" value="<?php if(User::islog($DB)) echo $_SESSION['user']['email']; else echo isset($_POST['email'])?$_POST['email']:''; ?>">
						</p>
						<?php if(!empty($erreur_email)) :?>
							<div class="error"> <?php echo $erreur_email; ?></div>
						<?php endif ?>
						<p>
							<label for="commentaire">Commentaire</label>
							<textarea name="commentaire" id="" cols="30" rows="10"><?php echo isset($_POST['commentaire'])?$_POST['commentaire']:''; ?></textarea>
						</p>
						<?php if(!empty($erreur_commentaire)) :?>
							<div class="error"> <?php echo $erreur_commentaire; ?></div>
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