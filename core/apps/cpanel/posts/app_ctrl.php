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

function cl_admin_get_posts($args = array())
{
    global $cl, $me, $db;

    $args           = (is_array($args)) ? $args : array();
    $offset         = $args['limit'] * ($args['page'] - 1);

    $limit          =  $args['limit'];

    $data           =  array();
    $t_pubs         =  T_PUBS;
    $sql            =  cl_sqltepmlate('apps/cpanel/posts/sql/fetch_posts', array(
        'offset'    => $offset,
        't_pubs'    => $t_pubs,
        'limit'     => $limit,

    ));

    $data  = array();
    $posts = $db->rawQuery($sql);

    if (cl_queryset($posts)) {
        foreach ($posts as $row) {
            $row['url']           = cl_link(cl_strf('thread/%d', $row['id']));
            $row['replys_count']  = cl_number($row['replys_count']);
            $row['reposts_count'] = cl_number($row['reposts_count']);
            $row['likes_count']   = cl_number($row['likes_count']);
            $row['time']          = date('d M, Y h:m', $row['time']);
            $data[]               = $row;
        }
    }

    return $data;
}