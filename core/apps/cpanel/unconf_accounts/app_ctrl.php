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

function cl_get_unconfirmed_accounts() {
	global $db;

	$db = $db->where("time", (time() - 604800), "<");
	$qr = $db->getValue(T_ACC_VALIDS, "COUNT(*)");

	if (is_posnum($qr)) {
		return $qr;
	}

	return 0;
}