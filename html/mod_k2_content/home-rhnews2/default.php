<?php
/**
 * @package     JoomlaZen Nerudas Template
 * @version     4.3
 * @author      JoomlaZen - www.joomlazen.com
 * @copyright   Copyright (c) 2016 - 2016 JoomlaZen. All rights reserved.
 * @license     GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
if ($params->get('itemCustomLinkMenuItem')){
	$menu = JMenu::getInstance('site');
    $menuLink = $menu->getItem($params->get('itemCustomLinkMenuItem'));
    $params->set('itemCustomLinkURL', JRoute::_('index.php?&Itemid='.$menuLink->id));
}
$date = new JDate('now');

$date = JHTML::_('date', $date, 'j F');
?>

<div class="rhnews">
	<div class="mtitle uk-clearfix">
		<a href="/news"
		   class="uk-text-xlarge uk-link-muted uk-margin-small-top">
			<?php echo $params->get('itemPreText'); ?>
		</a>
	</div>
	<ul class="uk-list uk-list-space uk-list-line uk-margin-bottom-remove">
	<?php foreach ($items as $key => $item):
		$item->mintext = NerudasUtility::minimalizeText($item->introtext);
		if ($item->extra_fields) {
			$item->extra = NerudasK2Helper::getItemExtra($item->extra_fields);
		}
		if (empty($item->image)) {
			$item->image = '/templates/'.$app->getTemplate().'/images/noimages/'.$item->catid.'.jpg';
		}
	?>

	<?php if ($item->catid == 315): ?>
	<li class="herak item">
		<a class="uk-overlay uk-overlay-hover uk-display-block" href="<?php echo $item->link; ?>">
			<div class="uk-text-center">
				<img src="<?php echo $item->image; ?>"
					 alt="<?php echo str_replace('"','', $item->title); ?>"
				class="uk-width-1-1"/>
			</div>
			<div class="uk-overlay-panel uk-overlay-panel-small uk-overlay-background ">
				<div class="title">
					<?php echo $item->extra['city']->value; ?>
				</div>
				<div class="uk-text-small text">
					<?php echo $item->mintext;?>
				</div>
			</div>
		</a>
	</li>
	<?php endif; ?>
	<?php if ($item->catid == 40): ?>
	<li class="rabotaem item">
		<div class="title uk-text-medium">
			<a href="<?php echo $item->link; ?>"
			   class="uk-link-muted">
				<?php echo JHTML::_('date', $item->publish_up, 'd.m'); ?> - <?php echo $item->title; ?></a>
		</div>
		<div class="uk-text-muted"><?php echo strip_tags($item->introtext);?></div>

	</li>
	<?php endif; ?>
		
	<?php endforeach; ?>
	</ul>
</div>
