<?php
$session = false;
if ($this->request->getSession()->read('Auth.User')) :
	$session = true;
endif;
$image_url = $this->Url->build('/', ['escape' => false,'fullBase' => true,]);
?>
<header class="nk-header nk-header-opaque">
	<div class="nk-contacts-top">
		<div class="container">
			<div class="nk-contacts-right">
				<ul class="nk-contacts-icons">
					<li>
						<a href="#" data-toggle="modal" data-target="#modalSearch">
							<span class="fa fa-search"></span>
						</a>
					</li>
					<?php if ($session) : ?>
					<li>
						<a href="#">
							<span><?= $this->request->getSession()->read('Auth.User.email');?></span>
						</a>
					</li>
					<li>
						<?= $this->Html->link('logout', [
							'controller' => 'Users',
							'action' => 'logout'
						]); ?>
					</li>
					<?php else : ?>
					<li>
						<a href="#" data-toggle="modal" data-target="#modalLogin">
							<span class="fa fa-user"></span>
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<nav class="nk-navbar nk-navbar-top nk-navbar-sticky nk-navbar-autohide">
		<div class="container">
			<div class="nk-nav-table">
				<a href="<?php echo $this->Url->build('/', ['escape' => false,'fullBase' => true,]); ?>" class="nk-nav-logo">
					<img src="<?= $image_url.'images/logo.png'?>" alt="GoodGames" width="199">
				</a>
				<ul class="nk-nav nk-nav-right d-none d-lg-table-cell" data-nav-mobile="#nk-nav-mobile">
					<?php foreach ($layout as $key => $value) :
							if (!empty($value->subpages)) :
								if (count($value->subpages) > 1) :
					?>
								<li class=" nk-drop-item">
									<a><?= h($value->display);?></a>
									<ul class="dropdown">
										<?php foreach ($value->subpages as $k => $v) : ?>
										<li>
											<?= $this->Html->link(h($v->display), [
												'controller' => $value->tag_links,
												'action' => $v->tag_links
											]); ?>
										</li>
										<?php endforeach; ?>
									</ul>
								</li>
								<?php else :?>
								<li>
									<?php foreach ($value->subpages as $k => $v) :?>
									<li>
										<?= $this->Html->link(h($v->display), [
											'controller' => $value->tag_links,
											'action' => $v->tag_links
										]); ?>
									</li>
									<?php endforeach; ?>
								</li>
								<?php endif; ?>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
				<ul class="nk-nav nk-nav-right nk-nav-icons">
					<li class="single-icon d-lg-none">
						<a href="#" class="no-link-effect" data-nav-toggle="#nk-nav-mobile">
							<span class="nk-icon-burger">
								<span class="nk-t-1"></span>
								<span class="nk-t-2"></span>
								<span class="nk-t-3"></span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
<!-- mobile menu -->
<div id="nk-nav-mobile" class="nk-navbar nk-navbar-side nk-navbar-right-side nk-navbar-overlay-content d-lg-none">
	<div class="nano">
		<div class="nano-content">
			<a href="<?php echo $this->Url->build('/', ['escape' => false,'fullBase' => true,]); ?>" class="nk-nav-logo">
				<img src="<?= $image_url.'images/logo.png'?>" alt="" width="120">
			</a>
			<div class="nk-navbar-mobile-content">
				<ul class="nk-nav">
					<!-- Here will be inserted menu from [data-mobile-menu="#nk-nav-mobile"] -->
				</ul>
			</div>
		</div>
	</div>
</div>
