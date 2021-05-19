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

<!-- START: Login Modal -->
<div class="nk-modal modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="ion-android-close"></span>
				</button>

				<h4 class="mb-0"><span class="text-main-1">Sign</span> In</h4>

				<div class="nk-gap-1"></div>
				<form action="login" method="post" class="nk-form text-white">
					<div class="row vertical-gap">
						<div class="col-md-6">
							Use email and password:

							<div class="nk-gap"></div>
							<input type="email" value="" name="email" class="required form-control" placeholder="Email">

							<div class="nk-gap"></div>
							<input type="password" value="" name="password" class="required form-control" placeholder="Password">
						</div>
						<div class="col-md-6">
							Or social account:

							<div class="nk-gap"></div>

							<ul class="nk-social-links-2">
								<li><a class="nk-social-facebook" href="#"><span class="fab fa-facebook"></span></a></li>
								<li><a class="nk-social-google-plus" href="#"><span class="fab fa-google-plus"></span></a></li>
								<li><a class="nk-social-twitter" href="#"><span class="fab fa-twitter"></span></a></li>
							</ul>
						</div>
					</div>

					<div class="nk-gap-1"></div>
					<div class="row vertical-gap">
						<div class="col-md-6">
							<?php
							echo $this->Form->button('Sign In', [
								'type' => 'submit',
								'class' => 'nk-btn nk-btn-rounded nk-btn-color-white nk-btn-block',
							]); ?>
						</div>
						<div class="col-md-6">
							<div class="mnt-5">
								<small><a href="#">Forgot your password?</a></small>
							</div>
							<div class="mnt-5">
								<small><a href="#">Not a member? Sign up</a></small>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- END: Login Modal -->

<!-- START:Search -->
<div class="nk-modal modal fade" id="modalSearch" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="ion-android-close"></span>
				</button>
				<h4 class="mb-0">Search</h4>
				<div class="nk-gap-1"></div>
				<form action="#" class="nk-form nk-form-style-1">
					<input type="text" value="" name="search" class="form-control" placeholder="Type something and press Enter" autofocus>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- END: Search -->