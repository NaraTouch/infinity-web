<div class="nk-gap-2"></div>
<div class="row vertical-gap">
<?php
	if (!empty($component_data)) :
		if (!empty($component_data['GGCategories'])) :
			foreach ($component_data['GGCategories'] as $key => $value) :
			?>
			<div class="col-lg-4">
				<div class="nk-feature-1">
					<div class="nk-feature-icon">
						<?php
							if (isset($value->icon)) :
						?>
						<img src="<?= ($value->icon) ? $value->icon : '';?>"
							 alt="<?= ($value->title) ? $value->title : '';?>">
						<?php
							endif;
						?>
					</div>
					<div class="nk-feature-cont">
						<h3 class="nk-feature-title">
							<a href="#"><?= h($value->title)?></a>
						</h3>
						<h4 class="nk-feature-title text-main-1">
							<a href="<?= (isset($value->tag_links)) ? $value->tag_links : '#';?>">View Games</a>
						</h4>
					</div>
				</div>
			</div>
<?php
			endforeach;
		else:
		?>
		<div class="col-lg-4">
			<div class="nk-feature-1">
				<div class="nk-feature-cont">
					<h3 class="nk-feature-title"><a href="#">No Data</a></h3>
					<h4 class="nk-feature-title text-main-1"><a href="#">Empty</a></h4>
				</div>
			</div>
		</div>
<?php
		endif;
	endif;
	?>
</div>