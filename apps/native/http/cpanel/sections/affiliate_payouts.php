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

require_once(cl_full_path("core/apps/cpanel/affiliate_payouts/app_ctrl.php"));

$cl['total_requests'] = cl_get_affiliate_payouts_total();
$cl['requests']       = cl_get_affiliate_payouts();
$cl['http_res']       = cl_template("cpanel/assets/affiliate_payouts/content");