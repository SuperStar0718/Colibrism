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
	$data         = array(
		'code'    => 401,
		'data'    => array(),
		'message' => 'Unauthorized Access'
	);
}

else {
	$swift_data = $me['swift'];

	if (not_empty($me["last_swift"]) && isset($swift_data[$me["last_swift"]])) {
        $swift_data     = cl_delete_swift($me["last_swift"]);
       
        cl_update_user_data($me["id"], array(
            "swift"      => cl_minify_js(json($swift_data, true)),
            "last_swift" => ""
        ));
    }

    
    $data['code']    = 200;
    $data['message'] = "Media deleted successfully";
    $data['data']    = array();
}