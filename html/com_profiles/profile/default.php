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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Registry\Registry;

HTMLHelper::_('jquery.framework');

// Board module
$boardModule            = new stdClass();
$boardModule->id        = 0;
$boardModule->title     = Text::_('TPL_NERUDAS_PROFILE_BOARD');
$boardModule->module    = 'mod_board_latest';
$boardModule->position  = '';
$boardModule->content   = '';
$boardModule->showtitle = 0;
$boardModule->control   = '';
$boardModule->params    = new Registry();
$boardModule->params->set('layout', 'nerudas:profile');
$boardModule->params->set('style', 'blank');
$boardModule->params->set('author_id', $this->item->id);
$boardModule->params->set('allregions', 1);
$boardModule->params = (string) $boardModule->params;
$boardModule->style  = 'blank';
$boardModule         = ModuleHelper::renderModule($boardModule);


// Prototype module
$prototypeModule            = new stdClass();
$prototypeModule->id        = 0;
$prototypeModule->title     = Text::_('TPL_NERUDAS_PROFILE_PROTOTYPE');
$prototypeModule->module    = 'mod_prototype_latest';
$prototypeModule->position  = '';
$prototypeModule->content   = '';
$prototypeModule->showtitle = 0;
$prototypeModule->control   = '';
$prototypeModule->params    = new Registry();
$prototypeModule->params->set('layout', 'nerudas:profile');
$prototypeModule->params->set('style', 'blank');
$prototypeModule->params->set('limit', '20');
$prototypeModule->params->set('author_id', $this->item->id);
$prototypeModule->params->set('allregions', 1);
$prototypeModule->params = (string) $prototypeModule->params;
$prototypeModule         = ModuleHelper::renderModule($prototypeModule);

?>
<div id="profiles" class="item">
	<?php echo LayoutHelper::render('template.title', array('edit' => $this->editLink)); ?>
	<div class="header uk-margin-bottom">
		<div class="bg uk-display-block uk-cover-background"
			 style="background-image: url('<?php echo $this->item->header; ?>');"></div>
		<div class="info">
			<div class="avatar">
				<div class="image uk-display-block uk-cover-background"
					 style="background-image: url('<?php echo $this->item->avatar; ?>');">
				</div>
			</div>
			<div class="uk-width-1-1">
				<div class="content uk-grid uk-grid-small">
					<div class="author  uk-width-1-2 uk-width-medium-3-4">
						<div class="uk-text-large">
							<?php echo $this->item->name; ?>
						</div>
						<?php if ($this->item->job) : ?>
							<div class="job">
								<a href="<?php echo $this->item->job_link; ?>"><?php echo $this->item->job_name; ?></a>
								<?php if (!empty($this->item->position)): ?>
									<i class="uk-margin-left uk-text-muted">(<?php echo $this->item->position; ?>)</i>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="uk-width-1-2 uk-width-medium-1-4 uk-text-right">
						<div class="uk-text-nowrap">
							<time class="timeago uk-text-muted uk-text-small uk-text-nowrap uk-margin-small-left"
								  data-uk-tooltip
								  datetime="<?php echo HTMLHelper::date($this->item->created, 'c'); ?>"
								  title="<?php echo HTMLHelper::date($this->item->created, 'd.m.Y H:i'); ?>"></time>
						</div>
						<div class="uk-text-right uk-margin-small-bottom uk-text-nowrap">
							<span class="uk-badge uk-badge-white uk-margin-small-left">
								<i class="uk-icon-eye uk-margin-small-right"></i><?php echo $this->item->hits; ?>
							</span>
							<a href="<?php echo $this->item->link; ?>#comments"
							   class="uk-badge uk-badge-white uk-margin-small-left">
								<i class="uk-icon-comment-o uk-margin-small-right"></i>
								<?php echo ($this->comments && $this->comments->total) ? $this->comments->total : 0; ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<ul class="uk-tab-new uk-margin-bottom-remove" data-uk-switcher="{connect:'#profileTabs', swiping: false}"
		data-save-tabs="profileTabs">
		<li><a href="#about"><?php echo Text::_('COM_PROFILES_PROFILE_ABOUT'); ?></a></li>
		<?php if ($this->item->contacts) : ?>
			<li><a href="#contacts"><?php echo Text::_('COM_PROFILES_PROFILE_CONTACTS'); ?></a></li>
		<?php endif; ?>
		<?php if (!empty($this->jobs)) : ?>
			<li><a href="#jobs"><?php echo Text::_('TPL_NERUDAS_PROFILE_JOB'); ?></a></li>
		<?php endif; ?>
		<li><a href="#prototype"><?php echo Text::_('TPL_NERUDAS_PROFILE_PROTOTYPE'); ?></a></li>
		<li><a href="#board"><?php echo Text::_('TPL_NERUDAS_PROFILE_BOARD'); ?></a></li>
		<li><a href="#comments"><?php echo Text::_('TPL_NERUDAS_REVIEWS'); ?></a></li>
	</ul>

	<ul id="profileTabs" class="uk-switcher" data-uk-switcher-tabs="">
		<li data-tab="about" class="uk-panel uk-panel-box">
			<div>
				<?php if (!empty($this->item->status)): ?>
					<div class="uk-margin-bottom">
						<blockquote>
							<div class="uk-padding">
								<?php echo $this->item->status; ?>
							</div>
						</blockquote>
					</div>
				<?php endif; ?>
				<div>
					<?php echo $this->item->about; ?>
				</div>
				<?php if (!empty($this->item->tags->itemTags)): ?>
					<hr>
					<div class="uk-margin-small-top tags">
						<?php if ($this->item->tags): ?>
							<?php foreach ($this->item->tags->itemTags as $tag): ?>
								<span class="uk-tag"><?php echo $tag->title; ?></span>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</li>
		<?php if ($this->item->contacts) : ?>
			<li data-tab="contacts" class="uk-panel uk-panel-box">
				<div class="uk-text-right">
					<span class="uk-badge uk-badge-white uk-margin-small-left">
						<?php echo $this->item->region_name; ?>
					</span>
				</div>
				<dl class="uk-description-list-horizontal">
					<?php if ($this->item->contacts->get('phones', false)) : ?>
						<dt><?php echo Text::_('JGLOBAL_FIELD_PHONES_LABEL'); ?></dt>
						<dd class="uk-margin-bottom">
							<?php foreach ($this->item->contacts->get('phones') as $phone): ?>
								<div class="uk-margin-small-bottom uk-display-block">
									<a class="uk-text-xlarge "
									   href="tel:<?php echo $phone->code . $phone->number; ?>">
										<?php $phone->display = (!empty($phone->display)) ?
											$phone->display : $phone->code . $phone->number;

										$regular = "/(\\+\\d{1})(\\d{3})(\\d{3})(\\d{2})(\\d{2})/";
										$subst   = '$1($2)$3-$4-$5';
										echo preg_replace($regular, $subst, $phone->display); ?>
									</a>
								</div>
							<?php endforeach; ?>
						</dd>
					<?php endif; ?>
					<?php if (!empty($this->item->contacts->get('email', ''))) : ?>
						<dt><?php echo Text::_('JGLOBAL_EMAIL'); ?></dt>
						<dd class="uk-margin-bottom">
							<a class="uk-margin-small-bottom"
							   href="mailto:<?php echo $this->item->contacts->get('email'); ?>">
								<?php echo $this->item->contacts->get('email'); ?>
							</a>
						</dd>
					<?php endif; ?>
					<?php if (!empty($this->item->contacts->get('site', ''))) : ?>
						<dt><?php echo Text::_('COM_PROFILES_PROFILE_SITE'); ?></dt>
						<dd class="uk-margin-bottom">
							<a class="uk-margin-small-bottom" href="<?php echo $this->item->contacts->get('site'); ?>"
							   target="_blank">
								<?php echo trim(str_replace(array('http://', 'https://'), '', $this->item->contacts->get('site')), '/'); ?>
							</a>
						</dd>
					<?php endif; ?>
					<?php if (!empty($this->item->contacts->get('vk', ''))) : ?>
						<dt><?php echo Text::_('JGLOBAL_FIELD_SOCIAL_LABEL_VK'); ?></dt>
						<dd class="uk-margin-bottom">
							<a class="uk-margin-small-bottom"
							   href="https://vk.com/<?php echo $this->item->contacts->get('vk'); ?>"
							   target="_blank">
								vk.com/<?php echo $this->item->contacts->get('vk'); ?>
							</a>
						</dd>
					<?php endif; ?>
					<?php if (!empty($this->item->contacts->get('facebook', ''))) : ?>
						<dt><?php echo Text::_('JGLOBAL_FIELD_SOCIAL_LABEL_FB'); ?></dt>
						<dd class="uk-margin-bottom">
							<a class="uk-margin-small-bottom"
							   href="https://facebook.com/<?php echo $this->item->contacts->get('facebook'); ?>"
							   target="_blank">
								facebook.com/<?php echo $this->item->contacts->get('facebook'); ?>
							</a>
						</dd>
					<?php endif; ?>
					<?php if (!empty($this->item->contacts->get('instagram', ''))) : ?>
						<dt><?php echo Text::_('JGLOBAL_FIELD_SOCIAL_LABEL_INST'); ?></dt>
						<dd class="uk-margin-bottom">
							<a class="uk-margin-small-bottom"
							   href="https://instagram.com/<?php echo $this->item->contacts->get('instagram'); ?>"
							   target="_blank">
								instagram.com/<?php echo $this->item->contacts->get('instagram'); ?>
							</a>
						</dd>
					<?php endif; ?>
				</dl>
			</li>
		<?php endif; ?>
		<?php if (!empty($this->jobs)) : ?>
			<li data-tab="jobs" class="uk-panel uk-panel-box">
				<div class="jobs">
					<?php foreach ($this->jobs as $company): ?>
						<div class="item uk-margin-bottom">
							<div class="uk-grid uk-grid-small">
								<div class="uk-width-small-3-4">
									<div>
										<div class="uk-h3 uk-margin-small-bottom">
											<a class="uk-display-block uk-link-muted"
											   href="<?php echo $company->link; ?>">
												<?php echo $company->name; ?>
												<?php if ($company->logo): ?>
													<sup><img class="logo" src="<?php echo $company->logo; ?>"
															  alt="<?php echo $company->name; ?>"></sup>
												<?php endif; ?>
											</a>
										</div>
									</div>

									<div class="uk-text-muted">
										<?php echo HTMLHelper::_('string.truncate', (strip_tags($company->about)), 100); ?>
									</div>

								</div>
								<div class="uk-width-small-1-4">
									<div class="uk-text-right">
										<div class="uk-text-right uk-margin-small-bottom uk-text-nowrap">
											<a href="<?php echo $company->link; ?>"
											   class="uk-badge uk-badge-white uk-margin-small-left">
												<i class="uk-icon-eye uk-margin-small-right"></i><?php echo $company->hits; ?>
											</a>
											<a href="<?php echo $company->link; ?>#comments"
											   class="uk-badge uk-badge-white uk-margin-small-left">
												<i class="uk-icon-comment-o uk-margin-small-right"></i>0
											</a>
											<?php if ($company->region_icon): ?>
												<div class="region uk-margin-top uk-text-small">
													<img src="<?php echo $company->region_icon; ?>"
														 alt="<?php echo $company->region_name; ?>"
														 data-uk-tooltip title="<?php echo $company->region_name; ?>"/>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr>
					<?php endforeach; ?>
				</div>
			</li>
		<?php endif; ?>
		<li data-tab="prototype" class="uk-panel uk-panel-box">
			<div>
				<?php echo $prototypeModule; ?>
			</div>
		</li>
		<li data-tab="board" class="uk-panel uk-panel-box">
			<div>
				<?php echo $boardModule; ?>
			</div>
		</li>
		<li data-tab="comments" class="uk-panel uk-panel-box">
			<?php echo $this->comments->render; ?>
		</li>
	</ul>
	<?php
	$user = Factory::getUser();
	if ($user->authorise('core.edit', 'com_users') && $user->authorise('core.manage', 'com_users') && $user->authorise('core.admin')): ?>
		<div class=" uk-margin-top uk-text-large">
			<a href="/administrator/index.php?option=com_users&task=user.edit&id=<?php echo $this->item->id; ?>"
			   target="_blank" class="uk-margin-right">
				#<?php echo $this->item->id; ?>
			</a>
		</div>
	<?php endif; ?>
</div>
