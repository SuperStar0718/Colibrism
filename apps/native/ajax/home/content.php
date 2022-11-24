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
} else if ($action == 'load_more') {

    require_once(cl_full_path("core/apps/home/app_ctrl.php"));

    $data['err_code'] = 0;
    $data['status']   = 400;
    $offset           = fetch_or_get($_GET['offset'], 0);
    $html_arr         = array();

    if (is_posnum($offset)) {

        $posts_ls = cl_get_timeline_feed(15, $offset);

        if (not_empty($posts_ls)) {
            foreach ($posts_ls as $cl['li']) {
                $html_arr[] = cl_template('timeline/post');
            }

            $data['status'] = 200;
            $data['html']   = implode("", $html_arr);
        }
    }
} else if ($action == 'update_timeline') {

    require_once(cl_full_path("core/apps/home/app_ctrl.php"));

    $data['err_code'] = 0;
    $data['status']   = 400;
    $onset            = fetch_or_get($_GET['onset'], 0);
    $html_arr         = array();

    if (is_posnum($onset)) {

        $posts_ls = cl_get_timeline_feed(false, false, $onset);

        if (not_empty($posts_ls)) {
            foreach ($posts_ls as $cl['li']) {
                $html_arr[] = cl_template('timeline/post');
            }

            $data['status'] = 200;
            $data['html']   = implode("", $html_arr);
        }
    }
} else if ($action == 'upload_image') {
    $data['err_code'] =  0;
    $data['status']   =  400;
    $post_description = fetch_or_get($_POST['post_description'], "");
    $_SESSION['post_description'] = $post_description;
    if (not_empty($_FILES['image']) && not_empty($_FILES['image']['tmp_name']) && $_POST['submit'] == 'preview') {
        $file_info      = array(
            'file'      => $_FILES['image']['tmp_name'],
            'size'      => $_FILES['image']['size'],
            'name'      => $_FILES['image']['name'],
            'type'      => $_FILES['image']['type'],
            'file_type' => 'image',
            'folder'    => 'images',
            'slug'      => 'original',
            'allowed'   => 'jpg,png,jpeg,gif'
        );

        $file_upload = cl_upload($file_info);

        if (not_empty($file_upload['filename'])) {
            $data['status'] = 200;
        }

        $_SESSION['image_path'] = $file_upload['filename'];;

        //return cl_redirect('home');
    } else if ($_POST['submit'] == "tweet") {

        $data['err_code'] = 0;
        $data['status']   = 400;
        // $data['err_code']=$_POST['option_1'];
        // $data['status']=$_POST['option_2'];
        $max_post_length  = $cl["config"]["max_post_len"];
        $post_data        = $me['draft_post'];
        $curr_pn          = fetch_or_get($_POST['curr_pn'], "none");
        $post_text        = fetch_or_get($_POST['post_text'], "");
        $post_description = fetch_or_get($_POST['post_description'], "");
        $community_id = fetch_or_get($_POST['community_id'], "");
        $gif_src          = fetch_or_get($_POST['gif_src'], "");
        $og_data          = fetch_or_get($_POST['og_data'], array());
        $thread_id        = fetch_or_get($_POST['thread_id'], 0);
        $post_privacy     = fetch_or_get($_POST['privacy'], "everyone");
        $post_text        = cl_croptxt($post_text, $max_post_length);
        $thread_data      = array();
        $poll_data = array();
        $poll_data[] = fetch_or_get($_SESSION['subject'], "");
        for ($i = 1; $i < 6; $i++) {
            if ($_SESSION['answer-' . $i] == "") continue;
            $poll_data[] = $_SESSION['answer-' . $i];
        }

        $image_src = "";
        if (not_empty($_FILES['image']) && not_empty($_FILES['image']['tmp_name'])) {
            $file_info      = array(
                'file'      => $_FILES['image']['tmp_name'],
                'size'      => $_FILES['image']['size'],
                'name'      => $_FILES['image']['name'],
                'type'      => $_FILES['image']['type'],
                'file_type' => 'image',
                'folder'    => 'images',
                'slug'      => 'original',
                'allowed'   => 'jpg,png,jpeg,gif'
            );

            $file_upload = cl_upload($file_info);

            if (not_empty($file_upload['filename'])) {
                $data['status'] = 200;
            }
            $image_src = $file_upload['filename'];
        } else if (not_empty($_SESSION['image_path']))
            $image_src = $_SESSION['image_path'];

        global $cl;
        if (not_empty($post_description)) {
            $thread_id      = ((is_posnum($thread_id)) ? $thread_id : 0);
            $post_text      = cl_upsert_htags($post_text);
            $mentions       = cl_get_user_mentions($post_text);
            $vote = array();
            $vote_json = json_encode($vote);
            $insert_data    = array(
                "user_id"   => $me['id'],
                "text"      => cl_text_secure($post_text),
                "description" => cl_text_secure($post_description),
                "status"    => "inactive",
                "type"      => "text",
                "thread_id" => $thread_id,
                "time"      => time(),
                "priv_wcs"  => $me["profile_privacy"],
                "priv_wcr"  => $post_privacy,
                "image" => $image_src,
                "community_id" => $community_id,
                "upvote_count" => $vote_json,
                "downvote_count" => $vote_json
            );


            if ($poll_data[0] != "") {
                $insert_data['og_data']   = "";
                $gif_src                  = "";
                $insert_data['type']      = "poll";
                $insert_data['poll_data'] = array_map(function ($option) {
                    return array(
                        "option" => cl_text_secure($option),
                        "voters" => array(),
                        "votes"  => 0
                    );
                }, $poll_data);

                $insert_data['poll_data'] = json($insert_data['poll_data'], true);
            }


            $post_id = cl_db_insert(T_PUBS, $insert_data);


            cl_db_insert(T_POSTS, array(
                "user_id" => $me['id'],
                "publication_id" => $post_id,
                "time" => time(),
                "community_id" => $community_id,
            ));


            $data['posts_total'] = ($me['posts'] += 1);

            cl_update_user_data($me['id'], array(
                'posts' => $data['posts_total']
            ));
        }








        cl_delete_orphan_posts($me['id']);
        cl_update_user_data($me['id'], array(
            'last_post' => 0
        ));
        $_SESSION['image_path'] = "";
        $_SESSION['poll_data'] = "";
        $_SESSION['answer-1'] = "";
        $_SESSION['answer-2'] = "";
        $_SESSION['answer-3'] = "";
        $_SESSION['answer-4'] = "";
        $_SESSION['answer-5'] = "";
        $_SESSION['subject'] = "";
        $_SESSION['post_description'] = '';
        return cl_redirect('home');
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'exit_post') {
    $_SESSION['image_path'] = "";
    $_SESSION['poll_data'] = "";
    $_SESSION['answer-1'] = "";
    $_SESSION['answer-2'] = "";
    $_SESSION['answer-3'] = "";
    $_SESSION['answer-4'] = "";
    $_SESSION['answer-5'] = "";
    $_SESSION['subject'] = "";
    $_SESSION['post_description'] = '';
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'exit_poll') {
    $_SESSION['poll_data'] = "true";
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'create_poll') {
    $_SESSION['poll_data'] = "true";

    if ($_POST['submit'] == 'poll') {
        $poll_data = array();
        $poll_data[0] = $_POST['answer-1'];
        $poll_data[1] = $_POST['answer-2'];
        $poll_data[2] = $_POST['answer-3'];
        $poll_data[3] = $_POST['answer-4'];
        $poll_data[4] = $_POST['answer-5'];
        $poll_data[5] = $_POST['subject'];
        $_SESSION['answer-1'] = $poll_data[0];
        $_SESSION['answer-2'] = $poll_data[1];
        $_SESSION['answer-3'] = $poll_data[2];
        $_SESSION['answer-4'] = $poll_data[3];
        $_SESSION['answer-5'] = $poll_data[4];
        $_SESSION['subject'] = $poll_data[5];
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}