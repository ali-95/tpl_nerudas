<?php
/**
 * @package    Nerudas Template
 * @version    4.9.2
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2017 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;
?>

<div class="uk-form-row">
	<?php if (!empty($field->title)): ?>
		<label class="uk-form-label"><?php echo $field->title; ?></label>
	<?php endif; ?>
	<div class="uk-form-controls">
		<select name="extra[<?php echo $field->id; ?>][]" multiple>
			<?php foreach ($field->values as $val): ?>
				<option value="<?php echo $val->value; ?>" <?php if ($val->active) {
					echo 'selected';
				} ?>><?php echo $val->name; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>