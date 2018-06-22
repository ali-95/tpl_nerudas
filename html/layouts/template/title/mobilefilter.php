<?php
/**
 * @package    Nerudas Template
 * @version    4.9.15
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

$displayData = (empty($displayData)) ? array() : $displayData;
extract($displayData);


/**
 * Layout variables
 * -----------------
 * @var  string $add  Add Link
 * @var  string $edit Edit link
 * @var  string $form Form actions controler name
 */

$app     = Factory::getApplication();
$pathway = $app->getPathway();
$items   = $pathway->getPathWay();
$menu    = $app->getMenu();

$home       = new stdClass();
$home->name = Text::_('TPL_NERUDAS_HOME');
$home->link = '/';
array_unshift($items, $home);

$count = count($items);
$i     = 1;

$revers  = array_reverse($items);
$current = $revers[0];
unset($revers[0]);

$margin = (!isset($margin)) ? true : $margin;

?>
<div class="uk-hidden-medium uk-hidden-large" data-title-mobilefilter>
	<ul class="uk-breadcrumb uk-margin-small-bottom">
		<?php foreach ($items as $item): ?>
			<?php if ($i !== $count) : ?>
				<li class="item">
					<a href="<?php echo Route::_($item->link); ?>">
						<?php echo $item->name; ?>
					</a>
				</li>
			<?php else: ?>
				<li class="item">
					<span>
						<?php echo $item->name; ?>
					</span>
				</li>
			<?php endif; ?>
			<?php $i++; ?>
		<?php endforeach; ?>
	</ul>
	<?php if (!empty($subitems)): ?>
		<ul class="uk-breadcrumb subitems uk-margin-small-top uk-margin-bottom-remove ">
			<?php foreach ($subitems as $subitem): ?>
				<li class="item">
					<a href="<?php echo Route::_($subitem->link); ?>">
						<?php echo $subitem->name; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<hr>
	<div class="actions uk-margin-small-top uk-text-right">
		<a class="close uk-button uk-button-danger" data-uk-tooltip
		   data-title-mobilefilter-action="close"
		   title="<?php echo Text::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?>">
			<?php echo Text::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?>
		</a>
		<?php if (!empty($add)) :
			$addText = (!empty($addText)) ? $addText : 'TPL_NERUDAS_ACTIONS_ADD';
			?>
			<a href="<?php echo $add; ?>" class="add uk-button uk-button-success" data-uk-tooltip
			   title="<?php echo Text::_($addText); ?>">
				<?php echo Text::_($addText); ?>
			</a>
		<?php endif; ?>
	</div>
</div>
