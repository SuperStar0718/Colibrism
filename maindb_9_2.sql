/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : maindb

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 02/09/2022 19:01:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cl_acc_validations
-- ----------------------------
DROP TABLE IF EXISTS `cl_acc_validations`;
CREATE TABLE `cl_acc_validations`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `json` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_acc_validations
-- ----------------------------

-- ----------------------------
-- Table structure for cl_ads
-- ----------------------------
DROP TABLE IF EXISTS `cl_ads`;
CREATE TABLE `cl_ads`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `cover` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `company` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `target_url` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` enum('orphan','active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'orphan',
  `approved` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `audience` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]',
  `description` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `cta` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `budget` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `clicks` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_ads
-- ----------------------------
INSERT INTO `cl_ads` VALUES (2, 4, 'upload/covers/2022/04/EylVB8uajuh5TL9uq1o4_22_12a1a66808918b2aa09b7caccc29ad0f_image_cover.jpeg', 'lol', 'https://a.com', 'active', 'N', '[\n    \"1\",\n    \"4\"\n]', '1', '1', '500', 0, 0, '1650604752');
INSERT INTO `cl_ads` VALUES (3, 2, '', '', '', 'orphan', 'N', '[]', '', '', '0.00', 0, 0, '1650603295');
INSERT INTO `cl_ads` VALUES (4, 4, '', '', '', 'orphan', 'N', '[]', '', '', '0.00', 0, 0, '1650605069');
INSERT INTO `cl_ads` VALUES (5, 6, '', '', '', 'orphan', 'N', '[]', '', '', '0.00', 0, 0, '1658898268');

-- ----------------------------
-- Table structure for cl_affiliate_payouts
-- ----------------------------
DROP TABLE IF EXISTS `cl_affiliate_payouts`;
CREATE TABLE `cl_affiliate_payouts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `email` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `amount` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `bonuses` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending','paid') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'pending',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_affiliate_payouts
-- ----------------------------

-- ----------------------------
-- Table structure for cl_blocks
-- ----------------------------
DROP TABLE IF EXISTS `cl_blocks`;
CREATE TABLE `cl_blocks`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `profile_id` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_blocks
-- ----------------------------

-- ----------------------------
-- Table structure for cl_bookmarks
-- ----------------------------
DROP TABLE IF EXISTS `cl_bookmarks`;
CREATE TABLE `cl_bookmarks`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publication_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_bookmarks
-- ----------------------------

-- ----------------------------
-- Table structure for cl_chats
-- ----------------------------
DROP TABLE IF EXISTS `cl_chats`;
CREATE TABLE `cl_chats`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_one` int(11) NOT NULL DEFAULT 0,
  `user_two` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_chats
-- ----------------------------

-- ----------------------------
-- Table structure for cl_community
-- ----------------------------
DROP TABLE IF EXISTS `cl_community`;
CREATE TABLE `cl_community`  (
  `community_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `property` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `icon` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `moderator` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`community_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_community
-- ----------------------------
INSERT INTO `cl_community` VALUES (1, 'c/Torify', 'r/Torify', 'public', NULL, 'upload/images/2022/08/tQefe25GhcPiFPRQzDLo_02_010a2c575763fcfc6b0a19302b20e2d8_image_original.png', '1');
INSERT INTO `cl_community` VALUES (2, 'ours', 'r/my', 'private', NULL, 'upload/images/2022/08/tQefe25GhcPiFPRQzDLo_02_010a2c575763fcfc6b0a19302b20e2d8_image_original.png', '1');
INSERT INTO `cl_community` VALUES (6, 'Test', 'r/Mycommunit', 'public', NULL, 'upload/images/2022/08/tQefe25GhcPiFPRQzDLo_02_010a2c575763fcfc6b0a19302b20e2d8_image_original.png', '1');
INSERT INTO `cl_community` VALUES (7, 'hello', 'r/news', 'public', NULL, NULL, '2');
INSERT INTO `cl_community` VALUES (8, 'use', 'r/help', 'public', NULL, NULL, '3');
INSERT INTO `cl_community` VALUES (9, 'world', 'r/sos', 'public', NULL, NULL, '4');
INSERT INTO `cl_community` VALUES (10, 'tech', 'r/job', 'public', NULL, NULL, '1');
INSERT INTO `cl_community` VALUES (11, 'job', 'r/lancer', 'private', NULL, 'upload/images/2022/08/tQefe25GhcPiFPRQzDLo_02_010a2c575763fcfc6b0a19302b20e2d8_image_original.png', '1');
INSERT INTO `cl_community` VALUES (12, 'welcome', 'r/myjob', 'public', 'upload/images/2022/08/21KSp5lW1f4Kwdhqef34_04_9b303cbf08496f7dc858e5d1e6712f14_image_original.jpg', 'upload/images/2022/08/uPQdDQpyvfZHdfSerJ9m_04_9b303cbf08496f7dc858e5d1e6712f14_image_original.jpg', '2');
INSERT INTO `cl_community` VALUES (13, 'hader', 'r/iiosos', 'private', NULL, NULL, '8');
INSERT INTO `cl_community` VALUES (14, 'test', 'r/mytest', 'public', NULL, NULL, '12');
INSERT INTO `cl_community` VALUES (18, 'my best job', 'r/mybestjob', 'public', NULL, NULL, '1');
INSERT INTO `cl_community` VALUES (19, 'this is my community', 'r/asdf', 'private', NULL, NULL, '6');

-- ----------------------------
-- Table structure for cl_community_following
-- ----------------------------
DROP TABLE IF EXISTS `cl_community_following`;
CREATE TABLE `cl_community_following`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) NOT NULL,
  `follow_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_community_following
-- ----------------------------
INSERT INTO `cl_community_following` VALUES (5, 7, 5);
INSERT INTO `cl_community_following` VALUES (7, 8, 5);
INSERT INTO `cl_community_following` VALUES (10, 2, 5);

-- ----------------------------
-- Table structure for cl_configs
-- ----------------------------
DROP TABLE IF EXISTS `cl_configs`;
CREATE TABLE `cl_configs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `name` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `value` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `regex` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 80 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_configs
-- ----------------------------
INSERT INTO `cl_configs` VALUES (1, 'Theme', 'theme', 'default', '');
INSERT INTO `cl_configs` VALUES (2, 'Site name', 'name', 'Torify', '/^(.){0,50}$/');
INSERT INTO `cl_configs` VALUES (3, 'Site title', 'title', 'Torify', '/^(.){0,150}$/');
INSERT INTO `cl_configs` VALUES (4, 'Site description', 'description', '', '/^(.){0,350}$/');
INSERT INTO `cl_configs` VALUES (5, 'SEO keywords', 'keywords', '', '');
INSERT INTO `cl_configs` VALUES (6, 'Site logo', 'site_logo', 'statics/img/logo.png', '');
INSERT INTO `cl_configs` VALUES (7, 'Site favicon', 'site_favicon', 'statics/img/favicon.png', '');
INSERT INTO `cl_configs` VALUES (8, 'Chat wallpaper', 'chat_wp', 'statics/img/chatwp/default.png', '');
INSERT INTO `cl_configs` VALUES (9, 'Account activation', 'acc_validation', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (10, 'Default language', 'language', 'english', '');
INSERT INTO `cl_configs` VALUES (11, 'AS3 storage', 'as3_storage', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (12, 'E-mail address', 'email', 'realemail@aol.com', '');
INSERT INTO `cl_configs` VALUES (13, 'SMTP server', 'smtp_or_mail', 'smtp', '/^(smtp|mail)$/');
INSERT INTO `cl_configs` VALUES (14, 'SMTP host', 'smtp_host', '', '');
INSERT INTO `cl_configs` VALUES (15, 'SMTP password', 'smtp_password', '', '/^(.){0,50}$/');
INSERT INTO `cl_configs` VALUES (16, 'SMTP encryption', 'smtp_encryption', 'tls', '/^(ssl|tls)$/');
INSERT INTO `cl_configs` VALUES (17, 'SMTP port', 'smtp_port', '587', '/^[0-9]{1,11}$/');
INSERT INTO `cl_configs` VALUES (18, 'SMTP username', 'smtp_username', '', '');
INSERT INTO `cl_configs` VALUES (19, 'FFMPEG binary', 'ffmpeg_binary', 'core/libs/ffmpeg/ffmpeg', '/^(.){0,550}$/');
INSERT INTO `cl_configs` VALUES (20, 'Giphy api', 'giphy_api_key', 'EEoFiCosGuyEIWlXnRuw4McTLxfjCrl1', '/^(.){0,150}$/');
INSERT INTO `cl_configs` VALUES (21, 'Google analytics', 'google_analytics', '', '');
INSERT INTO `cl_configs` VALUES (22, 'Facebook API ID', 'facebook_api_id', '', '/^(.){0,150}$/');
INSERT INTO `cl_configs` VALUES (23, 'Facebook API Key', 'facebook_api_key', '', '/^(.){0,150}$/');
INSERT INTO `cl_configs` VALUES (24, 'Twitter API ID', 'twitter_api_id', '', '/^(.){0,150}$/');
INSERT INTO `cl_configs` VALUES (25, 'Twitter API Key', 'twitter_api_key', '', '/^(.){0,150}$/');
INSERT INTO `cl_configs` VALUES (26, 'Google API ID', 'google_api_id', '', '/^(.){0,150}$/');
INSERT INTO `cl_configs` VALUES (27, 'Google API Key', 'google_api_key', '', '/^(.){0,150}$/');
INSERT INTO `cl_configs` VALUES (28, 'Script version', 'version', '1.3.2', '');
INSERT INTO `cl_configs` VALUES (29, 'Last backup', 'last_backup', '0', '');
INSERT INTO `cl_configs` VALUES (30, 'Sitemap last update', 'sitemap_update', '', '');
INSERT INTO `cl_configs` VALUES (31, 'Affiliate bonus rate', 'aff_bonus_rate', '0.10', '/^([0-9]{1,3}\\.[0-9]{1,3}|[0-9]{1,3})$/');
INSERT INTO `cl_configs` VALUES (32, 'Affiliates System', 'affiliates_system', 'on', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (33, 'PayPal API Public key', 'paypal_api_key', '', '');
INSERT INTO `cl_configs` VALUES (34, 'PayPal API Secret key', 'paypal_api_pass', '', '');
INSERT INTO `cl_configs` VALUES (35, 'PayPal Payment Mode', 'paypal_mode', 'sandbox', '/^(sandbox|live)$/');
INSERT INTO `cl_configs` VALUES (36, 'Site currency', 'site_currency', 'usd', ' \r\n/^([a-zA-Z]){2,7}$/');
INSERT INTO `cl_configs` VALUES (37, 'Advertising system', 'advertising_system', 'on', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (38, 'Ad conversion rate', 'ad_conversion_rate', '0.05', '/^([0-9]{1,3}\\.[0-9]{1,3}|[0-9]{1,3})$/');
INSERT INTO `cl_configs` VALUES (39, 'Max post length', 'max_post_len', '200', '/^[0-9]{1,11}$/');
INSERT INTO `cl_configs` VALUES (40, 'Google oAuth', 'google_oauth', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (41, 'Twitter oAuth', 'twitter_oauth', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (42, 'Facebook oAuth', 'facebook_oauth', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (43, 'Google ads (Horiz-banner)', 'google_ad_horiz', '', '');
INSERT INTO `cl_configs` VALUES (44, 'Google ads (Vert-banner)', 'google_ad_vert', '', '');
INSERT INTO `cl_configs` VALUES (45, 'Default country', 'country_id', '1', '/^[0-9]{1,11}$/');
INSERT INTO `cl_configs` VALUES (46, 'Firebase API key', 'firebase_api_key', '', '');
INSERT INTO `cl_configs` VALUES (47, 'Push notifications', 'push_notifs', 'on', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (48, 'Page update interval', 'page_update_interval', '30', '/^[0-9]{1,11}$/');
INSERT INTO `cl_configs` VALUES (49, 'Chat update interval', 'chat_update_interval', '5', '/^[0-9]{1,11}$/');
INSERT INTO `cl_configs` VALUES (50, 'Amazon S3 storage', 'as3_storage', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (51, 'AS3 bucket name', 'as3_bucket_name', '', '');
INSERT INTO `cl_configs` VALUES (52, 'Amazon S3 API key', 'as3_api_key', '', '');
INSERT INTO `cl_configs` VALUES (53, 'Amazon S3 API secret key', 'as3_api_secret_key', '', '');
INSERT INTO `cl_configs` VALUES (54, 'AS3 bucket region', 'as3_bucket_region', 'us-east-1', '');
INSERT INTO `cl_configs` VALUES (55, 'Max upload size', 'max_upload_size', '2097152', '/^[0-9]{1,11}$/');
INSERT INTO `cl_configs` VALUES (56, 'Max post audio record length', 'post_arec_length', '30', '/^[0-9]{1,11}$/');
INSERT INTO `cl_configs` VALUES (57, 'Wallet topup min amount', 'wallet_min_amount', '50', '/^([0-9]{1,3}\\.[0-9]{1,3}|[0-9]{1,3})$/');
INSERT INTO `cl_configs` VALUES (58, '', '', '', '');
INSERT INTO `cl_configs` VALUES (59, 'Currency symbol position', 'currency_symbol_pos', 'after', '/^(before|after)$/');
INSERT INTO `cl_configs` VALUES (60, 'Aff payout min amount', 'aff_payout_min', '50', '/^([0-9]{1,3}\\\\.[0-9]{1,3}|[0-9]{1,3})$/');
INSERT INTO `cl_configs` VALUES (61, 'Default color scheme', 'default_color_scheme', 'purple', '');
INSERT INTO `cl_configs` VALUES (62, 'Default BG color', 'default_bg_color', 'default', '');
INSERT INTO `cl_configs` VALUES (63, 'Android app (Google play item URL)', 'android_app_url', '', '');
INSERT INTO `cl_configs` VALUES (64, 'IOS app (App store item URL)', 'ios_app_url', '', '');
INSERT INTO `cl_configs` VALUES (65, 'User registration system', 'user_signup', 'on', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (66, 'Cookie warning popup', 'cookie_warning_popup', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (67, 'Google reCAPTCHA', 'google_recaptcha', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (68, 'Google reCAPTCHA Sitekey', 'google_recap_key1', '', '');
INSERT INTO `cl_configs` VALUES (69, 'Google reCAPTCHA Secret key', 'google_recap_key2', '', '');
INSERT INTO `cl_configs` VALUES (70, 'E-Mail notifications', 'email_notifications', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (71, 'Swifts system status (Daily stories)', 'swift_system_status', 'off', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (72, 'PayPal Payment Status', 'paypal_method_status', 'on', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (73, 'PayStack API Public key', 'paystack_api_key', '', '');
INSERT INTO `cl_configs` VALUES (74, 'Paystack API Secret key', 'paystack_api_pass', '', '');
INSERT INTO `cl_configs` VALUES (75, 'Paystack Payment Status', 'paystack_method_status', 'on', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (76, 'Stripe API Secret key', 'stripe_api_pass', '', '');
INSERT INTO `cl_configs` VALUES (77, 'Stripe API Public key', 'stripe_api_key', '', '');
INSERT INTO `cl_configs` VALUES (78, 'Stripe Payment Status', 'stripe_method_status', 'on', '/^(on|off)$/');
INSERT INTO `cl_configs` VALUES (79, 'AliPay Payment Status', 'alipay_method_status', 'on', '/^(on|off)$/');

-- ----------------------------
-- Table structure for cl_connections
-- ----------------------------
DROP TABLE IF EXISTS `cl_connections`;
CREATE TABLE `cl_connections`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) NOT NULL DEFAULT 0,
  `following_id` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','pending') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'active',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '25',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_connections
-- ----------------------------
INSERT INTO `cl_connections` VALUES (2, 1, 2, 'active', '1650587557');
INSERT INTO `cl_connections` VALUES (3, 3, 1, 'active', '1650588239');
INSERT INTO `cl_connections` VALUES (4, 3, 2, 'active', '1650588240');
INSERT INTO `cl_connections` VALUES (6, 4, 3, 'active', '1650603388');
INSERT INTO `cl_connections` VALUES (8, 1, 3, 'active', '1659292336');
INSERT INTO `cl_connections` VALUES (9, 1, 7, 'active', '1659292377');
INSERT INTO `cl_connections` VALUES (10, 6, 1, 'active', '1659292436');
INSERT INTO `cl_connections` VALUES (12, 5, 2, 'active', '1659313102');
INSERT INTO `cl_connections` VALUES (19, 1, 12, 'active', '1660790234');
INSERT INTO `cl_connections` VALUES (20, 1, 5, 'active', '1660801937');

-- ----------------------------
-- Table structure for cl_hashtags
-- ----------------------------
DROP TABLE IF EXISTS `cl_hashtags`;
CREATE TABLE `cl_hashtags`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posts` int(11) NOT NULL DEFAULT 0,
  `tag` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_hashtags
-- ----------------------------
INSERT INTO `cl_hashtags` VALUES (3, 1, 'lol', '1650602919');

-- ----------------------------
-- Table structure for cl_invite_links
-- ----------------------------
DROP TABLE IF EXISTS `cl_invite_links`;
CREATE TABLE `cl_invite_links`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `role` set('user','admin') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'user',
  `mnu` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `expires_at` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `registered_users` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_invite_links
-- ----------------------------

-- ----------------------------
-- Table structure for cl_join_list
-- ----------------------------
DROP TABLE IF EXISTS `cl_join_list`;
CREATE TABLE `cl_join_list`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 67 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_join_list
-- ----------------------------
INSERT INTO `cl_join_list` VALUES (3, 1, 2);
INSERT INTO `cl_join_list` VALUES (9, 6, 1);
INSERT INTO `cl_join_list` VALUES (10, 6, 12);
INSERT INTO `cl_join_list` VALUES (11, 6, 12);
INSERT INTO `cl_join_list` VALUES (14, 18, 1);
INSERT INTO `cl_join_list` VALUES (15, 12, 1);
INSERT INTO `cl_join_list` VALUES (16, 19, 6);
INSERT INTO `cl_join_list` VALUES (17, 12, 1);
INSERT INTO `cl_join_list` VALUES (27, 2, 1);
INSERT INTO `cl_join_list` VALUES (28, 7, 1);
INSERT INTO `cl_join_list` VALUES (30, 1, 13);
INSERT INTO `cl_join_list` VALUES (31, 2, 13);
INSERT INTO `cl_join_list` VALUES (41, 12, 2);
INSERT INTO `cl_join_list` VALUES (42, 11, 1);
INSERT INTO `cl_join_list` VALUES (66, 2, 5);

-- ----------------------------
-- Table structure for cl_messages
-- ----------------------------
DROP TABLE IF EXISTS `cl_messages`;
CREATE TABLE `cl_messages`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sent_by` int(11) NOT NULL DEFAULT 0,
  `sent_to` int(11) NOT NULL DEFAULT 0,
  `owner` int(11) NOT NULL DEFAULT 0,
  `message` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `media_file` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `media_type` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'none',
  `seen` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `deleted_fs1` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `deleted_fs2` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_messages
-- ----------------------------

-- ----------------------------
-- Table structure for cl_notifications
-- ----------------------------
DROP TABLE IF EXISTS `cl_notifications`;
CREATE TABLE `cl_notifications`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notifier_id` int(11) NOT NULL DEFAULT 0,
  `recipient_id` int(11) NOT NULL DEFAULT 0,
  `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `subject` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'none',
  `entry_id` int(11) NOT NULL DEFAULT 0,
  `json` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_notifications
-- ----------------------------
INSERT INTO `cl_notifications` VALUES (2, 1, 2, '1', 'subscribe', 1, '[]', '1650587557');
INSERT INTO `cl_notifications` VALUES (5, 3, 2, '1', 'subscribe', 3, '[]', '1650588240');
INSERT INTO `cl_notifications` VALUES (6, 3, 2, '1', 'repost', 1, '[]', '1650588282');
INSERT INTO `cl_notifications` VALUES (7, 1, 2, '1', 'repost', 1, '[]', '1650589225');
INSERT INTO `cl_notifications` VALUES (8, 4, 2, '0', 'subscribe', 4, '[]', '1650608175');
INSERT INTO `cl_notifications` VALUES (9, 4, 3, '0', 'subscribe', 4, '[]', '1650603388');
INSERT INTO `cl_notifications` VALUES (10, 4, 1, '1', 'subscribe', 4, '[]', '1650603389');
INSERT INTO `cl_notifications` VALUES (11, 4, 2, '1', 'reply', 5, '[]', '1650603564');
INSERT INTO `cl_notifications` VALUES (14, 4, 1, '1', 'reply', 7, '[]', '1650605368');
INSERT INTO `cl_notifications` VALUES (15, 4, 2, '1', 'repost', 1, '[]', '1650598458');
INSERT INTO `cl_notifications` VALUES (16, 1, 4, '0', 'like', 9, '[]', '1658515098');
INSERT INTO `cl_notifications` VALUES (17, 1, 4, '0', 'repost', 9, '[]', '1658515100');
INSERT INTO `cl_notifications` VALUES (18, 1, 7, '0', 'subscribe', 1, '[]', '1659292377');
INSERT INTO `cl_notifications` VALUES (19, 1, 3, '0', 'subscribe', 1, '[]', '1659292336');
INSERT INTO `cl_notifications` VALUES (20, 6, 1, '1', 'subscribe', 6, '[]', '1659292436');
INSERT INTO `cl_notifications` VALUES (21, 5, 1, '1', 'subscribe', 5, '[]', '1659313011');
INSERT INTO `cl_notifications` VALUES (22, 5, 2, '0', 'subscribe', 5, '[]', '1659313102');
INSERT INTO `cl_notifications` VALUES (23, 1, 12, '0', 'subscribe', 1, '[]', '1660790234');
INSERT INTO `cl_notifications` VALUES (24, 1, 6, '0', 'subscribe', 1, '[]', '1660789672');
INSERT INTO `cl_notifications` VALUES (25, 1, 5, '1', 'subscribe', 1, '[]', '1660801937');

-- ----------------------------
-- Table structure for cl_posts
-- ----------------------------
DROP TABLE IF EXISTS `cl_posts`;
CREATE TABLE `cl_posts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `community_id` int(11) NOT NULL,
  `publication_id` int(11) NOT NULL DEFAULT 0,
  `type` enum('post','repost') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'post',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_posts
-- ----------------------------
INSERT INTO `cl_posts` VALUES (1, 5, 12, 1, 'post', '1662078450');
INSERT INTO `cl_posts` VALUES (5, 5, 6, 5, 'post', '1662081394');
INSERT INTO `cl_posts` VALUES (6, 5, 7, 6, 'post', '1662085146');
INSERT INTO `cl_posts` VALUES (7, 5, 8, 7, 'post', '1662085175');
INSERT INTO `cl_posts` VALUES (8, 5, 2, 8, 'post', '1662085206');

-- ----------------------------
-- Table structure for cl_profile_reports
-- ----------------------------
DROP TABLE IF EXISTS `cl_profile_reports`;
CREATE TABLE `cl_profile_reports`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `profile_id` int(11) NOT NULL DEFAULT 0,
  `reason` int(11) NOT NULL DEFAULT 0,
  `comment` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `seen` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_profile_reports
-- ----------------------------

-- ----------------------------
-- Table structure for cl_pub_reports
-- ----------------------------
DROP TABLE IF EXISTS `cl_pub_reports`;
CREATE TABLE `cl_pub_reports`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `reason` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `seen` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `comment` varchar(1210) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_pub_reports
-- ----------------------------

-- ----------------------------
-- Table structure for cl_publications
-- ----------------------------
DROP TABLE IF EXISTS `cl_publications`;
CREATE TABLE `cl_publications`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `type` enum('text','video','image','gif','poll','audio') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'text',
  `replys_count` int(11) NOT NULL DEFAULT 0,
  `reposts_count` int(11) NOT NULL DEFAULT 0,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','deleted','orphan') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'active',
  `thread_id` int(11) NOT NULL DEFAULT 0,
  `target` enum('publication','pub_reply') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'publication',
  `og_data` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `poll_data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `priv_wcs` enum('everyone','followers') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `priv_wcr` enum('everyone','followers','mentioned') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `edited` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `image` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `community_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `image`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_publications
-- ----------------------------
INSERT INTO `cl_publications` VALUES (1, 5, '', 'poll', 0, 0, 0, 'active', 0, 'publication', '', '[\n    {\n        \"option\": \"This\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"is\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"First Tweet\",\n        \"voters\": [],\n        \"votes\": 0\n    }\n]', 'everyone', 'everyone', '1662078450', '0', 'This is the first Tweet', 'upload/images/2022/09/ZVujKOujbav9SB1e7dvE_02_69a6f9c9471d8cffc0c1345a554f7b7b_image_original.jpeg', 12);
INSERT INTO `cl_publications` VALUES (5, 5, '', 'poll', 0, 0, 0, 'active', 0, 'publication', '', '[\n    {\n        \"option\": \"Test\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"Test\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"commuity\",\n        \"voters\": [],\n        \"votes\": 0\n    }\n]', 'everyone', 'everyone', '1662081394', '0', 'Hello Community', 'upload/images/2022/09/ffXNRN6LQ1284euc3wZt_02_566eab065ab43c5686d2512ca45e613f_image_original.jpeg', 6);
INSERT INTO `cl_publications` VALUES (6, 5, '', 'poll', 0, 0, 0, 'active', 0, 'publication', '', '[\n    {\n        \"option\": \"Hello\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"Hi\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"Nice to meet you\",\n        \"voters\": [],\n        \"votes\": 0\n    }\n]', 'everyone', 'everyone', '1662085146', '0', 'Hello Every one', 'upload/images/2022/09/sHir7Xv4jKzhA3Lj4Tns_02_a78fd2ebafbbb34fea77892e0c220c4f_image_original.jpeg', 7);
INSERT INTO `cl_publications` VALUES (7, 5, '', 'poll', 0, 0, 0, 'active', 0, 'publication', '', '[\n    {\n        \"option\": \"I\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"am\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"happy\",\n        \"voters\": [],\n        \"votes\": 0\n    }\n]', 'everyone', 'everyone', '1662085175', '0', 'I am very happy', 'upload/images/2022/09/GJFJfOIHFAk3lqDuQOiq_02_1880f18d85bc8c43774a3d8388246ab9_image_original.jpeg', 8);
INSERT INTO `cl_publications` VALUES (8, 5, '', 'poll', 0, 0, 0, 'active', 0, 'publication', '', '[\n    {\n        \"option\": \"Hello\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"world\",\n        \"voters\": [],\n        \"votes\": 0\n    },\n    {\n        \"option\": \"Hi\",\n        \"voters\": [],\n        \"votes\": 0\n    }\n]', 'everyone', 'everyone', '1662085206', '0', 'Hello world', 'upload/images/2022/09/39wCsTkjUH7C3dw92Jfd_02_8715d04f694a9adf9ccbb089e6ed5dc1_image_original.jpeg', 2);

-- ----------------------------
-- Table structure for cl_publikes
-- ----------------------------
DROP TABLE IF EXISTS `cl_publikes`;
CREATE TABLE `cl_publikes`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pub_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_publikes
-- ----------------------------
INSERT INTO `cl_publikes` VALUES (1, 1, 2, '1650587484');
INSERT INTO `cl_publikes` VALUES (2, 9, 1, '1658515097');
INSERT INTO `cl_publikes` VALUES (4, 98, 1, '1659348946');

-- ----------------------------
-- Table structure for cl_pubmedia
-- ----------------------------
DROP TABLE IF EXISTS `cl_pubmedia`;
CREATE TABLE `cl_pubmedia`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pub_id` int(11) NOT NULL DEFAULT 0,
  `type` enum('image','video','gif','audio') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `src` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `json_data` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_pubmedia
-- ----------------------------
INSERT INTO `cl_pubmedia` VALUES (2, 7, 'image', 'upload/images/2022/04/8txEVoP7366CCB8MuAKI_22_53c144eff57a4d399853e074586c07e9_image_original.jpeg', '{\n    \"image_thumb\": \"upload\\/images\\/2022\\/04\\/ansEy9dwGdwm9PjHJkj2_22_53c144eff57a4d399853e074586c07e9_image_300x300.jpeg\"\n}', '1650605365');

-- ----------------------------
-- Table structure for cl_sessions
-- ----------------------------
DROP TABLE IF EXISTS `cl_sessions`;
CREATE TABLE `cl_sessions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `user_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `platform` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'web',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `lifespan` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 111 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_sessions
-- ----------------------------
INSERT INTO `cl_sessions` VALUES (1, 'bb464e3286587c54d9fe733810b6f1c6014b4e1d1650587455386583ece406f404ebc1b813dfb44764', '2', 'web', '1650587455', '1682123455');
INSERT INTO `cl_sessions` VALUES (2, 'e0b99f9e60ecec60151b1062fdc5f8a98e1db03616505875522324c4f52daeb35301dbad702cf77655', '1', 'web', '1650587552', '1682123552');
INSERT INTO `cl_sessions` VALUES (4, 'f91f8cd85b9e292d38e8a3e3d676262fd25f17a21650588434424663c5f1a5d434d46812a316f0f904', '1', 'web', '1650588434', '1682124434');
INSERT INTO `cl_sessions` VALUES (20, 'b74769777f984aa65a0789e45f3bf63ebece7c7b1650607500d9248689104129db9a352c7e026c1c0a', '4', 'web', '1650607500', '1682143500');
INSERT INTO `cl_sessions` VALUES (22, '29750f6fa333bf80e0a4087789ce9b32212c105d16506615035684b2087f25a609d34e01da4b13a56e', '4', 'web', '1650661503', '1682197503');
INSERT INTO `cl_sessions` VALUES (23, '97a4623ba91a869245ecaaacd4a7a34c4faedf1f1658087114f47491fb20587f6eeedc79466d3f3b53', '1', 'web', '1658087114', '1689623114');
INSERT INTO `cl_sessions` VALUES (26, '8c78d69d273175ef0c8db95923541f398d366f00165815794842817b4186c09c9bd205506900bdc19a', '$2y$10$uox0', 'web', '1658157948', '1689693948');
INSERT INTO `cl_sessions` VALUES (27, '19fb0af7dda6f7b554b4ea7ce60b183108b8088016581579856998d5383acc8cbacf90fd2091c8895c', '$2y$10$uox0', 'web', '1658157985', '1689693985');
INSERT INTO `cl_sessions` VALUES (28, '9bcd539ffb69a03c494b23f2ae22a44873d5bc10165815816900978803525a7ab43d9c9a733866c3e5', '$2y$10$uox0', 'web', '1658158169', '1689694169');
INSERT INTO `cl_sessions` VALUES (80, '955aeb780284e169382f0c74ea29d8e8906369961659484885626c1e01d7451cd084f0e1daea6a5249', '9', 'web', '1659484885', '1691020885');
INSERT INTO `cl_sessions` VALUES (84, '655ccdaaf898e24eaea946452e7cc0f9b4ef6db316595000954dbbeb5b93d32b848324001cd30db988', '10', 'web', '1659500095', '1691036095');
INSERT INTO `cl_sessions` VALUES (105, '40a18a500f3bf3321f7fc4c7ad4211f0974390fb1660818445bcb267bab50ab04de04a9b2cc5c9ac20', '5', 'web', '1660818445', '1692354445');
INSERT INTO `cl_sessions` VALUES (106, '9e80dd4aa0b7da22114c7d6ca4e5c4b248e0e2c616611511809bf0d44eebcca5dc31241d8f325acd8f', '5', 'web', '1661151180', '1692687180');
INSERT INTO `cl_sessions` VALUES (108, 'e7cda3496ba999f314ef3c43f943dd0863c14d8a16619642849fcada77465b7ebe5759b663201b98aa', '5', 'web', '1661964284', '1693500284');
INSERT INTO `cl_sessions` VALUES (109, '488875c5dcc35a34be41d84b05dbe62875044c6c1661965054d810e301f5a8675413c4b053283ad52c', '5', 'web', '1661965054', '1693501054');
INSERT INTO `cl_sessions` VALUES (110, '7452526b52f059e67259ab26326f0652a5aad0d316619666714dc2e02feeecf5ee19377938485b9033', '5', 'web', '1661966671', '1693502671');

-- ----------------------------
-- Table structure for cl_ui_langs
-- ----------------------------
DROP TABLE IF EXISTS `cl_ui_langs`;
CREATE TABLE `cl_ui_langs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `slug` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` set('1','0') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `is_rtl` set('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `is_native` set('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_ui_langs
-- ----------------------------
INSERT INTO `cl_ui_langs` VALUES (1, 'English', 'english', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (2, 'French', 'french', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (3, 'German', 'german', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (4, 'Italian', 'italian', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (5, 'Russian', 'russian', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (6, 'Portuguese', 'portuguese', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (7, 'Spanish', 'spanish', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (8, 'Turkish', 'turkish', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (9, 'Dutch', 'dutch', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (10, 'Ukraine', 'ukraine', '1', 'N', '1');
INSERT INTO `cl_ui_langs` VALUES (11, 'Arabic', 'arabic', '1', 'Y', '1');

-- ----------------------------
-- Table structure for cl_users
-- ----------------------------
DROP TABLE IF EXISTS `cl_users`;
CREATE TABLE `cl_users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `fname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `lname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `about` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `gender` enum('M','F','T','O') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'M',
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `em_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email_conf_code` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `password` varchar(140) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `joined` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `start_up` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'done',
  `last_active` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(140) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.0.0.0',
  `language` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default',
  `avatar` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/avatar-1.png',
  `cover` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/cover-1.png',
  `cover_orig` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/cover-1.png',
  `active` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `verified` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `admin` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `posts` int(11) NOT NULL DEFAULT 0,
  `followers` int(11) NOT NULL DEFAULT 0,
  `following` int(11) NOT NULL DEFAULT 0,
  `website` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `country_id` int(11) NOT NULL DEFAULT 1,
  `city` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_post` int(11) NOT NULL DEFAULT 0,
  `last_swift` varchar(135) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_ad` int(11) NOT NULL DEFAULT 0,
  `profile_privacy` enum('everyone','followers') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `follow_privacy` enum('everyone','approved') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `contact_privacy` enum('everyone','followed') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `index_privacy` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y',
  `aff_bonuses` int(11) NOT NULL DEFAULT 0,
  `wallet` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `pnotif_token` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"token\": \"\",\"type\": \"android\"}',
  `refresh_token` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `settings` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',
  `display_settings` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"color_scheme\": \"default\",\"background\": \"default\"}',
  `swift` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `swift_update` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `info_file` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `posts`(`posts`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_users
-- ----------------------------
INSERT INTO `cl_users` VALUES (1, 'Admin', 'RIchardjk', 'Dalon', 'zxcvzxc', 'M', 'realemail@aol.com', '', '0', '$2y$10$uox0hNIAUjAyBSjhhj3ys.B7bGnCQkuAvSPF1vj0gjm0I1WAaOLr.', '1650586829', 'done', '1660697615', '::1', 'english', 'upload/images/2022/08/uPQdDQpyvfZHdfSerJ9m_04_9b303cbf08496f7dc858e5d1e6712f14_image_original.jpg', 'upload/default/cover-1.png', 'upload/default/cover-1.png', '1', '0', '1', 46, 2, 5, 'http://our.com', 1, '', 0, '', 1, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\",\n    \"base\": \"#388538\",\n    \"links\": \"#f59351\",\n    \"title\": \"#272c6d\",\n    \"highlight\": \"#8c3b3b\",\n    \"main_menu\": \"#24c25b\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (2, 'urgaylol', 'urgaylol', '', '', 'M', 'urgaylol@aol.com', 'ad3b72af3388a1bece39c310d4f11202422f55b8', '0', '$2y$10$3TXr25hHhYCizyl1mbGpU..pfOQM/7cgIOeizSy2EoacO0dLWJh8W', '1650587455', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1650603367', '127.0.0.1', 'english', 'upload/default/avatar-5.png', 'upload/default/cover-5.png', 'upload/default/cover-5.png', '1', '1', '0', 1, 3, 0, '', 1, '', 0, '', 3, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (3, 'lolana', 'lolana', '', '', 'M', 'emaaia@aol.com', '6ed15189e24ed1a2e20b6f817072c67f6143ea06', '0', '$2y$10$hKfnFb1C.c4I7XuM.FVXgutzko7pMyA7ZBTlyAD9t.gUFI8n9BJDi', '1650588199', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1650588300', '127.0.0.1', 'english', 'upload/default/avatar-3.png', 'upload/default/cover-3.png', 'upload/default/cover-3.png', '1', '0', '0', 0, 2, 2, '', 1, '', 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"purple\",\n    \"background\": \"dark\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (4, 'itsme', 'itsme', '', 'its me', 'M', 'itsmeitsme@aol.com', '2e163bf958d43190cdd051a6888a18eafdad860d', '0', '$2y$10$0ayF1hp4gCu0qdRsYgj7o.edtbYaiqSLnQAd5M7QsSFDlE9hiG.7S', '1650603316', '{\r\n    \"source\": \"system\",\r\n    \"avatar\": 0,\r\n    \"info\": 0,\r\n    \"follow\": 0\r\n}', '1650661982', '127.0.0.1', 'english', 'upload/avatars/2022/04/kTByCtNkM61ZgEHzOu2X_22_e0f399cc1cd3ab9287ef507683ae936c_thumbnail_512x512.jpeg', 'upload/covers/2022/04/UfrjUnCpbujGQqyTmaBw_22_aa37d07ff1d7155b2aecae0613718c35_image_cover_600x200.jpeg', 'upload/covers/2022/04/UfrjUnCpbujGQqyTmaBw_22_aa37d07ff1d7155b2aecae0613718c35_image_cover.jpeg', '1', '0', '1', 1, 0, 1, 'http://slol.com', 1, '', 0, '', 4, 'everyone', 'everyone', 'everyone', 'Y', 0, '5000000', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"purple\",\n    \"background\": \"default\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (5, 'Boris', 'Boris', '', '', 'M', '', 'c047ba3fc7b03666e54e7ce7c1767c393e450c35', '0', '$2y$10$uHP52Boh.sVhlE8Jj3gdLeO11eZoXYm.jCrOUPcmKSTx/MylKx1dq', '1658169082', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1661966671', '::1', 'english', 'upload/default/avatar-3.png', 'upload/default/cover-3.png', 'upload/default/cover-3.png', '1', '2', '0', 29, 1, 1, '', 1, '', 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\",\n    \"base\": \"#59ff00\",\n    \"links\": \"#2bff00\",\n    \"title\": \"#cf3030\",\n    \"highlight\": \"#632b0d\",\n    \"main_menu\": \"#a74972\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (6, 'stuff', 'asdf', 'asdf', 'sdf', 'M', '', 'de9ef3875ec5b35d7428acf325c7bb1499bdcc14', '0', '$2y$10$KajtcUGxRi25IEZ1QFdxd.PrMMQfKhYWYMKGcEH3qipAwRl19PMH.', '1658388818', '{\n    \"source\": \"system\",\n    \"avatar\": 1,\n    \"info\": 1,\n    \"follow\": 0\n}', '1659612862', '::1', 'english', 'upload/default/avatar-6.png', 'upload/default/cover-6.png', 'upload/default/cover-6.png', '1', '0', '0', 46, 0, 1, '', 2, '', 0, '', 5, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\",\n    \"base\": \"#00ff00\",\n    \"links\": \"#ff00bb\",\n    \"title\": \"#4400ff\",\n    \"highlight\": \"#ff0000\",\n    \"main_menu\": \"#ff0000\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (7, 'Lovesmile', 'rkvudtys0718', '', '', 'M', '', 'a51898c9815e3e2c8563a8512ddfe50d6e120468', '0', '$2y$10$u/b0/DmPl2DRTuia3jTZu..78q5kZDPXZodqaUW.khJWRu1xUPlxu', '1658543383', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1658543383', '::1', 'english', 'upload/default/avatar-11.png', 'upload/default/cover-11.png', 'upload/default/cover-11.png', '1', '0', '0', 0, 1, 0, '', 1, '', 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"purple\",\n    \"background\": \"default\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (11, 'Ivan', 'asdf', '', '', 'M', '', '60f6d08c3e2c7ecec1133b2e380ba616cac995bd', '0', '$2y$10$GXVydCirf8chQaFHrrMlheOI5Zl.8lOMUc2ch08c2mlCwJSI06rlO', '1659549219', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1659558519', '::1', 'english', 'upload/default/avatar-1.png', 'upload/default/cover-1.png', 'upload/default/cover-1.png', '1', '0', '0', 0, 0, 0, '', 1, '', 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"purple\",\n    \"background\": \"default\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (12, 'Atonio', 'new', '', '', 'M', '', '365eddbed26ff92949f1f02865898f24cd6ceb2b', '0', '$2y$10$JfmeD4Y0nka1.DePkIcF7uSM1UGR/n8xyWobA4P8sfXPiH8ZhzfcC', '1659560566', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1659651202', '::1', 'english', 'upload/default/avatar-1.png', 'upload/default/cover-1.png', 'upload/default/cover-1.png', '1', '0', '0', 0, 1, 0, '', 1, '', 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"purple\",\n    \"background\": \"default\"\n}', NULL, '0', '');
INSERT INTO `cl_users` VALUES (13, 'Jacky', 'Jacky', '', '', 'M', '', '10b5b2a0f8118852706fbdb7d57d39df197d883f', '0', '$2y$10$s31IhlQRFL9NqTQl4H96ietAqo6YDlE3DrJMrAjQ5mIidz2gQDcHu', '1660816921', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1660817704', '::1', 'english', 'upload/default/avatar-1.png', 'upload/default/cover-1.png', 'upload/default/cover-1.png', '1', '0', '0', 0, 0, 0, '', 1, '', 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"purple\",\n    \"background\": \"default\"\n}', NULL, '0', '');

-- ----------------------------
-- Table structure for cl_verifications
-- ----------------------------
DROP TABLE IF EXISTS `cl_verifications`;
CREATE TABLE `cl_verifications`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `full_name` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `text_message` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `video_message` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_verifications
-- ----------------------------
INSERT INTO `cl_verifications` VALUES (1, 5, 'Boris', 'ddghfdghdfgh', 'upload/videos/2022/08/I3UC7FF5UgO1GrVjYG2w_22_6e1f30e5e82061a440cfc5113c6f2a91_video_video_message.mp4', 1661151375);

-- ----------------------------
-- Table structure for cl_wallet_history
-- ----------------------------
DROP TABLE IF EXISTS `cl_wallet_history`;
CREATE TABLE `cl_wallet_history`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `operation` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `amount` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `json_data` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cl_wallet_history
-- ----------------------------

-- ----------------------------
-- Table structure for copy_cl_users
-- ----------------------------
DROP TABLE IF EXISTS `copy_cl_users`;
CREATE TABLE `copy_cl_users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `fname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `lname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `about` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `gender` enum('M','F','T','O') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'M',
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `em_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email_conf_code` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `password` varchar(140) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `joined` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `start_up` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'done',
  `last_active` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(140) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.0.0.0',
  `language` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default',
  `avatar` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/avatar-1.png',
  `cover` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/cover-1.png',
  `cover_orig` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/cover-1.png',
  `active` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `verified` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `admin` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `posts` int(11) NOT NULL DEFAULT 0,
  `followers` int(11) NOT NULL DEFAULT 0,
  `following` int(11) NOT NULL DEFAULT 0,
  `website` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `country_id` int(11) NOT NULL DEFAULT 1,
  `city` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_post` int(11) NOT NULL DEFAULT 0,
  `last_swift` varchar(135) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_ad` int(11) NOT NULL DEFAULT 0,
  `profile_privacy` enum('everyone','followers') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `follow_privacy` enum('everyone','approved') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `contact_privacy` enum('everyone','followed') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `index_privacy` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y',
  `aff_bonuses` int(11) NOT NULL DEFAULT 0,
  `wallet` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `pnotif_token` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"token\": \"\",\"type\": \"android\"}',
  `refresh_token` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `settings` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',
  `display_settings` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"color_scheme\": \"default\",\"background\": \"default\"}',
  `swift` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `swift_update` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `info_file` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `posts`(`posts`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of copy_cl_users
-- ----------------------------
INSERT INTO `copy_cl_users` VALUES (1, 'Admin', 'Site', 'Admin', '', 'M', 'realemail@aol.com', '', '0', '$AWojUmolQrzjWuPBYlYrE.SL31hNG/9WStTBPOtuoMFNZByLbSrnK', '1650586829', 'done', '1650589946', '127.0.0.1', 'english', 'upload/default/avatar-1.png', 'upload/default/cover-1.png', 'upload/default/cover-1.png', '1', '0', '1', 1, 1, 1, '', 1, '', 0, '', 1, 'everyone', 'everyone', 'followed', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\"\n}', NULL, '0', '');
INSERT INTO `copy_cl_users` VALUES (2, 'urgaylol', 'urgaylol', '', '', 'M', 'urgaylol@aol.com', 'ad3b72af3388a1bece39c310d4f11202422f55b8', '0', '$2y$10$3TXr25hHhYCizyl1mbGpU..pfOQM/7cgIOeizSy2EoacO0dLWJh8W', '1650587455', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1650603367', '127.0.0.1', 'english', 'upload/default/avatar-5.png', 'upload/default/cover-5.png', 'upload/default/cover-5.png', '1', '1', '0', 1, 2, 0, '', 1, '', 0, '', 3, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\"\n}', NULL, '0', '');
INSERT INTO `copy_cl_users` VALUES (3, 'lolana', 'lolana', '', '', 'M', 'emaaia@aol.com', '6ed15189e24ed1a2e20b6f817072c67f6143ea06', '0', '$2y$10$hKfnFb1C.c4I7XuM.FVXgutzko7pMyA7ZBTlyAD9t.gUFI8n9BJDi', '1650588199', '{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}', '1650588300', '127.0.0.1', 'english', 'upload/default/avatar-3.png', 'upload/default/cover-3.png', 'upload/default/cover-3.png', '1', '0', '0', 0, 1, 2, '', 1, '', 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"purple\",\n    \"background\": \"dark\"\n}', NULL, '0', '');
INSERT INTO `copy_cl_users` VALUES (4, 'itsme', 'itsme', '', 'its me', 'M', 'itsmeitsme@aol.com', '2e163bf958d43190cdd051a6888a18eafdad860d', '0', '$2y$10$0ayF1hp4gCu0qdRsYgj7o.edtbYaiqSLnQAd5M7QsSFDlE9hiG.7S', '1650603316', '{\r\n    \"source\": \"system\",\r\n    \"avatar\": 0,\r\n    \"info\": 0,\r\n    \"follow\": 0\r\n}', '1650661982', '127.0.0.1', 'english', 'upload/avatars/2022/04/kTByCtNkM61ZgEHzOu2X_22_e0f399cc1cd3ab9287ef507683ae936c_thumbnail_512x512.jpeg', 'upload/covers/2022/04/UfrjUnCpbujGQqyTmaBw_22_aa37d07ff1d7155b2aecae0613718c35_image_cover_600x200.jpeg', 'upload/covers/2022/04/UfrjUnCpbujGQqyTmaBw_22_aa37d07ff1d7155b2aecae0613718c35_image_cover.jpeg', '1', '0', '1', 1, 0, 1, 'http://slol.com', 1, '', 0, '', 4, 'everyone', 'everyone', 'everyone', 'Y', 0, '5000000', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}', '{\n    \"color_scheme\": \"purple\",\n    \"background\": \"default\"\n}', NULL, '0', '');

-- ----------------------------
-- Table structure for copy_cl_verifications
-- ----------------------------
DROP TABLE IF EXISTS `copy_cl_verifications`;
CREATE TABLE `copy_cl_verifications`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `full_name` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `text_message` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `video_message` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of copy_cl_verifications
-- ----------------------------

-- ----------------------------
-- Table structure for copy_cl_wallet_history
-- ----------------------------
DROP TABLE IF EXISTS `copy_cl_wallet_history`;
CREATE TABLE `copy_cl_wallet_history`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `operation` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `amount` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `json_data` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of copy_cl_wallet_history
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
