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

if (not_empty($cl["is_logged"])) {
	cl_redirect("home");
}

require_once(cl_full_path("core/apps/guest/app_ctrl.php"));

$cl["invite_code"] = fetch_or_get($_GET["invite_code"], false);
$cl["auth_type"]   = fetch_or_get($_GET["auth"], "login");
$cl["auth_type"]   = (in_array($cl["auth_type"], array("login", "signup", "forgot_pass", "reset_pass"))) ? $cl["auth_type"] : "login";
$cl["page_title"]  = $cl["config"]["title"];
$cl["page_desc"]   = $cl["config"]["description"];
$cl["page_kw"]     = $cl["config"]["keywords"];
$cl["pn"]          = "guest";
$cl['em_code']     = ((not_empty($_GET['em_code']) && cl_verify_emcode($_GET['em_code'])) ? cl_text_secure($_GET['em_code']) : null);
$cl["sbr"]         = false;
$cl["sbl"]         = false;
$cl["total_user"]  = cl_get_total_users();
$cl["invite_code_status"] = (not_empty($cl["invite_code"])) ? cl_verify_invite_code($cl["invite_code"]) : false;
$cl['follow_suggestion']  = cl_get_follow_suggestions(10);
$cl["http_res"] = cl_template("guest/content");
