<?php

$main_query = $botQuery->check_main_qr($number);
$previous_query = $botQuery->check_previous_qr($number);

if ($main_query != false) {
    if ($main_query == 'register') {
        if ($previous_query == 'bs_register') {
            $bs_status = $businessQuery->check_bs_user($number);
            if ($bs_status == false) {
                date_default_timezone_set('Asia/Kolkata');
                $currentTime = date('d-m-Y h:i:s A', time());

                $businessQuery->insert_new_bs($number, $currentTime);
                $messageApi->sendMessage('What is your business name?', $number);
            } else {
                $values = $businessQuery->get_bs_stmt($number);

                if (!empty($values)) {
                    foreach ($values as $val) {
                        if (empty($val['name'])) {
                            $businessQuery->update_bs_name($conversation, $number);
                            $messageApi->sendMessage('What is your business category?', $number);
                        } else if (empty($val['category'])) {
                            $businessQuery->update_bs_category($conversation, $number);
                            $messageApi->sendMessage('Please enter 5 different keywords that can help your customers to get products and services that you serve             ' . '\n' . '\n' . 'Eg:' . '\n' . '\n' . 'Rice,wheat,sugar ( enter each word followed by a comma.', $number);
                        } else if (empty($val['keyword'])) {
                            $keywords = explode(",", $conversation);
                            if (count($keywords) <= 5) {
                                foreach ($keywords as $keys) {
                                    $remove_space = trim($keys, " ");
                                    $businessQuery->insert_bs_keyword($number, $remove_space);
                                }
                                $businessQuery->update_bs_keywords($conversation, $number);
                                $messageApi->sendMessage('What is your business contact number?', $number);
                            } else {
                                $messageApi->sendMessage('Please enter only maximum 5 keywords?', $number);
                            }
                        } else if (empty($val['contact'])) {
                            $validate = $messageApi->checkNumber($conversation);
                            if ($validate == "available") {
                                $businessQuery->update_bs_contact($conversation, $number);
                                $msg = "Dear *" . $pushName . "*, Please watch the video to send the current location";
                                $messageApi->sendMediaMessage($msg, 'https://paybill.live/extrafiles/townchat/public/media/video/send_location_video.mp4', $number);
                            }else{
                                $messageApi->sendMessage('' . $conversation . ' is not a whatsapp number', $number);
                            }
                        } else if (empty($val['latitude'] && empty($val['longitude']))) {

                            if (!empty($latitude) && !empty($longitude)) {
                                date_default_timezone_set('Asia/Kolkata');
                                $currentTime = date('d-m-Y h:i:s A', time());
                                $bs_status = 'done';

                                $businessQuery->update_bs_location($latitude, $longitude, $currentTime, $bs_status, $number);

                                $businessQuery->update_keyword_location($latitude, $longitude, $number);

                                $btnId = "";
                                $listId = "";
                                $botQuery->update_query($number, $btnId, $listId);
                                $messageApi->sendMessage('Thank you for registering with Town Number.', $number);
                            }
                        }
                    }
                }
            }
        }
    }
}