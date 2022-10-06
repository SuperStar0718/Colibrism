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

function cl_get_timeline_feed($limit = false, $offset = 0, $onset = false)
{
	global $db, $cl, $me;
	$offset = $limit * ($cl['page'] - 1);

	if (empty($cl["is_logged"])) {
		return false;
	}
	$community_id = not_empty($_GET['community_id']) ? true : false;
	$data           = array();
	$sql            = cl_sqltepmlate("apps/home/sql/fetch_timeline_feed", array(
		"t_posts"   => T_POSTS,
		"t_pubs"    => T_PUBS,
		"t_conns"   => T_CONNECTIONS,
		"t_reports" => T_PUB_REPORTS,
		"t_community" => T_COMMUNITY,
		"limit"     => $limit,
		"offset"    => $offset,
		"onset"     => $onset,
		"user_id"   => $me['id'],
	));

	$query_res = $db->rawQuery($sql);

	$sql = "SELECT COUNT(posts.`id`) FROM `cl_posts` posts	INNER JOIN `cl_publications` pubs ON posts.`publication_id` = pubs.`id` INNER JOIN `cl_community` community ON posts.`community_id` = community.`community_id` WHERE posts.`community_id` IN (SELECT `community_id` FROM `cl_community_following` WHERE `follow_user_id`= " . $me['id'] . ") OR posts.`user_id` IN (SELECT `people_id` FROM `cl_people_following` WHERE `user_id` = " . $me['id'] . ") OR posts.`user_id` = " . $me['id'];

	$query_res_1 = $db->rawQuery($sql);
	cl_queryset($query_res_1);
	$cl['total_number'] = $query_res_1[0]["COUNT(posts.`id`)"];
	if (cl_queryset($query_res)) {
		foreach ($query_res as $row) {
			$post_data = cl_raw_post_data($row['publication_id']);
			if (not_empty($post_data)) {
				// $post_data['flair_id']

				$data[]             = cl_post_data($post_data);
			}
		}
	}
	return $data;
}

function cl_timeline_swifts()
{
	global $db, $cl, $me;

	if (empty($cl["is_logged"])) {
		return false;
	}

	$data         = array();
	$sql          = cl_sqltepmlate("apps/home/sql/fetch_timeline_swifts", array(
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