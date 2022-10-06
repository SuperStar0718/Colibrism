<?php
global $cl, $db, $me, $voted;
$voted = array(array());
$sql = "SELECT * FROM cl_community WHERE community_id IN(SELECT community_id FROM cl_community_following WHERE follow_user_id=" . $me['id'] . ")";
$query_res = $db->rawQuery($sql);
cl_queryset($query_res);
$cl['communities_followed'] = $query_res;

$sql = "SELECT * FROM cl_community WHERE community_id NOT IN(SELECT community_id FROM cl_community_following WHERE follow_user_id=" . $me['id'] . ")";
// $sql = "SELECT * FROM cl_community ";
$query_res = $db->rawQuery($sql);
cl_queryset($query_res);
$cl['communities_can_follow'] = $query_res;

$sql = "SELECT * FROM cl_users WHERE `id` NOT IN(SELECT `people_id` FROM cl_people_following WHERE `user_id` = " . $me['id'] . " ) AND `id` != " . $me['id'];
$query_res = $db->rawQuery($sql);
cl_queryset($query_res);
$cl['users'] = $query_res;

foreach ($cl['communities_followed'] as $key => $community) {
    $temp_com = $community['community_id'];
    $temp_user = $me['id'];
    $sql = "select * from cl_join_list where community_id='$temp_com' and user_id='$temp_user'";
    $query_res = $db->rawQuery($sql);
    cl_queryset($query_res);

    $sql = "select * from cl_community where community_id='$temp_com' and moderator='$temp_user'";
    $query_moderator = $db->rawQuery($sql);
    cl_queryset($query_moderator);

    if (count($query_res) > 0 || count($query_moderator) > 0)
        $cl['communities_followed'][$key]['joined'] = true;
    else
        $cl['communities_followed'][$key]['joined'] = false;
    $sql = "select * from cl_join_list where community_id='$temp_com'";
    $query_res = $db->rawQuery($sql);
    cl_queryset($query_res);
    $cl['communities_followed'][$key]['members'] = count($query_res);
}
foreach ($cl['communities_can_follow'] as $key => $community) {
    $temp_com = $community['community_id'];
    $temp_user = $me['id'];

    $sql = "select * from cl_community_following where community_id='$temp_com' and follow_user_id='$temp_user'";
    $query_res = $db->rawQuery($sql);
    cl_queryset($query_res);
    if (count($query_res) > 0)
        $cl['communities_can_follow'][$key]['followed'] = true;
    else
        $cl['communities_can_follow'][$key]['followed'] = false;

    $sql = "select * from cl_join_list where community_id='$temp_com'";
    $query_res = $db->rawQuery($sql);
    cl_queryset($query_res);
    $cl['communities_can_follow'][$key]['members'] = count($query_res);
}

function convert_into_base64($path)
{
    $type = pathinfo($path, PATHINFO_EXTENSION); #Get product image type
    $data = file_get_contents($path); #Get the product image
    $imageBase64 = "data:image/$type;base64," . base64_encode($data); #Convert product image to base64

    echo "$imageBase64";
}

if (not_empty($_GET['community_id'])) {
    $db = $db->where('community_id', $_GET['community_id']);
    $result = $db->getOne(T_COMMUNITY_SETTINGS);
    if (not_empty($result)) {
        $cl['menu_links'] = json($result['menu_links']);
        $cl['post_flairs']  = json($result['post_flairs']);
        $cl['display_set'] = json($result['display_settings']);
        $cl['textarea_widget'] = json($result['textarea_widget']);
        $cl['image_widget'] = json($result['image_widget']);
        $temp = json($result['community_list_widget']);
        if (not_empty($temp)) :
            $array = array();
            foreach ($temp as $item) :
                $db = $db->where('community_id', $item['community_id']);
                $result = $db->getone(T_COMMUNITY);
                $array[] = $result;
            endforeach;
            $array[0]['widgetTitle'] =  $temp[0]['widgetTitle'];
            $cl['community_list_widget'] = $array;
        endif;
    }

    $db = $db->where('community_id', $_GET['community_id']);
    $result = $db->getOne(T_COMMUNITY);
    if (not_empty($result)) {
        // global $community;
        $community = $result;
        $db = $db->where('id', $community['moderator']);
        $result = $db->getone(T_USERS);
        $community['moderator_name'] = $result['username'];
    }
}
$cl['following_people'] = array();
$db = $db->where('user_id', $cl['me']['id']);
$db = $db->where('people_id', $me['id']);
$result = $db->getone(T_PEOPLE_FOLLOWING);
$cl['following_people'] = $result;
$cl['community_id'] = $_GET['community_id'];