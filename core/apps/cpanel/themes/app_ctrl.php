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

function cl_admin_get_themes() {
	$theme_dirs = glob(cl_full_path("themes/*"), GLOB_ONLYDIR);
	$theme_list = array();

	if (is_array($theme_dirs)) {
		foreach ($theme_dirs as $dir_path) {
			$theme_info = file_get_contents(cl_strf("%s/info.json", $dir_path));
			$theme_info = json($theme_info);

			array_push($theme_list, $theme_info);
		}
	}

    return $theme_list;
}