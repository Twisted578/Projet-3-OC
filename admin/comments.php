<?php require_once 'INC/includes.php';

$nbr = $DB->query("SELECT count(*) as nbr FROM comments");
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

$comments= $DB->query("SELECT id,texte FROM comments ORDER BY created_at DESC LIMIT ".$premierPage.",".$perpage."");

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

			<h2>les commentaires </h2>
		
			<table>
				<thead>
					<tr>
						<td>ID</td>
						<td>Commentaire</td>
						<td class='actions'>Actions</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($comments as $comment): ?>
						<tr>
							<td><?php echo $comment->id; ?> </td>
							<td><a href="editComment.php?id=<?php echo $comment->id; ?>"><?php echo $comment->texte; ?></a>	</td>
							<td>
								<button><a href="editComment.php?id=<?php echo $comment->id; ?>">Edit</a> </button>
								<button><a href="delete.php?comment=<?php echo $comment->id; ?>">Delete</a> </button>
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
						echo '<li><a href="comments.php?page='.$i.'">'.$i.'</a></li>';
					}
				}
				 ?>
					
				</ul>
			</div>
			<?php endif ?>
	</div> <!-- contenuPage -->
</div> <!-- #page -->
<?php include 'INC/footer.php'; ?>