<?php

$main_query = $botQuery->check_main_qr($number);
$previous_query = $botQuery->check_previous_qr($number);

if ($main_query != false) {
    if ($main_query == 'register') {
        if ($previous_query == 'bl_register') {
            $blood_status = $bloodQr->check_blood_user($number);
            if ($blood_status == false) {

                if ($buttonId == "send_blood_list") {
                    $messageApi->BloodDonorList($number);
                }

                if ($listId == 'A+' || $listId == 'A-' || $listId == 'B+' || $listId == 'B-' || $listId == 'AB+' || $listId == 'AB-' || $listId == 'O+' || $listId == 'O-') {
                    date_default_timezone_set('Asia/Kolkata');
                    $currentTime = date('d-m-Y h:i:s A', time());
                    $messageApi->sendMessage('What is your name', $number);
                    $response = $bloodQr->insert_blood_donor($number, $listId, $currentTime);
                }
            } else {
                $values = $bloodQr->get_donor_stmt($number);

                if (!empty($values)) {
                    foreach ($values as $val) {
                        if (empty($val['name'])) {
                            date_default_timezone_set('Asia/Kolkata');
                            $currentTime = date('d-m-Y h:i:s A', time());
                            $msg = "Dear *" . $pushName . "*, Please watch the video to send the current location";
                            $messageApi->sendMediaMessage($msg, 'https://paybill.live/extrafiles/townchat/public/media/video/send_location_video.mp4', $number);
                            $bloodQr->update_donor_name($conversation, $number);
                        } else if (empty($val['latitude']) || empty($val['longitude'])) {
                            if (!empty($latitude) && !empty($longitude)) {
                                date_default_timezone_set('Asia/Kolkata');
                                $currentTime = date('d-m-Y h:i:s A', time());

                                $messageApi->sendBtnMessage('Select Your Gender', $number, 'Male', 'Female', 'Male', 'Female');

                                $bloodQr->update_donor_location($latitude, $longitude, $currentTime, $number);
                            }
                        }else if($buttonId == "Male" || $buttonId == "Female"){
                            if($buttonId == "Male" || $buttonId == "Female"){
                                $bloodQr->update_donor_gender($buttonId, $number);
                            }
                        }else if(empty($val['donor_status'])){
                            if($buttonId == 'i_agree'){
                                $messageApi->sendMessage('Thank you for registering as a Blood Donor.', $number);

                                date_default_timezone_set('Asia/Kolkata');
                                $currentTime = date('d-m-Y h:i:s A', time());
                                $bloodQr->update_donor_status("done", $currentTime, $number);
                                $btnId = "";
                                $listId = "";
                                $botQuery->update_query($number, $btnId, $listId);
                            }else if($buttonId == 'dont_agree'){
                                $messageApi->sendMessage('data deleted', $number);
                                $bloodQr->delete_donor_entry($number);
                                $btnId = "";
                                $listId = "";
                                $botQuery->update_query($number, $btnId, $listId);
                            }
                        }
                    }
                }
            }
        }
    }
}