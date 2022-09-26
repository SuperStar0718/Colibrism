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

if (empty($cl["is_logged"])) {
    $data['status'] = 400;
    $data['error']  = 'Invalid access token';
} else if ($action == 'add_post_flair') {
    $data['err_code'] = "invalid_req_data";
    $data['status']   = 400;
    $flairText           = fetch_or_get($_POST['flairText'], "");
    $flair_back_color           = fetch_or_get($_POST['flair_back_color'], "");
    $flair_text_color           = fetch_or_get($_POST['flair_text_color'], "");
    $post_back_color           = fetch_or_get($_POST['post_back_color'], "");
    $community_id           = fetch_or_get($_POST['community_id'], "");


    if (not_empty($flairText) && not_empty($flair_text_color) && not_empty($flair_back_color) && not_empty($post_back_color) && not_empty($community_id)) {
        $db           = $db->where('user_id', $me['id']);
        $db           = $db->where('community_id', $community_id);
        $result = $db->getOne(T_COMMUNITY_SETTINGS);
        if (not_empty($result)) {
            $data['status']   = 200;
            if (!not_empty($result['post_flairs'])) {
                $new_post_flair = array();
                $new_post_flair[] = array(
                    'flairText' => $flairText,
                    'flair_back_color' => $flair_back_color,
                    'flair_text_color' => $flair_text_color,
                    'post_back_color' => $post_back_color,
                    'id' => rand(0, 10000)
                );
                $db           = $db->where('user_id', $me['id']);
                $db           = $db->where('community_id', $community_id);
                $result = $db->update(T_COMMUNITY_SETTINGS, array(
                    'post_flairs' => json($new_post_flair, true)
                ));
            } else {
                $post_flairs = json($result['post_flairs']);
                if (count($post_flairs) > 9)
                    return header('Location: ' . $_SERVER['HTTP_REFERER']);
                $new_post_flair = array(
                    'flairText' => $flairText,
                    'flair_back_color' => $flair_back_color,
                    'flair_text_color' => $flair_text_color,
                    'post_back_color' => $post_back_color,
                    'id' => rand(0, 10000)
                );
                $post_flairs[] = $new_post_flair;
                $db           = $db->where('user_id', $me['id']);
                $db           = $db->where('community_id', $community_id);
                $result = $db->update(T_COMMUNITY_SETTINGS, array(
                    'post_flairs' => json($post_flairs, true)
                ));
            }
        } else {
            $new_post_flair = array(
                'flairText' => $flairText,
                'flair_back_color' => $flair_back_color,
                'flair_text_color' => $flair_text_color,
                'post_back_color' => $post_back_color,
                'id' => rand(0, 10000)
            );
            $insert_data = array(
                "community_id" => $community_id,
                "user_id" => $me['id'],
                "post_flairs" => json($new_post_flair, true)
            );
            $db->insert(T_COMMUNITY_SETTINGS, $insert_data);
        }
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'delete_post_flair') {
    $data['err_code'] = "invalid_req_data";
    $data['status']   = 400;
    $flair_id           = fetch_or_get($_GET['id'], "");
    $community_id           = fetch_or_get($_GET['community_id'], "");
    $db = $db->where('user_id', $me['id']);
    $db = $db->where('community_id', $community_id);
    $result = $db->getone(T_COMMUNITY_SETTINGS);
    if (not_empty($result)) {
        $post_flairs = json($result['post_flairs']);
        $result = array();
        foreach ($post_flairs as $post_flair) :
            if (in_array($flair_id, $post_flair)) :
                continue;
            else :
                $result[] = $post_flair;
            endif;
        endforeach;
        $db           = $db->where('user_id', $me['id']);
        $db           = $db->where('community_id', $community_id);
        $db->update(T_COMMUNITY_SETTINGS, array(
            'post_flairs' => json($result, true)
        ));
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'copy_id') {
    $flair_id = fetch_or_get($_GET['id'], "");
    setcookie("flair_id", $flair_id, strtotime("+7 days"), '/') or die('unable to create cookie');
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}