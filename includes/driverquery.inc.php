<?php

$main_query = $botQuery->check_main_qr($number);
$previous_query = $botQuery->check_previous_qr($number);

if ($main_query != false) {
    if ($main_query == 'register') {
        if ($previous_query == 'at_register') {
            $driver_status = $driverQuery->check_driver_user($number);
            if ($driver_status == false) {
                date_default_timezone_set('Asia/Kolkata');
                $currentTime = date('d-m-Y h:i:s A', time());
                $uniqueId = (rand(1, 10000000));

                $driverQuery->insert_town_driver($number, $uniqueId, $currentTime);
                $messageApi->sendMessage('What is your name?', $number);
            } else {
                $values = $driverQuery->get_driver_stmt($number);

                if (!empty($values)) {
                    foreach ($values as $val) {
                        if (empty($val['name'])) {
                            $driverQuery->update_driver_name($conversation, $number);
                            $messageApi->sendBtnMessage('Please select your option', $number, 'Auto Driver', 'Taxi', 'auto driver', 'taxi driver');
                        } else if ($buttonId == "auto driver" || $buttonId == "taxi driver") {
                            $driverQuery->update_driver_type($buttonId, $number);
                            //$messageApi->sendMessage('Send your location', $number);
                        } else if (empty($val['latitude']) && empty($val['longitude'])) {
                            date_default_timezone_set('Asia/Kolkata');
                            $currentTime = date('d-m-Y h:i:s A', time());
                            $status = 'done';

                            $driverQuery->update_driver_location($latitude, $longitude, $currentTime, $status, $number);

                            $btnId = "";
                            $listId = "";
                            $botQuery->update_query($number, $btnId, $listId);
                            $messageApi->sendMessage('Thank you for registering with Town Number. Please login with your mobile number to town locator app to show your location live.', $number);
                        }
                    }
                }
            }
        }
    }
}