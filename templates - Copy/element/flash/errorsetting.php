<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
	$message = h($message);
}
?>
<p onclick="this.classList.add('hidden');" class="forget-pass"><?= $message ?></p>