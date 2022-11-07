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

require_once(cl_full_path("core/apps/cpanel/dashboard/app_ctrl.php"));
require_once(cl_full_path("core/apps/cpanel/users/app_ctrl.php"));
$page = fetch_or_get($_GET['page'],1);
$filter = array();
$filter['username'] = fetch_or_get($_POST['username'],"");
$filter['status'] = fetch_or_get($_POST['status'],"");
$filter['type'] = fetch_or_get($_POST['type'],"");
$cl['filter'] = $filter;
$cl['total_users'] = cl_admin_total_users();
$cl['site_users']  = cl_admin_get_users(array('limit' => 7, 'page'=>$page, 'filter'=>$filter ));    
$cl['http_res']    = cl_template("cpanel/assets/users/content");