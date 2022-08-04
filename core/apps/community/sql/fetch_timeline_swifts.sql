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

SELECT u.`id`, u.`username`, u.`fname`, u.`lname`, u.`avatar`, u.`swift` FROM `<?php echo($data['t_users']); ?>` u
	
	WHERE u.`swift_update` > <?php echo time(); ?>

	AND (u.`id` = <?php echo($data['user_id']); ?> OR u.`id` IN (SELECT `following_id` FROM `<?php echo($data['t_conns']); ?>` WHERE `follower_id` = <?php echo($data['user_id']); ?> AND `status` = "active"))

ORDER BY u.`swift_update` DESC;