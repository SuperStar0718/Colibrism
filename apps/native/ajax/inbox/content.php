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

if ($action == 'send_message') {
    $data['err_code'] = "invalid_req_data";
    $data['status']   = 400;
    $message           = fetch_or_get($_POST['message'], "");
    $conversation_id = fetch_or_get($_POST['conversation_id'], 0);
    $conversation_type = fetch_or_get($_POST['conversation_type'], "");
    $owner =  fetch_or_get($_POST['owner'], "");


    if (not_empty($message) && is_posnum($conversation_id) && $conversation_type == 'user') {
        $insert_data = array(
            "conversation_id" => $conversation_id,
            "owner" => $me['id'],
            "message" => $message
        );
        $db->insert(T_CONVERSATION_MESSAGE, $insert_data);
        $db = $db->where('id', $_POST['conversation_id']);
        $db = $db->update(T_CONVERSATIONS, array(
            'updated_at' =>  date('Y-m-d H:i:s')
        ));
    } else if (not_empty($message) && is_posnum($conversation_id) && $conversation_type == 'community') {
        $insert_data = array(
            "conversation_id" => $conversation_id,
            "owner" =>  $me['id'],
            "message" => $message
        );
        $db->insert(T_MOD_MAIL_MESSAGES, $insert_data);
        $db = $db->where('id', $_POST['conversation_id']);
        $db = $db->update(T_MOD_MAILS, array(
            'updated_at' =>  date('Y-m-d H:i:s')
        ));
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'send_mod_mail') {
    $data['err_code'] = "invalid_req_data";
    $data['status']   = 400;
    $message           = fetch_or_get($_POST['message'], "");
    $conversation_id = fetch_or_get($_POST['conversation_id'], 0);
    $owner =  fetch_or_get($_POST['owner'], "");
    if (not_empty($message) && is_posnum($conversation_id)) {
        $insert_data = array(
            "conversation_id" => $conversation_id,
            "owner" => $owner ? 0 : $me['id'],
            "message" => $message
        );
        $db->insert(T_MOD_MAIL_MESSAGES, $insert_data);
        $db = $db->where('id', $_POST['conversation_id']);
        $db = $db->update(T_MOD_MAILS, array(
            'updated_at' =>  date('Y-m-d H:i:s')
        ));
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}