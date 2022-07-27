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

SELECT r.`id`, u.`email`, u.`avatar`, u.`last_active`, u.`verified`, u.`username`, r.`full_name`, r.`time`

	FROM `<?php echo($data['t_reqs']) ?>` r

	INNER JOIN `<?php echo($data['t_users']); ?>` u ON r.`user_id` = u.`id`

	WHERE u.`active` IN ('1', '2')

	<?php if($data['offset']): ?>

		<?php if($data['offset_to'] == 'gt'): ?>

			AND r.`id` > <?php echo($data['offset']) ?>

		<?php else: ?>

			AND r.`id` < <?php echo($data['offset']) ?>

		<?php endif; ?>	

	<?php endif; ?>

	ORDER BY r.`id` <?php echo($data['order']) ?> 

<?php if($data['limit']): ?>	
	LIMIT <?php echo($data['limit']) ?>
<?php endif; ?>