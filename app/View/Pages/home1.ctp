<?php
/**
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */
$this->layout = 'public';
$this->assign('title', 'hogehoge');

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;

App::uses('Debugger', 'Utility');
?>
<h2><?php echo 'H2テキスト'; ?></h2>
<p>
	Roleの種類（テスト取得）
</p>
<ul>
	<?php
	foreach ($myhistories as $history): ?>
		<li><?=  $history['Role']['name']; ?></li>
		<?php endforeach; ?>
</ul>

