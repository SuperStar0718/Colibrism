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
    require("apps/native/http/preprocess.php");
    if(empty($cl['communities_can_follow'])):
        cl_redirect("home");
    endif;
    $cl["page_title"] = cl_translate("Madatory Join");
    $cl["page_desc"]  = $cl["config"]["description"];
    $cl["page_kw"]    = $cl["config"]["keywords"];
    $cl["pn"]         = "madatory_join";
    $cl["http_res"]   = cl_template("madatory_join/content");
}