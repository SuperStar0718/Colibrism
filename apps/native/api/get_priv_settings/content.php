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
	$data["code"]    = 200;
	$data["valid"]   = true;
	$data["message"] = "";
	$data["data"]    = array(
		"profile_visibility" => $me["profile_privacy"],
		"contact_privacy"    => $me["contact_privacy"],
		"search_visibility"  => (($me["index_privacy"] == "Y") ? true : false)
	);
}