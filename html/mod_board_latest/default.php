<?php
/**
 * @package    Nerudas Template
 * @version    4.9.6
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::_('jquery.framework');
HTMLHelper::_('script', '//api-maps.yandex.ru/2.1/?lang=ru-RU', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'modalmap.min.js', array('version' => 'auto', 'relative' => true));

?>
<div class="board-lastes-module">
	<?php if ($items) : ?>
		<div class="items">
			<?php foreach ($items as $id => $item): ?>

				<div class="item uk-panel uk-panel-box uk-margin-bottom">
					<div class="title uk-flex uk-flex-space-between">
						<?php echo LayoutHelper::render('content.author.horizontal',
							array('author_id' => $item->created_by, 'author_link' => $item->link)); ?>
						<div class="uk-text-right">

							<div class="uk-text-nowrap">
								<time class="timeago uk-text-muted uk-text-small uk-text-nowrap uk-margin-small-left"
									  data-uk-tooltip
									  datetime="<?php echo HTMLHelper::date($item->created, 'c'); ?>"
									  title="<?php echo HTMLHelper::date($item->created, 'd.m.Y H:i'); ?>"></time>
							</div>
							<div class="uk-text-right uk-margin-small-bottom uk-text-nowrap">
								<a href="<?php echo $item->link; ?>"
								   class="uk-badge uk-badge-white uk-margin-small-left">
									<i class="uk-icon-eye uk-margin-small-right"></i><?php echo $item->hits; ?>
								</a>
								<a href="<?php echo $item->link; ?>#comments"
								   class="uk-badge uk-badge-white uk-margin-small-left">
									<i class="uk-icon-comment-o uk-margin-small-right"></i>0
								</a>
							</div>
						</div>
					</div>
					<a class="uk-margin-top uk-grid uk-grid-small uk-link-muted" href="<?php echo $item->link; ?>">
						<div class="uk-width-small-3-4">
							<h2 class="uk-h4 uk-margin-small-bottom">
								<?php echo $item->title; ?>
								<?php if ($item->for_when == 'today'): ?>
									<sup class="uk-badge uk-badge-success uk-margin-small-left">
										<?php echo Text::_('COM_BOARD_ITEM_FOR_WHEN_TODAY'); ?>
									</sup>
								<?php elseif ($item->for_when == 'tomorrow'): ?>
									<sup class="uk-badge uk-badge-notification uk-margin-small-left">
										<?php echo Text::_('COM_BOARD_ITEM_FOR_WHEN_TOMORROW'); ?>
									</sup>
								<?php endif; ?>
								<?php if (!$item->state): ?>
									<sup class="uk-badge uk-badge-warning uk-margin-small-left">
										<?php echo Text::_('TPL_NERUDAS_ONMODERATION'); ?>
									</sup>
								<?php endif; ?>
								<?php if ($item->publish_down !== '0000-00-00 00:00:00' &&
									$item->publish_down < Factory::getDate()->toSql()): ?>
									<sup class="uk-badge uk-badge-danger uk-margin-small-left">
										<?php echo Text::_('TPL_NERUDAS_PUBLISH_TIMEOUT'); ?>
									</sup>
								<?php endif; ?>
							</h2>
							<div>
								<?php
								$text = JHtmlString::truncate($item->text, 100, false, false);
								$text = str_replace('...', '', $text);
								?>
								<span class="uk-text-small"><?php echo !empty($text) ? $text . '... ' : ''; ?></span>
								<span class="uk-link"><?php echo Text::_('TPL_NERUDAS_READMORE'); ?></span>
							</div>
						</div>
						<div class="uk-width-small-1-4 uk-flex uk-flex-top uk-flex-right">
							<?php if (!empty($item->price) ||
								$item->payment_method == 'cashless' || $item->payment_method == 'cash' ||
								$item->prepayment == 'required' || $item->prepayment == 'no') : ?>
								<div class="uk-price uk-text-right">
									<?php if (!empty($item->price)) : ?>
										<div class="text">
											<?php echo ($item->price == '-0') ? Text::_('JGLOBAL_FIELD_PRICE_CONTRACT_PRICE') :
												$item->price . ' ' . Text::_('JGLOBAL_FIELD_PRICE_CURRENCY_RUB'); ?>
										</div>
									<?php endif; ?>
									<div class="uk-text-right">
										<?php if ($item->payment_method == 'cashless')
										{
											echo HTMLHelper::image('icons/payment_method_cashless.png',
												Text::_('COM_BOARD_ITEM_PAYMENT_METHOD_CASHLESS'),
												array('title'           => Text::_('COM_BOARD_ITEM_PAYMENT_METHOD_CASHLESS'),
												      'data-uk-tooltip' => ''),
												true);

										}
										elseif ($item->payment_method == 'cash')
										{
											echo HTMLHelper::image('icons/payment_method_cash.png',
												Text::_('COM_BOARD_ITEM_PAYMENT_METHOD_CASH'),
												array('title'           => Text::_('COM_BOARD_ITEM_PAYMENT_METHOD_CASH'),
												      'data-uk-tooltip' => ''),
												true);
										}

										if ($item->prepayment == 'required')
										{
											echo HTMLHelper::image('icons/prepayment_required.png',
												Text::_('COM_BOARD_ITEM_PREPAYMENT_REQUIRED'),
												array('title'           => Text::_('COM_BOARD_ITEM_PREPAYMENT_REQUIRED'),
												      'data-uk-tooltip' => ''),
												true);

										}
										elseif ($item->prepayment == 'no')
										{
											echo HTMLHelper::image('icons/prepayment_no.png',
												Text::_('COM_BOARD_ITEM_PREPAYMENT_NO'),
												array('title'           => Text::_('COM_BOARD_ITEM_PREPAYMENT_NO'),
												      'data-uk-tooltip' => ''),
												true);
										} ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</a>
					<div class="uk-margin-top uk-grid uk-grid-small">
						<div class="uk-width-small-2-3 uk-flex uk-flex-bottom">
							<?php if ($item->contacts->get('phones', false)) : ?>
								<?php foreach ($item->contacts->get('phones') as $phone): ?>
									<a class="uk-text-xlarge uk-display-block"
									   href="tel:<?php echo $phone->code . $phone->number; ?>">
										<?php $phone->display = (!empty($phone->display)) ?
											$phone->display : $phone->code . $phone->number;
										$regular              = "/(\\+\\d{1})(\\d{3})(\\d{3})(\\d{2})(\\d{2})/";
										$subst                = '$1($2)$3-$4-$5';
										echo preg_replace($regular, $subst, $phone->display); ?>
									</a>
									<?php break; endforeach; ?>
							<?php endif; ?>
						</div>
						<div class="uk-width-small-1-3 uk-flex uk-flex-right uk-flex-bottom">
							<?php
							$item->region = ($item->region == '*') ? 100 : $item->region;
							echo HTMLHelper::image('regions/' . $item->region . '.png', $item->region_name,
								array('title' => $item->region_name, 'data-uk-tooltip' => ''), true); ?>

							<?php if ($item->map):
								$item->map = $item->map->toArray();
								$item->map['link'] = $item->link;
								Factory::getDocument()->addScriptOptions('board_' . $item->id, $item->map);
								?>
								<a data-uk-tooltip title="<?php echo Text::_('TPL_NERUDAS_ON_MAP'); ?>"
								   data-modalmap="board_<?php echo $item->id; ?>">
									<?php echo HTMLHelper::image('icons/map_30.png', Text::_('TPL_NERUDAS_ON_MAP'),
										'', true); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
					<?php if ($item->image) : ?>
						<div class="uk-margin-top">
							<div class="uk-grid uk-grid-small image">
								<?php
								$count = count($item->images);
								foreach ($item->images as $image): ?>
									<div class="uk-container-center
									<?php echo 'uk-width-small-1-' . $count; ?>">
										<a class="uk-position-relative uk-display-block"
										   href="<?php echo $item->link; ?>">
											 <span class="image uk-thumbnail uk-display-block uk-cover-background"
												   style="background-image: url('<?php echo $image['src']; ?>')"
												   data-ratio-height="[166,125]"></span>
										</a>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if (!empty($item->tags->itemTags)): ?>
						<div class="uk-margin-small-top tags">
							<?php if ($item->tags): ?>
								<?php foreach ($item->tags->itemTags as $tag): ?>
									<span class="uk-tag">
											<?php echo $tag->title; ?>
										</span>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>