<?php
				$posts=$DB->query("SELECT id,titre,description,image from posts ORDER BY created_at LIMIT 6");
			?>
				<h3>Derniers articles </h3>
				<ul>
					<?php foreach ($posts as $posts): ?>
					<li>
						<a href="articles.php?id=<?php echo $posts->id; ?>">
							<div class="thumb"><img src="<?php echo $posts->image; ?>" alt ="<?php $posts->titre ?>" /></div>
							<div class="detail">
								<h4><?php echo $posts->titre; ?></h4>
								<p><?php echo Texte::limit($posts->description,130); ?></p>
							</div>
						</a>
					</li>
					<?php endforeach ?>
				</ul>