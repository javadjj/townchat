<?php

if(!empty($buttonId)){
    if($buttonId == "referral_continue"){
    $listId = "";
    $main = "play_whatsapp_game";
    $pre = "ready_to_play";
        $res = $botQuery->validate_user($number);
        if ($res == true) {
            $botQuery->update_query($number, $main, $listId);
        } else {
            $botQuery->insert_user($number, $main);
        }
        $response = $botQuery->update_previous_query($number, $pre);
    }
    }
    if(!empty($conversation)){
       // if($conversation == int){
    $checkcode = $earnwithTown->check_referral_code($conversation);
    foreach($checkcode as $name){
        $name =$name['username'];
    }
    $fetchusername = $earnwithTown->all_user_values($number);
    foreach($fetchusername as $user){
        $coins =$user['towncoins'];
        $referel_code =$user['referel_code'];
        $refered_code =$user['refered_code'];

    if($checkcode !=false && $refered_code ==""){
            $msge = "*Hi,".$pushName."*".'\n'.$name." referred you, you have be rewarded with *🪙400 TOWN COINS* to play *AIT*".'\n'.'\n'."And ".$name." would like to thank you for being a reason for earning 600 TOWN COINS😍";
            $messageApi->referral_join_btn($number,$msge);
            $reffbonus =400;
            $earnwithTown->add_referral_coins($coins,$reffbonus,$conversation,$number);
    }elseif($checkcode ==false && $refered_code ==""){
       // $messageApi->sendMessage("*Please Type a Valid Referral Code!*",$number);
    }
    }
}




$main_query = $botQuery->check_main_qr($number);
$previous_query = $botQuery->check_previous_qr($number);

date_default_timezone_set('Asia/Kolkata');
$currenttime = new DateTime('now');
$targettime = new DateTime('11:59:59 PM');
$difference = $currenttime->diff($targettime);
$remning_time = $difference->format('%h hours %i minutes %s seconds remaining');
if ($main_query != false) {
    if ($main_query == 'play_whatsapp_game') {
        if ($previous_query == 'ready_to_play') {
            $actve_btn_id = $earnwithTown->fetch_btn_id($number);
            $actve_list_id = $earnwithTown->fetch_list_id($number);
            if(!empty($buttonId)){
                $earnwithTown->update_btn_id($buttonId,$number); 
            }
            if(!empty($listId)){
                $earnwithTown->update_list_id($listId,$number);
            }
            $check_number = $earnwithTown->check_number($number);
            if ($check_number == false) {
                date_default_timezone_set('Asia/Kolkata');
                $regstrd_dateTime = date('d-m-Y h:i:s A', time());
                $earnwithTown->savenumber($number,$regstrd_dateTime);
                $referalcode = rand(1111,9999);
                $refstatus = "code_genarated";
                $dailylimit = 15000;
                $limitsts = "bonus_limit_added";
                $earnwithTown->update_daily_lmt($dailylimit,$limitsts,$referalcode,$refstatus,$number);
            }else{
                $earnwithTown->update_user_name($pushName,$number);
                //if($buttonId == "ready_to_play"){
                    //$msg ="*📍Share your current location*";
                    //$media ="https://c703-2406-7400-56-c2db-6d99-49da-ffee-f4ae.in.ngrok.io/projects/chatbottest/ait_admin/ait_videos/assets/how_to_share_location.mp4";
                    //$messageApi->sendMediaMessage($msg,$media,$number);
                //}
                $check_vdo_count1 = $earnwithTown->check_vdo_cunt($number);  //tomorros limit
                $check_dailylimit_sts = $earnwithTown->check_dailylmt_sts($number);
                if($check_vdo_count1 == 15 ){
                    $limitsts="limit_reached";
                    $earnwithTown->update_dailylmt_sts($limitsts,$number);
                }
                if($check_vdo_count1 == 0){
                    $earnwithTown->reset_coin_arrys_cunt($number);
                }
                if($check_vdo_count1 == 15 && $check_dailylimit_sts =="limit_reached" && $check_dailylimit_sts !="tomrrow_lmt_added" ){
                    $fetch_dailylimit3 = $earnwithTown->all_user_values($number);
                    foreach($fetch_dailylimit3 as $lmt3){
                        $limit = $lmt3['daily_limit'];
                        $percentageChange =rand(0,5);
                        $newlimit = ($percentageChange / 100 ) * $limit ;
                        $incselimit = $limit+$newlimit;
                        $increased_daily_limit = intval($incselimit);
                        $earnwithTown->update_tomrrw_lmt($increased_daily_limit,$number);
                        $limitsts="daily_limit_updated";
                        $earnwithTown->update_dailylmt_sts($limitsts,$number);
                    }
                }
                if($check_vdo_count1 < 15 && $check_dailylimit_sts =="limit_reached" && $check_dailylimit_sts !="tomrrow_lmt_added" ){
                    $fetch_dailylimit1 = $earnwithTown->all_user_values($number);
                    foreach($fetch_dailylimit1 as $lmt1){
                        $limit = $lmt1['daily_limit'];
                        $percentageChange = rand(0,3);
                        $newlimit = ($percentageChange / 100 ) * $limit ;
                        $mineslimit = $limit-$newlimit;
                        $minesed_limit1 = intval($mineslimit);
                        $earnwithTown->update_tomrrw_lmt($minesed_limit1,$number);
                        $limitsts="tomrrow_lmt_added";
                        $earnwithTown->update_dailylmt_sts($limitsts,$number);
                    }
                }   
                if(!empty($conversation)){
                    if($conversation == "resetvcount-id-XAM5432XAZ"){
                        $count=0;
                        $earnwithTown->reset_daily_video_count($count);
                        $messageApi->sendMessage("process concluded", $number);
                    }
                    if(strtolower($conversation) =="wallet"){
                        $earned_points = $earnwithTown->all_user_values($number);
                        foreach($earned_points as $erngs1){
                            $towncoins = $erngs1['towncoins'];
                            $earnings = $erngs1['earnings'];
                           // $msg = "*TOWN Wallet*".'\n' .'\n' ."Hi,".$pushName.'\n' .'\n' ."Total Town Coins : 🪙".$towncoins."".'\n'."500000 Town Coins = ₹500".'\n'.'\n'."*NOTE*:The minimum balance for withdrawal is ₹500.";
                            $msg = "*TOWN Wallet*".'\n' .'\n' ."Hi,".$pushName.'\n' .'\n' ."Total Town Coins : 🪙".$towncoins.'\n'.'\n';
                            $messageApi->sendMessage($msg, $number);
                        }
                    }
                    
                    if(strtolower($conversation) == "check limit"){
                        $fetch_dailylimit2 = $earnwithTown->all_user_values($number);
                        $check_vdo_count2 = $earnwithTown->check_vdo_cunt($number);
                        foreach($fetch_dailylimit2 as $lmt2){
                            $check_limit = $lmt2['daily_limit'];
                            $tmrrow_lmt = $lmt2['tomrrows_limit'];
                            if(!empty($check_limit) && $check_vdo_count2 < 15){
                                $msg ="Hi, ".$pushName.'\n'.'\n'."Today's limit: *🪙".$check_limit." TOWN COINS* ";
                                $messageApi->sendMessage($msg,$number);
                            }elseif($check_vdo_count2 == 15){
                                $msg = "You have reached today's limit. please check tomorrow ".'\n'.'\n'."$remning_time";
                                $messageApi->sendMessage($msg, $number);
                            }
                        }
                    }

                    if($actve_btn_id =="marketplace_order"){
                        if(strtolower($conversation) !="marketplace" && strtolower($conversation) !="wallet" && strtolower($conversation) !="hi" && strtolower($conversation) !="check limit"){
                            $earnwithTown->update_delivery_address($conversation,$number);
                            $check_addrss = $earnwithTown->check_delivry_address($number);
                            $msg ="Delivery Address: ".'\n'.'\n'.$check_addrss.'\n'.'\n'."NOTE: You can change your address by typing the new address";
                            $foote="Click below to confirm";
                            $btnid="confirm_order";
                            $display_text="CONFIRM ORDER";
                            $messageApi->singlebutton($number,$footer,$btnid,$display_text,$msg);
                        }
                    }

                    if(strtolower($conversation) == "business demo"){
                        $footer="click below to continue";
                        $btnid="business_demo";
                        $display_text="CONTINUE";
                        $msg="You can find any business by typing a business ID";
                        $messageApi->singlebutton($number,$footer,$btnid,$display_text,$msg);
                    }
                    if($actve_btn_id =="business_demo"){
                        $fetch_databy_id=$earnwithTown->get_business_id_data($conversation);
                        foreach($fetch_databy_id as $iddata){
                            $video_name1 = $iddata['name'];
                            $ad_id1 = $iddata['Ad_id'];
                        $media = 'https://paybill.live/extrafiles/townchat/ait_admin/ait_videos/'.$video_name1.'';
                        $msg = "Level: ".$incr_vdo_cunt."\n\n*PLEASE NOTE:* Questions can be answered just once. be sure to select the correct answer in your first attempt.\n \nTo check your earnings in your wallet you can type *wallet* anytime.💰";
                        $text="Click below to questions ⬇️";
                        $vdobtnid="ready_to_answer";
                        $display_txt ="Ready to Answer";
                        $messageApi->sendvideo($number,$media,$msg,$text,$vdobtnid,$display_txt);
                        $earnwithTown->update_demo_ad_id($ad_id1,$number);
                    }
                    }
                }
                if((strtolower($conversation) == "marketplace") || ($buttonId == "marketplace") || (strtolower($conversation) == "market place")){
                    $text ="Categories";
                    $footer="Click below to select";
                    $title="MARKETPLACE";
                    $buttontext="CATEGORY";
                    $list1="Auto & Vehicles";
                    $listid1 ="Auto & Vehicles";
                    $list2 ="Baby & Children's Products";
                    $listid2 ="Baby & Children's Products";
                    $list3 ="Beauty Products & Services";
                    $listid3 ="Beauty Products & Services";
                    $list4 ="Computers & Peripherals";
                    $listid4 ="Computers & Peripherals";
                    $list5 ="Consumer Electronics";
                    $listid5 ="Consumer Electronics";
                    $list6 ="Home appliances";
                    $listid6 ="Home appliances";
                    $list7 ="Gifts & Occasions";
                    $listid7 ="Gifts & Occasions";
                    $list8 ="Home & Garden";
                    $listid8 ="Home & Garden";
                    $messageApi->marketplace_list($number,$text,$footer,$title,$buttontext,$list1,$listid1,$list2,$listid2,$list3,$listid3,$list4,$listid4,$list5,$listid5,$list6,$listid6,$list7,$listid7,$list8,$listid8);
                    $pro_count =0;
                    $earnwithTown->reset_product_list_id($pro_count,$number);
                }
                if(!empty($listId)){
                    if($listId =="Auto & Vehicles" || $listId =="Baby & Children's Products" || $listId =="Beauty Products & Services"|| $listId =="Computers & Peripherals"|| $listId =="Consumer Electronics"||$listId =="Financial Services"||
                    $listId =="Gifts & Occasions"|| $listId =="Home & Garden" || $listId =="Home appliances" ){
                    //if($listId==$check_category){
                    $msg ="You are selected ".$listId;
                    $footer="Click below to get products";
                    $btnid="next_product_btn";
                    $display_text="GET PRODUCTS";
                    $messageApi->singlebutton($number,$footer,$btnid,$display_text,$msg);
                    }
                }
                if($buttonId=="next_product_btn"){
                    $current_pro_list_count = $earnwithTown->all_user_values($number);
                    foreach($current_pro_list_count as $procount){
                        $crrnt_pro_count = $procount['current_pro_count'];
                    }
                    $category =$actve_list_id;
                    $products = $earnwithTown->fetch_products($category,$crrnt_pro_count);
                    $actve_list_id = $earnwithTown->fetch_list_id($number);
                    $check_category = $earnwithTown->check_category($actve_list_id);
                    if($check_category!=false && $products !=false){
                        //if($products !=false){}
                        foreach($products as $pro){
                            $id = $pro['id'];
                            $pro_id = $pro['product_id'];
                            $pro_media =$pro['media'];
                            $pro_name = $pro['name'];
                            $pro_description = $pro['description'];
                            $pro_price = $pro['price'];
                            $towencoin = $earnwithTown->all_user_values($number);
                            foreach($towencoin as $coin){
                                $coins = $coin['towncoins'];
                                if($coins >=$pro_price){
                                $media ='https://paybill.live/extrafiles/townchat/ait_admin/ait_products/'.$pro_media.'';
                                $msg = "".$pro_name."\nProduct ID: $pro_id\n\n".$pro_description."\n\nprice: 🪙".$pro_price."\nAvailable Coins: 🪙".$coins."\n\nNOTE: You have sufficient Town coins for this product✅";
                                $text="Click below to order";
                                $vdobtnid1="marketplace_order";
                                $display_txt1 ="ORDER NOW";
                                $vdobtnid2="next_product_btn";
                                $display_txt2 ="NEXT PRODUCT";
                                $messageApi->send_available_product($number,$media,$msg,$text,$vdobtnid1,$display_txt1,$vdobtnid2,$display_txt2);
                                $earnwithTown->update_current_product_id($pro_id,$id,$number);
                            }else{
                                $media ='https://paybill.live/extrafiles/townchat/ait_admin/ait_products/'.$pro_media.'';
                                $msg = "".$pro_name."\nProduct ID: $pro_id\n\n".$pro_description."\n\nprice: 🪙".$pro_price."\nAvailable Coins: 🪙".$coins."\n\nNOTE: You dont have sufficient Town coins for this product❌";
                                $text="Click below to next product";
                                $vdobtnid1="next_product_btn";
                                $display_txt1 ="NEXT PRODUCT";
                                $messageApi->send_notavailable_product($number,$media,$msg,$text,$vdobtnid1,$display_txt1);
                                $earnwithTown->update_current_product_id($pro_id,$id,$number);
                            }
                            }
                        }
                    }else{
                        $messageApi->sendMessage("No products found", $number);
                        $pro_count =0;
                        $earnwithTown->reset_product_list_id($pro_count,$number);
                    }
                    }
                    if($buttonId =="go_to_marketplace" || strtolower($conversation) == "testing"){
                        $msg ="Now you can visit our *🛒Marketplace* or continue with game";
                        $btn1 ="Marketplace";
                        $btnid1 ="marketplace";
                        $btn2 ="Continue Game";
                        $btnid2 ="get_started_btn";
                        $messageApi->sendBtnMessage($msg, $number, $btn1, $btn2, $btnid1, $btnid2);
                    }
                    if($buttonId == "marketplace_order"){
                        $check_addrss = $earnwithTown->check_delivry_address($number);
                        if($check_addrss ==false){
                            $msg ="Type your delivery address";
                            $messageApi->sendMessage($msg, $number);
                        }else{
                            $check_addrss = $earnwithTown->check_delivry_address($number);
                            $msg ="Delivery Address: ".'\n'.'\n'.$check_addrss;
                            $foote="Click below to confirm";
                            $btnid="confirm_order";
                            $display_text="CONFIRM ORDER";
                            $messageApi->singlebutton($number,$footer,$btnid,$display_text,$msg);
                        }
                    }
                    if($buttonId=="confirm_order"){
                        $checkcoins = $earnwithTown->all_user_values($number);
                        foreach($checkcoins as $coi){
                            $checkcoin = $coi['towncoins'];
                            $pro_id = $coi['current_product_id'];
                        }
                        $pr_prce = $earnwithTown->fetch_products_with_id($pro_id);
                        foreach($pr_prce as $pro_pric){
                            $pro_price = $pro_pric['price'];
                        }
                        if($checkcoin >= $pro_price ){
                        $prodctid = $earnwithTown->all_user_values($number);
                        foreach($prodctid as $pro){
                            $pro_id1 = $pro['current_product_id'];
                            $products1 = $earnwithTown->fetch_products_with_id($pro_id1);
                            foreach($products1 as $pro1){
                            $pro_id2 = $pro1['product_id'];
                            $pro_media =$pro1['media'];
                            $pro_name1 = $pro1['name'];
                            $pro_description = $pro1['description'];
                            $pro_price1 = $pro1['price'];
                            date_default_timezone_set('Asia/Kolkata');
                            $order_time = date('d-m-Y h:i:s A', time());
                            $order_address = $earnwithTown->check_delivry_address($number);
                            $order_sts ="order_placed";
                            $earnwithTown->insert_new_order($number,$pushName,$order_time,$order_address,$pro_id2,$order_sts,$pro_name1,$pro_price1);
                            $updatetowncoin = $earnwithTown->all_user_values($number);
                            foreach($updatetowncoin as $u_coin){
                                $towncoins = $u_coin['towncoins'];
                                $towncoins =  $towncoins-$pro_price1;
                                $earnwithTown->update_town_coins_after_purchase($towncoins,$number);
                            }
                            $balence_coin = $earnwithTown->all_user_values($number);
                            foreach($balence_coin as $b_coin){
                                $b_towncoins = $b_coin['towncoins'];
                                $msge ="Thank you, ".$pushName.'\n'.'\n'." Kindly wait for our updates".'\n'.'\n'."Available TOWN COINS: 🪙".$b_towncoins;
                                $messageApi->sendMessage($msge, $number);
                            }
                        }
                    }
                }else{
                    $msge ="You dont have sufficient Town coins for this product❌";
                    $messageApi->sendMessage($msge, $number);
                }
                }
                if($buttonId =="referthe_game" || strtolower($conversation) == "refer"){
                    $msge = "👇 You can Forward the below message to your 5 contacts per day and tell them to enter your referal code and get *600 🪙 TOWN COINS* immediately after they complete their 1st day 15 levels questions".'\n'.'\n'."( You shall earn *600 TOWN COINS* even if your friend win or lose on any level among the 1st 15 levels)";
                    $messageApi->click_below_torefer($number,$msge);
                }elseif($buttonId =="get_referral_link" ){
                        $referlcode = $earnwithTown->all_user_values($number);
                        foreach($referlcode as $ref){
                            $refcolumn = $ref['referel_code'];
                            if(empty($refcolumn)){
                                $refstatus = "code_genarated";
                                $referalcode = rand(1123,9989);
                                $earnwithTown->update_referal_code($referalcode,$refstatus,$number);
                            }
                        }
                        $referlcode = $earnwithTown->all_user_values($number);
                        foreach($referlcode as $ref1){
                            $refcolumn = $ref1['referel_code'];
                            $msge ="Hi, I would like to recommend you to play *AIT* Game on WhatsApp. \n \nIt's interesting and fun to play this chat game and earn money 😍by playing this *AIT* \n \nClick on the link below and type my referral code to start earning your points \n \n *Referral code : $refcolumn*   \n \n https://api.whatsapp.com/send/?phone=917377378055&text=referred_join&type&phone_number&app_absent=0";
                            $media ="https://paybill.live/extrafiles/townchat/ait_admin/ait_videos/assets/referral_link_image.jpg";
                            $messageApi->sendMediaMessage($msge, $media, $number);
                        }
                    }
                        $reff_code = $earnwithTown->check_teferl_code($number);
                        $referlstatus = $earnwithTown->check_referral_sts($reff_code);
                        foreach($referlstatus as $refsts){
                            $refstatus = $refsts['referral_status'];
                            $referel_code = $refsts['referel_code'];
                            $total_refarrals = $refsts['total_refarrals'];
                            $coins1 = $refsts['towncoins'];
                            $refferred_name = $refsts['username'];
                            $refphone = $refsts['phone'];
                            $referral_status = $earnwithTown->all_user_values($number);
                            foreach($referral_status as $rsts){
                                $referr_status = $rsts['referral_status'];
                                $reffbonus1 =600;
                                if($check_vdo_count1 =15 && $referr_status!="600_tc_updated"){
                                    $addrefrr = $total_refarrals+1;
                                    $totalcoin = $coins1+$reffbonus1;
                                    $earnwithTown->add_coins_to_tefarred_user($totalcoin,$addrefrr,$reff_code);
                                    $messageApi->sendMessage("*You have rewarded 🪙600 Town Coins*",$reff_code);
                                    $refrral_sts = "600_tc_updated";
                                    $earnwithTown->update_referral_sts($refrral_sts,$number);
                                    //$messageApi->sendMessage($refferred_name." Rewarded 🪙600 Town Coins",$number);
                                }
                            }
                        }
                        if($buttonId =="business_demo"){
                            $msg="*Please Type Your Business ID*";
                            $messageApi->sendMessage($msg,$number);
                        }
                if(!empty($latitude) && !empty($longitude)){
                    $earnwithTown->update_lat_long($latitude,$longitude,$number);
                    $msg ="*Points to remember:*⚠️".'\n'."Watch the full video before you select the *READY TO ANSWER* button, once you answer the first question you will be taken to the second question. Once you answer the second question correctly you shall be rewarded.💰";
                    $foote="Click below to Get Started";
                    $btnid="get_started_btn";
                    $display_text="GET STARTED";
                    $messageApi->singlebutton($number,$footer,$btnid,$display_text,$msg);
                }
                $currnt_usr_sts = $earnwithTown->current_usr_sts($number);
                $check_vdo_count = $earnwithTown->check_vdo_cunt($number);
                if($buttonId == "get_started_btn" || strtolower($conversation) =="next" ){
                    $latti = $earnwithTown->get_latitude($number);
                    $longi = $earnwithTown->get_longitude($number);
                    $dstce_rslt = $earnwithTown->get_distnc_data($latti,$longi,$number);
                    if ($dstce_rslt != false && $check_vdo_count < 15) {
                        foreach($dstce_rslt as $res){
                            $video_url = $res['video_url'];
                            $ad_id = $res['Ad_id'];
                            $video_name = $res['name'];
                            $lat1 = $latti;
                            $lon1 = $longi;
                            $lat2 = $res['latitude'];
                            $lon2 = $res['longitude'];
                            $geopointDistance = $distCalc->calculate_dist($latti, $longi, $lat2, $lon2);
                            $dist = $geopointDistance . " mts";
                            if ($geopointDistance > 1000) {
                            $gpDistance = round($geopointDistance / 1000);
                            $dist = $gpDistance . " kms";
                            } else if ($geopointDistance > 500) {
                                $dist = "more than 500 mts";
                            } else if ($geopointDistance < 500) {
                                $dist = "less than 500 mts";
                            }
                            if ($geopointDistance < 50000000) {
                                $vdo_count = $earnwithTown->all_user_values($number);
                                foreach($vdo_count as $v_cunt){
                                    $vdo_cunt = $v_cunt['daily_video_cont'];
                                    $incr_vdo_cunt = $vdo_cunt+1;
                                    $earnwithTown->update_ad_id($incr_vdo_cunt,$ad_id,$number);
                                    $media = 'https://paybill.live/extrafiles/townchat/ait_admin/ait_videos/'.$video_name.'';
                                    $msg = "Level: ".$incr_vdo_cunt."\n\n*PLEASE NOTE:* Questions can be answered just once. be sure to select the correct answer in your first attempt.\n \nTo check your earnings in your wallet you can type *wallet* anytime.💰";
                                    $text="Click below to questions ⬇️";
                                    $vdobtnid="ready_to_answer";
                                    $display_txt ="Ready to Answer";
                                    $messageApi->sendvideo($number,$media,$msg,$text,$vdobtnid,$display_txt);
                                    $earnwithTown->sve_viwd_v_id($number,$ad_id,$video_name);
                                }
                            }else{
                                //$msge = "☹️".'\n'."Sorry, you have reached todays limit!";
                                //$msge = "Today's max limit reached..".'\n'.'\n'."Check again tomorrow to continue your daily streak and know your *daily limit*.".'\n'."TIP: Send *CHECK LIMIT* TO know your limit for the day";
                                //$messageApi->start_again($number,$msge);
                            }
                        }
                    }elseif($check_vdo_count >= 15){
                        $msge = "Today's max limit reached..".'\n'.'\n'."Check again tomorrow to continue your daily streak and know your *daily limit*.".'\n'.'\n'."TIP: Send *CHECK LIMIT* TO know your limit for the day";
                        $messageApi->start_again($number,$msge);
                        $earnwithTown->reset_coin_arrys_cunt($number);
                        $null = null;
                        $sts_null ="value_null";
                        $earnwithTown->reset_TC_values($null,$sts_null,$number);
                        
                    }else{
                        $msge = "Today's max limit reached..".'\n'.'\n'."Check again tomorrow to continue your daily streak and know your *daily limit*.".'\n'.'\n'."TIP: Send *CHECK LIMIT* TO know your limit for the day";
                        $messageApi->start_again($number,$msge);
                        $earnwithTown->reset_coin_arrys_cunt($number);
                        $null = null;
                        $sts_null ="value_null";
                        $earnwithTown->reset_TC_values($null,$sts_null,$number);
                    }
                }elseif( $buttonId == "ready_to_answer"){ 
                    $current_ad_id = $earnwithTown->current_ad_id($number);
                    $bssns_values = $earnwithTown->all_bsns_values($current_ad_id);
                    foreach ($bssns_values as $bval){
                        $question1 = $bval["question1"];
                        $question1_answer = $bval["question1_answer"];
                        $question1_option1 = $bval["question1_option1"];
                        $question1_option2 = $bval["question1_option2"];
                        $ans_array = array( $question1_answer, $question1_option1,$question1_option2);
                        shuffle($ans_array);
                        $messageApi->sendquestion1($number,$question1,$ans_array);
                        $sts = "Q_1_send";
                        $earnwithTown->update_Q1_sts($sts,$number);  //sts
                    }
                }elseif (!empty($listId)){
                    $current_ad_id = $earnwithTown->current_ad_id($number);
                    $bssns_values = $earnwithTown->all_bsns_values($current_ad_id);
                    foreach ($bssns_values as $bval){
                        $question1_answer = $bval["question1_answer"];
                        $question1_option1 = $bval["question1_option1"];
                        $question1_option2 = $bval["question1_option2"];
                        if ($listId == $question1_answer && $currnt_usr_sts =="Q_1_send"){
                            $earnwithTown->update_Q1_ansr($listId,$number); //ansr
                            $msg ="Congratulations, you are eligible to answer the 2nd question. If you answer this question correctly, you shall be rewarded💰.";
                            $messageApi->Q1_rightansr($msg,$number);
                            $sts = "Q_1 right_ansr";
                            $earnwithTown->update_Q1_sts($sts,$number);
                        }elseif($currnt_usr_sts == "Q_1_send"){
                            if($listId == $question1_option1 || $listId == $question1_option2){
                                $earnwithTown->update_Q1_ansr($listId,$number); //ansr
                                $earned_points = $earnwithTown->all_user_values($number);
                                foreach($earned_points as $erngs1){
                                    $totalcoins = $erngs1['towncoins'];
                                    $msge ="*☹️Ops!* you lost, please watch the video carefully next time.".'\n' .'\n' ."Please continue with next video";
                                    $check_vdo_count2 = $earnwithTown->check_vdo_cunt($number);
                                    if($check_vdo_count2 != 5){
                                        $footer ="Total TOWN COINS: 🪙".$totalcoins;
                                        $btnid ="get_started_btn";
                                        $btntext ="NEXT";
                                        $messageApi->wronganswer($number,$msge,$footer,$btnid,$btntext);
                                    }elseif($check_vdo_count2 == 5){
                                        $footer ="Total TOWN COINS: 🪙".$totalcoins;
                                        $btnid ="go_to_marketplace";
                                        $btntext ="NEXT";
                                        $messageApi->wronganswer($number,$msge,$footer,$btnid,$btntext);
                                    }
                                    $sts = "Q_1 attempted";
                                    $earnwithTown->update_Q1_sts($sts,$number);
                                }
                            }
                        }elseif($currnt_usr_sts =="Q_1 attempted" || $currnt_usr_sts =="Q_1 right_ansr") {
                            if($listId == $question1_answer || $listId == $question1_option1 || $listId == $question1_option2 ){
                                $mesge = "Sorry! You have already answered the question. Please continue with the *next video*.";
                                $messageApi->nextvideo($number,$mesge);
                                $sts = "multiple attempt";
                                $earnwithTown->update_Q1_sts($sts,$number);
                            }
                        }
                    }
                }elseif($buttonId == "next_question"){
                    $current_ad_id = $earnwithTown->current_ad_id($number);
                    $bssns_values = $earnwithTown->all_bsns_values($current_ad_id);
                    foreach( $bssns_values as $bval_1){
                        $question2 = $bval_1["question2"];
                        $question2_answer = $bval_1["question2_answer"];
                        $question2_option1 = $bval_1["question2_option1"];
                        $question2_option2 = $bval_1["question2_option2"];
                        $scnd_ans_array = array($question2_answer, $question2_option1,$question2_option2);
                        shuffle($scnd_ans_array);
                        $messageApi->sendquestion2($number,$question2,$scnd_ans_array);
                        $sts = "Q_2_send";
                        $earnwithTown->update_Q2_sts($listId,$sts,$number);
                    }
                }
               if(!empty($listId)){
                    $current_ad_id = $earnwithTown->current_ad_id($number);
                    $bssns_values_1 = $earnwithTown->all_bsns_values($current_ad_id);
                    foreach( $bssns_values_1 as $bval_2){
                        $question2_answer = $bval_2["question2_answer"];
                        $question2_option1 = $bval_2["question2_option1"];
                        $question2_option2 = $bval_2["question2_option2"];
                        $budjet = $bval_2["budjet"];
                        $video_count = $earnwithTown->check_vdo_cunt($number);
                        if ($listId == "q_2_".$question2_answer && $currnt_usr_sts == "Q_2_send" && $video_count < 16){
                            $checknumber = $earnwithTown->check_number_coinvalue($number);
                            if($checknumber == false){
                                date_default_timezone_set('Asia/Kolkata');
                                $user_dateTime = date('d-m-Y h:i:s A', time());
                                $earnwithTown->update_user_coinvalue($user_dateTime,$pushName,$number);
                                
                            }
                            $fetch_value_status=$earnwithTown->fetch_coinvalues($number);
                            foreach($fetch_value_status as $stus){
                                $rewardstatus = $stus['status'];
                                if($rewardstatus == "value_null"){
                                    $fetch_coins_limit = $earnwithTown->all_user_values($number);
                                    foreach( $fetch_coins_limit as $coins){
                                        $towncoins = $coins["towncoins"];
                                        $daily_limit = $coins["daily_limit"];
                                        $value = $daily_limit;                                                    
                                        $parts = $earnwithTown->divideIntoFifteen($value, 50 ,2500);
                                        $earnwithTown->update_15000_TC_values($parts,$number);
                                    }
                                }
                            }
                            $fetch_high_reward = $earnwithTown->fetch_coinvalues($number);
                            foreach($fetch_high_reward as $high){
                                $value1 = $high['value1'];
                                $value2 = $high['value2'];
                                $value3 = $high['value3'];
                                $value4 = $high['value4'];
                                $value5 = $high['value5'];
                                $value6 = $high['value6'];
                                $value7 = $high['value7'];
                                $value8 = $high['value8'];
                                $value9 = $high['value9'];
                                $value10 = $high['value10'];
                                $value11 = $high['value11'];
                                $value12 = $high['value12'];
                                $value13 = $high['value13'];
                                $value14 = $high['value14'];
                                $value15 = $high['value15'];
                                $value_array = array($value1, $value2, $value3, $value4, $value5, $value6, $value7, $value8, $value9, $value10, $value11, $value12, $value13, $value14, $value15, );
                                $fetchcoin_array_count = $earnwithTown->all_user_values($number);
                                foreach($fetchcoin_array_count as $cac){
                                    $coin_array_count = $cac['highcoin_arraycount'];
                                    $totalarrcunts =  $coin_array_count+1;
                                    date_default_timezone_set('Asia/Kolkata');
                                    $current_user_time = date('d-m-Y h:i:s A', time());
                                    $earned_points = $earnwithTown->all_user_values($number);
                                    foreach($earned_points as $erngs){
                                        $towncoins = $erngs['towncoins'];
                                        $earnwithTown->update_high_point_budjt($towncoins, $budjet, $number, $current_ad_id, $value_array, $totalarrcunts,$current_user_time);
                                    }
                                }
                                $earned_points = $earnwithTown->all_user_values($number);
                                foreach($earned_points as $erngs){
                                    $towncoins = $erngs['towncoins'];
                                    $msge ="👏 *Congratulations* , you have earned *🪙".$value_array[$totalarrcunts]." Town Coins* in your Town Wallet." .'\n' .'\n' . "Click NEXT VIDEO to continue.";
                                    $footer ="Total TOWN COINS: 🪙".$towncoins;
                                    $check_vdo_count2 = $earnwithTown->check_vdo_cunt($number);
                                    if($check_vdo_count2 != 5){
                                        $btnid ="get_started_btn";
                                        $btntext ="NEXT";
                                        $messageApi->rightanswer($number,$msge,$footer,$btnid,$btntext);
                                    }elseif($check_vdo_count2 == 5){
                                        $btnid ="go_to_marketplace";
                                        $btntext ="NEXT";
                                        $messageApi->rightanswer($number,$msge,$footer,$btnid,$btntext);
                                    }
                                    $sts ="ready_for_nxt_vdo";
                                    $earnwithTown->update_Q2_sts($listId,$sts,$number);
                                }
                            }
                        }elseif($currnt_usr_sts == "Q_2_send"){
                            if($listId == "q_2_".$question2_option1 || $listId == "q_2_".$question2_option2){
                                $earned_points = $earnwithTown->all_user_values($number);
                                foreach($earned_points as $erngs1){
                                    $points = $erngs1['towncoins'];
                                    $msge ="*☹️Ops!* you lost, please watch the video carefully next time.".'\n' .'\n' ."Please continue with next video";
                                    $check_vdo_count2 = $earnwithTown->check_vdo_cunt($number);
                                    if($check_vdo_count2 != 5){
                                        $footer1 ="Total TOWN COINS: 🪙".$points;
                                        $btnid ="get_started_btn";
                                        $btntext ="NEXT";
                                        $messageApi->wronganswer($number,$msge,$footer1,$btnid,$btntext);
                                    }elseif($check_vdo_count2 == 5){
                                        $footer ="Total TOWN COINS: 🪙".$points;
                                        $btnid ="go_to_marketplace";
                                        $btntext ="NEXT";
                                        $messageApi->wronganswer($number,$msge,$footer,$btnid,$btntext);
                                    }
                                    $sts ="ready_for_nxt_vdo";
                                    $earnwithTown->update_Q2_sts($listId,$sts,$number);
                                }
                            }
                        }elseif($currnt_usr_sts =="ready_for_nxt_vdo") {
                            if($listId == "q_2_".$question2_answer || $listId == "q_2_".$question2_option1 || $listId == "q_2_".$question2_option2 ){
                                $sts = "multiple attempt";
                                $earnwithTown->update_Q1_sts($sts,$number);
                                $mesge = "Sorry! You have already attempted the question. Please continue with the next video.";
                                $messageApi->nextvideo($number,$mesge);
                            }
                        }
                    }
                }
            }
        }
    }
}