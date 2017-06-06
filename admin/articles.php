<?php require_once 'INC/includes.php';

$nbr = $DB->query("SELECT count(*) as nbr FROM posts");
$perpage = 4;
$nbr_pages = ceil($nbr[0]->nbr/$perpage );

if(isset($_GET['page'])){
	$page = intval($_GET['page']);
	if($page > $nbr_pages){
		$page = $nbr_pages;
	}
}else{
	$page =1;
}

$premierPage = ($page-1) *$perpage;

$posts= $DB->query("SELECT id,titre,image FROM posts ORDER BY created_at DESC LIMIT ".$premierPage.",".$perpage."");

include 'INC/header.php';?>
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

			<h2>les articles </h2>
			<button><a href="addArticle.php">Ajouter un article</a> </button>
			<table>
				<thead>
					<tr>
						<td>image</td>
						<td>Titre</td>
						<td class='actions'>Actions</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($posts as $post): ?>
						<tr>
							<td><img src="../<?php echo $post->image; ?>" alt="<?php echo $post->titre; ?>"> </td>
							<td><a href="editArticle.php?id=<?php echo $post->id; ?>"><?php echo $post->titre; ?></a>	</td>
							<td>
								<button><a href="editArticle.php?id=<?php echo $post->id; ?>">Edit</a> </button>
								<button><a href="delete.php?post=<?php echo $post->id; ?>">Delete</a> </button>
							</td>
						</tr>
					<?php endforeach ?>

				</tbody>
			</table>

			<!-- pagination  -->
			<?php if ($nbr_pages>1): ?>
				<div class="pagination">
				<ul>
				<?php 
				for($i=1;$i<=$nbr_pages;$i++){
					if($i == $page){
						echo '<li  class="active"><a href="">'.$i.'</a></li>';
					}else{
						echo '<li><a href="articles.php?page='.$i.'">'.$i.'</a></li>';
					}
				}
				 ?>
					
				</ul>
			</div>
			<?php endif ?>
	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>