<?php
/**
 * @package    Nerudas Template
 * @version    4.9.42
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$app = Factory::getApplication();

LayoutHelper::render('components.com_prototype.map.head');

?>
<div id="prototype" class="map">
	<div class="map-block">
		<div class="uk-hidden-medium uk-hidden-large">
			<div class="uk-button-group uk-width-1-1 ">
				<a class="uk-button uk-width-1-<?php echo ($this->addLink) ? '2' : '1' ?> uk-button-white"
				   data-title-mobilefilter-action="open">
					<?php echo Text::_('TPL_NERUDAS_SECTIONS'); ?>
				</a>
				<?php if ($this->addLink): ?>
					<a class="uk-button uk-width-1-<?php echo ($this->addLink) ? '2' : '1' ?> uk-button-success"
					   href="<?php echo $this->addLink; ?>">
						<?php echo Text::_('TPL_NERUDAS_ACTIONS_ADD'); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php $layouts = array('list' => $this->listLink, 'map' => $this->mapLink, 'active' => 'map');
		$menus         = $app->getMenu();
		$menu          = $menus->getActive();
		$subitems      = array();
		foreach ($menus->getItems(array('menutype', 'level'), array($menu->menutype, 2)) as $menuItem)
		{
			if ($menuItem->getParams()->get('menu_show'))
			{
				$object       = new stdClass();
				$object->name = $menuItem->title;
				$object->link = $menuItem->link;

				$subitems[] = $object;
			}
		}
		?>

		<?php echo LayoutHelper::render('template.title.mobilefilter', array(
			'add'      => $this->addLink,
			'layouts'  => $layouts,
			'subitems' => $subitems,
			'margin'   => false)); ?>

		<div class="uk-hidden-small">
			<?php echo LayoutHelper::render('template.title', array(
				'add'      => $this->addLink,
				'layouts'  => $layouts,
				'subitems' => $subitems,
				'margin'   => false)); ?>
		</div>
		<div id="map" data-prototype-map>
			<div class="zoom" data-afterInit="show">
				<a data-prototype-map-zoom="plus"
				   class="uk-flex uk-flex-middle uk-flex-center uk-icon-small uk-icon-plus uk-text-success"></a>
				<span data-prototype-map-zoom="current"
					  class="uk-flex uk-flex-middle uk-flex-center uk-hidden-small"></span>
				<a data-prototype-map-zoom="minus"
				   class="uk-flex uk-flex-middle uk-flex-center uk-icon-small uk-icon-minus uk-text-danger"></a>
			</div>

			<div class="users-counter" data-afterInit="show">
				<?php
				$this->visitors = ($this->visitors > 2) ? $this->visitors : 2;
				echo Text::sprintf('TPL_NERUDAS_MAP_VISITORS', $this->visitors); ?>
			</div>
			<div class="geo" data-afterInit="show">
				<a class="uk-button uk-icon-location-arrow" data-prototype-map-geo></a>
			</div>
		</div>
	</div>
	<div data-prototype-map-itemlist="container" class="uk-panel uk-panel-box uk-padding-remove uk-hidden-small">

		<form action="<?php echo htmlspecialchars(Factory::getURI()->toString()); ?>" method="get" name="adminForm"
			  class="uk-form primary-fiter filter desktop-filter uk-margin-small-bottom"
			  data-prototype-map-filter>
			<div class="">
				<div class="uk-form-row uk-flex uk-flex-wrap uk-flex-middle">
					<div class="uk-margin-right uk-flex">
						<?php
						$class = $this->filterForm->getFieldAttribute('search', 'class', '', 'filter') . ' uk-width-1-1';
						$this->filterForm->setFieldAttribute('search', 'class', $class, 'filter');
						$this->filterForm->setFieldAttribute('search', 'id', 'filter_search_desktop');
						echo $this->filterForm->getInput('search', 'filter'); ?>
						<div class="uk-button-group left-input">
							<button type="submit" class="uk-button uk-text-primary uk-icon-search uk-hidden-small"
									title="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>" data-uk-tooltip>
							</button>
						</div>
					</div>
				</div>
				<?php foreach ($this->filterForm->getFieldset('extra') as $field):
					$name = $field->getAttribute('name');
					$class = $field->getAttribute('class');
					$this->filterForm->setFieldAttribute($name, 'class', $class . ' uk-width-1-1', 'extra');
					?>
					<div class="uk-form-row">
						<?php echo $this->filterForm->getInput($name, 'extra'); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</form>
		<div class="modules">
			<?php echo Factory::getDocument()->loadRenderer('modules')->render('map-beforeitems', array('style' => 'blank')); ?>
		</div>
		<div data-prototype-map-itemlist="items"></div>
		<div class="uk-margin-large-bottom"></div>
	</div>
</div>
<?php echo LayoutHelper::render('components.com_prototype.map.balloon'); ?>

