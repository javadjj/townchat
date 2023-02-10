<?php

$main_query = $botQuery->check_main_qr($number);
$previous_query = $botQuery->check_previous_qr($number);

if ($main_query != false) {
    if ($main_query == 'search') {

//code for business search
        if ($previous_query == 'bs_search') {
            if ($listId == "bs_search") {
                $messageApi->sendMessage('HI, Please enter a keyword to search?', $number);
            }

            if (!empty($conversation)) {
                $res = $searchQuery->update_search_key($conversation, $number);
                $msg = "Dear *" . $pushName . "*, Please watch the video to send the current location";
                $messageApi->sendMediaMessage($msg, 'https://paybill.live/extrafiles/townchat/public/media/video/send_location_video.mp4', $number);
            } else if (!empty($latitude) && !empty($longitude)) {
                $search_keyword = $searchQuery->get_search_key($number);

                if (!empty($search_keyword)) {
                    $bsCount = 0;
                    $result = $searchQuery->get_business_keys($latitude, $longitude, $search_keyword);

                    if ($result != false) {

                        foreach ($result as $res) {
                            $phone = $res['phone'];
                            $values = $searchQuery->get_business($phone);

                            foreach ($values as $val) {

                                $lat1 = $latitude;
                                $lon1 = $longitude;
                                $lat2 = $val['latitude'];
                                $lon2 = $val['longitude'];

                                $geopointDistance = $distCalc->calculate_dist($latitude, $longitude, $lat2, $lon2);

                                $dist = $geopointDistance . " mts";

                                if ($geopointDistance > 1000) {
                                    $gpDistance = round($geopointDistance / 1000);
                                    $dist = "Distance ".$gpDistance . " kms";
                                } else if ($geopointDistance > 500) {
                                    $dist = "Distance more than 500 mts";
                                } else if ($geopointDistance < 500) {
                                    $dist = "Distance less than 500 mts";
                                }

                                if ($geopointDistance < 350000) {
                                    $bsCount = $bsCount + 1;
                                    $name = $val['name'];
                                    $category = $val['category'];
                                    $contact_number = $val['contact'];
                                    $services = $val['keyword'];

                                    $msg = $msg = "*$name*" . "\n" . "▪️ $category" . "\n" . "▪️ $contact_number" . "\n" . "▪️ $services" . "\n" . "▪️ $dist" . "\n";;
                                    $messageApi->sendMediaMessage($msg, "https://paybill.live/extrafiles/townchat/public/media/image/business_img.png", $number);

                                    //reset main and previous query columns and search keyword
                                    $searchQuery->reset_stmt($number, "", "", "");
                                } else {
                                    $messageApi->sendBtnMessage($bsCount . " - Business available in your location.", $number, 'Start Again', 'Search Again', 'Hi', 'search');
                                    //$messageApi->sendMessage($driverCount." - Drivers available at the moment.", $number);
                                    $searchQuery->reset_stmt($number, "", "", "");
                                    break;
                                }
                            }
                        }
                        //default message to start over for every result.
                        $messageApi->sendBtnMessage("Please Select Any Option", $number, 'Start From Beginning', 'Search 🔍', 'Hi', 'search');
                        
                    } else {
                        //$messageApi->sendMediaMessage("Sorry No Result found." . "\n" . "Please search another keyword.", "https://cdn.dribbble.com/users/45010/screenshots/1709699/search.gif", $number);
                        $messageApi->sendBtnMessage("Sorry No Result found Please Select Any Option", $number, 'Start From Beginning', 'Search 🔍', 'Hi', 'search');
                        $searchQuery->reset_stmt($number, "", "", "");
                    }
                }
            }


//code for profession search

        } else if ($previous_query == 'pr_search') {

            if ($listId == "pr_search") {
                $messageApi->sendMessage('HI, Please enter a keyword to search?', $number);
            }

            if (!empty($conversation)) {
                $res = $searchQuery->update_search_key($conversation, $number);
                $msg = "Dear *" . $pushName . "*, Please watch the video to send the current location";
                $messageApi->sendMediaMessage($msg, 'https://paybill.live/extrafiles/townchat/public/media/video/send_location_video.mp4', $number);
            } else if (!empty($latitude) && !empty($longitude)) {
                $search_keyword = $searchQuery->get_search_key($number);

                if (!empty($search_keyword)) {
                    $prCount = 0;
                    $result = $searchQuery->get_profession_keys($latitude, $longitude, $search_keyword);

                    if ($result != false) {
                        foreach ($result as $res) {
                            $phone = $res['phone'];
                            $values = $searchQuery->get_professionals($phone);

                            foreach ($values as $val) {

                                $lat1 = $latitude;
                                $lon1 = $longitude;
                                $lat2 = $val['latitude'];
                                $lon2 = $val['longitude'];

                                $geopointDistance = $distCalc->calculate_dist($latitude, $longitude, $lat2, $lon2);

                                $dist = $geopointDistance . " mts";

                                if ($geopointDistance > 1000) {
                                    $gpDistance = round($geopointDistance / 1000);
                                    $dist = "Distance ".$gpDistance . " kms";
                                } else if ($geopointDistance > 500) {
                                    $dist = "Distance more than 500 mts";
                                } else if ($geopointDistance < 500) {
                                    $dist = "Distance less than 500 mts";
                                }

                                if ($geopointDistance < 350000) {
                                    $prCount = $prCount + 1;
                                    $name = $val['name'];
                                    $category = $val['category'];
                                    $contact_number = $val['contact'];
                                    $services = $val['keyword'];

                                    $msg = "*$name*" . "\n" . "▪️ $category" . "\n" . "▪️ $contact_number" . "\n" . "▪️ $services" . "\n" . "▪️ $dist";
                                    $messageApi->sendMediaMessage($msg, "https://www.nicepng.com/png/full/802-8029567_group-of-people-animated-png.png", $number);

                                    //reset main and previous query columns and search keyword
                                    $searchQuery->reset_stmt($number, "", "", "");
                                }else {
                                    $messageApi->sendBtnMessage($prCount . " - Professionals available in your location.", $number, 'Start Again', 'Search Again', 'Hi', 'search');
                                    $searchQuery->reset_stmt($number, "", "", "");
                                    break;
                                }
                            }
                        }
                        
                        //default message to start over for every result.
                        $messageApi->sendBtnMessage("Please Select Any Option", $number, 'Start From Beginning', 'Search 🔍', 'Hi', 'search');
                        
                    } else {
                        $messageApi->sendBtnMessage("Sorry No Result found Please Select Any Option", $number, 'Start From Beginning', 'Search 🔍', 'Hi', 'search');
                        $searchQuery->reset_stmt($number, "", "", "");
                    }
                }
            }


//code for Driver search

        } else if ($previous_query == 'at_search') {
            if ($listId == 'at_search') {
                $messageApi->sendBtnMessage("Please select your *Auto* or *Taxi*", $number, "Auto Driver", "Taxi Driver", "auto driver", "taxi driver");
            }

            if ($buttonId == "auto driver" || $buttonId == "taxi driver") {
                $searchQuery->update_search_key($buttonId, $number);
            }

            if (!empty($latitude) && !empty($longitude)) {
                $search_keyword = $searchQuery->get_search_key($number);

                if (!empty($search_keyword)) {
                    $driverCount = 0;
                    $result = $searchQuery->get_driver($latitude, $longitude, $search_keyword);

                    if ($result != false) {
                        foreach ($result as $res) {

                            $lat1 = $latitude;
                            $lon1 = $longitude;
                            $lat2 = $res['latitude'];
                            $lon2 = $res['longitude'];

                            $geopointDistance = $distCalc->calculate_dist($latitude, $longitude, $lat2, $lon2);

                            $dist = $geopointDistance . " mts";

                            if ($geopointDistance > 1000) {
                                $gpDistance = round($geopointDistance / 1000);
                                $dist = "Distance ".$gpDistance . " kms";
                            } else if ($geopointDistance > 500) {
                                $dist = "Distance more than 500 mts";
                            } else if ($geopointDistance < 500) {
                                $dist = "Distance less than 500 mts";
                            }

                            if ($geopointDistance < 5000) {
                                $driverCount = $driverCount + 1;
                                $name = $res['name'];
                                $contact_number = "+91".$res['phone'];
                                $vehicle_number = $res['vehicle_number'];
                                $app_version = $res["app_version"];

                                if (empty($app_version)) {
                                    $contact_number = "Just registered, not verified.";
                                }

                                if (empty($vehicle_number)) {
                                    $vehicle_number = "Not Available";
                                }

                                if ($search_keyword == "auto driver") {
                                    $msg = "*$name*" . "\n" . "▪️ $dist"."\n" . "▪️ $contact_number" . "\n". "▪️ $vehicle_number";
                                    $messageApi->sendMediaMessage($msg, "https://paybill.live/extrafiles/townchat/public/media/image/auto_driver.jpeg", $number);
                                } else if ($search_keyword == "taxi driver") {
                                    $msg = "*$name*" . "\n" . "▪️ $dist" . "\n" . "▪️ $contact_number" . "\n" . "▪️ $vehicle_number";
                                    $messageApi->sendMediaMessage($msg, "https://holidays.hrs.de/journal/wp-content/uploads/2015/11/Fotolia_76840424_Subscription_Monthly_XXL-831x560.jpg", $number);
                                }

                                //reset main and previous query columns and search keyword
                                $searchQuery->reset_stmt($number, "", "", "");
                            }else{
                                $messageApi->sendMessage($driverCount." - Drivers available at the moment.", $number);
                                $searchQuery->reset_stmt($number, "", "", "");
                                break;
                            }
                        }
                        
                        //default message to start over for every result.
                        $messageApi->sendBtnMessage("Please Select Any Option", $number, 'Start From Beginning', 'Search 🔍', 'Hi', 'search');
                        
                    } else {
                        $messageApi->sendBtnMessage("Sorry No Drivers available at the moment.", $number, 'Start From Beginning', 'Search 🔍', 'Hi', 'search');
                        $searchQuery->reset_stmt($number, "", "", "");
                    }
                }
            }



//code for Blood Donor search

        } else if ($previous_query == 'bl_search') {
            if ($listId == 'bl_search') {
                $messageApi->BloodDonorList($number);
            }

            if ($listId == 'A+' || $listId == 'A-' || $listId == 'B+' || $listId == 'B-' || $listId == 'AB+' || $listId == 'AB-' || $listId == 'O+' || $listId == 'O-') {
                $msg = "Dear *" . $pushName . "*, Please watch the video to send the current location";
                $messageApi->sendMediaMessage($msg, 'https://paybill.live/extrafiles/townchat/public/media/video/send_location_video.mp4', $number);
                $searchQuery->update_search_key($listId, $number);
            }


            if (!empty($latitude) && !empty($longitude)) {
                $search_keyword = $searchQuery->get_search_key($number);

                if (!empty($search_keyword)) {
                    $donorCount = 0;
                    $result = $searchQuery->get_donor($latitude, $longitude, $search_keyword);

                    if ($result != false) {
                        foreach ($result as $res) {

                            $lat1 = $latitude;
                            $lon1 = $longitude;
                            $lat2 = $res['latitude'];
                            $lon2 = $res['longitude'];

                            $geopointDistance = $distCalc->calculate_dist($latitude, $longitude, $lat2, $lon2);

                            $dist = $geopointDistance . " mts";

                            if ($geopointDistance > 1000) {
                                $gpDistance = round($geopointDistance / 1000);
                                $dist = "Distance ".$gpDistance . " kms";
                            } else if ($geopointDistance > 500) {
                                $dist = "Distance more than 500 mts";
                            } else if ($geopointDistance < 500) {
                                $dist = "Distance less than 500 mts";
                            }

                            if ($geopointDistance < 50000) {
                                $donorCount = $donorCount + 1;
                                $name = $res['name'];
                                $contact_number = $res['phone'];
                                $blood_group = $res['blood_group'];


                                $msg = "🩸 *$name*" . "\n" . "🩸 *$blood_group*" . "\n" . "🩸 *$dist*" . "\n" . "🩸 *91$contact_number*";
                                $messageApi->sendMediaMessage($msg, "https://paybill.live/extrafiles/townchat/public/media/image/blood_donor_profile.jpeg", $number);

                                //reset main and previous query columns and search keyword
                                $searchQuery->reset_stmt($number, "", "", "");
                            }else{
                                $messageApi->sendMessage($donorCount." - Donors available at the moment.", $number);
                                $searchQuery->reset_stmt($number, "", "", "");
                                break;
                            }
                        }
                        
                        //default message to start over for every result.
                        $messageApi->sendBtnMessage("Please Select Any Option", $number, 'Start From Beginning', 'Search 🔍', 'Hi', 'search');
                        
                    } else {
                        $messageApi->sendBtnMessage("Sorry No Donors available at the moment.", $number, 'Start From Beginning', 'Search 🔍', 'Hi', 'search');
                        $searchQuery->reset_stmt($number, "", "", "");
                    }
                }
            }
        }
    }
}