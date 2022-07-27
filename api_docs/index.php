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

require_once("../core/web_req_init.php");

$docs_page = fetch_or_get($_GET['page'], false);
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <title>ColibriSM API - Documentation</title>
        <meta name="description" content="ColibriSM - The Ultimate Modern Social Media Sharing Platform">
        <meta name="author" content="Mansur TL">
        <meta http-equiv="cleartype" content="on">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo cl_link('api_docs/css/hightlightjs-dark.css'); ?>">
        <link rel="stylesheet" href="<?php echo cl_link('api_docs/css/bootstrap-v4.0.0.min.css'); ?>">
        <script src="<?php echo cl_link('api_docs/js/jquery-3.5.1.min.js'); ?>"></script>
        <script src="<?php echo cl_link('api_docs/js/highlight-9.8.0.min.js'); ?>"></script>
        <script src="<?php echo cl_link('api_docs/js/bootstrap.v4.0.0.min.js'); ?>"></script>
        <script src="<?php echo cl_link('api_docs/js/popper.1.12.9.min.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo cl_link('api_docs/css/style.css'); ?>" media="all">
        <link rel="icon" href="<?php echo cl_link('api_docs/images/favicon.png'); ?>" type="image/png">
    </head>
    <body>
        <div class="left-menu">
            <div class="content-logo">
                <span class="label">ColibriSM - API</span>
            </div>
            <div class="content-menu">
                <ul id="left-menu-nav">
                    <li class="<?php if(empty($docs_page)) { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs"); ?>">
                            Get started
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'login') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=login"); ?>">
                            Login
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'oauth_login') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=oauth_login"); ?>">
                            Social login
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'signup') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=signup"); ?>">
                            Signup
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'resetpassword') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=resetpassword"); ?>">
                            Reset password
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'feeds') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=feeds"); ?>">
                            Timeline feed
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'profile') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=profile"); ?>">
                            Profile data (2)
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'report_profile') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=report_profile"); ?>">
                            Report profile
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'block_user') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=block_user"); ?>">
                            Block user
                        </a>
                    </li>
                    <li class="<?php if($docs_page == 'save_pnotif_token') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=save_pnotif_token"); ?>">Notification token</a>
                    </li>
                    <li class="<?php if($docs_page == 'change_password') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=change_password"); ?>">Change password</a>
                    </li>
                    <li class="<?php if($docs_page == 'refresh_access_token') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=refresh_access_token"); ?>">Refresh access token</a>
                    </li>
                    <li class="<?php if($docs_page == 'logout') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=logout"); ?>">Logout user</a>
                    </li>
                    <li class="<?php if($docs_page == 'verify_user') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=verify_user"); ?>">Verify user</a>
                    </li>
                    <li class="<?php if($docs_page == 'create_post') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=create_post"); ?>">Post & Reply (4)</a>
                    </li>
                    <li class="<?php if($docs_page == 'vote_polls') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=vote_polls"); ?>">Vote polls</a>
                    </li>
                    <li class="<?php if($docs_page == 'create_swift') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=create_swift"); ?>">Create swift (7)</a>
                    </li>
                    <li class="<?php if($docs_page == 'thread_data') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=thread_data"); ?>">Thread data (2)</a>
                    </li>
                    <li class="<?php if($docs_page == 'like_post') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=like_post"); ?>">Like / Unlike</a>
                    </li>
                    <li class="<?php if($docs_page == 'report_post') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=report_post"); ?>">Report post</a>
                    </li>
                    <li class="<?php if($docs_page == 'publication_repost') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=publication_repost"); ?>">Repost post</a>
                    </li>
                    <li class="<?php if($docs_page == 'bookmarks') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=bookmarks"); ?>">Bookmarks (2)</a>
                    </li>
                    <li class="<?php if($docs_page == 'fetch_likes') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=fetch_likes"); ?>">Post likes</a>
                    </li>
                    <li class="<?php if($docs_page == 'delete_post') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=delete_post"); ?>">Delete post</a>
                    </li>
                    <li class="<?php if($docs_page == 'search_hashtags') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=search_hashtags"); ?>">Search hashtags</a>
                    </li>
                    <li class="<?php if($docs_page == 'search_people') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=search_people"); ?>">Search people</a>
                    </li>
                    <li class="<?php if($docs_page == 'search_posts') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=search_posts"); ?>">Search posts</a>
                    </li>
                    <li class="<?php if($docs_page == 'pin_post') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=pin_post"); ?>">Pin post to profile</a>
                    </li>
                    <li class="<?php if($docs_page == 'gen_settings') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=gen_settings"); ?>">Update profile data</a>
                    </li>
                    <li class="<?php if($docs_page == 'avatar_cover') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=avatar_cover"); ?>">Avatar & Cover (3)</a>
                    </li>
                    <li class="<?php if($docs_page == 'get_priv_settings') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=priv_settings"); ?>">User privacy (2)</a>
                    </li>
                    <li class="<?php if($docs_page == 'follow') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=follow"); ?>">Follow & Unfollow</a>
                    </li>
                    <li class="<?php if($docs_page == 'fetch_following') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=fetch_following"); ?>">Fetch following</a>
                    </li>
                    <li class="<?php if($docs_page == 'fetch_followers') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=fetch_followers"); ?>">Fetch followers</a>
                    </li>
                    <li class="<?php if($docs_page == 'follow_requests') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=follow_requests"); ?>">Follow requests (3)</a>
                    </li>
                    <li class="<?php if($docs_page == 'get_notifications') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=get_notifications"); ?>">Get notifications</a>
                    </li>
                    <li class="<?php if($docs_page == 'delete_notifs') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=delete_notifs"); ?>">Delete notifications</a>
                    </li>
                    <li class="<?php if($docs_page == 'messaging') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=messaging"); ?>">Messaging (6)</a>
                    </li>
                    <li class="<?php if($docs_page == 'delete_account') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=delete_account"); ?>">Delete account</a>
                    </li>
                    <li class="<?php if($docs_page == 'language') { echo("active"); } ?>">
                        <a href="<?php echo cl_link("api_docs?page=language"); ?>">Change language</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <?php if (empty($docs_page)): ?>
                    <div class="overflow-hidden content-section">
                        <?php require_once("endpoints/getstarted/content.phtml"); ?>
                    </div>
                <?php else: ?>
                    <?php if (file_exists(cl_strf("endpoints/%s/content.phtml", $docs_page))): ?>
                        <div class="overflow-hidden content-section">
                            <?php require_once(cl_strf("endpoints/%s/content.phtml", $docs_page)); ?>
                        </div>
                    <?php else: ?>
                        <div class="overflow-hidden content-section">
                            <?php require_once("endpoints/getstarted/content.phtml"); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <script src="js/script.js"></script>
    </body>
</html>