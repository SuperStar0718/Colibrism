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

function cl_admin_get_users($args = array()) {
    global $cl,$me,$db;

    $args           = (is_array($args)) ? $args : array();
 
    $limit          = $args['limit'];
    $filter         = $args['filter'];
    $offset         = $args['limit']*($args['page']-1);

    $data           = array();
    $t_users        = T_USERS;
    $sql            = cl_sqltepmlate('apps/cpanel/users/sql/fetch_site_users',array(
        't_users'   => $t_users,
        'limit'     => $limit,
        'filter'    => $filter,
        'offset'    => $offset,
    ));
    $data  = array();
    $users = $db->rawQuery($sql);

    if (cl_queryset($users)) {
        foreach ($users as $row) {
            
            $row['url']         = cl_link($row['username']);
             $row['avatar']      = cl_get_media($row['avatar']);
            $row['last_active'] = date('d M, Y h:m',$row['last_active']);
            $banner_code        = fetch_or_get($cl['country_codes'][$row['country_id']], 'us');
            $row['banner']      = cl_banner($banner_code);
            $data[]             = $row;
        }
    }
    return $data;
}