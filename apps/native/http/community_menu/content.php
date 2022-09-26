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
    $cl['community_id'] = $_GET['community_id'];
    require("preprocess.php");
    $cl["page_title"] = cl_translate("Community Menu");
    $cl["page_desc"]  = $cl["config"]["description"];
    $cl["page_kw"]    = $cl["config"]["keywords"];
    $cl["pn"]         = "community";
    $cl["sbr"]        = true;
    $cl["sbl"]        = true;

    //$cl["bookmarks"]  = cl_get_bookmarks($me['id'], 30);
    $cl["http_res"]   = cl_template("community_menu/content");
}