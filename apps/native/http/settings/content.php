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
	cl_redirect("404");
}

$cl["page_title"]    = cl_translate("Account settings");
$cl["page_desc"]     = $cl["config"]["description"];
$cl["page_kw"]       = $cl["config"]["keywords"];
$cl["pn"]            = "settings";
$cl["sbr"]           = true;
$cl["sbl"]           = true;
$cl["blocked_users"] = cl_get_blocked_users();
$cl["settings_app"]  = fetch_or_get($_GET["sapp"], false);
$cl["settings_app"]  = (not_empty($cl["settings_app"])) ? cl_text_secure($cl["settings_app"]) : 0;
$cl["settings_apps"] = array("name", "email", "siteurl", "bio", "gender", "password", "language", "country", "city", "verification", "privacy", "notifications", "blocked", "delete", "information", "email_notifs");

if (not_empty($cl["settings_app"]) && in_array($cl["settings_app"], $cl["settings_apps"])) {

	if ($cl["settings_app"] == "email_notifs" && $cl["config"]["email_notifications"] == "off") {
		cl_redirect("404");
	}
	else{
		$cl["http_res"] = cl_template(cl_strf("settings/includes/%s", $cl["settings_app"]));
	}
}

else{
	$cl["http_res"] = cl_template("settings/content");
}


