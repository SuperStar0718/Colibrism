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

function cl_get_total_users() {
	global $db, $cl;

	$db  = $db->where('active', array('1', '2'), 'IN');
	$qr  = $db->getValue(T_USERS, 'COUNT(*)');
	$num = 0;

	if (is_posnum($qr)) {
		$num = $qr;
	}

	return $num;
}