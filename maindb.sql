-- Adminer 4.8.1 MySQL 8.0.28-0ubuntu0.20.04.3 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `cl_acc_validations`;
CREATE TABLE `cl_acc_validations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hash` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `json` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_ads`;
CREATE TABLE `cl_ads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `cover` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `company` varchar(120) NOT NULL DEFAULT '',
  `target_url` varchar(1200) NOT NULL DEFAULT '',
  `status` enum('orphan','active','inactive') NOT NULL DEFAULT 'orphan',
  `approved` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `audience` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]',
  `description` varchar(600) NOT NULL DEFAULT '',
  `cta` varchar(300) NOT NULL DEFAULT '',
  `budget` varchar(15) NOT NULL DEFAULT '0.00',
  `clicks` int NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_ads` (`id`, `user_id`, `cover`, `company`, `target_url`, `status`, `approved`, `audience`, `description`, `cta`, `budget`, `clicks`, `views`, `time`) VALUES
(2,	4,	'upload/covers/2022/04/EylVB8uajuh5TL9uq1o4_22_12a1a66808918b2aa09b7caccc29ad0f_image_cover.jpeg',	'lol',	'https://a.com',	'active',	'N',	'[\n    \"1\",\n    \"4\"\n]',	'1',	'1',	'500',	0,	0,	'1650604752'),
(3,	2,	'',	'',	'',	'orphan',	'N',	'[]',	'',	'',	'0.00',	0,	0,	'1650603295'),
(4,	4,	'',	'',	'',	'orphan',	'N',	'[]',	'',	'',	'0.00',	0,	0,	'1650605069');

DROP TABLE IF EXISTS `cl_affiliate_payouts`;
CREATE TABLE `cl_affiliate_payouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `email` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `amount` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `bonuses` int NOT NULL DEFAULT '0',
  `status` enum('pending','paid') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'pending',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_blocks`;
CREATE TABLE `cl_blocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `profile_id` int NOT NULL DEFAULT '0',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_bookmarks`;
CREATE TABLE `cl_bookmarks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_chats`;
CREATE TABLE `cl_chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_one` int NOT NULL DEFAULT '0',
  `user_two` int NOT NULL DEFAULT '0',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_configs`;
CREATE TABLE `cl_configs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL DEFAULT '',
  `name` varchar(120) NOT NULL DEFAULT '',
  `value` varchar(3000) NOT NULL DEFAULT '',
  `regex` varchar(120) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_configs` (`id`, `title`, `name`, `value`, `regex`) VALUES
(1,	'Theme',	'theme',	'default',	''),
(2,	'Site name',	'name',	'Torify',	'/^(.){0,50}$/'),
(3,	'Site title',	'title',	'Torify',	'/^(.){0,150}$/'),
(4,	'Site description',	'description',	'',	'/^(.){0,350}$/'),
(5,	'SEO keywords',	'keywords',	'',	''),
(6,	'Site logo',	'site_logo',	'statics/img/logo.png',	''),
(7,	'Site favicon',	'site_favicon',	'statics/img/favicon.png',	''),
(8,	'Chat wallpaper',	'chat_wp',	'statics/img/chatwp/default.png',	''),
(9,	'Account activation',	'acc_validation',	'off',	'/^(on|off)$/'),
(10,	'Default language',	'language',	'english',	''),
(11,	'AS3 storage',	'as3_storage',	'off',	'/^(on|off)$/'),
(12,	'E-mail address',	'email',	'realemail@aol.com',	''),
(13,	'SMTP server',	'smtp_or_mail',	'smtp',	'/^(smtp|mail)$/'),
(14,	'SMTP host',	'smtp_host',	'',	''),
(15,	'SMTP password',	'smtp_password',	'',	'/^(.){0,50}$/'),
(16,	'SMTP encryption',	'smtp_encryption',	'tls',	'/^(ssl|tls)$/'),
(17,	'SMTP port',	'smtp_port',	'587',	'/^[0-9]{1,11}$/'),
(18,	'SMTP username',	'smtp_username',	'',	''),
(19,	'FFMPEG binary',	'ffmpeg_binary',	'core/libs/ffmpeg/ffmpeg',	'/^(.){0,550}$/'),
(20,	'Giphy api',	'giphy_api_key',	'EEoFiCosGuyEIWlXnRuw4McTLxfjCrl1',	'/^(.){0,150}$/'),
(21,	'Google analytics',	'google_analytics',	'',	''),
(22,	'Facebook API ID',	'facebook_api_id',	'',	'/^(.){0,150}$/'),
(23,	'Facebook API Key',	'facebook_api_key',	'',	'/^(.){0,150}$/'),
(24,	'Twitter API ID',	'twitter_api_id',	'',	'/^(.){0,150}$/'),
(25,	'Twitter API Key',	'twitter_api_key',	'',	'/^(.){0,150}$/'),
(26,	'Google API ID',	'google_api_id',	'',	'/^(.){0,150}$/'),
(27,	'Google API Key',	'google_api_key',	'',	'/^(.){0,150}$/'),
(28,	'Script version',	'version',	'1.3.2',	''),
(29,	'Last backup',	'last_backup',	'0',	''),
(30,	'Sitemap last update',	'sitemap_update',	'',	''),
(31,	'Affiliate bonus rate',	'aff_bonus_rate',	'0.10',	'/^([0-9]{1,3}\\.[0-9]{1,3}|[0-9]{1,3})$/'),
(32,	'Affiliates System',	'affiliates_system',	'on',	'/^(on|off)$/'),
(33,	'PayPal API Public key',	'paypal_api_key',	'',	''),
(34,	'PayPal API Secret key',	'paypal_api_pass',	'',	''),
(35,	'PayPal Payment Mode',	'paypal_mode',	'sandbox',	'/^(sandbox|live)$/'),
(36,	'Site currency',	'site_currency',	'usd',	' \r\n/^([a-zA-Z]){2,7}$/'),
(37,	'Advertising system',	'advertising_system',	'on',	'/^(on|off)$/'),
(38,	'Ad conversion rate',	'ad_conversion_rate',	'0.05',	'/^([0-9]{1,3}\\.[0-9]{1,3}|[0-9]{1,3})$/'),
(39,	'Max post length',	'max_post_len',	'200',	'/^[0-9]{1,11}$/'),
(40,	'Google oAuth',	'google_oauth',	'off',	'/^(on|off)$/'),
(41,	'Twitter oAuth',	'twitter_oauth',	'off',	'/^(on|off)$/'),
(42,	'Facebook oAuth',	'facebook_oauth',	'off',	'/^(on|off)$/'),
(43,	'Google ads (Horiz-banner)',	'google_ad_horiz',	'',	''),
(44,	'Google ads (Vert-banner)',	'google_ad_vert',	'',	''),
(45,	'Default country',	'country_id',	'1',	'/^[0-9]{1,11}$/'),
(46,	'Firebase API key',	'firebase_api_key',	'',	''),
(47,	'Push notifications',	'push_notifs',	'on',	'/^(on|off)$/'),
(48,	'Page update interval',	'page_update_interval',	'30',	'/^[0-9]{1,11}$/'),
(49,	'Chat update interval',	'chat_update_interval',	'5',	'/^[0-9]{1,11}$/'),
(50,	'Amazon S3 storage',	'as3_storage',	'off',	'/^(on|off)$/'),
(51,	'AS3 bucket name',	'as3_bucket_name',	'',	''),
(52,	'Amazon S3 API key',	'as3_api_key',	'',	''),
(53,	'Amazon S3 API secret key',	'as3_api_secret_key',	'',	''),
(54,	'AS3 bucket region',	'as3_bucket_region',	'us-east-1',	''),
(55,	'Max upload size',	'max_upload_size',	'2097152',	'/^[0-9]{1,11}$/'),
(56,	'Max post audio record length',	'post_arec_length',	'30',	'/^[0-9]{1,11}$/'),
(57,	'Wallet topup min amount',	'wallet_min_amount',	'50',	'/^([0-9]{1,3}\\.[0-9]{1,3}|[0-9]{1,3})$/'),
(58,	'',	'',	'',	''),
(59,	'Currency symbol position',	'currency_symbol_pos',	'after',	'/^(before|after)$/'),
(60,	'Aff payout min amount',	'aff_payout_min',	'50',	'/^([0-9]{1,3}\\\\.[0-9]{1,3}|[0-9]{1,3})$/'),
(61,	'Default color scheme',	'default_color_scheme',	'purple',	''),
(62,	'Default BG color',	'default_bg_color',	'default',	''),
(63,	'Android app (Google play item URL)',	'android_app_url',	'',	''),
(64,	'IOS app (App store item URL)',	'ios_app_url',	'',	''),
(65,	'User registration system',	'user_signup',	'on',	'/^(on|off)$/'),
(66,	'Cookie warning popup',	'cookie_warning_popup',	'off',	'/^(on|off)$/'),
(67,	'Google reCAPTCHA',	'google_recaptcha',	'off',	'/^(on|off)$/'),
(68,	'Google reCAPTCHA Sitekey',	'google_recap_key1',	'',	''),
(69,	'Google reCAPTCHA Secret key',	'google_recap_key2',	'',	''),
(70,	'E-Mail notifications',	'email_notifications',	'off',	'/^(on|off)$/'),
(71,	'Swifts system status (Daily stories)',	'swift_system_status',	'off',	'/^(on|off)$/'),
(72,	'PayPal Payment Status',	'paypal_method_status',	'on',	'/^(on|off)$/'),
(73,	'PayStack API Public key',	'paystack_api_key',	'',	''),
(74,	'Paystack API Secret key',	'paystack_api_pass',	'',	''),
(75,	'Paystack Payment Status',	'paystack_method_status',	'on',	'/^(on|off)$/'),
(76,	'Stripe API Secret key',	'stripe_api_pass',	'',	''),
(77,	'Stripe API Public key',	'stripe_api_key',	'',	''),
(78,	'Stripe Payment Status',	'stripe_method_status',	'on',	'/^(on|off)$/'),
(79,	'AliPay Payment Status',	'alipay_method_status',	'on',	'/^(on|off)$/');

DROP TABLE IF EXISTS `cl_connections`;
CREATE TABLE `cl_connections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `follower_id` int NOT NULL DEFAULT '0',
  `following_id` int NOT NULL DEFAULT '0',
  `status` enum('active','pending') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'active',
  `time` varchar(25) NOT NULL DEFAULT '25',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_connections` (`id`, `follower_id`, `following_id`, `status`, `time`) VALUES
(2,	1,	2,	'active',	'1650587557'),
(3,	3,	1,	'active',	'1650588239'),
(4,	3,	2,	'active',	'1650588240'),
(6,	4,	3,	'active',	'1650603388');

SET NAMES utf8;

DROP TABLE IF EXISTS `cl_hashtags`;
CREATE TABLE `cl_hashtags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `posts` int NOT NULL DEFAULT '0',
  `tag` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_hashtags` (`id`, `posts`, `tag`, `time`) VALUES
(3,	1,	'lol',	'1650602919');

DROP TABLE IF EXISTS `cl_invite_links`;
CREATE TABLE `cl_invite_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `role` set('user','admin') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'user',
  `mnu` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `expires_at` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `registered_users` int NOT NULL DEFAULT '0',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_invite_links` (`id`, `code`, `role`, `mnu`, `expires_at`, `registered_users`, `time`) VALUES
(1,	'75e86c5575529b6a36961fa261233071c97a5ed7165060250853d1374d20dddf59dc391518b4b44298',	'user',	'1000',	'1650688908',	0,	'1650602508');

DROP TABLE IF EXISTS `cl_messages`;
CREATE TABLE `cl_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sent_by` int NOT NULL DEFAULT '0',
  `sent_to` int NOT NULL DEFAULT '0',
  `owner` int NOT NULL DEFAULT '0',
  `message` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `media_file` varchar(1000) NOT NULL DEFAULT '',
  `media_type` varchar(25) NOT NULL DEFAULT 'none',
  `seen` varchar(25) NOT NULL DEFAULT '0',
  `deleted_fs1` enum('Y','N') NOT NULL DEFAULT 'N',
  `deleted_fs2` enum('Y','N') NOT NULL DEFAULT 'N',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_notifications`;
CREATE TABLE `cl_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notifier_id` int NOT NULL DEFAULT '0',
  `recipient_id` int NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `subject` varchar(32) NOT NULL DEFAULT 'none',
  `entry_id` int NOT NULL DEFAULT '0',
  `json` varchar(1200) NOT NULL DEFAULT '[]',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_notifications` (`id`, `notifier_id`, `recipient_id`, `status`, `subject`, `entry_id`, `json`, `time`) VALUES
(2,	1,	2,	'1',	'subscribe',	1,	'[]',	'1650587557'),
(5,	3,	2,	'1',	'subscribe',	3,	'[]',	'1650588240'),
(6,	3,	2,	'1',	'repost',	1,	'[]',	'1650588282'),
(7,	1,	2,	'1',	'repost',	1,	'[]',	'1650589225'),
(8,	4,	2,	'0',	'subscribe',	4,	'[]',	'1650608175'),
(9,	4,	3,	'0',	'subscribe',	4,	'[]',	'1650603388'),
(10,	4,	1,	'0',	'subscribe',	4,	'[]',	'1650603389'),
(11,	4,	2,	'1',	'reply',	5,	'[]',	'1650603564'),
(14,	4,	1,	'0',	'reply',	7,	'[]',	'1650605368'),
(15,	4,	2,	'1',	'repost',	1,	'[]',	'1650598458');

DROP TABLE IF EXISTS `cl_posts`;
CREATE TABLE `cl_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `publication_id` int NOT NULL DEFAULT '0',
  `type` enum('post','repost') NOT NULL DEFAULT 'post',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_posts` (`id`, `user_id`, `publication_id`, `type`, `time`) VALUES
(1,	2,	1,	'post',	'1650587479'),
(3,	3,	1,	'repost',	'1650588282'),
(5,	1,	3,	'post',	'1650589134'),
(6,	1,	1,	'repost',	'1650589225'),
(12,	4,	1,	'repost',	'1650598458'),
(13,	4,	9,	'post',	'1650602919');

DROP TABLE IF EXISTS `cl_profile_reports`;
CREATE TABLE `cl_profile_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `profile_id` int NOT NULL DEFAULT '0',
  `reason` int NOT NULL DEFAULT '0',
  `comment` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `seen` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_pub_reports`;
CREATE TABLE `cl_pub_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `post_id` int NOT NULL DEFAULT '0',
  `reason` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `seen` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `comment` varchar(1210) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_publications`;
CREATE TABLE `cl_publications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `type` enum('text','video','image','gif','poll','audio') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'text',
  `replys_count` int NOT NULL DEFAULT '0',
  `reposts_count` int NOT NULL DEFAULT '0',
  `likes_count` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive','deleted','orphan') NOT NULL DEFAULT 'active',
  `thread_id` int NOT NULL DEFAULT '0',
  `target` enum('publication','pub_reply') NOT NULL DEFAULT 'publication',
  `og_data` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `poll_data` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `priv_wcs` enum('everyone','followers') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `priv_wcr` enum('everyone','followers','mentioned') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `time` varchar(25) NOT NULL DEFAULT '0',
  `edited` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_publications` (`id`, `user_id`, `text`, `type`, `replys_count`, `reposts_count`, `likes_count`, `status`, `thread_id`, `target`, `og_data`, `poll_data`, `priv_wcs`, `priv_wcr`, `time`, `edited`) VALUES
(1,	2,	'hello!',	'text',	1,	3,	1,	'active',	0,	'publication',	'',	NULL,	'everyone',	'everyone',	'1650587479',	'0'),
(3,	1,	'👍👍',	'text',	1,	0,	0,	'active',	0,	'publication',	'',	NULL,	'everyone',	'everyone',	'1650589134',	'0'),
(5,	4,	'test',	'text',	0,	0,	0,	'active',	1,	'pub_reply',	'',	NULL,	'everyone',	'everyone',	'1650603564',	'0'),
(7,	4,	'',	'image',	0,	0,	0,	'active',	3,	'pub_reply',	'',	NULL,	'everyone',	'everyone',	'1650605368',	'0'),
(9,	4,	'{#id:3#}',	'text',	0,	0,	0,	'active',	0,	'publication',	'',	NULL,	'everyone',	'everyone',	'1650602919',	'0');

DROP TABLE IF EXISTS `cl_publikes`;
CREATE TABLE `cl_publikes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pub_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_publikes` (`id`, `pub_id`, `user_id`, `time`) VALUES
(1,	1,	2,	'1650587484');

DROP TABLE IF EXISTS `cl_pubmedia`;
CREATE TABLE `cl_pubmedia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pub_id` int NOT NULL DEFAULT '0',
  `type` enum('image','video','gif','audio') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `src` varchar(1200) NOT NULL DEFAULT '',
  `json_data` varchar(3000) NOT NULL DEFAULT '[]',
  `time` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_pubmedia` (`id`, `pub_id`, `type`, `src`, `json_data`, `time`) VALUES
(2,	7,	'image',	'upload/images/2022/04/8txEVoP7366CCB8MuAKI_22_53c144eff57a4d399853e074586c07e9_image_original.jpeg',	'{\n    \"image_thumb\": \"upload\\/images\\/2022\\/04\\/ansEy9dwGdwm9PjHJkj2_22_53c144eff57a4d399853e074586c07e9_image_300x300.jpeg\"\n}',	'1650605365');

DROP TABLE IF EXISTS `cl_sessions`;
CREATE TABLE `cl_sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(120) NOT NULL DEFAULT '',
  `user_id` varchar(11) NOT NULL DEFAULT '0',
  `platform` varchar(15) NOT NULL DEFAULT 'web',
  `time` varchar(25) NOT NULL DEFAULT '0',
  `lifespan` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_sessions` (`id`, `session_id`, `user_id`, `platform`, `time`, `lifespan`) VALUES
(1,	'bb464e3286587c54d9fe733810b6f1c6014b4e1d1650587455386583ece406f404ebc1b813dfb44764',	'2',	'web',	'1650587455',	'1682123455'),
(2,	'e0b99f9e60ecec60151b1062fdc5f8a98e1db03616505875522324c4f52daeb35301dbad702cf77655',	'1',	'web',	'1650587552',	'1682123552'),
(4,	'f91f8cd85b9e292d38e8a3e3d676262fd25f17a21650588434424663c5f1a5d434d46812a316f0f904',	'1',	'web',	'1650588434',	'1682124434'),
(20,	'b74769777f984aa65a0789e45f3bf63ebece7c7b1650607500d9248689104129db9a352c7e026c1c0a',	'4',	'web',	'1650607500',	'1682143500'),
(22,	'29750f6fa333bf80e0a4087789ce9b32212c105d16506615035684b2087f25a609d34e01da4b13a56e',	'4',	'web',	'1650661503',	'1682197503');

DROP TABLE IF EXISTS `cl_ui_langs`;
CREATE TABLE `cl_ui_langs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `slug` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` set('1','0') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `is_rtl` set('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `is_native` set('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_ui_langs` (`id`, `name`, `slug`, `status`, `is_rtl`, `is_native`) VALUES
(1,	'English',	'english',	'1',	'N',	'1'),
(2,	'French',	'french',	'1',	'N',	'1'),
(3,	'German',	'german',	'1',	'N',	'1'),
(4,	'Italian',	'italian',	'1',	'N',	'1'),
(5,	'Russian',	'russian',	'1',	'N',	'1'),
(6,	'Portuguese',	'portuguese',	'1',	'N',	'1'),
(7,	'Spanish',	'spanish',	'1',	'N',	'1'),
(8,	'Turkish',	'turkish',	'1',	'N',	'1'),
(9,	'Dutch',	'dutch',	'1',	'N',	'1'),
(10,	'Ukraine',	'ukraine',	'1',	'N',	'1'),
(11,	'Arabic',	'arabic',	'1',	'Y',	'1');

DROP TABLE IF EXISTS `cl_users`;
CREATE TABLE `cl_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `fname` varchar(30) NOT NULL DEFAULT '',
  `lname` varchar(30) NOT NULL DEFAULT '',
  `about` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `gender` enum('M','F','T','O') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'M',
  `email` varchar(60) NOT NULL DEFAULT '',
  `em_code` varchar(100) NOT NULL DEFAULT '',
  `email_conf_code` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `password` varchar(140) NOT NULL DEFAULT '',
  `joined` varchar(20) NOT NULL DEFAULT '0',
  `start_up` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'done',
  `last_active` varchar(20) NOT NULL DEFAULT '0',
  `ip_address` varchar(140) NOT NULL DEFAULT '0.0.0.0',
  `language` varchar(32) NOT NULL DEFAULT 'default',
  `avatar` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/avatar-1.png',
  `cover` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/cover-1.png',
  `cover_orig` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/cover-1.png',
  `active` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `verified` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `admin` enum('0','1') NOT NULL DEFAULT '0',
  `posts` int NOT NULL DEFAULT '0',
  `followers` int NOT NULL DEFAULT '0',
  `following` int NOT NULL DEFAULT '0',
  `website` varchar(120) NOT NULL DEFAULT '',
  `country_id` int NOT NULL DEFAULT '1',
  `city` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_post` int NOT NULL DEFAULT '0',
  `last_swift` varchar(135) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_ad` int NOT NULL DEFAULT '0',
  `profile_privacy` enum('everyone','followers') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `follow_privacy` enum('everyone','approved') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `contact_privacy` enum('everyone','followed') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `index_privacy` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y',
  `aff_bonuses` int NOT NULL DEFAULT '0',
  `wallet` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `pnotif_token` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{"token": "","type": "android"}',
  `refresh_token` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `settings` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{"notifs":{"like":1,"subscribe":1,"subscribe_request":1,"subscribe_accept":1,"reply":1,"repost":1,"mention":1},"enotifs":{"like":0,"subscribe":0,"subscribe_request":0,"subscribe_accept":0,"reply":0,"repost":0,"mention":0}}',
  `display_settings` varchar(1200) NOT NULL DEFAULT '{"color_scheme": "default","background": "default"}',
  `swift` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `swift_update` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `info_file` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `posts` (`posts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `cl_users` (`id`, `username`, `fname`, `lname`, `about`, `gender`, `email`, `em_code`, `email_conf_code`, `password`, `joined`, `start_up`, `last_active`, `ip_address`, `language`, `avatar`, `cover`, `cover_orig`, `active`, `verified`, `admin`, `posts`, `followers`, `following`, `website`, `country_id`, `city`, `last_post`, `last_swift`, `last_ad`, `profile_privacy`, `follow_privacy`, `contact_privacy`, `index_privacy`, `aff_bonuses`, `wallet`, `pnotif_token`, `refresh_token`, `settings`, `display_settings`, `swift`, `swift_update`, `info_file`) VALUES
(1,	'Admin',	'Site',	'Admin',	'',	'M',	'realemail@aol.com',	'',	'0',	'$2y$10$C6fBjOxaUqSqLHTu6B7oXOagLTos9/neNsyjrJgBYKage/UH9jd6u',	'1650586829',	'done',	'1650589946',	'127.0.0.1',	'english',	'upload/default/avatar-1.png',	'upload/default/cover-1.png',	'upload/default/cover-1.png',	'1',	'0',	'1',	1,	1,	1,	'',	1,	'',	0,	'',	1,	'everyone',	'everyone',	'followed',	'Y',	0,	'0.00',	'{\"token\": \"\",\"type\": \"android\"}',	'0',	'{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',	'{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\"\n}',	NULL,	'0',	''),
(2,	'urgaylol',	'urgaylol',	'',	'',	'M',	'urgaylol@aol.com',	'ad3b72af3388a1bece39c310d4f11202422f55b8',	'0',	'$2y$10$3TXr25hHhYCizyl1mbGpU..pfOQM/7cgIOeizSy2EoacO0dLWJh8W',	'1650587455',	'{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}',	'1650603367',	'127.0.0.1',	'english',	'upload/default/avatar-5.png',	'upload/default/cover-5.png',	'upload/default/cover-5.png',	'1',	'1',	'0',	1,	2,	0,	'',	1,	'',	0,	'',	3,	'everyone',	'everyone',	'everyone',	'Y',	0,	'0.00',	'{\"token\": \"\",\"type\": \"android\"}',	'0',	'{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',	'{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\"\n}',	NULL,	'0',	''),
(3,	'lolana',	'lolana',	'',	'',	'M',	'emaaia@aol.com',	'6ed15189e24ed1a2e20b6f817072c67f6143ea06',	'0',	'$2y$10$hKfnFb1C.c4I7XuM.FVXgutzko7pMyA7ZBTlyAD9t.gUFI8n9BJDi',	'1650588199',	'{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}',	'1650588300',	'127.0.0.1',	'english',	'upload/default/avatar-3.png',	'upload/default/cover-3.png',	'upload/default/cover-3.png',	'1',	'0',	'0',	0,	1,	2,	'',	1,	'',	0,	'',	0,	'everyone',	'everyone',	'everyone',	'Y',	0,	'0.00',	'{\"token\": \"\",\"type\": \"android\"}',	'0',	'{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',	'{\n    \"color_scheme\": \"purple\",\n    \"background\": \"dark\"\n}',	NULL,	'0',	''),
(4,	'itsme',	'itsme',	'',	'its me',	'M',	'itsmeitsme@aol.com',	'2e163bf958d43190cdd051a6888a18eafdad860d',	'0',	'$2y$10$0ayF1hp4gCu0qdRsYgj7o.edtbYaiqSLnQAd5M7QsSFDlE9hiG.7S',	'1650603316',	'{\r\n    \"source\": \"system\",\r\n    \"avatar\": 0,\r\n    \"info\": 0,\r\n    \"follow\": 0\r\n}',	'1650661982',	'127.0.0.1',	'english',	'upload/avatars/2022/04/kTByCtNkM61ZgEHzOu2X_22_e0f399cc1cd3ab9287ef507683ae936c_thumbnail_512x512.jpeg',	'upload/covers/2022/04/UfrjUnCpbujGQqyTmaBw_22_aa37d07ff1d7155b2aecae0613718c35_image_cover_600x200.jpeg',	'upload/covers/2022/04/UfrjUnCpbujGQqyTmaBw_22_aa37d07ff1d7155b2aecae0613718c35_image_cover.jpeg',	'1',	'0',	'1',	1,	0,	1,	'http://slol.com',	1,	'',	0,	'',	4,	'everyone',	'everyone',	'everyone',	'Y',	0,	'5000000',	'{\"token\": \"\",\"type\": \"android\"}',	'0',	'{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',	'{\n    \"color_scheme\": \"purple\",\n    \"background\": \"default\"\n}',	NULL,	'0',	'');

DROP TABLE IF EXISTS `cl_verifications`;
CREATE TABLE `cl_verifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `full_name` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `text_message` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `video_message` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `cl_wallet_history`;
CREATE TABLE `cl_wallet_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `operation` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `amount` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `json_data` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `copy_cl_users`;
CREATE TABLE `copy_cl_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `fname` varchar(30) NOT NULL DEFAULT '',
  `lname` varchar(30) NOT NULL DEFAULT '',
  `about` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `gender` enum('M','F','T','O') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'M',
  `email` varchar(60) NOT NULL DEFAULT '',
  `em_code` varchar(100) NOT NULL DEFAULT '',
  `email_conf_code` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `password` varchar(140) NOT NULL DEFAULT '',
  `joined` varchar(20) NOT NULL DEFAULT '0',
  `start_up` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'done',
  `last_active` varchar(20) NOT NULL DEFAULT '0',
  `ip_address` varchar(140) NOT NULL DEFAULT '0.0.0.0',
  `language` varchar(32) NOT NULL DEFAULT 'default',
  `avatar` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/avatar-1.png',
  `cover` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/cover-1.png',
  `cover_orig` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'upload/default/cover-1.png',
  `active` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `verified` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `admin` enum('0','1') NOT NULL DEFAULT '0',
  `posts` int NOT NULL DEFAULT '0',
  `followers` int NOT NULL DEFAULT '0',
  `following` int NOT NULL DEFAULT '0',
  `website` varchar(120) NOT NULL DEFAULT '',
  `country_id` int NOT NULL DEFAULT '1',
  `city` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_post` int NOT NULL DEFAULT '0',
  `last_swift` varchar(135) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_ad` int NOT NULL DEFAULT '0',
  `profile_privacy` enum('everyone','followers') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `follow_privacy` enum('everyone','approved') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `contact_privacy` enum('everyone','followed') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'everyone',
  `index_privacy` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y',
  `aff_bonuses` int NOT NULL DEFAULT '0',
  `wallet` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `pnotif_token` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{"token": "","type": "android"}',
  `refresh_token` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `settings` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{"notifs":{"like":1,"subscribe":1,"subscribe_request":1,"subscribe_accept":1,"reply":1,"repost":1,"mention":1},"enotifs":{"like":0,"subscribe":0,"subscribe_request":0,"subscribe_accept":0,"reply":0,"repost":0,"mention":0}}',
  `display_settings` varchar(1200) NOT NULL DEFAULT '{"color_scheme": "default","background": "default"}',
  `swift` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `swift_update` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `info_file` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `posts` (`posts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `copy_cl_users` (`id`, `username`, `fname`, `lname`, `about`, `gender`, `email`, `em_code`, `email_conf_code`, `password`, `joined`, `start_up`, `last_active`, `ip_address`, `language`, `avatar`, `cover`, `cover_orig`, `active`, `verified`, `admin`, `posts`, `followers`, `following`, `website`, `country_id`, `city`, `last_post`, `last_swift`, `last_ad`, `profile_privacy`, `follow_privacy`, `contact_privacy`, `index_privacy`, `aff_bonuses`, `wallet`, `pnotif_token`, `refresh_token`, `settings`, `display_settings`, `swift`, `swift_update`, `info_file`) VALUES
(1,	'Admin',	'Site',	'Admin',	'',	'M',	'realemail@aol.com',	'',	'0',	'$2y$10$C6fBjOxaUqSqLHTu6B7oXOagLTos9/neNsyjrJgBYKage/UH9jd6u',	'1650586829',	'done',	'1650589946',	'127.0.0.1',	'english',	'upload/default/avatar-1.png',	'upload/default/cover-1.png',	'upload/default/cover-1.png',	'1',	'0',	'1',	1,	1,	1,	'',	1,	'',	0,	'',	1,	'everyone',	'everyone',	'followed',	'Y',	0,	'0.00',	'{\"token\": \"\",\"type\": \"android\"}',	'0',	'{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',	'{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\"\n}',	NULL,	'0',	''),
(2,	'urgaylol',	'urgaylol',	'',	'',	'M',	'urgaylol@aol.com',	'ad3b72af3388a1bece39c310d4f11202422f55b8',	'0',	'$2y$10$3TXr25hHhYCizyl1mbGpU..pfOQM/7cgIOeizSy2EoacO0dLWJh8W',	'1650587455',	'{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}',	'1650603367',	'127.0.0.1',	'english',	'upload/default/avatar-5.png',	'upload/default/cover-5.png',	'upload/default/cover-5.png',	'1',	'1',	'0',	1,	2,	0,	'',	1,	'',	0,	'',	3,	'everyone',	'everyone',	'everyone',	'Y',	0,	'0.00',	'{\"token\": \"\",\"type\": \"android\"}',	'0',	'{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',	'{\n    \"color_scheme\": \"default\",\n    \"background\": \"default\"\n}',	NULL,	'0',	''),
(3,	'lolana',	'lolana',	'',	'',	'M',	'emaaia@aol.com',	'6ed15189e24ed1a2e20b6f817072c67f6143ea06',	'0',	'$2y$10$hKfnFb1C.c4I7XuM.FVXgutzko7pMyA7ZBTlyAD9t.gUFI8n9BJDi',	'1650588199',	'{\n    \"source\": \"system\",\n    \"avatar\": 0,\n    \"info\": 0,\n    \"follow\": 0\n}',	'1650588300',	'127.0.0.1',	'english',	'upload/default/avatar-3.png',	'upload/default/cover-3.png',	'upload/default/cover-3.png',	'1',	'0',	'0',	0,	1,	2,	'',	1,	'',	0,	'',	0,	'everyone',	'everyone',	'everyone',	'Y',	0,	'0.00',	'{\"token\": \"\",\"type\": \"android\"}',	'0',	'{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',	'{\n    \"color_scheme\": \"purple\",\n    \"background\": \"dark\"\n}',	NULL,	'0',	''),
(4,	'itsme',	'itsme',	'',	'its me',	'M',	'itsmeitsme@aol.com',	'2e163bf958d43190cdd051a6888a18eafdad860d',	'0',	'$2y$10$0ayF1hp4gCu0qdRsYgj7o.edtbYaiqSLnQAd5M7QsSFDlE9hiG.7S',	'1650603316',	'{\r\n    \"source\": \"system\",\r\n    \"avatar\": 0,\r\n    \"info\": 0,\r\n    \"follow\": 0\r\n}',	'1650661982',	'127.0.0.1',	'english',	'upload/avatars/2022/04/kTByCtNkM61ZgEHzOu2X_22_e0f399cc1cd3ab9287ef507683ae936c_thumbnail_512x512.jpeg',	'upload/covers/2022/04/UfrjUnCpbujGQqyTmaBw_22_aa37d07ff1d7155b2aecae0613718c35_image_cover_600x200.jpeg',	'upload/covers/2022/04/UfrjUnCpbujGQqyTmaBw_22_aa37d07ff1d7155b2aecae0613718c35_image_cover.jpeg',	'1',	'0',	'1',	1,	0,	1,	'http://slol.com',	1,	'',	0,	'',	4,	'everyone',	'everyone',	'everyone',	'Y',	0,	'5000000',	'{\"token\": \"\",\"type\": \"android\"}',	'0',	'{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1},\"enotifs\":{\"like\":0,\"subscribe\":0,\"subscribe_request\":0,\"subscribe_accept\":0,\"reply\":0,\"repost\":0,\"mention\":0}}',	'{\n    \"color_scheme\": \"purple\",\n    \"background\": \"default\"\n}',	NULL,	'0',	'');

DROP TABLE IF EXISTS `copy_cl_verifications`;
CREATE TABLE `copy_cl_verifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `full_name` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `text_message` varchar(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `video_message` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `copy_cl_wallet_history`;
CREATE TABLE `copy_cl_wallet_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `operation` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `amount` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0.00',
  `json_data` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]',
  `time` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2022-04-22 21:13:56
