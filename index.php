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

require_once("core/web_req_init.php");

$app_name = (isset($_GET["app"])) ? $_GET["app"] : "home";
$app_stat = fetch_or_get($applications[$app_name], false);
$spa_load = fetch_or_get($_GET['spa_load'], '0');
$spa_data = array();
$site_url = parse_url($site_url);

if (is_array($site_url)) {
	if ($site_url['host'] != fetch_or_get($_SERVER['HTTP_HOST'], 'none')) {
		cl_redirect("/home?page=1");
	}
}

if ($spa_load != '1') {
	require_once("core/components/mw/http_request_mw.php");
}

if ($app_stat == true) {
	include_once(cl_strf("apps/native/http/%s/content.php", $app_name));
	if (empty($cl["http_res"])) {
		include_once("apps/native/http/err404/content.php");
	}
} else {
	include_once("apps/native/http/err404/content.php");
}

if ($spa_load == '1') {

	header('Content-Type: application/json');

	$spa_data['status']    = 200;
	$spa_data['html']      = $cl["http_res"];
	$spa_data['json_data'] = array(
		"page_title"       => $cl["page_title"],
		"page_desc"        => $cl["page_desc"],
		"page_kw"          => $cl["page_kw"],
		"page_img"         => fetch_or_get($cl["page_img"], $cl["config"]["site_logo"]),
		"pn"               => $cl["pn"],
		"page_xdata"       => fetch_or_get($cl["page_xdata"], array()),
		"page_tab"         => fetch_or_get($cl["page_tab"], "none")
	);

	echo json_encode($spa_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	mysqli_close($mysqli);
	unset($cl);
	exit();
} else {
	if ($app_name == "mnemonic") {
		$http_res = cl_template("mnemonic/content");
		echo $http_res;
	} elseif ($app_name == "madatory_join") {
		$http_res = cl_template("madatory_join/content");
		echo $http_res;
		// } elseif ($app_name == "inbox") {
		// 	$http_res = cl_template("inbox/content");
		// 	echo $http_res;
	} else {
		$http_res = cl_template("main/content");
		echo $http_res;
		// cl_redirect("home?page=1");
	}



	mysqli_close($mysqli);
	unset($cl);
}