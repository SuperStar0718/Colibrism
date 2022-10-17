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

if ($action == 'upload_post_image') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = "invalid_req_data";
        $data['status']   = 400;
        $post_data        = $me['draft_post'];

        if (not_empty($_FILES['image']) && not_empty($_FILES['image']['tmp_name'])) {
            if (empty($post_data)) {
                $post_id   = cl_create_orphan_post($me['id'], "image");
                $post_data = cl_get_orphan_post($post_id);

                cl_update_user_data($me['id'], array(
                    'last_post' => $post_id
                ));
            }

            if (not_empty($post_data) && $post_data["type"] == "image") {
                if (empty($post_data['media']) || count($post_data['media']) < 10) {
                    $file_info      =  array(
                        'file'      => $_FILES['image']['tmp_name'],
                        'size'      => $_FILES['image']['size'],
                        'name'      => $_FILES['image']['name'],
                        'type'      => $_FILES['image']['type'],
                        'file_type' => 'image',
                        'folder'    => 'images',
                        'slug'      => 'original',
                        'crop'      => array('width' => 300, 'height' => 300),
                        'allowed'   => 'jpg,png,jpeg,gif,webp'
                    );


                    $file_upload = cl_upload($file_info);

                    if (not_empty($file_upload['filename'])) {
                        $post_id     =  $post_data['id'];
                        $img_id      =  $db->insert(T_PUBMEDIA, array(
                            "pub_id" => $post_id,
                            "type"   => "image",
                            "src"    => $file_upload['filename'],
                            "time"   => time(),
                            "json_data" => json(array(
                                "image_thumb" => $file_upload['cropped']
                            ), true)
                        ));

                        if (is_posnum($img_id)) {
                            $data['img']     = array("id" => $img_id, "url" => cl_get_media($file_upload['cropped']));
                            $data['status']  = 200;
                        }
                    }
                } else {
                    $data['err_code'] = "total_limit_exceeded";
                    $data['status']   = 400;
                }
            } else {
                cl_delete_orphan_posts($me['id']);
                cl_update_user_data($me['id'], array(
                    'last_post' => 0
                ));
            }
        }
    }
} else if ($action == 'upload_post_video') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = "invalid_req_data";
        $data['status']   = 400;
        $post_data        = $me['draft_post'];

        if (not_empty($_FILES['video']) && not_empty($_FILES['video']['tmp_name'])) {
            if (empty($post_data)) {
                $post_id   = cl_create_orphan_post($me['id'], "video");
                $post_data = cl_get_orphan_post($post_id);

                cl_update_user_data($me['id'], array(
                    'last_post' => $post_id
                ));
            }

            if (not_empty($post_data) && $post_data["type"] == "video") {
                if (empty($post_data['media'])) {
                    $file_info           = array(
                        'file'           => $_FILES['video']['tmp_name'],
                        'size'           => $_FILES['video']['size'],
                        'name'           => $_FILES['video']['name'],
                        'type'           => $_FILES['video']['type'],
                        'file_type'      => 'video',
                        'folder'         => 'videos',
                        'slug'           => 'original',
                        'allowed'        => 'mp4,mov,3gp,webm',
                        'aws_uploadfile' => "N"
                    );

                    $file_upload = cl_upload($file_info);
                    $upload_fail = false;
                    $post_id     = $post_data['id'];

                    if (not_empty($file_upload['filename'])) {
                        try {
                            require_once(cl_full_path("core/libs/ffmpeg-php/vendor/autoload.php"));
                            require_once(cl_full_path("core/libs/getID3/getid3/getid3.php"));

                            $ffmpeg_binary       = ($config['ffmpeg_binary'] == "/core/libs/ffmpeg/ffmpeg") ? cl_full_path($config['ffmpeg_binary']) : $config['ffmpeg_binary'];
                            $ffmpeg              = new FFmpeg($ffmpeg_binary);
                            $getID3              = new getID3;
                            $getID3_FAR          = $getID3->analyze($file_upload['filename']);
                            $poster_frame_offset = 3;
                            $thumb_path          = cl_gen_path(array(
                                "folder"         => "images",
                                "file_ext"       => "jpeg",
                                "file_type"      => "image",
                                "slug"           => "poster",
                            ));

                            if (not_empty($getID3_FAR) && isset($getID3_FAR["playtime_seconds"])) {
                                if ($getID3_FAR["playtime_seconds"] < 3) {
                                    $poster_frame_offset = 1;
                                }
                            }

                            $ffmpeg->input($file_upload['filename']);
                            $ffmpeg->set('-ss', $poster_frame_offset);
                            $ffmpeg->set('-vframes', '1');
                            $ffmpeg->set('-f', 'mjpeg');
                            $ffmpeg->output($thumb_path)->ready();
                        } catch (Exception $e) {
                            $data["error"] = $e->getMessage();
                            $upload_fail   = true;
                        }

                        if (empty($upload_fail)) {

                            if (file_exists($thumb_path) != true) {
                                $thumb_path = "upload/default/video.png";
                            }

                            $img_id      = $db->insert(T_PUBMEDIA, array(
                                "pub_id" => $post_id,
                                "type"   => "video",
                                "src"    => $file_upload['filename'],
                                "time"   => time(),
                                "json_data" => json(array(
                                    "poster_thumb" => $thumb_path
                                ), true)
                            ));

                            if (is_posnum($img_id)) {
                                $data['status'] =  200;
                                $data['video']  =  array(
                                    "source"    => cl_get_media($file_upload['filename']),
                                    "poster"    => cl_get_media($thumb_path)
                                );

                                if ($cl['config']['as3_storage'] == 'on') {
                                    cl_upload2s3($file_upload['filename']);

                                    cl_upload2s3($thumb_path);
                                }
                            }
                        }
                    } else if (not_empty($file_upload['error'])) {
                        $data["error"] = $file_upload['error'];
                    }
                } else {
                    $data['err_code'] = "total_limit_exceeded";
                    $data['status']   = 400;
                }
            } else {
                cl_delete_orphan_posts($me['id']);
                cl_update_user_data($me['id'], array(
                    'last_post' => 0
                ));
            }
        }
    }
} else if ($action == 'upload_post_arecord') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = "invalid_req_data";
        $data['status']   = 400;
        $post_data        = $me['draft_post'];

        if (not_empty($_FILES['audio_file']) && not_empty($_FILES['audio_file']['tmp_name'])) {
            if (empty($post_data)) {
                $post_id   = cl_create_orphan_post($me['id'], "audio");
                $post_data = cl_get_orphan_post($post_id);

                cl_update_user_data($me['id'], array(
                    'last_post' => $post_id
                ));
            }

            if (not_empty($post_data) && $post_data["type"] == "audio") {
                if (empty($post_data['media'])) {
                    $file_info      =  array(
                        'file'      => $_FILES['audio_file']['tmp_name'],
                        'size'      => $_FILES['audio_file']['size'],
                        'name'      => $_FILES['audio_file']['name'],
                        'type'      => $_FILES['audio_file']['type'],
                        'file_type' => 'audio',
                        'folder'    => 'audios',
                        'slug'      => 'original',
                        'allowed'   => 'mp3,wav'
                    );

                    $file_upload = cl_upload($file_info);
                    $upload_fail = false;
                    $post_id     = $post_data['id'];

                    if (not_empty($file_upload['filename'])) {
                        $img_id      = $db->insert(T_PUBMEDIA, array(
                            "pub_id" => $post_id,
                            "type"   => "audio",
                            "src"    => $file_upload['filename'],
                            "time"   => time(),
                            "json_data" => json(array(), true)
                        ));

                        if (is_posnum($img_id)) {
                            $data['err_code'] = 0;
                            $data['status']   = 200;
                            $data['audio']    = array(
                                "source"      => cl_get_media($file_upload['filename'])
                            );
                        }
                    } else if (not_empty($file_upload['error'])) {
                        $data["error"] = $file_upload['error'];
                    }
                } else {
                    $data['err_code'] = "total_limit_exceeded";
                    $data['status']   = 400;
                }
            } else {
                cl_delete_orphan_posts($me['id']);
                cl_update_user_data($me['id'], array(
                    'last_post' => 0
                ));
            }
        }
    }
} else if ($action == 'delete_post_image') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = "invalid_req_data";
        $data['status']   = 400;
        $image_id         = fetch_or_get($_POST['image_id'], 0);
        $post_data        = $me['draft_post'];

        if (not_empty($post_data) && is_posnum($image_id)) {
            $post_id    = $post_data['id'];
            $db         = $db->where('id', $image_id);
            $db         = $db->where('pub_id', $post_id);
            $image_data = $db->getOne(T_PUBMEDIA);

            if (cl_queryset($image_data)) {
                $json_data        = json($image_data['json_data']);
                $data['status']   = 200;
                $data['err_code'] = 0;
                $db               = $db->where('id', $image_id)->where('pub_id', $post_id);
                $qr               = $db->delete(T_PUBMEDIA);

                if (in_array($image_data['type'], array('image', 'video'))) {
                    cl_delete_media($image_data['src']);

                    if (not_empty($json_data['image_thumb'])) {
                        cl_delete_media($json_data['image_thumb']);
                    }
                }
            }

            if (count($post_data['media']) < 2) {
                cl_delete_orphan_posts($me['id']);
                cl_update_user_data($me['id'], array(
                    'last_post' => 0
                ));
            }
        }
    }
} else if ($action == 'delete_post_video') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = "invalid_req_data";
        $data['status']   = 400;
        $post_data        = $me['draft_post'];

        if (not_empty($post_data)) {

            $data['err_code'] = "0";
            $data['status']   = 200;

            cl_delete_orphan_posts($me['id']);
            cl_update_user_data($me['id'], array(
                'last_post' => 0
            ));
        }
    }
} else if ($action == 'delete_post_arecord') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = "invalid_req_data";
        $data['status']   = 400;
        $post_data        = $me['draft_post'];

        if (not_empty($post_data)) {

            $data['err_code'] = "0";
            $data['status']   = 200;

            cl_delete_orphan_posts($me['id']);
            cl_update_user_data($me['id'], array(
                'last_post' => 0
            ));
        }
    }
} else if ($action == 'import_og_data') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = "invalid_req_data";
        $data['status']   = 400;

        if (empty($_POST['url']) || is_url($_POST['url'])) {
            $post_data = $me['draft_post'];
            $og_url    = fetch_or_get($_POST['url'], "");

            try {
                require_once(cl_full_path("core/libs/htmlParser/simple_html_dom.php"));

                $og_data_object = file_get_html($og_url);

                if ($og_data_object) {
                    $og_data_values = array(
                        "title" => "",
                        "description" => "",
                        "image" => "",
                        "site_name" => "",
                        "type" => ""
                    );

                    if ($og_data_object->find('title', 0)) {
                        $og_data_values["title"] = $og_data_object->find('title', 0)->plaintext;
                    }

                    if ($og_data_object->find("meta[name='og:title']", 0)) {
                        $og_data_values["title"] = $og_data_object->find("meta[name='og:title']", 0)->content;
                    }

                    if ($og_data_object->find("meta[name='description']", 0)) {
                        $og_data_values["description"] = $og_data_object->find("meta[name='description']", 0)->content;
                    } else if ($og_data_object->find("meta[property='og:description']", 0)) {
                        $og_data_values["description"] = $og_data_object->find("meta[property='og:description']", 0)->content;
                    }

                    if ($og_data_object->find("meta[property='og:image']", 0)) {
                        $og_data_values["image"] = $og_data_object->find("meta[property='og:image']", 0)->content;
                    }

                    if ($og_data_object->find("meta[property='og:type']", 0)) {
                        $og_data_values["type"] = $og_data_object->find("meta[property='og:type']", 0)->content;
                    }

                    if ($og_data_object->find("meta[property='og:site_name']", 0)) {
                        $og_data_values["site_name"] = $og_data_object->find("meta[property='og:site_name']", 0)->content;
                    }

                    $og_data_values   = array(
                        'title'       => cl_croptxt($og_data_values["title"], 160, '..'),
                        'description' => cl_croptxt($og_data_values["description"], 300, '..'),
                        'image'       => $og_data_values["image"],
                        'type'        => $og_data_values["type"],
                        'url'         => $og_url
                    );

                    if (not_empty($og_data_values['title'])) {
                        $data['status']  = 200;
                        $data['og_data'] = $og_data_values;
                    }
                }
            } catch (Exception $e) {
                /*pass*/
            }
        }
    }
} else if ($action == 'publish_new_post') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = 0;
        $data['status']   = 400;
        // $data['err_code']=$_POST['option_1'];
        // $data['status']=$_POST['option_2'];
        $max_post_length  = $cl["config"]["max_post_len"];
        $post_data        = $me['draft_post'];
        $curr_pn          = fetch_or_get($_POST['curr_pn'], "none");
        $post_text        = fetch_or_get($_POST['post_text'], "");
        $post_description = fetch_or_get($_POST['post_description'], "");
        $gif_src          = fetch_or_get($_POST['gif_src'], "");
        $og_data          = fetch_or_get($_POST['og_data'], array());
        $poll_data        = fetch_or_get($_POST['poll_data'], array());
        $thread_id        = fetch_or_get($_POST['thread_id'], 0);
        $post_privacy     = fetch_or_get($_POST['privacy'], "everyone");
        $post_text        = cl_croptxt($post_text, $max_post_length);
        $thread_data      = array();
        $poll_data = array();
        $poll_data[0] = $_POST['option_1'];
        $poll_data[1] = $_POST['option_2'];
        $poll_data[2] = $_POST['option_3'];
        $image_src = $_FILES['image']['tmp_name'];

        if (not_empty($thread_id)) {
            $thread_data  = cl_raw_post_data($thread_id);
            $post_privacy = "everyone";

            if (empty($thread_data) || cl_can_reply($thread_data) != true) {
                $thread_id   = 0;
                $thread_data = array();
            }
        } else {
            if (in_array($post_privacy, array("everyone", "followers", "mentioned")) != true) {
                $post_privacy = "everyone";
            }
        }

        if (not_empty($post_data) && not_empty($post_data["media"])) {
            $data['status'] = 200;
            $thread_id      = ((is_posnum($thread_id)) ? $thread_id : 0);
            $post_id        = $post_data['id'];
            $post_text      = cl_upsert_htags($post_text);
            $mentions       = cl_get_user_mentions($post_text);
            $qr             = cl_update_post_data($post_id, array(
                "text"      => cl_text_secure($post_text),
                "status"    => "active",
                "thread_id" => $thread_id,
                "time"      => time(),
                "priv_wcs"  => $me["profile_privacy"],
                "priv_wcr"  => $post_privacy
            ));

            if (empty($thread_id)) {
                cl_db_insert(T_POSTS, array(
                    "user_id"        => $me['id'],
                    "publication_id" => $post_id,
                    "time"           => time(),
                    // "community_id" => 12,
                ));

                $data['posts_total'] = ($me['posts'] += 1);

                cl_update_user_data($me['id'], array(
                    'posts' => $data['posts_total']
                ));
            } else {
                $data['replys_total'] = cl_update_thread_replys($thread_id, 'plus');

                cl_update_post_data($post_id, array(
                    "target" => "pub_reply"
                ));

                if ($thread_data['user_id'] != $me['id']) {
                    cl_notify_user(array(
                        'subject'  => 'reply',
                        'user_id'  => $thread_data['user_id'],
                        'entry_id' => $post_id
                    ));
                }
            }

            if (in_array($curr_pn, array('home', 'thread'))) {
                $post_data    = cl_raw_post_data($post_id);
                $cl['li']     = cl_post_data($post_data);
                $data['html'] = cl_template('timeline/post');
            }

            if (not_empty($mentions)) {
                cl_notify_mentioned_users($mentions, $post_id);
            }

            cl_delete_post_junk_files($post_data['id'], $post_data['type']);
        } else {
            if (not_empty($post_text) || not_empty($gif_src) || not_empty($og_data) || not_empty($poll_data)) {
                $thread_id      = ((is_posnum($thread_id)) ? $thread_id : 0);
                $post_text      = cl_upsert_htags($post_text);
                $mentions       = cl_get_user_mentions($post_text);
                $insert_data    = array(
                    "user_id"   => $me['id'],
                    "text"      => cl_text_secure($post_text),
                    "description" => cl_text_secure($post_description),
                    "status"    => "active",
                    "type"      => "text",
                    "thread_id" => $thread_id,
                    "time"      => time(),
                    "priv_wcs"  => $me["profile_privacy"],
                    "priv_wcr"  => $post_privacy,
                    "image" => $image_src,
                    "community_id" => $me['community_id'],

                );
                foreach ($poll_data as $key => $value) {
                    # code...
                    echo $value . "<br>";
                }

                if (not_empty($post_text) && $poll_data[0] != "") {
                    $insert_data['og_data']   = "";
                    $gif_src                  = "";
                    $insert_data['type']      = "poll";
                    echo "hello";
                    $insert_data['poll_data'] = array_map(function ($option) {
                        return array(
                            "option" => cl_text_secure($option),
                            "voters" => array(),
                            "votes"  => 0
                        );
                    }, $poll_data);

                    $insert_data['poll_data'] = json($insert_data['poll_data'], true);
                }

                // else if (not_empty($gif_src) && is_url($gif_src)) {
                //     $insert_data['og_data'] = "";
                //     $insert_data['type']    = "gif";
                // }

                // else if(not_empty($og_data) && cl_is_valid_og($og_data)) {
                //     if (not_empty($og_data["image"]) && is_url($og_data["image"])) {
                //         $og_data["image"] = cl_import_image(array(
                //             'url' => $og_data["image"],
                //             'file_type' => 'thumbnail',
                //             'folder' => 'images',
                //             'slug' => 'og_img'
                //         ));

                //         if (empty($og_data["image"])) {
                //             $og_data["image"] = "";
                //         }
                //         else{
                //             $og_data["image_loc"] = true;
                //         }

                //         $insert_data['og_data'] = json($og_data, true);
                //         $gif_src = "";
                //     }
                //     else{
                //         $insert_data['og_data'] = json(array(), true);
                //         $gif_src = "";
                //     }
                // }

                $post_id = cl_db_insert(T_PUBS, $insert_data);

                if (is_posnum($post_id)) {

                    $data['status'] = 200;

                    if (empty($thread_id)) {
                        cl_db_insert(T_POSTS, array(
                            "user_id" => $me['id'],
                            "publication_id" => $post_id,
                            "time" => time(),
                            "community_id" => $me['community_id'],

                        ));


                        $data['posts_total'] = ($me['posts'] += 1);

                        cl_update_user_data($me['id'], array(
                            'posts' => $data['posts_total']
                        ));
                    } else {
                        $data['replys_total'] = cl_update_thread_replys($thread_id, 'plus');

                        cl_update_post_data($post_id, array(
                            "target" => "pub_reply"
                        ));

                        if ($thread_data['user_id'] != $me['id']) {
                            cl_notify_user(array(
                                'subject'  => 'reply',
                                'user_id'  => $thread_data['user_id'],
                                'entry_id' => $post_id
                            ));
                        }
                    }

                    if ($insert_data["type"] == "gif") {
                        cl_db_insert(T_PUBMEDIA, array(
                            "pub_id" => $post_id,
                            "type"   => "gif",
                            "src"    => $gif_src,
                            "time"   => time(),
                        ));
                    }

                    if (in_array($curr_pn, array('home', 'thread'))) {
                        $post_data    = cl_raw_post_data($post_id);
                        $cl['li']     = cl_post_data($post_data);
                        $data['html'] = cl_template('timeline/post');
                    }

                    if (not_empty($mentions)) {
                        cl_notify_mentioned_users($mentions, $post_id);
                    }
                }
            }
        }

        cl_delete_orphan_posts($me['id']);
        cl_update_user_data($me['id'], array(
            'last_post' => 0
        ));
    }
    $temp = $me['community_id'];
    cl_redirect("community?community_id=$temp");
} else if ($action == 'get_draft_post') {
    $data['status']   = 404;
    $data['err_code'] = 0;
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        if (not_empty($me['draft_post'])) {
            if ($me['draft_post']['type'] == "image") {
                if (not_empty($me['draft_post']['media'])) {
                    $data['images'] = array();
                    $data['status'] = 200;
                    $data['type']   = "image";

                    foreach ($me['draft_post']['media'] as $row) {
                        $data['images'][] = array(
                            "id" => $row["id"],
                            "url" => cl_get_media($row["src"]),
                        );
                    }
                }
            } else if ($me['draft_post']['type'] == "video") {

                $video_src = fetch_or_get($me['draft_post']['media'][0], false);

                if (not_empty($video_src)) {
                    $data['status'] = 200;
                    $data['type']   = "video";
                    $data['video']  = array(
                        "poster"    => cl_get_media($video_src['x']['poster_thumb']),
                        "source"    => cl_get_media($video_src['src'])
                    );
                }
            } else if ($me['draft_post']['type'] == "audio") {

                $video_src = fetch_or_get($me['draft_post']['media'][0], false);

                if (not_empty($video_src)) {
                    $data['status'] = 200;
                    $data['type']   = "audio";
                    $data['audio']  = array(
                        "source"    => cl_get_media($video_src['src'])
                    );
                }
            }
        }
    }
} else if ($action == 'join') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['status']   = 404;
        $data['err_code'] = 0;
        $community_id          = fetch_or_get($_POST['community_id'], 0);

        if (cl_is_following($me['id'], $community_id)) {
            $data['status'] = 200;
            cl_unfollow($me['id'], $community_id);
        }
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'follow') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['status']   = 404;
        $data['err_code'] = 0;
        $community_id          = fetch_or_get($_POST['community_id'], 0);
        if (!cl_is_following($me['id'], $community_id)) {
            $data['status'] = 200;
            cl_follow($me['id'], $community_id);
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
        if (!cl_is_following_people($me['id'], $user_id)) {
            $data['status'] = 200;
            cl_follow_people($me['id'], $user_id);
        }
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
} else if ($action == 'delete_post') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = 0;
        $data['status']   = 400;
        $post_id          = fetch_or_get($_POST['id'], 0);

        if (is_posnum($post_id)) {
            $post_data = cl_raw_post_data($post_id);

            if (not_empty($post_data) && ($post_data['user_id'] == $me['id'] || not_empty($cl["is_admin"]))) {

                $post_owner = cl_raw_user_data($post_data['user_id']);

                if (not_empty($post_owner)) {
                    if ($post_data['target'] == 'publication') {

                        $data['posts_total'] = ($post_owner['posts'] -= 1);
                        $data['posts_total'] = ((is_posnum($data['posts_total'])) ? $data['posts_total'] : 0);

                        cl_update_user_data($post_data['user_id'], array(
                            'posts' => $data['posts_total']
                        ));

                        $db = $db->where('publication_id', $post_id);
                        $qr = $db->delete(T_POSTS);
                    } else {
                        $data['url'] = cl_link(cl_strf("thread/%d", $post_data['thread_id']));

                        cl_update_thread_replys($post_data['thread_id'], 'minus');
                    }

                    cl_recursive_delete_post($post_id);

                    $data['status'] = 200;
                }
            }
        }
    }
} else if ($action == 'load_likes') {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $post_id          = fetch_or_get($_GET['id'], 0);
    $offset           = fetch_or_get($_GET['offset'], 0);

    if (is_posnum($post_id) && is_posnum($offset)) {
        $cl['post_likes'] = cl_get_post_likes($post_id, 30, $offset);
        $html_arr         = array();

        if (not_empty($cl['post_likes'])) {
            foreach ($cl['post_likes'] as $cl['li']) {
                $html_arr[] = cl_template('timeline/includes/like_li');
            }

            $data['status'] = 200;
            $data['html']   = implode('', $html_arr);
        }
    }
} else if ($action == 'bookmark_post') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = 0;
        $data['status']   = 400;
        $post_id          = fetch_or_get($_POST['id'], 0);
        $a                = fetch_or_get($_POST['a'], 'none');

        if (is_posnum($post_id)) {
            $post_data = cl_raw_post_data($post_id);

            if (not_empty($post_data)) {
                if (cl_has_saved($me['id'], $post_id) != true) {
                    $db->insert(T_BOOKMARKS, array(
                        'publication_id' => $post_id,
                        'user_id'        => $me['id'],
                        'time'           => time()
                    ));

                    $data['status']      = 200;
                    $data['status_code'] = '1';
                } else {
                    $db                  = $db->where('publication_id', $post_id);
                    $db                  = $db->where('user_id', $me['id']);
                    $qr                  = $db->delete(T_BOOKMARKS);
                    $data['status']      = 200;
                    $data['status_code'] = '0';
                }
            }
        }
    }
} else if ($action == 'repost') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = 0;
        $data['status']   = 400;
        $post_id          = fetch_or_get($_POST['id'], 0);

        if (is_posnum($post_id)) {
            $post_data = cl_raw_post_data($post_id);

            if (not_empty($post_data)) {
                if (cl_has_reposted($me['id'], $post_id) != true) {
                    $db->insert(T_POSTS, array(
                        'publication_id'  => $post_id,
                        'user_id'         => $me['id'],
                        'type'            => 'repost',
                        'time'            => time()
                    ));

                    $reposts_count         = ($post_data['reposts_count'] += 1);
                    $data['status']        = 200;
                    $data['reposts_count'] = $reposts_count;

                    cl_update_post_data($post_id, array(
                        'reposts_count' => $reposts_count
                    ));

                    if ($post_data['user_id'] != $me['id']) {
                        cl_notify_user(array(
                            'subject'  => 'repost',
                            'user_id'  => $post_data['user_id'],
                            'entry_id' => $post_id
                        ));
                    }
                } else {
                    $db     = $db->where('publication_id', $post_id);
                    $db     = $db->where('user_id', $me['id']);
                    $db     = $db->where('type', 'repost');
                    $repost = $db->getOne(T_POSTS);

                    if (cl_queryset($repost)) {
                        $db                    = $db->where('publication_id', $post_id);
                        $db                    = $db->where('user_id', $me['id']);
                        $db                    = $db->where('type', 'repost');
                        $qr                    = $db->delete(T_POSTS);
                        $data['status']        = 200;
                        $data['repost_id']     = $repost['id'];
                        $reposts_count         = ($post_data['reposts_count'] -= 1);
                        $data['reposts_count'] = $reposts_count;

                        cl_update_post_data($post_id, array(
                            'reposts_count' => $reposts_count
                        ));

                        $db = $db->where('notifier_id', $me['id']);
                        $db = $db->where('recipient_id', $post_data['user_id']);
                        $db = $db->where('subject', 'repost');
                        $db = $db->where('entry_id', $post_id);
                        $rq = $db->delete(T_NOTIFS);
                    }
                }
            }
        }
    }
} else if ($action == 'update_msb_indicators') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['status']        = 200;
        $data['notifications'] = cl_total_new_notifs();
        $data['messages']      = cl_total_new_messages();
    }
} else if ($action == 'search') {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $search_query     = fetch_or_get($_GET['query'], false);
    $type             = fetch_or_get($_GET['type'], false);

    if (not_empty($search_query) && len_between($search_query, 3, 32) && in_array($type, array('users', 'htags'))) {
        require_once(cl_full_path("core/apps/search/app_ctrl.php"));

        if ($type == "htags") {
            $search_query = cl_text_secure($search_query);
            $search_query = cl_croptxt($search_query, 32);
            $query_result = cl_search_hashtags($search_query, false, 150);
            $html_arr     = array();

            if (not_empty($query_result)) {
                foreach ($query_result as $cl['li']) {
                    $html_arr[] = cl_template('main/includes/search/htags_li');
                }

                $data['status'] = 200;
                $data['html']   = implode("", $html_arr);
            }
        } else {
            $search_query = cl_text_secure($search_query);
            $search_query = cl_croptxt($search_query, 32);
            $query_result = cl_search_people($search_query, false, 150);
            $html_arr     = array();

            if (not_empty($query_result)) {
                foreach ($query_result as $cl['li']) {
                    $html_arr[] = cl_template('main/includes/search/users_li');
                }

                $data['status'] = 200;
                $data['html']   = implode("", $html_arr);
            }
        }
    }
} else if ($action == 'report_profile') {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $report_reason    = fetch_or_get($_POST['reason'], false);
    $profile_id       = fetch_or_get($_POST['profile_id'], false);
    $comment          = fetch_or_get($_POST['comment'], false);
    $profile_data     = cl_raw_user_data($profile_id);

    if (not_empty($profile_data) && $profile_id != $me['id'] && in_array($report_reason, array_keys($cl['profile_report_types']))) {
        $data['status']  = 200;
        $db              = $db->where('user_id', $me['id']);
        $db              = $db->where('profile_id', $profile_id);
        $qr              = $db->delete(T_PROF_REPORTS);
        $comment         = (empty($comment)) ? "" : cl_croptxt($comment, 2900);
        $qr              = $db->insert(T_PROF_REPORTS, array(
            'user_id'    => $me['id'],
            'profile_id' => $profile_id,
            'reason'     => $report_reason,
            'comment'    => $comment,
            'seen'       => '0',
            'time'       => time()
        ));
    }
} else if ($action == 'user_lbox') {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $user_id          = fetch_or_get($_GET['id'], false);
    $user_data        = cl_user_data($user_id);

    if (not_empty($user_data)) {
        $cl["lbox_usr"]                     = $user_data;
        $cl['lbox_usr']['owner']            = false;
        $cl['lbox_usr']['is_following']     = false;
        $cl['lbox_usr']['follow_requested'] = false;

        if (not_empty($cl["is_logged"])) {
            $cl['lbox_usr']['owner']            = ($user_id == $me['id']);
            $cl['lbox_usr']['is_following']     = cl_is_following($me['id'], $user_id);
            $cl['lbox_usr']['follow_requested'] = false;

            if (empty($cl['lbox_usr']['is_following'])) {
                $cl['lbox_usr']['follow_requested'] = cl_follow_requested($me['id'], $user_id);
            }
        }

        $data['status'] = 200;
        $data['html']   = cl_template("main/includes/lbox/userinfo");
    }
} else if ($action == 'block') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['status']   = 404;
        $data['err_code'] = 0;
        $user_id          = fetch_or_get($_POST['id'], 0);


        if (is_posnum($user_id) && $me['id'] != $user_id) {

            $udata = cl_raw_user_data($user_id);

            if (not_empty($udata)) {

                if (cl_is_blocked($me['id'], $user_id)) {
                    $data['status'] = 200;

                    cl_db_delete_item(T_BLOCKS, array(
                        'user_id'    => $me['id'],
                        'profile_id' => $user_id
                    ));
                } else {

                    $data['status']  = 200;
                    $insert_id       = cl_db_insert(T_BLOCKS, array(
                        'user_id'    => $me['id'],
                        'profile_id' => $user_id,
                        'time'       => time()
                    ));

                    if (cl_is_following($me['id'], $user_id)) {
                        cl_unfollow($me['id'], $user_id);
                        cl_follow_decrease($me['id'], $user_id);
                    }

                    if (cl_is_following($user_id, $me['id'])) {
                        cl_unfollow($user_id, $me['id']);
                        cl_follow_decrease($user_id, $me['id']);
                    }
                }
            }
        }
    }
} else if ($action == 'post_privacy') {
    if (empty($cl["is_logged"])) {
        $data['status'] = 400;
        $data['error']  = 'Invalid access token';
    } else {
        $data['err_code'] = 0;
        $data['status']   = 400;
        $post_id          = fetch_or_get($_POST['id'], 0);
        $priv_wcr         = fetch_or_get($_POST['priv'], 'everyone');

        if (is_posnum($post_id)) {
            $post_data = cl_raw_post_data($post_id);

            if (not_empty($post_data) && $post_data["user_id"] == $me["id"] && in_array($priv_wcr, array("everyone", "mentioned", "followers"))) {
                cl_update_post_data($post_id, array(
                    "priv_wcr" => $priv_wcr
                ));

                $data['status'] = 200;
            }
        }
    }
} else if ($action == 'vote_poll' && not_empty($cl["is_logged"])) {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $post_id          = fetch_or_get($_POST['id'], 0);
    $option           = fetch_or_get($_POST['option'], 0);

    if (is_posnum($post_id) && is_numeric($option)) {
        $post_data = cl_raw_post_data($post_id);

        if (not_empty($post_data) && $post_data["type"] == "poll") {
            $poll_data = json($post_data["poll_data"]);

            if (is_array($poll_data) && isset($poll_data[$option]) && cl_is_poll_voted($poll_data) == 0) {
                $poll_option_votes              = array_push($poll_data[$option]["voters"], $me["id"]);
                $poll_data[$option]["votes"]    = $poll_option_votes;
                $poll_votes_result              = cl_cacl_poll_votes($poll_data);

                $data["status"] = 200;
                $data["poll"]   = $poll_votes_result;
                $update_status  = cl_db_update(T_PUBS, array(
                    "id"        => $post_id
                ), array(
                    "poll_data" => cl_minify_js(json($poll_data, true))
                ));

                if ($update_status !== true) {
                    $free_poll = array_map(function ($option) {
                        return $option["voters"] = array();
                    }, $poll_data);

                    cl_db_update(T_PUBS, array(
                        "id" => $post_id
                    ), array(
                        "poll_data" => cl_minify_js(json($free_poll, true))
                    ));
                }
            }
        }
    }
} else if ($action == 'report_post') {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $report_reason    = fetch_or_get($_POST['reason'], false);
    $post_id          = fetch_or_get($_POST['post_id'], false);
    $comment          = fetch_or_get($_POST['comment'], false);
    $post_data        = cl_raw_post_data($post_id);

    if (not_empty($post_data) && in_array($report_reason, array_keys($cl['post_report_types']))) {

        cl_db_delete_item(T_PUB_REPORTS, array(
            'user_id' => $me['id'],
            'post_id' => $post_id
        ));

        $data['status'] = 200;
        $report_comment = (empty($comment)) ? "" : cl_croptxt($comment, 2900);

        cl_db_insert(T_PUB_REPORTS, array(
            'user_id' => $me['id'],
            'post_id' => $post_id,
            'reason'  => $report_reason,
            'comment' => $report_comment,
            'seen'    => '0',
            'time'    => time()
        ));
    }
} elseif ($action == "mentions_autocomp") {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $username         = fetch_or_get($_GET['username'], false);
    $username         = cl_text_secure($username);
    $username         = ltrim($username, "@");
    $username         = cl_croptxt($username, 32);
    $users_list       = cl_mention_ac_search($username);

    if (not_empty($users_list)) {
        $data["status"] = 200;
        $data["users"]  = $users_list;
    }
} elseif ($action == "hashtags_autocomp") {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $hashtag          = fetch_or_get($_GET['hashtag'], false);
    $hashtag          = cl_text_secure($hashtag);
    $hashtag          = ltrim($hashtag, "#");
    $hashtag          = cl_croptxt($hashtag, 32);
    $hashtag_list     = cl_hashtag_ac_search($hashtag);

    if (not_empty($hashtag_list)) {
        $data["status"] = 200;
        $data["tags"]   = $hashtag_list;
    }
} else if ($action == "cua") {
    setcookie("__c_u_a__", "1", strtotime("+3 years"), '/') or die('unable to create cookie');

    $data["status"] = 200;
} else if ($action == "save_display_settings") {
    $data['err_code'] = 0;
    $data['status']   = 400;

    // $bg_color   = fetch_or_get($_POST["bg"], "default");
    // $skin_color = fetch_or_get($_POST["color"], "default");
    $base = fetch_or_get($_POST["base"], "");
    $links = fetch_or_get($_POST["links"], "");
    // $title = fetch_or_get($_POST["title"], "#0000ff");
    $highlight = fetch_or_get($_POST["highlight"], "");
    $community_id = fetch_or_get($_POST["community_id"], "");

    // $main_menu = fetch_or_get($_POST["main_menu"], "#0000ff");

    // echo $base;


    // if (in_array($bg_color, array_keys($cl["bg_colors"])) && in_array($skin_color, array_keys($cl["color_schemes"]))) {
    $data['status'] = 200;

    cl_update_community_data($me["id"], $community_id, array(
        "display_settings" => json(array(
            // "color_scheme" => cl_text_secure($skin_color),
            // "background"   => cl_text_secure($bg_color),
            "base_color" => cl_text_secure($base),
            "link_color" => cl_text_secure($links),
            // "title" => cl_text_secure($title),
            "highlight_color" => cl_text_secure($highlight)
            // "main_menu" => cl_text_secure($main_menu),
        ), true)
    ));
    // }
    return cl_redirect("community?community_id=$community_id");
} else if ($action == "create_community") {
    $data['err_code'] = 0;
    $data['status']   = 400;

    $title    = fetch_or_get($_POST['title'], "");
    $name    = fetch_or_get($_POST['name'], "");
    $property    = fetch_or_get($_POST['property'], "");

    if (not_empty($title) && not_empty($name) && not_empty($property)) {
        global $db, $cl, $me;
        $user = $me['id'];
        $me['community'] = $name;
        $sql = "insert into cl_community(title, name,property,moderator) values ('$title','$name','$property','$user') ";
        $query_res = $db->rawQuery($sql);
        cl_queryset($query_res);

        $sql = "select community_id from cl_community where title='$title' and name = '$name'";
        $query_res = $db->rawQuery($sql);
        cl_queryset($query_res);
        $me['community_id'] = $query_res[0]['community_id'];

        $temp_com_id = $me['community_id'];
        $sql = "insert into cl_join_list(community_id,user_id) values ('$temp_com_id','$user') ";
        $query_res = $db->rawQuery($sql);
        cl_queryset($query_res);
        // print_r($query_res);


        return cl_redirect("community?community_id=$temp_com_id");
    } else
        return cl_redirect("create_community");
} else if ($action == "upload_community_banner_and_icon") {
    $data['err_code'] = 0;
    $data['status']   = 400;

    echo "icon" . $_FILES['icon']['name'] . "<br>";
    echo "banner" . $_FILES['banner']['name'];

    $file_info      =  array(
        'file'      => $_FILES['icon']['tmp_name'],
        'size'      => $_FILES['icon']['size'],
        'name'      => $_FILES['icon']['name'],
        'type'      => $_FILES['icon']['type'],
        'file_type' => 'image',
        'folder'    => 'images',
        'slug'      => 'original',
        'crop'      => array('width' => 300, 'height' => 300),
        'allowed'   => 'jpg,png,jpeg,gif,webp'
    );


    $file_upload = cl_upload($file_info);
    $icon = $file_upload['filename'];

    print_r($file_upload);
    $file_info      =  array(
        'file'      => $_FILES['banner']['tmp_name'],
        'size'      => $_FILES['banner']['size'],
        'name'      => $_FILES['banner']['name'],
        'type'      => $_FILES['banner']['type'],
        'file_type' => 'image',
        'folder'    => 'images',
        'slug'      => 'original',
        'crop'      => array('width' => 300, 'height' => 300),
        'allowed'   => 'jpg,png,jpeg,gif,webp'
    );


    $file_upload = cl_upload($file_info);
    $banner = $file_upload['filename'];


    global $db, $cl, $me;
    $user = $me['community'];
    $sql = "update cl_community set banner='$banner', icon='$icon' where name='$user' ";
    $query_res = $db->rawQuery($sql);
    cl_queryset($query_res);


    cl_redirect("home?page=1");
} else if ($action == "join_community") {
    $data['err_code'] = 0;
    $data['status']   = 400;
    $community_id = $_POST['community_id'];
    $user_id  = $_POST['user_id'];

    $sql = "select property from cl_community where community_id='$community_id'";
    $query_res = $db->rawQuery($sql);
    cl_queryset($query_res);
    if ($query_res[0]['property'] == "private")
        return cl_redirect("join_community");
    else {
        $sql = "insert into cl_join_list(community_id, user_id) values ('$community_id','$user_id') ";
        $query_res = $db->rawQuery($sql);
        cl_queryset($query_res);
        return cl_redirect("community?community_id=$community_id");
    }
}