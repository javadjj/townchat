<?php

$main_query = $botQuery->check_main_qr($number);
$previous_query = $botQuery->check_previous_qr($number);

if ($main_query != false) {
    if ($main_query == 'register') {
        if ($previous_query == 'pr_register') {
            $pr_status = $professionQuery->check_pr_user($number);
            if ($pr_status == false) {
                date_default_timezone_set('Asia/Kolkata');
                $currentTime = date('d-m-Y h:i:s A', time());

                $professionQuery->insert_new_bs($number, $currentTime);
                $messageApi->sendMessage('HI, What is your name?', $number);
            } else {
                $values = $professionQuery->get_pr_stmt($number);

                if (!empty($values)) {
                    foreach ($values as $val) {
                        if (empty($val['name'])) {
                            $professionQuery->update_pr_name($conversation, $number);
                            $messageApi->sendMessage('What is your profession?', $number);
                        } else if (empty($val['category'])) {
                            $professionQuery->update_pr_category($conversation, $number);
                            $messageApi->sendMessage('Please enter 5 different keywords that can help your customers get to you and services that you serve             ' . '\n' . '\n' . 'Eg:' . '\n' . '\n' . 'Designing,content writing,marketing ( enter each word followed by a comma.', $number);
                        } else if (empty($val['keyword'])) {
                            $keywords = explode(",", $conversation);
                            if (count($keywords) <= 5) {
                                foreach ($keywords as $keys) {
                                    $remove_space = trim($keys, " ");
                                    $professionQuery->insert_pr_keyword($number, $remove_space);
                                }
                                $professionQuery->update_pr_keywords($conversation, $number);
                                $messageApi->sendMessage('What is your whatsapp contact number?', $number);
                            } else {
                                $messageApi->sendMessage('Please enter only maximum 5 keywords?', $number);
                            }
                        } else if (empty($val['contact'])) {
                            $validate = $messageApi->checkNumber($conversation);
                            if ($validate == "available") {
                                $professionQuery->update_pr_contact($conversation, $number);
                                $msg = "Dear *" . $pushName . "*, Please watch the video to send the current location";
                                $messageApi->sendMediaMessage($msg, 'https://paybill.live/extrafiles/townchat/public/media/video/send_location_video.mp4', $number);
                            }else{
                                $messageApi->sendMessage('' . $conversation . ' is not a whatsapp number', $number);
                            }
                        } else if (empty($val['latitude'] && empty($val['longitude']))) {

                            if (!empty($latitude) && !empty($longitude)) {
                                date_default_timezone_set('Asia/Kolkata');
                                $currentTime = date('d-m-Y h:i:s A', time());
                                $pr_status = 'done';

                                $professionQuery->update_pr_location($latitude, $longitude, $currentTime, $pr_status, $number);

                                $professionQuery->update_keyword_location($latitude, $longitude, $number);

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