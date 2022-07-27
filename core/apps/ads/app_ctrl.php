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

function cl_get_or_create_orphan_ad($id = null) {
	global $db, $cl;

	if (not_num($id)) {
		$insert_data  = array(
			'user_id' => $cl['me']['id'],
			'status'  => 'orphan',
			'time'    => time(),
		);

		$insert_id = $db->insert(T_ADS, $insert_data);
		$ad_data   = cl_raw_ad_data($insert_id);

		cl_update_user_data($cl['me']['id'], array(
			"last_ad" => $insert_id
		));

		return $ad_data;
	}
	else {
		$ad_data = cl_raw_ad_data($id);
		return $ad_data;
	}
}

function cl_ad_vue_preprocess($ad_data = array()) {

	if (empty($ad_data)) {
		return false;
	}

	if (empty($ad_data['cover'])) {
		$ad_data['cover'] = "";
	}
	else {
		$ad_data['cover'] = cl_get_media($ad_data['cover']);
	}

	if (empty($ad_data['description'])) {
		$ad_data['description'] = "";
	}
	else {
		$ad_data['description'] = cl_text($ad_data['description']);
	}

	if (empty($ad_data['cta'])) {
		$ad_data['cta'] = "";
	}
	else {
		$ad_data['cta'] = cl_text($ad_data['cta']);
	}
	
	if (empty($ad_data['company'])) {
		$ad_data['company'] = "";
	}
	else {
		$ad_data['company'] = cl_text($ad_data['company']);
	}

	if (empty($ad_data['audience'])) {
		$ad_data['audience'] = array();
	}
	else {
		$ad_data['audience'] = json($ad_data['audience']);
	}

	return $ad_data;
}

function cl_get_user_ads($args = array()) {
	global $db, $cl, $me;

	$args        = (is_array($args)) ? $args : array();
	$options     = array(
        "offset" => false,
        "limit"  => 10,
        "type"   => "active",
    );

	$args   = array_merge($options, $args);
    $offset = $args['offset'];
    $limit  = $args['limit'];
    $type   = $args['type'];
    $sql    = cl_sqltepmlate('apps/ads/sql/fetch_ads', array(
    	't_ads'   => T_ADS,
    	'offset'  => $offset,
    	'limit'   => $limit,
    	'user_id' => $me['id'],
    	'type'    => $type
    ));

    $ads  = $db->rawQuery($sql);
	$data = array();

	if (cl_queryset($ads)) {
		foreach ($ads as $row) {
			$row['edit']        = cl_link(cl_strf('ads/edit/%d', $row['id']));
			$row['cover']       = cl_get_media($row['cover']);
			$row['budget']      = cl_money($row['budget']);
			$row['clicks']      = cl_number($row['clicks']);
			$row['views']       = cl_number($row['views']);
			$row['time']        = cl_time2str($row['time']);
			$row['description'] = stripcslashes($row['description']);
			$row['description'] = htmlspecialchars_decode($row['description'], ENT_QUOTES);
			$row['description'] = cl_linkify_urls($row['description']);
			$row['description'] = cl_rn2br($row['description']);
			$row['description'] = cl_strip_brs($row['description']);
			$row['cta']         = stripcslashes($row['cta']);
        	$row['cta']         = htmlspecialchars_decode($row['cta'], ENT_QUOTES);
			$row['company']     = stripcslashes($row['company']);
        	$row['company']     = htmlspecialchars_decode($row['company'], ENT_QUOTES);
			$row['is_owner']    = true;
			$row['show_stats']  = true;
			$row['owner']       = array(
				'name'          => $me['name'],
				'username'      => $me['username'],
				'verified'      => $me['verified'],
				'url'           => $me['url']
			);

			$data[] = $row;
		}
	}

	return $data;
}