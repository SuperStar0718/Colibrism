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

function cl_get_thread_data($post_id = false) {
	global $db, $cl;

	if (not_num($post_id)) {
		return false;
	}

	$post           = cl_raw_post_data($post_id);
	$data           = array(
		'post'      => array(),
		'next'      => array(),
		'can_reply' => true,
		'can_see'   => true
	);

	if (cl_queryset($post) && $post["status"] != "orphan") {
		$data['can_reply'] = cl_can_reply($post);
		$data['post']      = cl_post_data($post);
		$data['next']      = cl_get_thread_child_posts($post_id, 30);
	}

	return $data;
}

function cl_get_thread_parent_posts($post_obj = array()) {
    global $db, $cl;

    if (not_empty($post_obj['thread_id'])) {
        $db = $db->where('id', $post_obj['thread_id']);
        $db = $db->where('status', array('active','inactive','deleted'),'IN');
        $qr = $db->getOne(T_PUBS);

        if (cl_queryset($qr)) {
        	$cl['_'][] = cl_post_data($qr);

        	return cl_get_thread_parent_posts($qr);
        }
    }

    else {
    	return ((not_empty($cl['_'])) ? $cl['_'] : false);
    }
}

function cl_get_thread_child_posts($post_id = false, $limit = null, $offset = false, $offset_to = 'lt') {
    global $db, $cl;

    if (not_num($post_id)) {
    	return false;
    }

    $offset_to    = (($offset_to == 'gt') ? '>' : '<');
    $data         = array();
	$db           = $db->where('thread_id', $post_id);
	$db           = $db->where('status', array('active','inactive','deleted'),'IN');
	$db           = ((is_posnum($offset)) ? $db->where('id', $offset, $offset_to) : $db);
	$db           = $db->orderBy('id','DESC');
	$child_posts  = $db->get(T_PUBS, $limit);

	if (cl_queryset($child_posts)) {
		foreach ($child_posts as $row) {
			$row['replys'] = array();
			$db            = $db->where('thread_id', $row['id']);
			$db            = $db->where('status', array('active','inactive','deleted'),'IN');
			$db            = $db->orderBy('id','DESC');
			$replys        = $db->get(T_PUBS, 2);

			if (cl_queryset($replys)) {
				foreach ($replys as $reply) {
					$row['replys'][] = cl_post_data($reply);
				}
			}

			$data[] = cl_post_data($row);
		}
	}

	return $data;
}
