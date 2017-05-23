<?php 
					$comments=$DB->query("SELECT id,texte from comments ORDER BY created_at LIMIT 5");
				?>

				<h3>Derniers commentaires</h3>
				<?php foreach ($comments as $comments): ?> 
					<p><?php echo Texte::limit($comments->texte,150); ?></p>
				<?php endforeach ?>