<?php 
# @*************************************************************************@
# @ Software author: Mansur Altamirov (Mansur_TL)							@
# @ Author_url 1: https://www.instagram.com/mansur_tl                       @
# @ Author_url 2: http://codecanyon.net/user/mansur_tl                      @
# @ Author E-mail: vayart.help@gmail.com                                    @
# @*************************************************************************@
# @ ColibriSM - The Ultimate Modern Social Media Sharing Platform           @
# @ Copyright (c) 2020 - 2021 ColibriSM. All rights reserved.               @
# @*************************************************************************@

require_once(cl_full_path('core/libs/paypal/vendor/autoload.php'));

$paypal_conf = array(
 	"secret_key"      => $cl['config']['paypal_api_key'],
 	"publishable_key" => $cl['config']['paypal_api_pass']
);

$paypal_creds = new \PayPal\Auth\OAuthTokenCredential($cl['config']['paypal_api_key'], $cl['config']['paypal_api_pass']);
$paypal       = new \PayPal\Rest\ApiContext($paypal_creds);

$paypal->setConfig(array(
	'mode' => $cl['config']['paypal_mode']
));

