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

require_once(cl_full_path("core/apps/cpanel/account_verification/app_ctrl.php"));
$request_id       = fetch_or_get($_GET['id'], '');
$page = fetch_or_get($_GET['page'], 1);

if (not_empty($request_id)) {
    $cl['req_data']   = cl_admin_get_verification_request_data($request_id);
    if (not_empty($cl['req_data'])) {
        $cl['popup_modal'] = cl_template('cpanel/assets/account_verification/modals/popup_ticket');
    }
}
$cl['requests_total'] = cl_admin_get_verification_requests_total();
$cl['requests']       = cl_admin_get_verification_requests(array('limit' => 7, 'page' => $page));
$cl['http_res']       = cl_template("cpanel/assets/account_verification/content");