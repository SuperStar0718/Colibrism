<?php
global $cl, $db, $me;

function output_date($timestamp)
{
    if (date('Y M d', strtotime($timestamp)) == date('Y M d'))
        echo "Today";
    else if (date('Y M d', strtotime($timestamp)) == date('Y M d', strtotime("-1 days")))
        echo "Yesterday";
    else
        echo date('M d', strtotime($timestamp));
}

$community_id = fetch_or_get($_GET['community_id'], "");
$conversation_id = fetch_or_get($_GET['conversation_id'], "");

$cl['users'] = $db->get(T_USERS);
if (not_empty($community_id)) :


    $db = $db->where("community_id", $community_id);
    $db->orderBy('created_at', 'DESC');
    $result = $db->get(T_MOD_MAILS);


    global $user_list;
    $user_list = array();
    foreach ($result as $conversation) :
        $db = $db->where("id", $conversation['user']);
        $result = $db->getone(T_USERS);
        $db = $db->where('conversation_id', $conversation['id']);
        $db->orderBy('created_at', 'DESC');
        $res = $db->getone(T_MOD_MAIL_MESSAGES);
        $result['message'] = $res['message'];
        array_push($user_list, $result);
    endforeach;

    $db = $db->where('community_id', $community_id);
    $db->orderBy('created_at', 'DESC');
    $result = $db->get(T_MOD_MAILS);
    if (not_empty($result)) :
        $cl['conversations'] = $result;
        $cl['conversation_id']         = $conversation_id ? $conversation_id : $result[0]['id'];
        $conversation_id =  $cl['conversation_id'];
        $db = $db->where('community_id', $community_id);
        $result = $db->getone(T_COMMUNITY);
        $cl['community_icon'] = $result['icon'];
    endif;
// echo $cl['conversation_id'];
// asdf;




else :
    $db = $db->where('id', $conversation_id);
    $result = $db->getone(T_MOD_MAILS);
    global $user_list;
    $user_list = array();
    $db = $db->where('community_id', $result['community_id']);
    $res = $db->getone(T_COMMUNITY);
    $cl['conversations'] = array();
    $cl['conversations'][] = $result;
    $cl['conversation_id'] = $conversation_id;
    $db  = $db->where('conversation_id', $conversation_id);
    $db->orderBy('created_at', 'DESC');
    $result = $db->getone(T_MOD_MAIL_MESSAGES);
    if (not_empty($result)) :
        $user_list[] = array(
            'avatar' => $res['icon'],
            'username' => $res['name'],
            'message' => $result['message']
        );
    else :
        $user_list[] = array(
            'avatar' => $res['icon'],
            'username' => $res['name']
        );
    endif;

endif;







$cl['messages'] = array();
$db = $db->where('conversation_id', $conversation_id);
$db->orderBy('created_at', 'DESC');
$result = $db->get(T_MOD_MAIL_MESSAGES);
foreach ($result as $message) :
    array_push($cl['messages'], $message);
endforeach;