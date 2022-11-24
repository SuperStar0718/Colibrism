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
if (empty($cl['is_logged'])) {
    cl_redirect("guest");
} else {

    $uname           = fetch_or_get($_GET["uname"], false);
    $uname           = cl_text_secure($uname);
    $cl['prof_user'] = cl_get_user_by_name($uname);
    $cl['page_tab']  = fetch_or_get($_GET["tab"], 'posts');


    require_once(cl_full_path("core/apps/show_post_details/app_ctrl.php"));
    require("apps/native/http/preprocess.php");


    $cl["page_kw"]     = $cl["config"]["keywords"];
    $cl["pn"]          = "home";
    $cl["page_xdata"]  = array();
    $cl["sbr"]         = true;
    $cl["sbl"]         = true;
    $cl["user_posts"]  = array();
    $cl["user_likes"]  = array();
    $cl["app_statics"] = array(
        "scripts" => array()
    );

    $media_type       = (($cl['page_tab'] == 'media') ? true : false);
    $post_id = fetch_or_get($_GET['post_id'], "");
    $cl["user_posts"] = cl_get_profile_posts_details(6, 30, $media_type, $post_id);

    $cl["http_res"] = cl_template("show_post_details/content");
}