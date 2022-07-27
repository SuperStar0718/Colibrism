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

SELECT COUNT(*) AS total FROM `<?php echo($data['t_notifs']); ?>`
	
	WHERE `recipient_id` = <?php echo($data['user_id']); ?>

	<?php if($data['type'] == "notifs"): ?>
		AND `subject` IN ('reply','subscribe', 'like', 'repost', 'verified', 'visit', 'subscribe_request', 'subscribe_accept', 'ad_approval')
	<?php else: ?>
		AND `subject` = 'mention'
	<?php endif; ?>

	AND `notifier_id` NOT IN (SELECT b.`profile_id` FROM `<?php echo($data['t_blocks']); ?>` b WHERE b.`user_id` = <?php echo($data['user_id']); ?>)