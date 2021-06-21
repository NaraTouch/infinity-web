
<div class="nk-image-slider" data-autoplay="8000">
	<?php
		if (!empty($component_data)) :
			if (!empty($component_data['GGMainSliders'])) :
				foreach ($component_data['GGMainSliders'] as $key => $value) :
				?>
					<div class="nk-image-slider-item">
						<?php
							if ($value->image) :
						?>
							<img src="<?= ($value->image) ? $value->image : '';?>"
							 alt="<?= ($value->display) ? $value->display : '';?>"
							 class="nk-image-slider-img"
							 data-thumb="<?= ($value->thumb) ? $value->thumb : '';?>">
						<?php
							endif;
						?>
						<?php
							if ($value->display || $value->descriptions || $value->tag_links) :
						?>
							<div class="nk-image-slider-content">
								<h3 class="h4"><?= ($value->display) ? $value->display : '';?></h3>
								<p class="text-white"><?= ($value->descriptions) ? $value->descriptions : '';?></p>
								<?php
									if ($value->tag_links) :
								?>
									<a 
										target="_blank"
										href="<?= $value->tag_links;?>"
										class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-hover-color-main-1">
										Read More</a>
								<?php
									endif;
								?>
							</div>
						<?php
							endif;
						?>
					</div>
				<?php
				endforeach;
			else:
			?>
				<div class="nk-image-slider-item">
					<?php
					$_404image = 'https://api.pcloud.com/getpubthumb?fileid=31245376976&code=kZcwK9XZA7shjBIcnQfAqkn0I45ty5pTFuh7&type=jpeg&size=1200x675';
					$_404image_thumb = 'https://api.pcloud.com/getpubthumb?fileid=31245376976&code=kZcwK9XZA7shjBIcnQfAqkn0I45ty5pTFuh7&type=jpeg&size=150x95';
					?>
					<img src="<?= $_404image;?>"
						alt="404 Silder"
						class="nk-image-slider-img"
						data-thumb="<?= $_404image_thumb;?>">
				</div>
			<?php
			endif;
		endif;
	?>
</div>
    <!-- END: Image Slider -->