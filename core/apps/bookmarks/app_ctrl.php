<?php 
# @*************************************************************************@
# @ Software author: Mansur Altamirov (Mansur_TL)							@
# @ Author_url 1: https://www.instagram.com/mansur_tl                       @
# @ Author_url 2: http://codecanyon.net/user/mansur_tl                      @
# @ Author E-mail: vayart.help@gmail.com                                    @
# @*************************************************************************@
# @ ColibriSM - The Ultimate Modern Social Media Sharing Platform           @
# @ Copyright (c) 2020 - 2021 ColibriSM. All rights reserved.               @
# @*************************************************************************@

function cl_get_bookmarks($user_id = false, $limit = 10, $offset = false) {
	global $db, $cl;

	if (not_num($user_id)) {
		return false;
	}

	$data          = array();
	$sql           = cl_sqltepmlate('apps/bookmarks/sql/fetch_bookmarks', array(
		't_notes'  => T_BOOKMARKS,
		't_blocks' => T_BLOCKS,
		't_posts'  => T_PUBS,
		'offset'   => $offset,
		'user_id'  => $user_id,
		'limit'    => $limit
	));

	$bookmarks = $db->rawQuery($sql);
	
	if (cl_queryset($bookmarks)) {
		foreach ($bookmarks as $row) {
			$post_data = cl_raw_post_data($row['publication_id']);

			if (not_empty($post_data)) {
				$post_data['offset_id'] = $row['bookmark_id'];
				$data[]                 = cl_post_data($post_data);
			}
		}
	}

	return $data;
}