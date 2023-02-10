<?php

//classes
$messageApi = new Messages('19f9a7a71efb969df963911f972070a2', '636906E8AAC96');
$distCalc = new Distance();
$botQuery = new BotQuery();
$bloodQr = new BloodQuery();
$driverQuery = new DriverQuery();
$businessQuery = new BusinessQuery();
$professionQuery = new ProfessionQuery();
$searchQuery = new SearchQuery();
$earnwithTown = new EarnwithTown();



//*button's */
if (!empty($buttonId)) {
    $listId = "";
    switch ($buttonId) {
        case 'register':
            $res = $botQuery->validate_user($number);
            if ($res == true) {
                $botQuery->update_query($number, $buttonId, $listId);
            } else {
                $botQuery->insert_user($number, $buttonId);
            }
            break;


        case 'search':
            $res = $botQuery->validate_user($number);
            if ($res == true) {
                $botQuery->update_query($number, $buttonId, $listId);
            } else {
                $botQuery->insert_user($number, $buttonId);
            }
            break;


        case 'play_whatsapp_game':
            $res = $botQuery->validate_user($number);
            if ($res == true) {
                $botQuery->update_query($number, $buttonId, $listId);
            } else {
                $botQuery->insert_user($number, $buttonId);
            }
            break;


        case 'send_blood_list':
            $value = $bloodQr->check_donor_status($number);
            if ($value == 'done') {
                $btnId = "";
                $listId = "";
                $botQuery->update_query($number, $btnId, $listId);
                $messageApi->sendMessage('Your already registered as a blood donor.', $number);
            } else {
                $response = $botQuery->update_previous_query($number, 'bl_register');
            }

        case 'ready_to_play':
            $value = $bloodQr->check_donor_status($number);
            if ($value == 'done') {
                $btnId = "";
                $listId = "";
                $botQuery->update_query($number, $btnId, $listId);
            } else {
                $response = $botQuery->update_previous_query($number, $buttonId);
            }
    }
}


//*list's */
if (!empty($listId)) {
    $main_query = $botQuery->check_main_qr($number);

    if ($main_query != false) {
        if ($main_query == 'register') {
            if ($listId == 'bl_register') {

                $response = $botQuery->update_previous_query($number, $listId);

            } else if ($listId == 'pr_register') {

                $value = $professionQuery->check_pr_status($number);
                if ($value == 'done') {
                    $messageApi->sendMessage('Your profession already registered.', $number);
                    $response = $botQuery->update_previous_query($number, "");
                } else {
                    $response = $botQuery->update_previous_query($number, $listId);
                }

            } else if ($listId == 'bs_register') {

                $value = $businessQuery->check_bs_status($number);
                if ($value == 'done') {
                    $messageApi->sendMessage('Your business already registered.', $number);
                    $response = $botQuery->update_previous_query($number, "");
                } else {
                    $response = $botQuery->update_previous_query($number, $listId);
                }

            } else if ($listId == 'at_register') {
                $value = $driverQuery->check_driver_status($number);
                if ($value == 'done') {
                    $messageApi->sendMessage('You are already registered as Auto driver! Please install the app to be visible to customers.', $number);
                    $response = $botQuery->update_previous_query($number, "");
                } else {
                    $response = $botQuery->update_previous_query($number, $listId);
                }
            }

        } else if ($main_query == 'search') {
            if ($listId == 'bl_search' || $listId == 'pr_search' || $listId == 'bs_search' || $listId == 'at_search' || $listId == 'tx_search') {
                $response = $botQuery->update_previous_query($number, $listId);
            }
        }
    } else {
        $messageApi->sendBtnMessage('Please Select Any Option', $number, 'Start Again', 'Stop', 'Hi', 'Nothing');
    }
}




//*conversations

if (!empty($conversation)) {
    $previous_query = $botQuery->check_previous_qr($number);

    if (empty($previous_query)) {
        if (strcasecmp($conversation, "Search") == 0) {
            $listId = "";
            $res = $botQuery->validate_user($number);
            if ($res == true) {
                $botQuery->update_query($number, 'search', $listId);
            } else {
                $botQuery->insert_user($number, 'search');
            }
        }
    }
}