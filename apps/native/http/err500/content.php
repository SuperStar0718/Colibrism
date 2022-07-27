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

$cl["page_title"] = cl_translate('Server error 500!');
$cl["page_desc"]  = $cl["config"]["description"];
$cl["page_kw"]    = $cl["config"]["keywords"];
$cl["pn"]         = "err500";
$cl["sbr"]        = true;
$cl["sbl"]        = true;
$cl["err_msg"]    = cl_session('err500_message');

if ($cl["err_msg"]) {
	cl_session_unset('err500_message');
}

$cl["http_res"] = cl_template("err500/content");
