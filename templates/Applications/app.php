<?php 
$image_url = $this->Url->build('/', ['escape' => false,'fullBase' => true,]);
if (!empty($layout)) :
	echo $this->element('component/menu');
	if (!empty($component)) :
?>
	<div class="nk-main">
		<div class="nk-gap-2"></div>
			<div class="container">
	<?php
		foreach ($component as $key => $value) :
			echo $this->element('component/'.$value->table_name);
		endforeach;
	?>
			</div>
		</div>
	</div>
<?php
	endif;
endif;
?>
<!-- START: Page Background -->
