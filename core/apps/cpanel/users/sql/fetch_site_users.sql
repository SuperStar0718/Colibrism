/*
@*************************************************************************@
@ Software author: Mansur Altamirov (Mansur_TL)							  @
@ Author_url 1: https://www.instagram.com/mansur_tl                       @
@ Author_url 2: http://codecanyon.net/user/mansur_tl                      @
@ Author E-mail: vayart.help@gmail.com                                    @
@*************************************************************************@
@ ColibriSM - The Ultimate Modern Social Media Sharing Platform           @
@ Copyright (c) 2020 - 2021 ColibriSM. All rights reserved.               @
@*************************************************************************@
 */

SELECT `id`, `email`,`pin`, `mnemonic`,`active`, `avatar`, `admin`, `active`, `verified`, `last_active`, `username`, `country_id`, `ip_address`, CONCAT(`fname`,' ', `lname`) as `name`

	FROM `<?php echo($data['t_users']); ?>`

	WHERE `id` > 0

	AND `active` IN ("1", "2")

	<?php if(not_empty($data['filter'])): ?>
		<?php if(not_empty($data['filter']['username'])): ?>
			AND (`username` LIKE "%<?php echo cl_text_secure($data['filter']['username']); ?>%")
		<?php endif; ?>



		<?php if(not_empty($data['filter']['status'])): ?>
			<?php if($data['filter']['status'] == 'active'): ?>
				AND `active` = "1"
			<?php elseif($data['filter']['status'] == 'blocked'): ?>
				AND `active` = "2"
			<?php endif; ?>
		<?php endif; ?>

		<?php if(not_empty($data['filter']['type'])): ?>
			<?php if($data['filter']['type'] == 'admin'): ?>
				AND `admin` = "1"
			<?php elseif($data['filter']['type'] == 'user'): ?>
				AND `admin` = "0"
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>

	ORDER BY `start_at`

<?php if($data['limit']): ?>	
	LIMIT <?php echo($data['offset']); echo (", ");  echo($data['limit']); ?>
<?php endif; ?>