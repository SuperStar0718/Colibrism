<?php
global $cl, $db, $me;

// function convert_into_base64($path)
// {
//     $type = pathinfo($path, PATHINFO_EXTENSION); #Get product image type
//     $data = file_get_contents($path); #Get the product image
//     $imageBase64 = "data:image/$type;base64," . base64_encode($data); #Convert product image to base64

//     echo "$imageBase64";
// }

function output_date($timestamp)
{
    if (date('Y M d', strtotime($timestamp)) == date('Y M d'))
        echo "Today";
    else if (date('Y M d', strtotime($timestamp)) == date('Y M d', strtotime("-1 days")))
        echo "Yesterday";
    else
        echo date('M d', strtotime($timestamp));
}
$mode = fetch_or_get($_GET['mode'], 'All');
$conversation_id = fetch_or_get($_GET['conversation'], '');
$community_id = fetch_or_get($_GET['community_id'], '');

$cl['users'] = $db->get(T_USERS);

if ($mode == "DMs") :
    $db = $db->where("sender", $me['id']);
    $db = $db->orwhere('receiver', $me['id']);
    $db->orderBy('updated_at', 'DESC');
    $result = $db->get(T_CONVERSATIONS);
    if (count($result) > 0) {
        $cl['conversations'] = $result;
    } else {
        return;
    }
    global $user_list;
    $user_list = array();
    foreach ($result as $conversation) :
        if ($conversation['sender'] == $me['id']) :
            $db = $db->where("id", $conversation['receiver']);
            $result = $db->getone(T_USERS);
            $db = $db->where('conversation_id', $conversation['id']);
            $db->orderBy('created_at', 'DESC');
            $res = $db->getone(T_CONVERSATION_MESSAGE);
            $result['message'] = $res['message'];
            array_push($user_list, $result);
        else :
            $db = $db->where("id", $conversation['sender']);
            $result = $db->getone(T_USERS);
            $db = $db->where('conversation_id', $conversation['id']);
            $db->orderBy('created_at', 'DESC');
            $res = $db->getone(T_CONVERSATION_MESSAGE);
            $result['message'] = $res['message'];
            array_push($user_list, $result);
        endif;
    endforeach;
    $cl['conversation_id']         = fetch_or_get($_GET['conversation'], $cl['conversations'][0]['id']);
    $cl['conversation_type'] = 'user';
    $cl['messages'] = array();
    $db = $db->where("conversation_id", $cl['conversation_id']);
    $db->orderBy("created_at", "DESC");
    $result = $db->get(T_CONVERSATION_MESSAGE);
    foreach ($result as $message) :
        array_push($cl['messages'], $message);
    endforeach;


elseif ($mode == 'Mod_Mails') :
    $db = $db->where('user', $me['id']);
    $db->orderBy("created_at", "DESC");
    $result = $db->get(T_MOD_MAILS);
    if (count($result) > 0) {
        $cl['conversations'] = $result;
    } else {
        return;
    }
    $cl['conversations'] = $result;
    global $user_list;
    $user_list = array();
    foreach ($result as $conversation) :
        $db = $db->where("community_id", $conversation['community_id']);
        $temp = $db->getone(T_COMMUNITY);
        $db = $db->where('conversation_id', $conversation['id']);
        $db->orderBy('created_at', 'DESC');
        $res = $db->getone(T_MOD_MAIL_MESSAGES);
        $result = array(
            'avatar' => $temp['icon'],
            'username' => $temp['name'],
            'message' => isset($res['message']) ? $res['message'] : ''
        );

        array_push($user_list, $result);
    endforeach;

    $community_id = fetch_or_get($_GET['community_id'], '');
    $db = $db->where('community_id', $community_id);
    $db = $db->where('user', $me['id']);
    $result = $db->getone(T_MOD_MAILS);
    $cl['conversation_id'] = $result ? $result['id'] : $cl['conversations'][0]['id'];
    $cl['conversation_type'] = 'community';
    $cl['messages'] = array();
    $db = $db->where("conversation_id", $cl['conversation_id']);
    $db->orderBy("created_at", "DESC");
    $result = $db->get(T_MOD_MAIL_MESSAGES);
    foreach ($result as $message) :
        array_push($cl['messages'], $message);
    endforeach;
elseif ($mode == 'All') :
    $sql = "SELECT 'community' AS 'type', created_at FROM cl_mod_mails WHERE cl_mod_mails.`user` = " . $me['id'] . " UNION SELECT 'user',created_at  FROM cl_conversations  WHERE cl_conversations.receiver = " . $me['id'] . "  OR cl_conversations.sender =" . $me['id'] . " ORDER BY created_at DESC";
    $query_res = $db->rawQuery($sql);
    cl_queryset($query_res);
    $result = $query_res;
    if (count($result) > 0) {
        $cl['conversations'] = $result;
    } else {
        return;
    }
    $cl['conversations'] = array();
    global $user_list;
    $user_list = array();
    foreach ($result as $item) :
        if ($item['type'] == 'community') :
            $db = $db->where('created_at', $item['created_at']);
            $result = $db->getone(T_MOD_MAILS);
            $cl['conversations'][] = $result;

            $db = $db->where("community_id", $result['community_id']);
            $temp = $db->getone(T_COMMUNITY);
            $db = $db->where('conversation_id', $result['id']);
            $db->orderBy('created_at', 'DESC');
            $res = $db->getone(T_MOD_MAIL_MESSAGES);
            $result = array(
                'avatar' => $temp['icon'],
                'username' => $temp['name'],
                'message' => isset($res['message']) ? $res['message'] : '' 
            );

            array_push($user_list, $result);
        elseif ($item['type'] == 'user') :
            $db = $db->where('created_at', $item['created_at']);
            $result = $db->getone(T_CONVERSATIONS);
            $cl['conversations'][] = $result;

            if ($result['sender'] == $me['id']) :
                $db = $db->where("id", $result['receiver']);
                $result1 = $db->getone(T_USERS);

                $db = $db->where('conversation_id', $result['id']);
                $db->orderBy('created_at', 'DESC');
                $res = $db->getone(T_CONVERSATION_MESSAGE);
                $result1['message'] = $res['message'];
                array_push($user_list, $result1);
            else :
                $db = $db->where("id", $result['sender']);
                $result1 = $db->getone(T_USERS);
                $db = $db->where('conversation_id', $result['id']);
                $db->orderBy('created_at', 'DESC');
                $res = $db->getone(T_CONVERSATION_MESSAGE);
                if (not_empty($res['message']))
                    $result1['message'] = $res['message'];
                array_push($user_list, $result1);
            endif;
        endif;
    endforeach;

    if (not_empty($conversation_id) || (not_empty($cl['conversations'][0]['sender']) && empty($conversation_id) && empty($community_id))) :
        $cl['conversation_id']         = fetch_or_get($_GET['conversation'], $cl['conversations'][0]['id']);
        $cl['conversation_type'] = 'user';
        $cl['messages'] = array();
        $db = $db->where("conversation_id", $cl['conversation_id']);
        $db->orderBy("created_at", "DESC");
        $result = $db->get(T_CONVERSATION_MESSAGE);
        foreach ($result as $message) :
            array_push($cl['messages'], $message);
        endforeach;
    elseif (not_empty($community_id)  || (not_empty($cl['conversations'][0]['community_id']) && empty($conversation_id) && empty($community_id))) :
        $community_id = fetch_or_get($_GET['community_id'], '');
        $db = $db->where('community_id', $community_id);
        $db = $db->where('user', $me['id']);
        $result = $db->getone(T_MOD_MAILS);
        $cl['conversation_id'] = $result ? $result['id'] : $cl['conversations'][0]['id'];
        $cl['conversation_type'] = 'community';
        $cl['messages'] = array();
        $db = $db->where("conversation_id", $cl['conversation_id']);
        $db->orderBy("created_at", "DESC");
        $result = $db->get(T_MOD_MAIL_MESSAGES);
        foreach ($result as $message) :
            array_push($cl['messages'], $message);
        endforeach;
    endif;



endif;