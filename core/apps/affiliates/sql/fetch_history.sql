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

SELECT * FROM `<?php echo($data['t_affils']); ?>`
	
	WHERE `user_id` = <?php echo($data['user_id']); ?>

	<?php if(not_empty($data['offset'])): ?>
		AND `id` < <?php echo($data['offset']); ?>
	<?php endif; ?>

	ORDER BY `id` DESC 

<?php if(not_empty($data['limit'])): ?>
	LIMIT <?php echo($data['limit']); ?>;
<?php endif; ?>