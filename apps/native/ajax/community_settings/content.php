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
        $db           = $db->where('community_id', $community_id);
        $db->update(T_COMMUNITY_SETTINGS, array(
            'post_flairs' => json($result, true)
        ));
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'copy_id') {
    $flair_id = fetch_or_get($_GET['id'], "");
    setcookie("flair_id", $flair_id, strtotime("+1 days"), '/') or die('unable to create cookie');
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'paste_flair') {
    $flair_id = fetch_or_get($_POST['flair_id'], "");
    $community_id = fetch_or_get($_POST['community_id'], "");
    $post_id = fetch_or_get($_POST['post_id'], "");
    $db = $db->where('community_id', $community_id);
    $result = $db->getone(T_COMMUNITY_SETTINGS);

    if (not_empty($result['post_flairs'])) :
        $post_flairs = json($result['post_flairs']);

        foreach ($post_flairs as $post_flair) :
            if (in_array($flair_id, $post_flair)) :
                $insert_data = array(
                    "community_id" => $community_id,
                    "post_id" => $post_id,
                    "flair_id" => $flair_id
                );
                $db = $db->where('community_id', $community_id);
                $db = $db->where('post_id', $post_id);
                $res = $db->getone(T_POST_FLAIRS);
                if (not_empty($res)) :
                    $db = $db->where('community_id', $community_id);
                    $db = $db->where('post_id', $post_id);
                    $db->update(T_POST_FLAIRS, $insert_data);
                else :
                    $db->insert(T_POST_FLAIRS, $insert_data);
                endif;
            else :
                $result[] = $post_flair;
            endif;
        endforeach;
    endif;

    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'delete_textarea_widget') {
    $community_id = fetch_or_get($_POST['community_id'], "");

    $db           = $db->where('community_id', $community_id);
    $result = $db->update(T_COMMUNITY_SETTINGS, array(
        'textarea_widget' => null
    ));
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'add_textarea_widget') {
    $widgetTitle = fetch_or_get($_POST['widgetTitle'], "");
    $position = fetch_or_get($_POST['position'], "rightsidebar");
    $widgetContent = fetch_or_get($_POST['widgetContent'], "");
    $community_id = fetch_or_get($_POST['community_id'], "");

    if (not_empty($widgetTitle) && not_empty($position) && not_empty($widgetContent) && not_empty($community_id)) {
        $db           = $db->where('community_id', $community_id);
        $result = $db->getOne(T_COMMUNITY_SETTINGS);
        $date = new DateTime();

        if (not_empty($result)) {
            $data['status']   = 200;
            $textarea_widgets = json($result['textarea_widget']);
            // if (count($post_flairs) > 9)
            //     return header('Location: ' . $_SERVER['HTTP_REFERER']);
            $new_widget = array(
                'widgetTitle' => $widgetTitle,
                'position' => $position,
                'widgetContent' => $widgetContent,
                'created_at' => $date->format("m/d/Y"),
            );
            $db           = $db->where('community_id', $community_id);
            $result = $db->update(T_COMMUNITY_SETTINGS, array(
                'textarea_widget' => json($new_widget, true)
            ));
        } else {
            $new_widget = array(
                'widgetTitle' => $widgetTitle,
                'position' => $position,
                'widgetContent' => $widgetContent,
                'created_at' =>  $date->format("m/d/Y"),
            );
            $insert_data = array(
                "community_id" => $community_id,
                "textarea_widget" => json($new_widget, true)
            );
            $db->insert(T_COMMUNITY_SETTINGS, $insert_data);
        }
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'delete_image_widget') {
    $community_id = fetch_or_get($_POST['community_id'], "");
    $db           = $db->where('community_id', $community_id);
    $result = $db->update(T_COMMUNITY_SETTINGS, array(
        'image_widget' => null
    ));
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'add_image_widget') {
    $widgetTitle = fetch_or_get($_POST['widgetTitle'], "");
    $position = fetch_or_get($_POST['position'], "rightsidebar");
    $community_id = fetch_or_get($_POST['community_id'], "");

    if (not_empty($widgetTitle) && not_empty($position) && not_empty($community_id) && not_empty($_FILES['imageFile'])) {
        $file_info      = array(
            'file'      => $_FILES['imageFile']['tmp_name'],
            'size'      => $_FILES['imageFile']['size'],
            'name'      => $_FILES['imageFile']['name'],
            'type'      => $_FILES['imageFile']['type'],
            'file_type' => 'image',
            'folder'    => 'images',
            'slug'      => 'original',
            'allowed'   => 'jpg,png,jpeg,gif'
        );

        $file_upload = cl_upload($file_info);

        if (not_empty($file_upload['filename'])) {
            $data['status'] = 200;
        }

        $db           = $db->where('community_id', $community_id);
        $result = $db->getOne(T_COMMUNITY_SETTINGS);
        if (not_empty($result)) {
            $data['status']   = 200;
            $date = new DateTime();

            if (!not_empty($result['image_widget'])) {
                $new_widget = array(
                    'widgetTitle' => $widgetTitle,
                    'position' => $position,
                    'image_path' => $file_upload['filename'],
                    'created_at' =>  $date->format("m/d/Y"),
                );
                $db           = $db->where('community_id', $community_id);
                $result = $db->update(T_COMMUNITY_SETTINGS, array(
                    'image_widget' => json($new_widget, true)
                ));
            } else {
                $image_widgets = json($result['image_widget']);
                // if (count($post_flairs) > 9)
                //     return header('Location: ' . $_SERVER['HTTP_REFERER']);
                $new_widget = array(
                    'widgetTitle' => $widgetTitle,
                    'position' => $position,
                    'image_path' => $file_upload['filename'],
                    'created_at' =>  $date->format("m/d/Y"),
                );
                $db           = $db->where('community_id', $community_id);
                $result = $db->update(T_COMMUNITY_SETTINGS, array(
                    'image_widget' => json($new_widget, true)
                ));
            }
        } else {
            $new_widget = array(
                'widgetTitle' => $widgetTitle,
                'position' => $position,
                'image_path' => $file_upload['filename'],
                'created_at' =>  $date->format("m/d/Y"),
            );
            $insert_data = array(
                "community_id" => $community_id,
                "image_widget" => json($new_widget, true)
            );
            $db->insert(T_COMMUNITY_SETTINGS, $insert_data);
        }
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'delete_community_list_widget') {
    $community_id = fetch_or_get($_POST['community_id'], "");
    $db           = $db->where('community_id', $community_id);
    $result = $db->update(T_COMMUNITY_SETTINGS, array(
        'community_list_widget' => null
    ));
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'add_community_list_widget') {
    $widgetTitle = fetch_or_get($_POST['widgetTitle'], "");
    $community_id = fetch_or_get($_POST['community_id'], "");
    $community_id_selected = fetch_or_get($_POST['communityChice'], "");
    $db = $db->where('community_id', $community_id_selected);
    $result = $db->getone(T_COMMUNITY);
    $community_name = $result['name'];
    $date = new DateTime();

    if (not_empty($widgetTitle) && not_empty($community_id_selected) && not_empty($community_id)) {
        $db           = $db->where('community_id', $community_id);
        $result = $db->getOne(T_COMMUNITY_SETTINGS);
        if (not_empty($result)) {
            $data['status']   = 200;
            if (!not_empty($result['community_list_widget'])) {
                $community_ids = array();
                $community_ids[] = $community_id_selected;
                $new_widget = array(
                    'widgetTitle' => $widgetTitle,
                    'community_ids' => $community_ids,
                    'created_at' =>  $date->format("m/d/Y"),
                );
                $db           = $db->where('community_id', $community_id);
                $result = $db->update(T_COMMUNITY_SETTINGS, array(
                    'community_list_widget' => json($new_widget, true)
                ));
            } else {
                $community_list_widgets = json($result['community_list_widget']);
                $community_ids = $community_list_widgets['community_ids'];
                if (count($community_ids) > 4)
                    return header('Location: ' . $_SERVER['HTTP_REFERER']);
                $community_ids[] = $community_id_selected;
                $community_list_widgets['community_ids'] = $community_ids;
                $db           = $db->where('community_id', $community_id);
                $result = $db->update(T_COMMUNITY_SETTINGS, array(
                    'community_list_widget' => json($community_list_widgets, true)
                ));
            }
        } else {
            $community_ids = array();
            $community_ids[] = $community_id_selected;
            $new_widget = array(
                'widgetTitle' => $widgetTitle,
                'community_ids' => $community_ids,
                'created_at' =>  $date->format("m/d/Y"),
            );
            $insert_data = array(
                "community_id" => $community_id,
                "community_list_widgets" => json($new_widget, true)
            );
            $db->insert(T_COMMUNITY_SETTINGS, $insert_data);
        }
    }

    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'mod_mail_user') {
    $community_id = fetch_or_get($_GET['community_id'], "");
    $user_id = $me['id'];
    $db = $db->where('user', $user_id);
    $db = $db->where('community_id', $community_id);
    $result = $db->getone(T_MOD_MAILS);
    if (not_empty($result)) :
        $conversation_id = $result['id'];
        $db = $db->where('user', $user_id);
        $db = $db->where('community_id', $community_id);
        $db = $db->update(T_MOD_MAILS, array(
            'updated_at' =>  date('Y-m-d H:i:s')
        ));


    else :
        $conversation_id = $db->insert(T_MOD_MAILS, array(
            'user' => $user_id,
            'community_id' => $community_id
        ));
    endif;
    return cl_redirect("mod_mail?conversation_id=" . $conversation_id);
}