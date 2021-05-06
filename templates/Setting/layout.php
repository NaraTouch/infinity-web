<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<?php $image_url = $this->Url->build('/', ['escape' => false,'fullBase' => true,]);?>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Skydash Admin</title>
		<?php
			echo $this->Html->css([
				'layout',
			]);
			echo $this->fetch('css');
		?>
		<link rel="icon" type="image/png" href="<?= $image_url.'images/favicon.png'?>">
	</head>
	<body>
		<h1>Your Website Temaplate</h1>
		<?= $this->Flash->render() ?>
		<div id="Wrapper">
			<?php if (!empty($layouts)) : ?>
			<form action="layout" method="post">
				<?php foreach ($layouts as $key => $value) : ?>
					<div>
						<h2><?= h($value['display']);?></h2>
						<?php foreach ($value['subpages'] as $subpage_k => $subpage_v): ?>
							<p><?= h($subpage_v['display']);?></p>
							<?php foreach ($subpage_v['layouts'] as $layout_k => $layout_v): ?>
								<label title="<?= h($layout_v['component']['name']);?>"><?= h($layout_v['component']['name']);?></label>
							<?php endforeach;?>
						<?php endforeach;?>
					</div>
				<?php endforeach; ?>
					<div>
					<?php
						echo $this->Form->button('Confirmed', [
							'type' => 'submit',
							'class' => 'btn btn__accept',
						]); ?>
					</div>
			</form>
			<?php else : ?>
			<div>
				<h2>Page Not Found !!!</h2>
				<p>Page Elements Not Found !!!</p>
			</div>
			<?php endif; ?>
			
			</div>
		</div><!-- //#Wrapper -->
	</body>
</html>