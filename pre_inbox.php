<?php
global $cl, $db, $me;

function convert_into_base64($path)
{
    $type = pathinfo($path, PATHINFO_EXTENSION); #Get product image type
    $data = file_get_contents($path); #Get the product image
    $imageBase64 = "data:image/$type;base64," . base64_encode($data); #Convert product image to base64

    echo "$imageBase64";
    // return $imageBase64;
}

$sql = "select * from cl_users";
$query_res = $db->rawQuery($sql);
cl_queryset($query_res);
$cl['users'] = $query_res;

$db = $db->where("sender", $me['id']);
$db = $db->orwhere('receiver', $me['id']);
$db->orderBy('updated_at', 'DESC');
$result = $db->get(T_CONVERSATIONS);
if (count($result) > 0) {
    $cl['conversations'] = $result;
}
global $user_list;
$user_list = array();
foreach ($result as $conversation) :
    if ($conversation['sender'] == $me['id']) :
        $db = $db->where("id", $conversation['receiver']);
        $result = $db->getone(T_USERS);
        array_push($user_list, $result);
    else :
        $db = $db->where("id", $conversation['sender']);
        $result = $db->getone(T_USERS);
        array_push($user_list, $result);
    endif;
endforeach;

$cl['conversation_id']         = fetch_or_get($_GET['conversation'], $cl['conversations'][0]['id']);

$cl['messages'] = array();
$db = $db->where("conversation_id", $cl['conversation_id']);
$db->orderBy("created_at", "DESC");
$result = $db->get(T_CONVERSATION_MESSAGE);
foreach ($result as $message) :
    array_push($cl['messages'], $message);
endforeach;

// $db = $db->where('community_id', $_GET['community_id']);
// $result = $db->getOne(T_COMMUNITY);
// if (not_empty($result)) {
//     // global $community;
//     $community = $result;
// }