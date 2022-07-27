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

require_once(cl_full_path("core/apps/notifications/app_ctrl.php"));

$cl["page_tab"]   = fetch_or_get($_GET["page"],"notifs");
$cl["page_title"] = cl_translate("Notifications");
$cl["page_desc"]  = $cl["config"]["description"];
$cl["page_kw"]    = $cl["config"]["keywords"];
$cl["pn"]         = "notifications";
$cl["sbr"]        = true;
$cl["sbl"]        = true;
$cl["notifs"]     = cl_get_notifications(array(
	"type"        => $cl["page_tab"],
	"limit"       => 50
));

$cl["total_notifs"] = cl_get_total_notifications($cl["page_tab"]);
$cl["http_res"]     = cl_template("notifications/content");

