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

require_once(cl_full_path("core/apps/profile/app_ctrl.php"));

if ($action == 'load_more') {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $offset           = fetch_or_get($_GET['offset'], 0);
    $prof_id          = fetch_or_get($_GET['prof_id'], 0);
    $type             = fetch_or_get($_GET['type'], false);
    $html_arr         = array();

    if (is_posnum($prof_id) && is_posnum($offset) && cl_can_view_profile($prof_id)) {
        if (in_array($type, array('posts', 'media'))) {

            $media_type = (($type == 'media') ? true : false);
            $posts_ls   = cl_get_profile_posts($prof_id, 30, $media_type, $offset);

            if (not_empty($posts_ls)) {
                foreach ($posts_ls as $cl['li']) {
                    $html_arr[] = cl_template('timeline/post');
                }

                $data['status'] = 200;
                $data['html']   = implode("", $html_arr);
            }
        } else {
            if (cl_can_view_profile($prof_id)) {
                $posts_ls = cl_get_profile_likes($prof_id, 30, $offset);

                if (not_empty($posts_ls)) {
                    foreach ($posts_ls as $cl['li']) {
                        $html_arr[] = cl_template('timeline/post');
                    }

                    $data['status'] = 200;
                    $data['html']   = implode("", $html_arr);
                }
            }
        }
    }
} else if ($action == "new_conversation") {
    $user_id           = fetch_or_get($_GET['user_id'], "");
    $db = $db->where('sender', $user_id);
    // $db = $db->orwhere('sender', $cl['me']['id']);
    // $db = $db->where('receiver', $user_id);
    $db = $db->where('receiver', $cl['me']['id']);
    $result = $db->getone(T_CONVERSATIONS);
    $db = $db->where('receiver', $user_id);
    $db = $db->where('sender', $cl['me']['id']);
    $result1 = $db->getone(T_CONVERSATIONS);

    if (not_empty($result)) :
        return cl_redirect("inbox?conversation=" . $result['id']);
    elseif (not_empty($result1)) :
        return cl_redirect("inbox?conversation=" . $result1['id']);
    else :
        $db->insert(T_CONVERSATIONS, array(
            'sender' => $user_id,
            'receiver' => $cl['me']['id']
        ));
        return cl_redirect("inbox");
    endif;
} else if ($action == "follow") {
    $user_id           = fetch_or_get($_GET['user_id'], "");
    $db->insert(T_PEOPLE_FOLLOWING, array(
        'user_id' => $cl['me']['id'],
        'people_id' => $user_id,
    ));
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == "unfollow") {
    $user_id           = fetch_or_get($_GET['user_id'], "");
    $db = $db->where('user_id', $cl['me']['id']);
    $db = $db->where('people_id', $user_id);
    $db->delete(T_PEOPLE_FOLLOWING);
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == "leave") {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['status']   = 404;
        $data['err_code'] = 0;
        $community_id          = fetch_or_get($_POST['community_id'], 0);
        $user_id          = fetch_or_get($_POST['user_id'], 0);

        if (cl_is_following($user_id, $community_id)) {
            $data['status'] = 200;
            cl_unfollow($user_id, $community_id);
        }
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'follow_community') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['status']   = 404;
        $data['err_code'] = 0;
        $community_id          = fetch_or_get($_POST['community_id'], 0);
        $user_id          = fetch_or_get($_POST['user_id'], 0);
        echo $user_id;
        if (!cl_is_following($user_id, $community_id)) {
            $data['status'] = 200;
            cl_follow($user_id, $community_id);
        }
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'follow_people') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['status']   = 404;
        $data['err_code'] = 0;
        $user_id          = fetch_or_get($_POST['user_id'], 0);
        $people_id          = fetch_or_get($_POST['people_id'], 0);

        if (!cl_is_following_people($user_id, $people_id)) {
            $data['status'] = 200;
            cl_follow_people($user_id, $people_id);
        }
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}