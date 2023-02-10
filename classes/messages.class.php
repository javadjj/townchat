<?php

class Messages
{

    private $instance_id;
    private $access_token;

    // set instance id and access_token
    public function __construct($access_token, $instance_id)
    {
        $this->access_token = $access_token;
        $this->instance_id = $instance_id;
    }


    //@desc
    //send text message
    public function sendMessage($msg, $num)
    {

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
            CURLOPT_URL => 'https://aiwa.chat/api/send.php?instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '&type=json&number=' . $num . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "text": "' . $msg . '"
            }',
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
    }



    //@desc
    //send text button message
    public function sendBtnMessage($msg, $num, $btn1, $btn2, $btnid1, $btnid2)
    {

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
            CURLOPT_URL => 'https://aiwa.chat/api/send.php?number=' . $num . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "text": "' . $msg . '",
                "footer": "Click Below",
                "buttons": [
                    {"buttonId": "' . $btnid1 . '", "buttonText": {"displayText": "' . $btn1 . '"}},
                    {"buttonId": "' . $btnid2 . '", "buttonText": {"displayText": "' . $btn2 . '"}}
                ]
            }',
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
    }



    //@desc
    //send media message
    public function sendMediaMessage($msg, $media, $num)
    {

        $ch = curl_init();
        $url = "https://aiwa.chat/api/send.php";
        $dataArray = [
            "number" => $num,
            "type" => "media",
            "media_url" => $media,
            "message" => $msg,
            "instance_id" => $this->instance_id,
            "access_token" => $this->access_token
        ];

        $data = http_build_query($dataArray);
        $getUrl = $url . "?" . $data;

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);

        $response = curl_exec($ch);
        curl_close($ch);
    }



    //@desc
    //whatsapp number validation
    public function checkNumber($num)
    {

        $ch = curl_init();
        $url = "https://aiwa.chat/api/send.php";
        $dataArray = [
            "number" => $num,
            "type" => 'check_phone',
            "instance_id" => $this->instance_id,
            "access_token" => $this->access_token,
        ];

        $data = http_build_query($dataArray);
        $getUrl = $url . "?" . $data;

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);

        $response = curl_exec($ch);
        $obj = json_decode($response);
        $sts = $obj->Status;

        if ($obj->Message == "available") {
            $res = "available";
        } else if ($obj->Message == "not available") {
            $res = "not available";
        } else {
            $res = "not";
        }

        curl_close($ch);
        return $res;
    }



    //blood donor custom list
    public function BloodDonorList($num)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://aiwa.chat/api/send.php?instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '&type=json&number=' . $num . '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
                "text": "🩸 To select the Blood Group Please click below",
                "footer": "Click Below",
                "title": "Select Blood Group",
                "buttonText": "🩸 Click Here",
                "sections": [
                    {
                        "title": "Section 1",
                        "rows": [
                            {
                                "title": "A+ Blood Donor",
                                "rowId": "A+",
                                "description": "By selecting here you can get the list of A+ Blood Donors in your location"
                            },
                            {
                                "title": "A- Blood Donor",
                                "rowId": "A-",
                                "description": "By selecting here you can get the list of A- Blood Donors in your location"
                            },
                            {
                                "title": "B+ Blood Donor",
                                "rowId": "B+",
                                "description": "By selecting here you can get the list of B+ Blood Donors in your location"
                            },
                            {
                                "title": "B- Blood Donor",
                                "rowId": "B-",
                                "description": "By selecting here you can get the list of B- Blood Donors in your location"
                            },
                            {
                                "title": "AB+ Blood Donor",
                                "rowId": "AB+",
                                "description": "By selecting here you can get the list of AB+ Blood Donors in your location"
                            },
                            {
                                "title": "AB- Blood Donor",
                                "rowId": "AB-",
                                "description": "By selecting here you can get the list of AB- Blood Donors in your location"
                            },
                            {
                                "title": "O+ Blood Donor",
                                "rowId": "O+",
                                "description": "By selecting here you can get the list of O+ Blood Donors in your location"
                            },
                            {
                                "title": "O- Blood Donor",
                                "rowId": "O-",
                                "description": "By selecting here you can get the list of O- Blood Donors in your location"
                            }
                        ]
                    }
                ]
            }',
        )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;


    }

            //@ EARN WITH TOWN
        //SEARCH BUTTON  
        public function singlebutton($number,$footer,$btnid,$display_text,$msg){  
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "text": "'.$msg.'",
                "footer": "'.$footer.'",
                "buttons": [
                    {"buttonId": "'.$btnid.'", "buttonText": {"displayText": "'.$display_text.'"}}
                ]
            }',
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;
            }
    
                //SEND LOCATION DEMO
    
        public function sendlocDemo($number,$loc_demovideo_url,$msge){  
            $phone = $number;
            $type = "media";
            $msg = $msge;
            $media_url = $loc_demovideo_url;
            $instance_id = $this->instance_id;
            $access_token = $this->access_token;
            $ch = curl_init();
            $url = "https://aiwa.chat/api/send.php";
            $dataArray = [
                "number" => $phone,
                "type" => $type,
                "message" => $msg,
                "media_url" => $media_url,
                "instance_id" => $instance_id,
                "access_token" => $access_token,
                ];
                $data = http_build_query($dataArray);
                $getUrl = $url . "?" . $data;
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                $response = curl_exec($ch);
                echo $response;
                curl_close($ch);
            }
    
            //SEND VIDEO AND BUTTON
    
        public function sendvideo($number,$media,$msg,$text,$vdobtnid,$display_txt){  
            $phone = $number;
            $type = "media";
            $msg = $msg;
            $media_url = $media;
            $instance_id = $this->instance_id;
            $access_token = $this->access_token;
            $ch = curl_init();
            $url = "https://aiwa.chat/api/send.php";
            $dataArray = [
                "number" => $phone,
                "type" => $type,
                "message" => $msg,
                "media_url" => $media_url,
                "instance_id" => $instance_id,
                "access_token" => $access_token,
                ];
                $data = http_build_query($dataArray);
                $getUrl = $url . "?" . $data;
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                $response = curl_exec($ch);
                echo $response;
                curl_close($ch);
               
                  //VIDEO BUTTON
               $curl = curl_init();
               curl_setopt_array($curl, [
                   CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_MAXREDIRS => 10,
                   CURLOPT_TIMEOUT => 0,
                   CURLOPT_FOLLOWLOCATION => true,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "POST",
                   CURLOPT_POSTFIELDS => '{
                       "text": "'.$text.'",
                       "footer": "",
                       "buttons": [
                           {"buttonId": "'.$vdobtnid.'", "buttonText": {"displayText": "'.$display_txt.'"}}
                       ]
                   }',
               ]);
               $response = curl_exec($curl);
               curl_close($curl);
               echo $response;
               }
    
                //SEND QUESTION 1
        public function sendquestion1($number,$question1,$ans_array){
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL =>'https://aiwa.chat/api/send.php?instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '&type=json&number=' .$number .'',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS =>
                        '{
                     "text": "' . $question1 . '",
                     "footer": "Click below to answer",
                     "title": "1st Question",
                     "buttonText": "question 1",
                     "sections": [
                         {
                             "title": "options",
                             "rows": [
                                 {
                                     "title": "' .$ans_array[0] .'",
                                     "rowId": "' . $ans_array[0].'"
                                 },
                                 {
                                     "title": "' . $ans_array[1].'",
                                     "rowId": "' . $ans_array[1].'"
                                 },
                                 {
                                     "title": "' .$ans_array[2].'",
                                     "rowId": "' . $ans_array[2].'"
                                 }
                             ]
                         }
                     ]
                 }',
                ]);
                $response = curl_exec($curl);
                curl_close($curl);
                echo $response;
                }
    
                //SEND QUESTION 2
                    public function sendquestion2($number,$question2,$scnd_ans_array){
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL =>'https://aiwa.chat/api/send.php?instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '&type=json&number=' .$number .'',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS =>
                                '{
                             "text": "'.$question2.'",
                             "footer": "click below to answer",
                             "title": "2nd Question",
                             "buttonText": "Select the right answer",
                             "sections": [
                                 {
                                     "title": "options",
                                     "rows": [
                                         {
                                             "title": "' . $scnd_ans_array[0].'",
                                             "rowId": "q_2_' .$scnd_ans_array[0].'"
                                         },
                                         {
                                             "title": "' . $scnd_ans_array[1].'",
                                             "rowId": "q_2_' .$scnd_ans_array[1].'"
                                         },
                                         {
                                             "title": "' .$scnd_ans_array[2].'",
                                             "rowId": "q_2_' . $scnd_ans_array[2].'"
                                         }
                                     ]
                                 }
                             ]
                         }',
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                    }
    
                         //IF QUESTION 1 RIGHT ANSWER
                    function Q1_rightansr($msg,$number){     
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => '{
                                "text": "'.$msg.'",
                                "footer": "Click NEXT QUESTION to your second question",
                                "buttons": [
                                    {"buttonId": "next_question", "buttonText": {"displayText": "NEXT QUESTION"}}
                                ]
                            }',
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                        }
    
                        //IF ANSWERS RIGTH 
                   public function rightanswer($number,$msge,$footer,$btnid,$btntext){               
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => '{
                                "text": "'.$msge.'",
                                "footer": "'.$footer.'",
                                "buttons": [{"buttonId": "'.$btnid.'", "buttonText": {"displayText": "'.$btntext.'"}}]
                            }',
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                    }
    
                    //IF WRONG ANSWER
                   public function wronganswer($number,$msge,$footer,$btnid,$btntext){               
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => '{
                            "text": "'.$msge.'",
                            "footer": "'.$footer.'",
                            "buttons": [{"buttonId": "'.$btnid.'", "buttonText": {"displayText": "'.$btntext.'"}}]
                        }',
                    ]);
                    $response = curl_exec($curl);
                    curl_close($curl);
                    echo $response;
                }

    
                    //NEXT
                    public function nextvideo($number,$msge){               
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => '{
                                "text": "'.$msge.'",
                                "footer": " ",
                                "buttons": [{"buttonId": "get_started_btn", "buttonText": {"displayText": "NEXT"}}]
                            }',
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                    }
    
                                    //NEXT
                    public function start_again($number,$msge){               
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => '{
                                "text": "'.$msge.'",
                                "footer": "Click below to Main Menu",
                                "buttons": [
                                    {"buttonId": "marketplace", "buttonText": {"displayText": "MARKET PLACE"}},
                                    {"buttonId": "referthe_game", "buttonText": {"displayText": "REFER FRIEND"}}
                                ]
                            }',
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                    }
    
                                                    //NEXT
                    public function referral_join_btn($number,$msge){               
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => '{
                                "text": "'.$msge.'",
                                "footer": "Click Below to Start the Game",
                                "buttons": [
                                    {"buttonId": "hi", "buttonText": {"displayText": "Start"}}
                                ]
                            }',
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                    }
    
    
                            //CLICK BELOW TO REFER
                    public function click_below_torefer($number,$msge){               
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => '{
                                "text": "'.$msge.'",
                                "footer": "Click Below",
                                "buttons": [
                                    {"buttonId": "get_referral_link", "buttonText": {"displayText": "GET LINK"}}
                                ]
                            }',
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                    }
    
                    public function pay_confirm_btn($msg, $num, $btn1, $btnid1)
                    {
                
                        $curl = curl_init();
                        curl_setopt_array(
                            $curl,
                            array(
                            CURLOPT_URL => 'https://aiwa.chat/api/send.php?number=' . $num . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => '{
                                "text": "' . $msg . '",
                                "footer": "Click Below",
                                "buttons": [
                                    {"buttonId": "' . $btnid1 . '", "buttonText": {"displayText": "' . $btn1 . '"}}
                                ]
                            }',
                            )
                        );
                
                        $response = curl_exec($curl);
                        curl_close($curl);
                    }
    
                                //SEND QUESTION 2
                    public function marketplace_list($number,$text,$footer,$title,$buttontext,$list1,$listid1,$list2,$listid2,$list3,$listid3,$list4,$listid4,$list5,$listid5,$list7,$listid7,$list8,$listid8){
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL =>'https://aiwa.chat/api/send.php?instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '&type=json&number=' .$number .'',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS =>
                                '{
                             "text": "'.$text.'",
                             "footer": "'.$footer.'",
                             "title": "'.$title.'",
                             "buttonText": "'.$buttontext.'",
                             "sections": [
                                 {
                                     "title": "options",
                                     "rows": [
                                         {
                                             "title": "' . $list1.'",
                                             "rowId": "' .$listid1.'"
                                         },
                                         {
                                             "title": "' .$list2.'",
                                             "rowId": "' .$listid2.'"
                                         },
                                         {
                                             "title": "' .$list3.'",
                                             "rowId": "' .$listid3.'"
                                         },
                                         {
                                             "title": "' .$list4.'",
                                             "rowId": "' .$listid4.'"
                                         },
                                         {
                                             "title": "' .$list5.'",
                                             "rowId": "' .$listid5.'"
                                         },
                                         {
                                             "title": "' .$list7.'",
                                             "rowId": "' .$listid7.'"
                                         },
                                         {
                                             "title": "' .$list8.'",
                                             "rowId": "' .$listid8.'"
                                         }
                                     ]
                                 }
                             ]
                         }',
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                    }
    
                            //SEND AVAILABLE PRODUCTS AND BUTTON
    
        public function send_available_product($number,$media,$msg,$text,$vdobtnid1,$display_txt1,$vdobtnid2,$display_txt2){  
            $phone = $number;
            $type = "media";
            $msg = $msg;
            $media_url = $media;
            $instance_id = $this->instance_id;
            $access_token = $this->access_token;
            $ch = curl_init();
            $url = "https://aiwa.chat/api/send.php";
            $dataArray = [
                "number" => $phone,
                "type" => $type,
                "message" => $msg,
                "media_url" => $media_url,
                "instance_id" => $instance_id,
                "access_token" => $access_token,
                ];
                $data = http_build_query($dataArray);
                $getUrl = $url . "?" . $data;
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                $response = curl_exec($ch);
                echo $response;
                curl_close($ch);
               
                  //PRODUCT BUTTONS
               $curl = curl_init();
               curl_setopt_array($curl, [
                   CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_MAXREDIRS => 10,
                   CURLOPT_TIMEOUT => 0,
                   CURLOPT_FOLLOWLOCATION => true,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "POST",
                   CURLOPT_POSTFIELDS => '{
                       "text": "'.$text.'",
                       "footer": "'.$footer.'",
                       "buttons": [
                           {"buttonId": "'.$vdobtnid1.'", "buttonText": {"displayText": "'.$display_txt1.'"}},
                           {"buttonId": "'.$vdobtnid2.'", "buttonText": {"displayText": "'.$display_txt2.'"}}
                       ]
                   }',
               ]);
               $response = curl_exec($curl);
               curl_close($curl);
               echo $response;
               }
    
                     //SEND NOT AVAILABLE PRODUCTS AND BUTTON
    
        public function send_notavailable_product($number,$media,$msg,$text,$vdobtnid1,$display_txt1){  
            $phone = $number;
            $type = "media";
            $msg = $msg;
            $media_url = $media;
            $instance_id = $this->instance_id;
            $access_token = $this->access_token;
            $ch = curl_init();
            $url = "https://aiwa.chat/api/send.php";
            $dataArray = [
                "number" => $phone,
                "type" => $type,
                "message" => $msg,
                "media_url" => $media_url,
                "instance_id" => $instance_id,
                "access_token" => $access_token,
                ];
                $data = http_build_query($dataArray);
                $getUrl = $url . "?" . $data;
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                $response = curl_exec($ch);
                echo $response;
                curl_close($ch);
               
                  //PRODUCT BUTTONS
               $curl = curl_init();
               curl_setopt_array($curl, [
                   CURLOPT_URL =>'https://aiwa.chat/api/send.php?number=' . $number . '&type=json&instance_id=' . $this->instance_id . '&access_token=' . $this->access_token . '',
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_MAXREDIRS => 10,
                   CURLOPT_TIMEOUT => 0,
                   CURLOPT_FOLLOWLOCATION => true,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "POST",
                   CURLOPT_POSTFIELDS => '{
                       "text": "'.$text.'",
                       "footer": "'.$footer.'",
                       "buttons": [
                           {"buttonId": "'.$vdobtnid1.'", "buttonText": {"displayText": "'.$display_txt1.'"}}
                       ]
                   }',
               ]);
               $response = curl_exec($curl);
               curl_close($curl);
               echo $response;
               }
}

?>