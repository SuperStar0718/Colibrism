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

require_once(cl_full_path("core/apps/search/app_ctrl.php"));

$cl["page_title"]   = cl_translate("Search");
$cl["page_desc"]    = $cl["config"]["description"];
$cl["page_kw"]      = $cl["config"]["keywords"];
$cl["pn"]           = "search";
$cl["sbr"]          = true;
$cl["sbl"]          = true;
$cl["search_query"] = fetch_or_get($_GET['q'], "");
$cl["page_tab"]     = fetch_or_get($_GET['tab'], "posts");
$cl["query_result"] = array();

if (not_empty($cl["search_query"])) {
	$cl["search_query"] = cl_text_secure($cl["search_query"]);
	$cl["page_title"]   = $cl["search_query"];
	$cl["search_query"] = cl_croptxt($cl["search_query"], 32);
}

if ($cl["page_tab"] == 'htags') {
	$cl["query_result"] = cl_search_hashtags($cl["search_query"], false, 15);
}

else if($cl["page_tab"] == 'people') {
	$cl["query_result"] = cl_search_people($cl["search_query"], false, 15);
}

else {
	$cl["query_result"] = cl_search_posts($cl["search_query"], false, 15);
}

$cl["http_res"] = cl_template("search/content");