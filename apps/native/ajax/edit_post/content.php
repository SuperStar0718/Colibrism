<?php
# @*************************************************************************@
# @ Software author: Mansur Altamirov (Mansur_TL)                           @
# @ Author_url 1: https://www.instagram.com/mansur_tl                       @
# @ Author_url 2: http://codecanyon.net/user/mansur_tl                      @
# @ Author E-mail: vayart.help@gmail.com                                    @
# @*************************************************************************@
# @ ColibriSM - The Ultimate Modern Social Media Sharing Platform           @
# @ Copyright (c) 2020 - 2021 ColibriSM. All rights reserved.               @
# @*************************************************************************@

if (empty($cl["is_logged"])) {
	$data['status'] = 400;
	$data['error']  = 'Invalid access token';
} else if ($action == 'get_data') {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$post_id          = fetch_or_get($_GET["id"], false);
	$post_id          = cl_text_secure($post_id);
	$cl['post_data']  = cl_raw_post_data($post_id);

	if (not_empty($cl['post_data']) && $cl['post_data']["user_id"] == $me["id"] && empty($cl['post_data']["edited"])) {
		$cl['post_data']["htags"] = cl_listify_htags($cl['post_data']['text']);
		$cl['post_data']["text"]  = cl_tagify_htags($cl['post_data']['text'], $cl['post_data']["htags"]);


		$data['status'] = 200;
		$data['html']   = cl_template('timeline/modals/edit');
	}
} else if ($action == 'save_data') {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$post_id          = fetch_or_get($_POST["id"], false);
	$post_id          = cl_text_secure($post_id);
	$post_data        = cl_raw_post_data($post_id);
	$curr_pn          = fetch_or_get($_POST['curr_pn'], "none");
	$max_post_length  = $cl["config"]["max_post_len"];


	if (not_empty($post_data) && $post_data["user_id"] == $me["id"] && empty($post_data["edited"])) {
		$post_text = fetch_or_get($_POST['post_text'], "");
		$post_text = cl_croptxt($post_text, $max_post_length);
		$post_text = cl_upsert_htags($post_text);
		$mentions  = cl_get_user_mentions($post_text);

		cl_update_post_data($post_id, array(
			"text"   => cl_text_secure($post_text),
			"edited" => time()
		));

		if (not_empty($mentions)) {
			cl_notify_mentioned_users($mentions, $post_id);
		}

		$data['status'] = 200;

		if ($curr_pn !== "thread") {
			$cl['li']     = cl_post_data(cl_raw_post_data($post_id));
			$data['html'] = cl_template('timeline/post');
		}
	}
} else if ($action == 'up_vote') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);
	$votes          = fetch_or_get($_GET["upvote_count"], 0);
	$votes += 1;
	$sql = "UPDATE cl_publications SET upvote_count=$votes WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	$sql = "UPDATE cl_publications SET edited='up_voted' WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'down_vote') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);
	$votes          = fetch_or_get($_GET["downvote_count"], 0);
	$votes += 1;
	$sql = "UPDATE cl_publications SET downvote_count=$votes WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	$sql = "UPDATE cl_publications SET edited='down_voted' WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
}