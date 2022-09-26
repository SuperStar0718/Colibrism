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
    require("preprocess.php");

    $cl["page_title"] = cl_translate("Post Flairs");
    $cl["page_desc"]  = $cl["config"]["description"];
    $cl["page_kw"]    = $cl["config"]["keywords"];
    $cl["pn"]         = "community";
    $cl["sbr"]        = true;
    $cl["sbl"]        = true;
    $cl["http_res"]   = cl_template("post_flairs/content");
}