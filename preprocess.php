<?php
global $cl, $db, $me;
$sql = "SELECT * FROM cl_community WHERE community_id IN(SELECT community_id FROM cl_community_following WHERE follow_user_id=" . $me['id'] . ")";
$query_res = $db->rawQuery($sql);
cl_queryset($query_res);
$cl['communities_followed'] = $query_res;

$sql = "SELECT * FROM cl_community WHERE community_id NOT IN(SELECT community_id FROM cl_community_following WHERE follow_user_id=" . $me['id'] . ")";
// $sql = "SELECT * FROM cl_community ";
$query_res = $db->rawQuery($sql);
cl_queryset($query_res);
$cl['communities_can_follow'] = $query_res;

$sql = "select * from cl_users";
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