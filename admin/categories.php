<?php require_once 'INC/includes.php';

$nbr = $DB->query("SELECT count(*) as nbr FROM categories");
$perpage = 6;
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

$cats= $DB->query("SELECT id,name FROM categories  LIMIT ".$premierPage.",".$perpage."");

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

			<h2>les catégories </h2>
		<button><a href="addCat.php">Ajouter une catégorie</a> </button>
			<table>
				<thead>
					<tr>
						<td>ID</td>
						<td>Nom</td>
						<td class='actions'>Actions</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($cats as $cat): ?>
						<tr>
							<td><?php echo $cat->id; ?> </td>
							<td><a href="editCat.php?id=<?php echo $cat->id; ?>"><?php echo $cat->name; ?></a>	</td>
							<td>
								<button><a href="editCat.php?id=<?php echo $cat->id; ?>">Edit</a> </button>
								<button><a href="delete.php?cat=<?php echo $cat->id; ?>">Delete</a> </button>
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
						echo '<li><a href="categories.php?page='.$i.'">'.$i.'</a></li>';
					}
				}
				 ?>
					
				</ul>
			</div>
			<?php endif ?>
	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>