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

$cl["app_statics"] = array(
	"scripts" => array(
		cl_static_file_path("apps/cpanel/statics/js/libs/bootstrap-select-v1.13.9.min.js"),
		cl_static_file_path("statics/js/libs/jquery-plugins/jquery.form-v4.2.2.min.js")
	),
	"styles" => array(
		cl_static_file_path("apps/cpanel/statics/css/libs/bootstrap-select-v1.13.9.min.css")
	)
);

$cl['http_res'] = cl_template("cpanel/assets/oauth_settings/content");