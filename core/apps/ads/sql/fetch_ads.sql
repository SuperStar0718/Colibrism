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

SELECT * FROM `<?php echo($data['t_ads']); ?>`
	
	WHERE `user_id` = <?php echo($data['user_id']); ?>

	AND `status` IN ('active', 'inactive')

	<?php if($data['type'] == 'active'): ?>
		AND `status` = 'active' AND `approved` = 'Y'
	<?php elseif($data['type'] == 'inactive'): ?>
		AND `status` = 'inactive' AND `approved` = 'Y'
	<?php elseif($data['type'] == 'pending'): ?>
		AND `status` IN ('inactive', 'active') AND `approved` = 'N'
	<?php endif; ?>

	ORDER BY `clicks` DESC, `views` DESC

<?php if($data['offset']): ?>
	LIMIT <?php echo($data['offset']); ?>, <?php echo($data['offset'] + 10); ?>;
<?php else: ?>
	LIMIT <?php echo($data['limit']); ?>;
<?php endif; ?>