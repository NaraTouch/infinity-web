<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
	$message = h($message);
}
?>
<h1 onclick="this.classList.add('hidden');" class="forget-pass"><?= $message ?></h1>