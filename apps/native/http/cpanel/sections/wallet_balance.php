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


$user_id = fetch_or_get($_GET["id"], false);
$user_id = (is_posnum($user_id)) ? $user_id : 0;
$cl["user_data"] = cl_raw_user_data($user_id);

if (not_empty($cl["user_data"])) {
	$cl["app_statics"] = array(
		"scripts" => array(
			cl_static_file_path("statics/js/libs/jquery-plugins/jquery.form-v4.2.2.min.js")
		)
	);

	$cl['http_res'] = cl_template("cpanel/assets/wallet_balance/content");
}
else {
	cl_redirect("404");
}