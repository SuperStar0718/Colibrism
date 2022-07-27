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

if (empty($cl['is_logged'])) {
	$data         = array(
		'code'    => 401,
		'data'    => array(),
		'message' => 'Unauthorized Access'
	);
}

else {

	require_once(cl_full_path("core/apps/thread/app_ctrl.php"));

	$thread_id   = fetch_or_get($_GET["thread_id"], null);
	$offset_id   = fetch_or_get($_GET["offset"], null);
	$thread_data = cl_get_thread_data($thread_id);

	if (not_empty($thread_data["post"])) {
		$thread_data['prev'] = array();
		$thread_parents      = cl_get_thread_parent_posts($thread_data['post']);

		if (not_empty($thread_parents)) {
			$thread_data['prev'] = array_reverse($thread_parents);
		}

		$data["code"] = 200;
		$data["data"] = $thread_data;
	}
	else {
		$data['code']    = 400;
        $data['message'] = "Thread ID is missing or invalid. Please check your details";
    	$data['data']    = array();
	}
}