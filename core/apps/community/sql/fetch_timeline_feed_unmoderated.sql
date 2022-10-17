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
 
 WITH Row_count AS(
 SELECT ROW_NUMBER() OVER() AS num, posts.`id` as offset_id, posts.`publication_id`, posts.`type`, posts.`user_id`,posts.`community_id`, flairs.`flair_id` FROM `<?php echo($data['t_posts']); ?>` posts
	INNER JOIN `<?php echo($data['t_pubs']); ?>` pubs ON posts.`publication_id` = pubs.`id`
	LEFT JOIN `cl_post_flairs` flairs ON posts.`id`=flairs.`post_id` AND posts.`community_id` = flairs.`community_id` 
	WHERE (pubs.`community_id` = <?php echo($data['community_id']);  ?>) AND pubs.`status` = "inactive"
	ORDER BY posts.`id` DESC
 )
SELECT  *  FROM Row_count 	
	<?php if($data['offset']): ?>
		WHERE num BETWEEN <?php echo($data['offset']+1); ?> AND  <?php echo($data['offset']+$data['limit']); ?> 
	<?php else: ?>
		WHERE num BETWEEN 1 AND  <?php echo($data['limit']); ?> 
			<?php endif; ?>
