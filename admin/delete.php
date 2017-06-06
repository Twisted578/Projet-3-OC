<?php require_once 'INC/includes.php';
if($_SERVER['REQUEST_METHOD'] == "GET"){

	//cas d'un post
	if(isset($_GET['post'])){
		$id= intval($_GET['post']);
		$post = $DB->query("SELECT id,image FROM posts WHERE id=:id",array('id'=>$id));

		if(!empty($post)){

			$nb= $DB->insert('DELETE FROM posts WHERE id=:id',array('id'=>$id));
			if($nb){
				// supprimer l'image du serveur 
				unlink('../'.$post[0]->image);
				$_SESSION['message'] = "l'article à bien été supprimé !.";
			}else{
				$_SESSION['erreur'] = "Il y a eu un problème avec la suppression de l'article .";
			}
		}else{
			$_SESSION['erreur'] = "Article inéxistant dans notre base.";
		}

		// header('location:articles.php');
		// exit();
		echo '<script language="Javascript">
		<!--
		document.location.replace("articles.php");
		// -->
		</script>';

		
	}

	//cas d'un post
	if(isset($_GET['comment'])){
		$id= intval($_GET['comment']);
		$comment = $DB->query("SELECT id FROM comments WHERE id=:id",array('id'=>$id));

		if(!empty($comment)){

			$nb= $DB->insert('DELETE FROM comments WHERE id=:id',array('id'=>$id));
			if($nb){

				$_SESSION['message'] = "le commentaire à bien été supprimé !.";
			}else{
				$_SESSION['erreur'] = "Il y a eu un problème avec la suppression du commentaire .";
			}
		}else{
			$_SESSION['erreur'] = "Commentaire  inéxistant dans notre base.";
		}

		// header('location:articles.php');
		// exit();
		echo '<script language="Javascript">
		<!--
		document.location.replace("comments.php");
		// -->
		</script>';

		
	}

	//cas d'une categorie
	if(isset($_GET['cat'])){
		$id= intval($_GET['cat']);
		$cat = $DB->query("SELECT id FROM categories WHERE id=:id",array('id'=>$id));

		if(!empty($cat)){

			$nb= $DB->insert('DELETE FROM categories WHERE id=:id',array('id'=>$id));
			if($nb){

				$_SESSION['message'] = "la catégorie à bien été supprimée !.";
			}else{
				$_SESSION['erreur'] = "Il y a eu un problème avec la suppression de la catégorie .";
			}
		}else{
			$_SESSION['erreur'] = "Catégorie  inéxistante dans notre base.";
		}

		// header('location:articles.php');
		// exit();
		echo '<script language="Javascript">
		<!--
		document.location.replace("categories.php");
		// -->
		</script>';

		
	}

	//cas d'un user
	if(isset($_GET['user'])){
		$id= intval($_GET['user']);
		$cat = $DB->query("SELECT id FROM users WHERE id=:id",array('id'=>$id));

		if(!empty($cat)){

			$nb= $DB->insert('DELETE FROM users WHERE id=:id',array('id'=>$id));
			if($nb){

				$_SESSION['message'] = "l'Utilisateur à bien été supprimée !.";
			}else{
				$_SESSION['erreur'] = "Il y a eu un problème avec la suppression de l'utilisateur .";
			}
		}else{
			$_SESSION['erreur'] = "User  inéxistante dans notre base.";
		}

		// header('location:articles.php');
		// exit();
		echo '<script language="Javascript">
		<!--
		document.location.replace("users.php");
		// -->
		</script>';

		
	}


}

?>