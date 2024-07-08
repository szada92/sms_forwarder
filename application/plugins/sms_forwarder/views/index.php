<div id="window_container">
	<div id="window_title"><?php echo $title; ?></div>
	<div id="window_content">
		<?php echo form_open('plugin/sms_forwarder/save', array('id' => 'settingsForm')); ?>
		<table width="100%" cellpadding="5">
			<tr valign="top">
				<td width="175px"><?php echo tr('Enable SMS forwarding'); ?></td>
				<td>
					<?php
					$enabled = array('true' => tr('Yes'), 'false' => tr('No'));
					if ($settings->num_rows() === 1) {
						$enabled_act = $settings->row('enabled');
					} else {
						$enabled_act = 'false';
					}
					echo form_dropdown('enabled', $enabled, $enabled_act);
					?>
				</td>
			</tr>

			<tr valign="top">
				<td><?php echo tr('Trigger Sender Phone Numbers'); ?></td>
				<td>
					<input type="text" name="trigger_sender_phone_number" class="phone_numbers" value="<?php if ($settings->num_rows() === 1) {
						echo htmlentities($settings->row('trigger_sender_phone_number'), ENT_QUOTES);
					} ?>" />
				</td>
			</tr>

			<tr valign="top">
				<td><?php echo tr('Trigger SMS Contains'); ?></td>
				<td>
					<input type="text" name="trigger_sms_contains" class="trigger_sms" value="<?php if ($settings->num_rows() === 1) {
						echo htmlentities($settings->row('trigger_sms_contains'), ENT_QUOTES);
					} ?>" />
				</td>
			</tr>

			<tr valign="top">
				<td><?php echo tr('Phonebook Group ID'); ?></td>
				<td>
					<input type="text" name="phonebook_group_id" class="phonebook_group_id" value="<?php if ($settings->num_rows() === 1) {
						echo htmlentities($settings->row('phonebook_group_id'), ENT_QUOTES);
					} ?>" />
				</td>
			</tr>
		</table>
		<br />
		<input type="hidden" name="mode" value="<?php echo htmlentities($mode, ENT_QUOTES); ?>" />
		<div align="center"><input type="submit" id="submit" value="<?php echo tr('Save'); ?>" /></div>
		<?php echo form_close(); ?>
	</div>
</div>