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

function cl_get_community($limit = false, $offset = false, $onset = false)
{
	global $db, $cl, $me, $community, $is_joined, $is_moderator;

	if (empty($cl["is_logged"])) {
		return false;
	}
	$temp = $_GET['community_id'];
	$sql = "SELECT * from `cl_community` where `community_id`=$temp";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	$community = $query_res[0];

	$temp_id = $me['id'];
	$sql = "SELECT * from `cl_join_list` where `community_id`=$temp and `user_id`=$temp_id";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	$is_joined = $query_res;

	$sql = "SELECT * from `cl_community` where `community_id`=$temp and `moderator`=$temp_id";
	$query_res = $db->rawQuery($sql);
	cl_queryset($query_res);
	$is_moderator = $query_res;


	$community_id = not_empty($_GET['community_id']) ? true : false;
	$data           = array();
	$sql            = cl_sqltepmlate("apps/community/sql/fetch_timeline_feed", array(
		"t_posts"   => T_POSTS,
		"t_pubs"    => T_PUBS,
		"t_conns"   => T_CONNECTIONS,
		"t_reports" => T_PUB_REPORTS,
		"limit"     => $limit,
		"offset"    => $offset,
		"onset"     => $onset,
		"user_id"   => $me['id'],
		"community_id" => $community_id
	));

	$query_res = $db->rawQuery($sql);
	$counter   = 0;


	$user_id = $me['id'];
	$sql = "SELECT community_id FROM `cl_join_list` WHERE `user_id`=$user_id ";
	$query_res_1 = $db->rawQuery($sql);
	cl_queryset($query_res_1);
	//$me['communtiy_id'] = $query_res_1[0]['community_id'];
	$community_id = array();
	foreach ($query_res_1 as $row) {
		array_push($community_id, $row['community_id']);
	}
	// print_r($community_id);



	if (cl_queryset($query_res)) {
		// print_r($query_res);
		foreach ($query_res as $row) {
			$post_data = cl_raw_post_data($row['publication_id']);

			if (not_empty($post_data) && in_array($post_data['status'], array('active'))) {
				$post_data['offset_id']   = $row['offset_id'];
				$post_data['is_repost']   = (($row['type'] == 'repost') ? true : false);
				$post_data['is_reposter'] = false;
				$post_data['attrs']       = array();
				// echo "hello " . in_array($post_data['community_id'], $community_id);

				if (in_array($post_data['community_id'], $community_id))
					$post_data['og_data'] = "true";
				else
					$post_data['og_data'] = "false";

				if ($post_data['is_repost']) {
					$post_data['attrs'][]  = cl_html_attrs(array('data-repost' => $row['offset_id']));
					$reposter_data         = cl_user_data($row['user_id']);
					$post_data['reposter'] = array(
						'name' => $reposter_data['name'],
						'username' => $reposter_data['username'],
						'url' => $reposter_data['url'],
					);
				}

				if ($row['user_id'] == $me['id']) {
					$post_data['is_reposter'] = true;
				}

				$post_data['attrs'] = ((not_empty($post_data['attrs'])) ? implode(' ', $post_data['attrs']) : '');
				$data[]             = cl_post_data($post_data);
			}

			if ($cl['config']['advertising_system'] == 'on') {
				if (not_empty($offset)) {
					if ($counter == 5) {
						$counter = 0;
						$ad      = cl_get_timeline_ads();

						if (not_empty($ad)) {
							$data[] = $ad;
						}
					} else {
						$counter += 1;
					}
				}
			}
		}

		if ($cl['config']['advertising_system'] == 'on') {
			if (empty($offset)) {
				$ad = cl_get_timeline_ads();

				if (not_empty($ad)) {
					$data[] = $ad;
				}
			}
		}
	};
	return $data;
}

function cl_timeline_swifts()
{
	global $db, $cl, $me;

	if (empty($cl["is_logged"])) {
		return false;
	}

	$data         = array();
	$sql          = cl_sqltepmlate("apps/community/sql/fetch_timeline_swifts", array(
		"t_users" => T_USERS,
		"t_conns" => T_CONNECTIONS,
		"user_id" => $me['id']
	));

	$query_res = $db->rawQuery($sql);

	if (cl_queryset($query_res)) {
		foreach ($query_res as $row) {
			$row['name']       = cl_strf("%s %s", $row['fname'], $row['lname']);
			$row['avatar']     = cl_get_media($row['avatar']);
			$row['url']        = cl_link($row['username']);
			$row['is_user']    = ($me["id"] == $row["id"]);
			$row['swift']      = json($row['swift']);
			$row['has_unseen'] = false;

			if (is_array($row['swift'])) {
				$swifts_ls = array();

				foreach ($row['swift'] as $swift_id => $swift_data) {

					if ($swift_data["status"] == "active" && $swift_data["exp_time"] > time()) {
						if ($swift_data["type"] == "image") {
							$swift_data["media"]["src"] = cl_get_media($swift_data["media"]["src"]);
						} else if ($swift_data["type"] == "video") {
							$swift_data["media"]["source"] = cl_get_media($swift_data["media"]["source"]);
						}

						$swift_data["time"] = date("H:i", $swift_data["time"]);
						$swift_data["text"] = stripcslashes($swift_data["text"]);
						$swift_data["text"] = htmlspecialchars_decode($swift_data["text"], ENT_QUOTES);
						$swift_data["text"] = cl_linkify_urls($swift_data["text"]);
						$swift_data["seen"] = (in_array($me['id'], array_keys($swift_data["views"]))) ? 1 : 0;
						$swift_data["swid"] = $swift_id;


						if (empty($row['is_user'])) {
							if (empty($row['has_unseen']) && $swift_data["seen"] == 0) {
								$row['has_unseen'] = true;
							}
						} else {
							if (not_empty($swift_data["views"])) {
								$db = $db->where("id", array_keys($swift_data["views"]), "IN");
								$qr = $db->get(T_USERS, null, array("id", "username", "fname", "lname", "avatar"));

								if (cl_queryset($qr)) {
									foreach ($qr as $uinfo) {
										$uinfo['name']   = cl_strf("%s %s", $uinfo['fname'], $uinfo['lname']);
										$uinfo['avatar'] = cl_get_media($uinfo['avatar']);
										$uinfo['url']    = cl_link($uinfo['username']);
										$uinfo['time']   = cl_time2str($swift_data["views"][$uinfo["id"]]);
										$swift_data["views"][$uinfo["id"]] = $uinfo;
									}
								}
							}
						}

						array_push($swifts_ls, $swift_data);
					}
				}

				if (not_empty($swifts_ls)) {
					$row['swift'] = $swifts_ls;
					$data[]       = $row;
				}
			}
		}
	}

	return $data;
}