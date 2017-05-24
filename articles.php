<?php

include 'INC/includes.php';

$categorie = 0;
$cond = array();

//pagination
if (!empty($_GET['categorie']) && $_GET['categorie'] > 0) {
	$categorie = intval($_GET['categorie']);
	$cond = array('category_id' => $categorie); 
	$nbr = $DB -> query("SELECT count(*) as nbr FROM posts WHERE category_id=:category_id" ,$cond);
}else
	$nbr = $DB -> query("SELECT count(*) as nbr FROM posts");


$perpage = 4;
$nbr_pages = ceil($nbr[0]->nbr/$perpage);

if (isset($_GET['page'])) {
	$page = intval($_GET['page']);
	if ($page > $nbr_pages) {
		$page = $nbr_pages;
	}
}else{
	$page = 1;
}

$permierPage = ($page-1) * $perpage;

//posts

if (!empty($_GET['categorie']) && $_GET['categorie'] > 0) {
	$sql ='SELECT posts.id,posts.titre,posts.description,posts.created_at,posts.image,posts.category_id,users.username,categories.name FROM posts
		INNER JOIN categories ON category_id= category.id
		INNER JOIN users ON users_id = users.id
		WHERE posts.category_id=:category_id
		ORDER BY created_at DESC LIMIT '.$permierPage.','.$perpage;
}else
$sql ='SELECT posts.id,posts.titre,posts.description,posts.created_at,posts.image,posts.category_id,users.username,categories.name FROM posts
		INNER JOIN categories ON category_id= category.id
		INNER JOIN users ON users_id = users.id
		ORDER BY created_at DESC LIMIT '.$permierPage.','.$perpage;

$posts = $DB->query($sql,$cond);

// nombre de commentaires pas posts
$ids = array();
foreach ($posts as $posts) {
	array_push($ids, $posts->id);
}
$chaine='';
if (count($ids>0)) {
	foreach ($ids as $k => $v) {
		$chaine .= $v.', ';
	}
	$chaine = substr($chaine,0,-2);
}

$sql ="SELECT count(*) as nbr, posts_id from comments WHERE posts_id IN (".$chaine.") GROUP BY posts_id";
$nbComments = $DB->tquery($sql);
$num = array();
foreach ($nbComments as $key => $value) {
 	$num[$value['posts_id']] = $value['nbr'];
 } 


include 'INC/header.php';

?>


<!-- PAGE -->
<div id="page">
    <div id ="contenuPage" class="container clearfix">	
		<div id="content">
			<?php foreach ($posts as $posts): ?>
				<article class="clearfix">
			<h2><?php echo $posts->titre; ?></h2>
			<div class="article">
				<div class="thumbnail"><img  src="<?php echo $posts->image ?>" alt="<?php echo $posts->titre ?>" title="<?php echo $posts->titre ?>" /></div>	
				<p><?php echo Texte::limit($posts->description,450); ?></p>
				<button><a href="article.php?id=<?php echo $posts->id; ?>" title="lire la suite">lire la suite</a></button>
			</div>
			<div class="infos clearfix">
				<p class="posted">Publié le <?php echo Texte::french_date($posts->created_at); ?> par <?php echo $posts->username; ?><span><a href="" title="commentaires">(0) commentaires</a></span></p>
				<p>Categorie: <a href="articles.php?categorie=<?php echo $posts->category_id; ?>"><?php echo $posts->name ?></a> </p>
			</div>
			</article> 

			<?php endforeach ?>

			
			<div class="pagination">
				<ul>
					<?php
					for ($i=1; $i <= $nbr_pages; $i++) { 
						if ($i == $page) {
							echo '<li class="active"><a href="">'.$i.'</a></li>';
						}else{
							echo '<li><a href="articles.php?page='.$i.'&categorie='.$categorie.'">'.$i.'</a></li>';
						}
					}
					?>
				</ul>
			</div>

		</div> <!-- #content -->
			
		<!-- SIDEBAR -->
		<div id="sidebar">
			<div class="category">

				<?php 
					$sql ="SELECT * FROM categories";
					$cats = $DB->query($sql)
				?>
				<h3>Catégories</h3>
				<ul>
					<?php foreach ($cats as $cat): ?>
						<li><a href="articles.php?categorie=<?php echo $cat->id ?>;"><?php echo $cat->name; ?></a></li>
					<?php endforeach ?>
				</ul>
			</div>
			<div class="lastComments">
				
				<?php include 'INC/lastComments.php'; ?>

			</div>
			<div class="lastArticles">
				<?php include 'INC/lastPosts.php'; ?>
			</div>
		</div> <!-- #sidebar -->


	</div> <!-- contenuPage -->
</div> <!-- #page -->

<?php include 'INC/footer.php'; ?>