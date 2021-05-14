<?php $image_url = $this->Url->build('/', ['escape' => false,'fullBase' => true,]);?>
<?= $this->element('component/menu'); ?>
<?= $this->element('component/footer'); ?>
<!-- START: Page Background -->
<img class="nk-page-background-top" src="<?= $image_url.'images/bg-top.png'?>" alt="">
<img class="nk-page-background-bottom" src="<?= $image_url.'images/bg-bottom.png'?>" alt="">