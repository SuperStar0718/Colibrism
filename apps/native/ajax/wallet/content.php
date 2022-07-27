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
}

else if($action == 'topup_wallet') {
    $data['status']   = 400;
    $data['err_code'] = 0;
    $topup_amount     = fetch_or_get($_POST['amount'], false);
    $topup_method     = fetch_or_get($_POST['method'], false);
    $topup_min_amount = intval($cl["config"]["wallet_min_amount"]);

    if (empty($topup_amount) || is_numeric($topup_amount) != true) {
        $data['err_code'] = 'invalid_topup_amount';
    }

    else if ($topup_amount < $topup_min_amount || $topup_amount > 15000) {
        $data['err_code'] = 'invalid_topup_amount';
    }

    else if (empty($topup_method) || in_array($topup_method, array("paypal", "stripe", "paystack", "stripe_alipay")) != true) {
        $data['err_code'] = 'invalid_topup_method';
    }

    else {
        if ($topup_method == "paypal" && $cl['config']['paypal_method_status'] == 'on') {

            try {
                require_once("core/libs/configs/paypal.php");

                $currency       = strtoupper($cl['config']['site_currency']);
                $payer          = new \PayPal\Api\Payer();
                $itemList       = new \PayPal\Api\ItemList();
                $details        = new \PayPal\Api\Details();
                $amount         = new \PayPal\Api\Amount();
                $transaction    = new \PayPal\Api\Transaction();
                $redirectUrls   = new \PayPal\Api\RedirectUrls();
                $payment        = new \PayPal\Api\Payment();
                $line_item      = new \PayPal\Api\Item();
                $inputFields    = new \PayPal\Api\InputFields();
                $webProfile     = new \PayPal\Api\WebProfile();
                $payer          = $payer->setPaymentMethod('paypal');
                $subtotal       = $topup_amount;
                $url_success    = cl_link("native_api/wallet/pgw1_wallet_tup_success");
                $url_cancel     = cl_link("native_api/wallet/pgw1_wallet_tup_cancel");
                $inputFields    = $inputFields->setAllowNote(true);
                $inputFields    = $inputFields->setNoShipping(1);
                $inputFields    = $inputFields->setAddressOverride(0);
                $webProfile     = $webProfile->setName(uniqid());
                $webProfile     = $webProfile->setInputFields($inputFields);
                $webProfile     = $webProfile->setTemporary(true);
                $createProfile  = $webProfile->create($paypal);
                $profileID      = $createProfile->getId();
                $payment        = $payment->setExperienceProfileId($profileID); 
                $redirectUrls   = $redirectUrls->setReturnUrl($url_success);
                $redirectUrls   = $redirectUrls->setCancelUrl($url_cancel); 
                $line_item      = $line_item->setName(cl_translate('Top up your account balance'));
                $line_item      = $line_item->setQuantity(1);
                $line_item      = $line_item->setPrice($topup_amount);
                $line_item      = $line_item->setCurrency($currency);
                $itemList       = $itemList->setItems(array($line_item)); 
                $details        = $details->setSubtotal($subtotal);
                $amount         = $amount->setCurrency($currency);
                $amount         = $amount->setTotal($subtotal);
                $amount         = $amount->setDetails($details);
                $transaction    = $transaction->setAmount($amount);
                $transaction    = $transaction->setItemList($itemList);
                $transaction    = $transaction->setDescription(cl_translate('Pay to: {@site_name@}', array('site_name' => $cl['config']['name'])));
                $transaction    = $transaction->setInvoiceNumber(time());
                $payment        = $payment->setIntent('sale');
                $payment        = $payment->setPayer($payer);
                $payment        = $payment->setRedirectUrls($redirectUrls);
                $payment        = $payment->setTransactions(array($transaction));
                $payment        = $payment->create($paypal);
                $data['url']    = $payment->getApprovalLink();
                $data['status'] = 200;
                
                cl_session('tup_amount', $topup_amount);
            }

            catch (Exception $ex) {
                $data['status']  = 500;
                $data['message'] = $ex->getMessage();
            }
        }

        else if($topup_method == "paystack" && $cl['config']['paystack_method_status'] == 'on') {
            try {
                require_once(cl_full_path("core/libs/PayStack-PHP/vendor/autoload.php"));

                $paystack       = new \Yabacon\Paystack($cl["config"]["paystack_api_pass"]);
                $reference      = sha1(microtime());
                $tranx          = $paystack->transaction->initialize([
                    'amount'    => ($topup_amount * 100),
                    'email'     => $me["email"],
                    'reference' => $reference,
                    'callback'  => cl_link("native_api/wallet/pgw2_wallet_tup_verification"),
                    'currency'  => strtoupper($cl['config']['site_currency'])
                ]);

                cl_session('paystack_reference', $reference);
                cl_session('tup_amount', $topup_amount);

                $data['url']    = $tranx->data->authorization_url;
                $data['status'] = 200;
            }

            catch(Exception $ex){
                $data['status']  = 500;
                $data['message'] = $ex->getMessage();
            }
        }

        else if(in_array($topup_method, array("stripe", "stripe_alipay")) && $cl['config']['stripe_method_status'] == 'on') {
            try {
                require_once(cl_full_path("core/libs/Stripe/vendor/autoload.php"));

                $stripe_methods = array("stripe" => "card", "stripe_alipay" => "alipay");
                $stripe         = new \Stripe\StripeClient($cl["config"]["stripe_api_pass"]);
                $stripe_session = $stripe->checkout->sessions->create(array(
                    "payment_method_types" => array($stripe_methods[$topup_method]),
                    "success_url"          => cl_link("native_api/wallet/pgw3_wallet_tup_success"),
                    "cancel_url"           => cl_link("wallet"),
                    "line_items"           => array(
                        array(
                            "name"      => cl_translate('Top up your account balance'),
                            "currency"  => strtoupper($cl["config"]["site_currency"]),
                            "amount"    => ($topup_amount * 100),
                            "quantity"  => 1
                        )
                    )
                ));

                if (not_empty($stripe_session)) {
                    $data["status"]  = 200;
                    $data["sess_id"] = $stripe_session->id;

                    cl_session('stripe_session', $data["sess_id"]);
                    cl_session('tup_amount', $topup_amount);
                }
            }

            catch(Exception $ex){
                $data['status']  = 500;
                $data['message'] = $ex->getMessage();
            }
        }
    }
}

else if($action == 'pgw1_wallet_tup_success') {
    if (not_empty($_GET['paymentId']) && not_empty($_GET['token']) && not_empty($_GET['PayerID'])) {
        try{

            require_once("core/libs/configs/paypal.php");

            $paym_id    = fetch_or_get($_GET['paymentId'], false);
            $paym_tok   = fetch_or_get($_GET['token'], false);
            $payer_id   = fetch_or_get($_GET['PayerID'], false);
            $payment    = \PayPal\Api\Payment::get($paym_id, $paypal);
            $execute    = new \PayPal\Api\PaymentExecution();
            $execute    = $execute->setPayerId($payer_id);
            $tup_amount = cl_session('tup_amount');

            if ($tup_amount) {
                $result = $payment->execute($execute, $paypal);
                
                cl_update_user_data($me['id'], array(
                    'wallet' => ($me['wallet'] += $tup_amount)
                ));

                cl_db_insert(T_WALLET_HISTORY, array(
                    'user_id'   => $me['id'],
                    'operation' => 'paypal_wallet_tup',
                    'amount'    => $tup_amount,
                    'json_data' => json(array(
                        'paypal_pid' => $result->id
                    ), true),
                    'time' => time()
                ));

                cl_session_unset('tup_amount');

                cl_redirect('wallet');
            }
            else {
                throw new Exception('The current payment is duplicated of already processed payment. Please check your details');
            }
        }

        catch (Exception $e) {
            cl_session_unset('tup_amount');

            cl_session('err500_message', array(
                'title' => "Transaction failed!",
                'desc' => $e->getMessage()
            ));

            cl_redirect('500');
        }
    }
}

else if($action == 'pgw1_wallet_tup_cancel') {
    cl_session_unset('tup_amount');
    cl_redirect('wallet');
}

else if($action == 'pgw2_wallet_tup_verification') {
    if (not_empty($_GET['reference'])) {

        try{
            $reference1 = fetch_or_get($_GET['reference'], false);
            $tup_amount = cl_session('tup_amount');
            $reference2 = cl_session('paystack_reference');

            if ($tup_amount && ($reference1 == $reference2)) {
                
                require_once(cl_full_path("core/libs/PayStack-PHP/vendor/autoload.php"));

                $paystack = new \Yabacon\Paystack($cl["config"]["paystack_api_pass"]);
                $tranx    = $paystack->transaction->verify(array(
                    'reference' => $reference1
                ));
                
                cl_update_user_data($me['id'], array(
                    'wallet' => ($me['wallet'] += $tup_amount)
                ));

                cl_db_insert(T_WALLET_HISTORY, array(
                    'user_id'   => $me['id'],
                    'operation' => 'paystack_wallet_tup',
                    'amount'    => $tup_amount,
                    'json_data' => json(array(
                        'paystack_ref' => $reference1
                    ), true),
                    'time' => time()
                ));

                cl_session_unset('tup_amount');
                cl_session_unset('paystack_reference');

                cl_redirect('wallet');
            }
            else {
                throw new Exception('An error occurred while processing your request. Please try again later. Please contact our support team');
            }
        }

        catch (Exception $e) {
            cl_session_unset('tup_amount');

            cl_session('err500_message', array(
                'title' => "Transaction failed!",
                'desc' => $e->getMessage()
            ));

            cl_redirect('500');
        }
    }
}

else if($action == 'pgw3_wallet_tup_success') {
    $tup_amount     = cl_session('tup_amount');
    $stripe_session = cl_session('stripe_session');

    if ($tup_amount && $stripe_session) {

        try{

            require_once(cl_full_path("core/libs/Stripe/vendor/autoload.php"));

            $stripe         = new \Stripe\StripeClient($cl["config"]["stripe_api_pass"]);
            $session_object = $stripe->checkout->sessions->retrieve($stripe_session);

            if ($session_object && not_empty($session_object->payment_status) && $session_object->payment_status == "paid") {
                cl_update_user_data($me['id'], array(
                    'wallet' => ($me['wallet'] += $tup_amount)
                ));

                cl_db_insert(T_WALLET_HISTORY, array(
                    'user_id'   => $me['id'],
                    'operation' => 'stripe_wallet_tup',
                    'amount'    => $tup_amount,
                    'json_data' => json(array(
                        'sess_id' => $session_object->id,
                        'payment_intent' => $session_object->payment_intent
                    ), true),
                    'time' => time()
                ));

                cl_session_unset('tup_amount');
                cl_session_unset('stripe_session');

                cl_redirect('wallet');
            }

        }
        catch (Exception $e) {
            cl_session_unset('tup_amount');
            cl_session_unset('stripe_session');

            cl_session('err500_message', array(
                'title' => "Transaction failed!",
                'desc' => $e->getMessage()
            ));

            cl_redirect('500');
        }
    }
}