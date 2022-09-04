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


$uname           = fetch_or_get($_GET["uname"], false);
$uname           = cl_text_secure($uname);
$cl['prof_user'] = cl_get_user_by_name($uname);
$cl['page_tab']  = fetch_or_get($_GET["tab"], 'posts');


require_once(cl_full_path("core/apps/show_post_details/app_ctrl.php"));
require("preprocess.php");


$cl["page_kw"]     = $cl["config"]["keywords"];
$cl["pn"]          = "show_post_details";
$cl["page_xdata"]  = array();
$cl["sbr"]         = true;
$cl["sbl"]         = true;
$cl["user_posts"]  = array();
$cl["user_likes"]  = array();
$cl['prof_user']['index_privacy'] = 's';
$cl["app_statics"] = array(
    "scripts" => array()
);

$media_type       = (($cl['page_tab'] == 'media') ? true : false);
$post_description = (not_empty($_GET['post_description']) ? true : false);
$community_id = (not_empty($_GET['community_id']) ? true : false);
$cl["user_posts"] = cl_get_profile_posts_details(6, 30, $media_type, $post_description, $community_id);

$temp = $_GET['community_id'];
$sql = "SELECT * from `cl_community` where `community_id`=$temp";
$query_res = $db->rawQuery($sql);
cl_queryset($query_res);
global $community;
$community = $query_res[0];

$temp_id = $me['id'];
$sql = "SELECT * from `cl_join_list` where `community_id`=$temp and `user_id`=$temp_id";
$query_res = $db->rawQuery($sql);
cl_queryset($query_res);
$is_joined = $query_res;


$cl["http_res"] = cl_template("show_post_details/content");