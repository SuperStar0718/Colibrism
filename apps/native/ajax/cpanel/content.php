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

if (empty($cl['is_admin'])) {
	$data['status'] = 400;
    $data['error']  = 'Invalid access token';
}

else if ($action == 'save_settings') {	
	$data['status']    = 400;
	$data['err_field'] = null;
	$raw_configs       = $db->get(T_CONFIGS);
	$raw_configs       = ((cl_queryset($raw_configs)) ? $raw_configs : array());

	if ($raw_configs) {
		require_once(cl_full_path("core/apps/cpanel/settings/app_ctrl.php"));

		foreach ($raw_configs as $config_data) {
			if (isset($_POST[$config_data['name']])) {

				if (in_array($config_data['name'], array("google_ad_horiz", "google_ad_vert", "google_analytics"))) {
					$conf_new_val = htmlspecialchars($_POST[$config_data['name']]);
				}

				else {
					$conf_new_val = cl_text_secure($_POST[$config_data['name']]);
				}

				if ($config_data['regex']) {
					if (preg_match($config_data['regex'], $conf_new_val)) {
						cl_admin_save_config($config_data['name'], $conf_new_val);
					}

					else {
						$field_label       = $config_data['title'];
						$data['message']   = cl_strf('Invalid value of field: %s', $field_label);
						$data['err_field'] = $config_data['name']; break;
					}
				}
				else {
					cl_admin_save_config($config_data['name'], $conf_new_val);
				}
			}
		}

		if (empty($data['err_field'])) {
			$data['status'] = 200;
		}
	}
}

else if ($action == 'get_users') {
	require_once(cl_full_path("core/apps/cpanel/users/app_ctrl.php"));

	$filter_data      = fetch_or_get($_POST['filter'], array());
	$offset_to        = fetch_or_get($_POST['dir'], 'none');
	$offset_lt        = ((is_posnum($_POST['offset_lt'])) ? intval($_POST['offset_lt']) : 0);
	$offset_gt        = ((is_posnum($_POST['offset_gt'])) ? intval($_POST['offset_gt']) : 0);
	$users            = array();
	$data['status']   = 404;
	$data['err_code'] = 0;
	$html_arr         = array();

	if ($offset_to == 'up' && $offset_lt) {
		$users          = cl_admin_get_users(array(
			'limit'     => 7,
			'offset'    => $offset_lt,
			'offset_to' => 'gt',
			'order'     => 'ASC',
			'filter'    => $filter_data
		));

		$users = array_reverse($users);
	}

	else if($offset_to == 'down' && $offset_gt) {
		$users          = cl_admin_get_users(array(
			'limit'     => 7,
			'offset'    => $offset_gt,
			'offset_to' => 'lt',
			'order'     => 'DESC',
			'filter'    => $filter_data
		));
	}

	if (not_empty($users)) {
		foreach ($users as $cl['li']) {
			array_push($html_arr, cl_template('cpanel/assets/users/includes/list_item'));
		}

		$data['status'] = 200;
		$data['html']   = implode('', $html_arr);
	}
}

else if ($action == 'search_users') {

	require_once(cl_full_path("core/apps/cpanel/users/app_ctrl.php"));

	$filter_data      = fetch_or_get($_POST['filter'], array());
	$data['err_code'] = 0;
	$html_arr         = array();
	$users            = cl_admin_get_users(array(
		'limit'       => 7,
		'filter'      => $filter_data
	));

	if (not_empty($users)) {
		foreach ($users as $cl['li']) {
			array_push($html_arr, cl_template('cpanel/assets/users/includes/list_item'));
		}

		$data['status'] = 200;
		$data['html']   = implode('', $html_arr);
	}
	else{
		$data['status'] = 404;
		$data['html']   = cl_template('cpanel/assets/users/includes/filter404');
	}
}

else if ($action == 'get_posts') {

	require_once(cl_full_path("core/apps/cpanel/posts/app_ctrl.php"));

	$offset_to        = fetch_or_get($_GET['dir'], 'none');
	$offset_lt        = ((is_posnum($_GET['offset_lt'])) ? intval($_GET['offset_lt']) : 0);
	$offset_gt        = ((is_posnum($_GET['offset_gt'])) ? intval($_GET['offset_gt']) : 0);
	$posts            = array();
	$data['status']   = 404;
	$data['err_code'] = 0;
	$html_arr         = array();

	if ($offset_to == 'up' && $offset_lt) {
		$posts          = cl_admin_get_posts(array(
			'limit'     => 10,
			'offset'    => $offset_lt,
			'offset_to' => 'gt',
			'order'     => 'ASC'
		));

		$posts = array_reverse($posts);
	}

	else if($offset_to == 'down' && $offset_gt) {
		$posts          = cl_admin_get_posts(array(
			'limit'     => 10,
			'offset'    => $offset_gt,
			'offset_to' => 'lt',
			'order'     => 'DESC'
		));
	}

	if (not_empty($posts)) {
		foreach ($posts as $cl['li']) {
			array_push($html_arr, cl_template('cpanel/assets/publications/includes/list_item'));
		}

		$data['status'] = 200;
		$data['html']   = implode('', $html_arr);
	}
}

else if($action == 'delete_user') {
	$data['status']   = 404;
	$data['err_code'] = 0;
	$user_id          = fetch_or_get($_POST['id'], 0);

	if (is_posnum($user_id)) {
		$data['status']      = 200;
		$data['status_code'] = (cl_delete_user_data($user_id) == true) ? 1 : 0;
	}
}

else if($action == 'toggle_user_status') {
	$data['status']   = 404;
	$data['err_code'] = 0;
	$user_id          = fetch_or_get($_POST['id'], 0);

	if (is_posnum($user_id)) {
		$udata = cl_raw_user_data($user_id);

		if (not_empty($udata)) {
			$data['status']  = 200;
			$data['message'] = "Your changes has been successfully saved!";
			$status          = (($udata['active'] == '1') ? '2' : '1' );

			cl_update_user_data($user_id, array(
				'active' => $status
			));

			if ($status == '2') {
				cl_signout_user_by_id($user_id);
			}
		}
	}
}

else if($action == 'toggle_user_type') {
	$data['status']   = 404;
	$data['err_code'] = 0;
	$user_id          = fetch_or_get($_POST['id'], 0);

	if (is_posnum($user_id)) {
		$udata = cl_raw_user_data($user_id);

		if (not_empty($udata)) {
			$data['status']  = 200;
			$data['message'] = "Your changes has been successfully saved!";
			$user_type       = (($udata['admin'] == '1') ? '0' : '1');

			cl_update_user_data($user_id, array(
				'admin' => $user_type
			));
		}
	}
}

else if($action == 'verify_user') {
	$data['status']   = 404;
	$data['err_code'] = 0;
	$user_id          = fetch_or_get($_POST['id'], 0);

	if (is_posnum($user_id)) {
		$udata = cl_raw_user_data($user_id);

		if (not_empty($udata)) {
			$data['status']  = 200;
			$data['message'] = "Your changes has been successfully saved!";
			$is_verified     = (($udata['verified'] == '1') ? '0' : '1');

			cl_update_user_data($user_id, array(
				'verified' => $is_verified
			));
		}
	}
}

else if($action == 'delete_post') {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $post_id          = fetch_or_get($_POST['id'], 0);

    if (is_posnum($post_id)) {
        $post_data = cl_raw_post_data($post_id);

        if (not_empty($post_data)) {

            $post_owner = cl_raw_user_data($post_data['user_id']);

            if (not_empty($post_owner)) {
                if ($post_data['target'] == 'publication') {

                    $posts_total = ($post_owner['posts'] -= 1);
                    $posts_total = ((is_posnum($posts_total)) ? $posts_total : 0);

                    cl_update_user_data($post_data['user_id'], array(
                        'posts' => $posts_total
                    ));

                    $db = $db->where('publication_id', $post_id);
                    $qr = $db->delete(T_POSTS);
                }

                else {
                    cl_update_thread_replys($post_data['thread_id'], 'minus');
                }
                
                cl_recursive_delete_post($post_id);
                
                $data['status'] = 200;
            }
        }
    }
}

else if($action =='create_backup') {

	require_once(cl_full_path("core/apps/cpanel/backups/app_ctrl.php"));
	
	require_once(cl_full_path("core/apps/cpanel/settings/app_ctrl.php"));

	$data['err_code'] = 'failed_to_create_backup';
	$data['status']   = 500;
	$new_backup       = cl_admin_create_backup();

	if ($new_backup) {
		$time                = time();
		$data['status']      = 200;
		$data['err_code']    = 0;
		$data['last_backup'] = date('d F, Y - h:m', $time);

		cl_admin_save_config('last_backup', $time);
	}
}

else if ($action == 'get_account_verifications') {

	require_once(cl_full_path("core/apps/cpanel/account_verification/app_ctrl.php"));

	$offset_to        = fetch_or_get($_GET['dir'], 'none');
	$offset_lt        = ((is_posnum($_GET['offset_lt'])) ? intval($_GET['offset_lt']) : 0);
	$offset_gt        = ((is_posnum($_GET['offset_gt'])) ? intval($_GET['offset_gt']) : 0);
	$data['status']   = 404;
	$data['err_code'] = 0;
	$html_arr         = array();

	if ($offset_to == 'up' && $offset_lt) {
		$requests       = cl_admin_get_verification_requests(array(
			'limit'     => 7,
			'offset'    => $offset_lt,
			'offset_to' => 'gt',
			'order'     => 'ASC'
		));

		$requests = array_reverse($requests);
	}

	else if($offset_to == 'down' && $offset_gt) {
		$requests       = cl_admin_get_verification_requests(array(
			'limit'     => 7,
			'offset'    => $offset_gt,
			'offset_to' => 'lt',
			'order'     => 'DESC'
		));
	}

	if (not_empty($requests)) {
		foreach ($requests as $cl['li']) {
			array_push($html_arr, cl_template('cpanel/assets/account_verification/includes/list_item'));
		}

		$data['status'] = 200;
		$data['html']   = implode('', $html_arr);
	}
}

else if ($action == 'get_verifreq_data') {

	require_once(cl_full_path("core/apps/cpanel/account_verification/app_ctrl.php"));

	$request_id       = fetch_or_get($_GET['id'], 'none');
	$data['status']   = 404;
	$data['err_code'] = 0;
	$cl['req_data']   = cl_admin_get_verification_request_data($request_id);

	if (not_empty($cl['req_data'])) {
		$data['status'] = 200;
		$data['html']   = cl_template('cpanel/assets/account_verification/modals/popup_ticket');
	}
}

else if ($action == 'delete_verifreq_data') {
	$request_id       = fetch_or_get($_GET['id'], 'none');
	$data['status']   = 404;
	$data['err_code'] = 0;
	$db               = $db->where('id', $request_id);
	$req_data         = $db->getOne(T_VERIFICATIONS);

	if (cl_queryset($req_data)) {
		$data['status'] = 200;
		$db             = $db->where('id', $request_id);
		$qr             = $db->delete(T_VERIFICATIONS);

		cl_delete_media($req_data['video_message']);

		cl_update_user_data($req_data['user_id'], array(
			'verified' => '0'
		));
	}
	else {
		$data['status']  = 400;
		$data['message'] = "An error occurred while processing your request. Please try again later.";
	}
}

else if ($action == 'verify_user_account') {
	$request_id       = fetch_or_get($_GET['id'], 'none');
	$data['status']   = 404;
	$data['err_code'] = 0;
	$db               = $db->where('id', $request_id);
	$req_data         = $db->getOne(T_VERIFICATIONS);

	if (cl_queryset($req_data)) {
		$data['status']  = 200;
		$data['message'] = "Account has been verified successfully!";
		$db              = $db->where('id', $request_id);
		$qr              = $db->delete(T_VERIFICATIONS);

		cl_delete_media($req_data['video_message']);

		cl_update_user_data($req_data['user_id'], array(
			'verified' => '1'
		));

		cl_notify_user(array(
            'subject'  => 'verified',
            'user_id'  => $req_data['user_id'],
            'entry_id' => 0
        ));
	}
	else {
		$data['status']  = 400;
		$data['message'] = "An error occurred while processing your request. Please try again later.";
	}
}

else if($action == "update_sitemap") {
	$data['status']   = 404;
	$data['err_code'] = 0;
	$data['errors']   = array();

	if (is_writable('sitemap') != true) {
		$data['err_code'] = "permission_denied";
		$data['message']  = "The sitemaps storage folder does not exists or not writable!";
	}

	else if(is_writable('sitemap/sitemap-index.xml') != true) {
		$data['err_code'] = "permission_denied";
		$data['message']  = "The sitemap-index.xml does not exists or not writable!";
	}

	else if(is_writable('sitemap/maps') != true) {
		$data['err_code'] = "permission_denied";
		$data['message']  = "The sitemap/maps forder does not exists or not writable!";
	}

	else {

		require_once(cl_full_path("core/apps/cpanel/sitemap/app_ctrl.php"));

		$old_maps = glob('sitemap/maps/*.xml');
		$old_maps = ((is_array($old_maps) && not_empty($old_maps)) ? $old_maps : array());
		$maps     = 1;
		$posts    = cl_admin_get_publication_indexes();
		$users    = cl_admin_get_user_indexes();

		

		if (not_empty($old_maps)) {
			foreach($old_maps as $old_site_map){
			    try {
			    	@unlink($old_site_map);
			    } catch (Exception $e) { /* pass */ }
			}
		}

		if (not_empty($posts)) {
			$posts = array_chunk($posts, 1000);

			foreach ($posts as $cl['sitemap_entries']) {
				$map_url  = cl_strf("sitemap/maps/sitemap-%d.xml", $maps);
				$map_code = cl_sitemap('temps/sitemap');
				$map_code = trim($map_code);
				$map_code = str_replace("{%xml_version%}", '<?xml version="1.0" encoding="UTF-8"?>', $map_code);
				$exe_code = file_put_contents($map_url, $map_code);

				if ($exe_code) {
					$maps += 1;
				}

				else {
					$data['errors'][] = array(
						'file_index' => $maps,
						'file_path' => $map_url,
						'message' => "Failed to save sitemap file."
					);
				}
			}
		}

		if (not_empty($users)) {
			$users = array_chunk($users, 1000);

			foreach ($users as $cl['sitemap_entries']) {
				$map_url  = cl_strf("sitemap/maps/sitemap-%d.xml", $maps);
				$map_code = cl_sitemap('temps/sitemap');
				$map_code = trim($map_code);
				$map_code = str_replace("{%xml_version%}", '<?xml version="1.0" encoding="UTF-8"?>', $map_code);
				$exe_code = file_put_contents($map_url, $map_code);

				if ($exe_code) {
					$maps += 1;
				}

				else {
					$data['errors'][] = array(
						'file_index' => $maps,
						'file_path' => $map_url,
						'message' => "Failed to save sitemap file."
					);
				}
			}
		}

		if($maps > 1) {
			$cl['map_indexes'] = $maps;
			$sitemap_index     = cl_sitemap('temps/index');
			$sitemap_index     = trim($sitemap_index);
			$sitemap_index     = str_replace("{%xml_version%}", '<?xml version="1.0" encoding="UTF-8"?>', $sitemap_index);
			$exe_code          = file_put_contents('sitemap/sitemap-index.xml', trim($sitemap_index));

			if ($exe_code) {
				$data['status']       = 200;
				$data['last_sitemap'] = date('d F, Y - h:m');

				$db = $db->where('name', 'sitemap_update');
		        $qr = $db->update(T_CONFIGS, array(
		        	'value' => time()
		        ));
			}

			else {
				$data['errors'][] = array(
					'file_index' => $maps,
					'file_path' => $map_url,
					'message' => "Failed to save sitemap file."
				);
			}
		}
	}
}

else if ($action == 'get_account_reports') {

	require_once(cl_full_path("core/apps/cpanel/account_reports/app_ctrl.php"));

	$offset_to        = fetch_or_get($_GET['dir'], 'none');
	$offset_lt        = ((is_posnum($_GET['offset_lt'])) ? intval($_GET['offset_lt']) : 0);
	$offset_gt        = ((is_posnum($_GET['offset_gt'])) ? intval($_GET['offset_gt']) : 0);
	$data['status']   = 404;
	$data['err_code'] = 0;
	$html_arr         = array();

	if ($offset_to == 'up' && $offset_lt) {
		$reports        = cl_admin_get_profile_reports(array(
			'limit'     => 7,
			'offset'    => $offset_lt,
			'offset_to' => 'gt',
			'order'     => 'ASC'
		));

		$reports = array_reverse($reports);
	}

	else if($offset_to == 'down' && $offset_gt) {
		$reports        = cl_admin_get_profile_reports(array(
			'limit'     => 7,
			'offset'    => $offset_gt,
			'offset_to' => 'lt',
			'order'     => 'DESC'
		));
	}

	if (not_empty($reports)) {
		foreach ($reports as $cl['li']) {
			array_push($html_arr, cl_template('cpanel/assets/account_reports/includes/list_item'));
		}

		$data['status'] = 200;
		$data['html']   = implode('', $html_arr);
	}
}

else if ($action == 'get_account_report_data') {

	require_once(cl_full_path("core/apps/cpanel/account_reports/app_ctrl.php"));

	$report_id        = fetch_or_get($_GET['id'], 'none');
	$data['status']   = 404;
	$data['err_code'] = 0;
	$cl['rep_data']   = cl_admin_get_account_report_data($report_id);

	if (not_empty($cl['rep_data'])) {
		$data['status']  = 200;
		$data['is_seen'] = $cl['rep_data']['seen'];
		$data['html']    = cl_template('cpanel/assets/account_reports/modals/popup_ticket');
	}
}

else if($action == 'delete_account_report_data') {
	$report_id        = fetch_or_get($_GET['id'], 'none');
	$data['status']   = 404;
	$data['err_code'] = 0;

	if (is_posnum($report_id)) {

		require_once(cl_full_path("core/apps/cpanel/account_reports/app_ctrl.php"));

		$db             = $db->where('id', $report_id);
		$qr             = $db->delete(T_PROF_REPORTS);
		$data['status'] = 200;
		$data['total']  = cl_admin_get_total_profile_reports();;
	}
}

else if ($action == 'get_affiliate_payouts') {

	require_once(cl_full_path("core/apps/cpanel/affiliate_payouts/app_ctrl.php"));

	$offset_to        = fetch_or_get($_GET['dir'], 'none');
	$offset_lt        = ((is_posnum($_GET['offset_lt'])) ? intval($_GET['offset_lt']) : 0);
	$offset_gt        = ((is_posnum($_GET['offset_gt'])) ? intval($_GET['offset_gt']) : 0);
	$data['status']   = 404;
	$data['err_code'] = 0;
	$html_arr         = array();

	if ($offset_to == 'up' && $offset_lt) {
		$requests       = cl_get_affiliate_payouts(array(
			'limit'     => 7,
			'offset'    => $offset_lt,
			'offset_to' => 'gt',
			'order'     => 'ASC'
		));

		$requests = array_reverse($requests);
	}

	else if($offset_to == 'down' && $offset_gt) {
		$requests       = cl_get_affiliate_payouts(array(
			'limit'     => 7,
			'offset'    => $offset_gt,
			'offset_to' => 'lt',
			'order'     => 'DESC'
		));
	}

	if (not_empty($requests)) {
		foreach ($requests as $cl['li']) {
			array_push($html_arr, cl_template('cpanel/assets/affiliate_payouts/includes/list_item'));
		}

		$data['status'] = 200;
		$data['html']   = implode('', $html_arr);
	}
}

else if ($action == 'delete_affiliate_payout') {
	$request_id       = fetch_or_get($_POST['id'], 'none');
	$data['status']   = 400;
	$data['err_code'] = 0;

	if (is_posnum($request_id)) {
		$data['status'] = 200;
		$db             = $db->where('id', $request_id);
		$qr             = $db->delete(T_AFF_PAYOUTS);
	}
}

else if ($action == 'update_affiliate_payout_status') {
	$request_id       = fetch_or_get($_POST['id'], 'none');
	$data['status']   = 400;
	$data['err_code'] = 0;

	if (is_posnum($request_id)) {
		$payout_req = cl_db_get_item(T_AFF_PAYOUTS, array("id" => $request_id));

		if (not_empty($payout_req)) {
			$data['status'] = 200;

			cl_update_user_data($payout_req["user_id"], array(
				"aff_bonuses" => 0
			));

			cl_db_update(T_AFF_PAYOUTS, array(
				'id' => $request_id
			), array(
				'status' => 'paid'
			));
		}
	}
}

else if ($action == 'get_user_ads') {

	require_once(cl_full_path("core/apps/cpanel/ads/app_ctrl.php"));

	$offset_to        = fetch_or_get($_GET['dir'], 'none');
	$offset_lt        = ((is_posnum($_GET['offset_lt'])) ? intval($_GET['offset_lt']) : 0);
	$offset_gt        = ((is_posnum($_GET['offset_gt'])) ? intval($_GET['offset_gt']) : 0);
	$data['status']   = 404;
	$data['err_code'] = 0;
	$html_arr         = array();

	if ($offset_to == 'up' && $offset_lt) {
		$user_ads       = cl_admin_get_user_ads(array(
			'limit'     => 10,
			'offset'    => $offset_lt,
			'offset_to' => 'gt',
			'order'     => 'ASC'
		));

		$user_ads = array_reverse($user_ads);
	}

	else if($offset_to == 'down' && $offset_gt) {
		$user_ads       = cl_admin_get_user_ads(array(
			'limit'     => 10,
			'offset'    => $offset_gt,
			'offset_to' => 'lt',
			'order'     => 'DESC'
		));
	}

	if (not_empty($user_ads)) {
		foreach ($user_ads as $cl['li']) {
			array_push($html_arr, cl_template('cpanel/assets/manage_ads/includes/list_item'));
		}

		$data['status'] = 200;
		$data['html']   = implode('', $html_arr);
	}
}

else if($action == 'delete_user_ad') {
	$data['err_code'] = 0;
    $data['status']   = 400;
    $ad_id            = fetch_or_get($_POST['id'], false);
    $ad_data          = cl_raw_ad_data($ad_id);

    if (not_empty($ad_data)) {
        cl_delete_media($ad_data['cover']);
        cl_db_delete_item(T_ADS, array("id" => $ad_id));

        $data['status'] = 200;
    }
}

else if($action == 'approve_user_ad') {
	$data['err_code'] = 0;
    $data['status']   = 400;
    $ad_id            = fetch_or_get($_POST['id'], false);
    $ad_data          = cl_raw_ad_data($ad_id);

    if (not_empty($ad_data)) {
        $data['status'] = 200;

        cl_update_ad_data($ad_id, array(
        	"approved" => "Y"
        ));

        cl_notify_user(array(
	        'subject'  => 'ad_approval',
	        'user_id'  => $ad_data["user_id"],
	        'entry_id' => $ad_data["id"]
	    ));
    }
}

else if($action == 'delete_old_swifts') {
	require_once(cl_full_path("core/apps/cpanel/swifts/app_ctrl.php"));

	cl_admin_delete_user_old_swifts();

	$data['status'] = 200;
}

else if($action == 'activate_theme') {
	$data['err_code'] = 0;
    $data['status']   = 400;
    $theme_name       = fetch_or_get($_POST['theme_name'], false);

    if (not_empty($theme_name) && is_string($theme_name)) {
    	require_once(cl_full_path("core/apps/cpanel/settings/app_ctrl.php"));

    	cl_admin_save_config("theme", $theme_name);

    	$data['status'] = 200;
    }
}

else if ($action == 'get_post_reports') {

	require_once(cl_full_path("core/apps/cpanel/post_reports/app_ctrl.php"));

	$offset_to        = fetch_or_get($_GET['dir'], 'none');
	$offset_lt        = ((is_posnum($_GET['offset_lt'])) ? intval($_GET['offset_lt']) : 0);
	$offset_gt        = ((is_posnum($_GET['offset_gt'])) ? intval($_GET['offset_gt']) : 0);
	$data['status']   = 404;
	$data['err_code'] = 0;
	$html_arr         = array();

	if ($offset_to == 'up' && $offset_lt) {
		$reports        = cl_admin_get_post_reports(array(
			'limit'     => 7,
			'offset'    => $offset_lt,
			'offset_to' => 'gt',
			'order'     => 'ASC'
		));

		$reports = array_reverse($reports);
	}

	else if($offset_to == 'down' && $offset_gt) {
		$reports        = cl_admin_get_post_reports(array(
			'limit'     => 7,
			'offset'    => $offset_gt,
			'offset_to' => 'lt',
			'order'     => 'DESC'
		));
	}

	if (not_empty($reports)) {
		foreach ($reports as $cl['li']) {
			array_push($html_arr, cl_template('cpanel/assets/post_reports/includes/list_item'));
		}

		$data['status'] = 200;
		$data['html']   = implode('', $html_arr);
	}
}

else if ($action == 'get_post_report_data') {

	require_once(cl_full_path("core/apps/cpanel/post_reports/app_ctrl.php"));

	$report_id        = fetch_or_get($_GET['id'], 'none');
	$data['status']   = 404;
	$data['err_code'] = 0;
	$cl['rep_data']   = cl_admin_get_post_report_data($report_id);

	if (not_empty($cl['rep_data'])) {
		$data['status']  = 200;
		$data['is_seen'] = $cl['rep_data']['seen'];
		$data['html']    = cl_template('cpanel/assets/post_reports/modals/popup_ticket');
	}
}

else if($action == 'delete_post_report_data') {
	$report_id        = fetch_or_get($_GET['id'], 'none');
	$data['status']   = 404;
	$data['err_code'] = 0;

	if (is_posnum($report_id)) {

		require_once(cl_full_path("core/apps/cpanel/post_reports/app_ctrl.php"));

		cl_db_delete_item(T_PUB_REPORTS, array(
			'id' => $report_id
		));

		$data['status'] = 200;
		$data['total']  = cl_admin_get_total_post_reports();;
	}
}

else if($action == 'as3_api_contest') {
	try {
	    $cl['config']['as3_storage']     = 'on';
	    $cl['config']['as3_onup_delete'] = 'no';       
        $test_aws3_upload                = cl_upload2s3(cl_full_path("upload/default/as3-do-not-delete.png"));

        if ($test_aws3_upload == true) {
        	$data['status']  = 200;
        	$data['message'] = 'Connection test was successful!';
        }

	    else {
	        $data['status']  = 500;
	        $data['message'] = "Error found while processing your request. Please try again later!";
	    }
	}
	catch (Exception $e) {
	    $data['status']  = 400;
	    $data['message'] = $e->getMessage();
	}
}

else if($action == "delete_spam_accounts") {

	$data['status']   = 200;
	$data['err_code'] = 0;

	$db = $db->where("time", (time() - 604800), "<");
	$qr = $db->delete(T_ACC_VALIDS);
}

else if($action == "create_invite_link") {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$expires_at       = fetch_or_get($_POST["expires_at"], false);
	$user_role        = fetch_or_get($_POST["role"], false);
	$link_mnu         = fetch_or_get($_POST["mnu"], false);

	if (is_posnum($expires_at) != true || in_array($expires_at, array("1", "3", "7", "15", "30")) != true) {
		$data['err_code'] = "invalid_expiration_date";
	}

	else if(empty($user_role) || in_array($user_role, array("admin", "user")) != true) {
		$data['err_code'] = "invalid_user_role";
	}

	else if(is_posnum($link_mnu) != true) {
		$data['err_code'] = "invalid_link_mnu";
	}

	else{
		$insert_data = array(
			"code"       => sha1(rand(11111, 99999)) . time() . md5(microtime() . rand(11111, 99999)),
			"role"       => $user_role,
			"mnu"        => $link_mnu,
			"expires_at" => strtotime("+$expires_at day"),
			"time" => time()
		);

		$insert_id = cl_db_insert(T_USER_INVITES, $insert_data);

		if (is_posnum($insert_id)) {
			$data["status"] = 200;
		}
	}
}

else if($action == "update_invite_links_list") {
	$data['status']   = 200;
	$data['err_code'] = 0;

	require_once(cl_full_path("core/apps/cpanel/invite_users/app_ctrl.php"));

	$invite_links  = cl_admin_get_user_invitations();
	$data["links"] = $invite_links;
}

else if($action == "delete_invite_link") {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$link_id          = fetch_or_get($_POST["id"], false);

	if (is_posnum($link_id)) {
		$data['status'] = 200;

		cl_db_delete_item(T_USER_INVITES, array(
			"id" => $link_id
		));
	}
}

else if($action == "toggle_lang_status") {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$lang_stat        = fetch_or_get($_POST["stat"], false);
	$lang_id          = fetch_or_get($_POST["id"], false);

	if (in_array($lang_stat, array("active", "inactive")) && is_posnum($lang_id)) {
		$data['status'] = 200;

		cl_db_update(T_UI_LANGS, array(
			"id" => $lang_id
		), array(
			"status" => ($lang_stat == "active") ? "1" : "0"
		));
	}
}

else if($action == "set_default_lang") {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$lang_id          = fetch_or_get($_POST["id"], false);

	if (is_posnum($lang_id)) {
		$lang_data = cl_db_get_item(T_UI_LANGS, array("id" => $lang_id));

		if (not_empty($lang_data)) {
			$data['status'] = 200;

			cl_db_update(T_CONFIGS, array(
				"name" => "language"
			), array(
				"value" => $lang_data["slug"]
			));
		}
	}
}

else if($action == "delete_lang") {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$lang_id          = fetch_or_get($_POST["id"], false);

	if (is_posnum($lang_id)) {
		$lang_data = cl_db_get_item(T_UI_LANGS, array(
			"id" => $lang_id
		));

		if (not_empty($lang_data) && $lang_data["is_native"] != "1") {
			
			cl_db_delete_item(T_UI_LANGS, array(
				"id" => $lang_id
			));

			$data['status'] = 200;

			try {
				@unlink(cl_full_path(cl_strf("core/langs/%s.json", $lang_data["slug"])));
				@unlink(cl_full_path(cl_strf("core/langs/custom/%s.json", $lang_data["slug"])));
			} 

			catch (Exception $e) {
				/*PASS*/
			}
		}
	}
}

else if($action == "add_new_lanuage") {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$lang_name   = fetch_or_get($_POST["language"], false);
	$lang_status = fetch_or_get($_POST["status"], false);
	$lang_dir    = fetch_or_get($_POST["direction"], false);

	if (empty($lang_name) || in_array($lang_name, array_keys($cl['language_codes'])) != true) {
		$data['err_code'] = "invalid_lang_name";
	}

	else if(empty($lang_status) || in_array($lang_status, array("active", "inactive")) != true) {
		$data['err_code'] = "invalid_lang_status";
	}

	else if(empty($lang_dir) || in_array($lang_dir, array("rtl", "ltr")) != true) {
		$data['err_code'] = "invalid_lang_direction";
	}

	else{
		$data["status"] = 200;

		$lang_file1 = cl_full_path(cl_strf("core/langs/%s.json", $lang_name));
		$lang_file2 = cl_full_path(cl_strf("core/langs/custom/%s.json", $lang_name));

		$v1 = file_put_contents($lang_file1, file_get_contents(cl_full_path("core/langs/default.json")));
		$v2 = file_put_contents($lang_file2, json(array(), true));

		if ($v1 && $v2) {
			cl_db_insert(T_UI_LANGS, array(
				"name" => $cl['language_codes'][$lang_name]["name"],
				"slug" => $lang_name,
				"status" => (($lang_status == "active") ? "1" : "0"),
				"is_rtl" => (($lang_dir == "rtl") ? "Y" : "N")
			));
		}
	}
}

else if($action == 'edit_wallet_balance') {
	$data['status']   = 404;
	$data['err_code'] = 0;
	$user_id          = fetch_or_get($_POST['user_id'], 0);
	$wallet           = fetch_or_get($_POST['wallet'], "0.00");

	if (is_posnum($user_id) && is_numeric($wallet)) {
		$data['status']  = 200;
		$data['message'] = "Your changes has been successfully saved!";

		cl_update_user_data($user_id, array(
			'wallet' => $wallet
		));
	}
	else{
		$data['err_field'] = "wallet";
		$data['message']   = "Something went wrong while trying to save user balance. Please check your details or try again later";
	}
}

else if($action == "check_smtp_server") {
	$data['status']   = 400;
	$data['err_code'] = 0;
	$test_email       = fetch_or_get($_POST['test_email'], false);

	if (empty($test_email) || empty(filter_var(trim($test_email), FILTER_VALIDATE_EMAIL))) {
		$data['err_code'] = "invalid_email_address";
		$data['message']  = "The email address you entered is not valid. Please check your details";
	}
	else{
		$send_email_data   = array(
            'from_email'   => $cl['config']['email'],
            'from_name'    => $cl['config']['name'],
            'to_email'     => $test_email,
            'to_name'      => explode("@", $test_email)[0],
            'subject'      => "DO NOT REPLY. Checking SMTP server",
            'charSet'      => 'UTF-8',
            'is_html'      => false,
            'message_body' => "This is a test message that was sent to make sure that the SMTP server is working correctly. If you see this message, then your ColibriSM script is working and everything is OK"
        ); 

        if (cl_send_mail($send_email_data)) {
        	$data['status'] = 200;
        }
	}
}