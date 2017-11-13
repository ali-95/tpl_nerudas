<?php
/**
 * @package     Nerudas Template
 * @version     5.0
 * @author      Nerudas - nerudas.ru
 * @copyright   Copyright (c) 2013 - 2017 Nerudas. All rights reserved.
 * @license     GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
defined('_JEXEC') or die('Restricted access');
$attributes = array();
if ($item->anchor_title) {
	$attributes['title'] = $item->anchor_title;
}
if ($item->anchor_css) {
	$attributes['class'] = $item->anchor_css;
}
if ($item->anchor_rel) {
	$attributes['rel'] = $item->anchor_rel;
}
if ($item->browserNav == 1) {
	$attributes['target'] = '_blank';
}
elseif ($item->browserNav == 2) {
	$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes';
	$attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}
echo JHtml::_('link',$item->flink, $item->title, $attributes);