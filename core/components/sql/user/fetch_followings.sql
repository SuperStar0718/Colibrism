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

SELECT c.`id` AS offset_id, u.`id`, u.`about`, u.`followers`, u.`website`, u.`following`, u.`posts`, u.`avatar`, u.`country_id`, u.`last_active`, u.`username`, u.`fname`, u.`lname`, u.`email`, u.`verified`, u.`follow_privacy` FROM `<?php echo($data['t_conns']); ?>` c
	
	INNER JOIN `<?php echo($data['t_users']); ?>` u ON c.`following_id` = u.`id`

	WHERE c.`follower_id` = "<?php echo($data['user_id']); ?>"

	AND c.`status` = "active"

	AND u.`active` IN ('1', '2')

	<?php if($data['offset']): ?>
		AND c.`id` < <?php echo($data['offset']); ?>
	<?php endif; ?>

	ORDER BY c.`id` DESC, u.`followers` DESC, u.`posts` DESC

<?php if(not_empty($data['limit'])): ?>
	LIMIT <?php echo($data['limit']); ?>;
<?php endif; ?>