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
	$sql = "SELECT * from cl_publications  WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	$votes = $query_res[0]['upvote_count'];
	$downvote = json_decode($query_res[0]['downvote_count']);
	$id = $me['id'];
	foreach (array_keys($downvote, $id, true) as $key) {
		unset($downvote[$key]);
	}
	$downvote_json = json($downvote, true);
	$sql = "UPDATE cl_publications SET downvote_count='$downvote_json' WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);

	$upvote = json_decode($votes, true);
	$upvote[] = $me['id'];
	$upvote_json = json($upvote, true);
	$sql = "UPDATE cl_publications SET upvote_count='$upvote_json' WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'down_vote') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);
	$sql = "SELECT * from cl_publications  WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	$votes = $query_res[0]['downvote_count'];
	$upvote = json_decode($query_res[0]['upvote_count']);
	$id = $me['id'];
	foreach (array_keys($upvote, $id, true) as $key) {
		unset($upvote[$key]);
	}
	$upvote_json = json($upvote, true);
	$sql = "UPDATE cl_publications SET upvote_count='$upvote_json' WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	$downvote = json_decode($votes, true);
	$downvote[] = $me['id'];
	$downvote_json = json($downvote, true);

	$sql = "UPDATE cl_publications SET downvote_count='$downvote_json' WHERE id=$post_id;";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'approve') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);
	$db = $db->where('id', $post_id);
	$db->update(T_PUBS, array(
		'status' => 'active'
	));
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'remove') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);
	$db = $db->where('id', $post_id);
	$db->delete(T_PUBS);
	$db = $db->where('publication_id', $post_id);
	$db->delete(T_POSTS);
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'spam') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);
	$db = $db->where('publication_id', $post_id);
	$result = $db->getone(T_POSTS);
	$user_id = $result['user_id'];
	$community_id = $result['community_id'];

	$db = $db->where('user_id', $user_id);
	$db = $db->where('community_id', $community_id);
	$db->delete(T_POSTS);

	$db = $db->where('user_id', $user_id);
	$db = $db->where('communty_id',  $community_id);
	$db->delete(T_PUBS);

	$db = $db->where('community_id', $community_id);
	$result = $db->getone(T_COMMUNITY_SETTINGS);
	if (not_empty($result['banned_user'])) :
		$users = json($result['banned_user']);
		$users[] = $user_id;
		$db = $db->where('community_id', $community_id);
		$db->update(T_COMMUNITY_SETTINGS, array(
			'banned_user' => json($users, true)
		));
	else :
		$users = array();
		$users[] = $user_id;
		$db = $db->where('community_id', $community_id);
		$db->update(T_COMMUNITY_SETTINGS, array(
			'banned_user' => json($users, true)
		));
	endif;
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'spam_action') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);
	$db = $db->where('id', $post_id);
	$db->update(T_PUBS, array(
		'status' => 3
	));
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'bookmark') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);
	$db->insert(T_BOOKMARKS, array(
		'publication_id' => $post_id,
		'user_id' => $me['id'],
	));
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'un_bookmark') {
	$post_id          = fetch_or_get($_GET["post_id"], 0);

	$db = $db->where('publication_id', $post_id);
	$db = $db->where('user_id', $me['id']);
	$db->delete(T_BOOKMARKS);
	return header('Location: ' . $_SERVER['HTTP_REFERER']);
}