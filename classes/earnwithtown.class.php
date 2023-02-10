<?php
class EarnwithTown extends Dbh
{     
    public function check_number($number)
    {
        $stmt = $this->connect()->prepare('SELECT phone FROM earn_user WHERE phone = ?');
        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }
        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck = $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }


   public function savenumber($number,$regstrd_dateTime)
    {
        try {
            $stmt = $this->connect()->prepare('INSERT INTO earn_user (phone,reg_datetime) VALUES (?,?)');
            if (!$stmt->execute(array($number,$regstrd_dateTime))) {
                $stmt = null;
    
                $res = true;
            }
            $stmt = null;
            $res = false;
            return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
            return $return;
        }
    }
            //UPDATE USER NAME 
    public function update_user_name($pushname,$number)
    {
        try {
            $sql = "UPDATE earn_user SET username =? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$pushname,$number])) {
                $stmt = null;
                $res = true;
            }
            $stmt = null;
            $res = false;
            return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
        }
    }

    public function update_btn_id($buttonId,$number)
    {
        try {
            $sql = "UPDATE earn_user SET active_btn_id = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$buttonId,$number])) {
                $stmt = null;
                $res = true;
            }
            $stmt = null;
            $res = false;

            return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
        }
    }
        //FETCH ACTIVE BUTTON ID
    public function fetch_btn_id($number)
    {
        $stmt = $this->connect()->prepare('SELECT active_btn_id FROM earn_user WHERE phone = ? ');
        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }
        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck = $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }

            //FETCH ACTIVE LIST ID
    public function fetch_list_id($number)
    {
        $stmt = $this->connect()->prepare('SELECT active_list_id FROM earn_user WHERE phone = ? ');
        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }
        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck = $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }
    

    public function update_lat_long($latitude,$longitude,$number)
    {
        try {
            $sql = "UPDATE earn_user SET latitude = ?,longitude = ?,status='registered'WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$latitude,$longitude,$number])) {
                $stmt = null;
                $res = true;
            }
            $stmt = null;
            $res = false;
            return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
        }
    }

        //SELECT LATTITUDE
    public function get_latitude($number)
    {
        $stmt = $this->connect()->prepare('SELECT latitude FROM earn_user WHERE phone = ? ');

        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }
        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck = $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }

            //SELECT LONGITUDE
    public function get_longitude($number)
    {
        $stmt = $this->connect()->prepare('SELECT longitude FROM earn_user WHERE phone = ? ');
        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }
        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck = $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }

    //CHECH VIDEO ID FROM VIEWED VIDEO ID
    public function viewed_vdo_id($number)
    {
        $stmt = $this->connect()->prepare('SELECT Ad_id FROM earn_viewed_vido WHERE phone = ? ');
        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }
        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck = $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }

        ////FETCH CLOSEST VIDEOS

    public function get_distnc_data($latitude, $longitude,$number)
    {
        try {
            $sql = "SELECT  `video_url`, `latitude`, `longitude`, `name`, `Ad_id`, ( 6367 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) 
            AS distance FROM earn_bss_rgstr bs WHERE NOT bs.budjet <= 0 AND bs.Ad_id not in (SELECT vid.Ad_id FROM earn_viewed_vido vid WHERE vid.phone =? ) order by distance limit 1";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$latitude, $longitude, $latitude,$number])) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchAll();
            } else {
                $resultCheck = false;
            }
            return $resultCheck;
        } catch (PDOException $e) {
            $return = "Your fail message: " . $e->getMessage();
            return $return;
        }
    }
            //GET VIDEO BASED ON BUSINESS ID
    public function get_business_id_data($conversation)
    {
        try {
            $iddata = "SELECT  `video_url`, `name`, `Ad_id` FROM earn_bss_rgstr bs WHERE Ad_id =?";
            $stmt = $this->connect()->prepare($iddata);
            if (!$stmt->execute([$conversation])) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchAll();
            } else {
                $resultCheck = false;
            }
            return $resultCheck;
        } catch (PDOException $e) {
            $return = "Your fail message: " . $e->getMessage();
            return $return;
        }
    }

                //INSERT VIEWED VIDEO ID
       public function sve_viwd_v_id($number,$Ad_id,$video_name)
    {
        try {
            $stmt = $this->connect()->prepare('INSERT INTO earn_viewed_vido (phone,Ad_id,video_name) VALUES (?,?,?)');
            if (!$stmt->execute(array($number,$Ad_id,$video_name))) {
                $stmt = null;
                $res = true;
            }
            $stmt = null;
            $res = false;
            return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
            return $return;
        }
    }    
    
        //UPDATE BUTTON ID IN EARN_USER
    public function update_ad_id($vdo_cunt,$ad_id,$number)
    {
       
        try {
            $sql = "UPDATE earn_user SET current_ad_id =? ,daily_video_cont=? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$ad_id,$vdo_cunt,$number])) {
                $stmt = null;
                $res = true;
            }
            $stmt = null;
            $res = false;
            return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
        }
    }



         //FETCH CURRENT AD_ID
    public function current_ad_id($number)
    {
        $stmt = $this->connect()->prepare('SELECT current_ad_id FROM earn_user WHERE phone = ? ');
        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }
        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck = $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }

            //FETCH ALL USER VALUES

        public function all_user_values($number)
            {
                $sql = "SELECT * FROM earn_user WHERE phone = ?";
                $stmt = $this->connect()->prepare($sql);
                if (!$stmt->execute([$number])) {
                    $stmt = null;
                }
                $resultCheck = "";
                if ($stmt->rowCount() > 0) {
                    $resultCheck = $stmt->fetchAll();
                } else {
                    $resultCheck = false;
                }
                    return $resultCheck;
            }

                        //FETCH USER NUMBER

        public function check_referral_code($conversation)
        {
            $u_phone = "SELECT username FROM earn_user where referel_code =?";
            $stmt = $this->connect()->prepare($u_phone);
            if (!$stmt->execute([$conversation])) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchAll();
            } else {
                $resultCheck = false;
            }
                return $resultCheck;
        }

        //FETCH ALL QUESTIONS AND VALUES FROM BUSINESS
        public function all_bsns_values($current_ad_id)
        {
                $sql = "SELECT * FROM earn_bss_rgstr WHERE Ad_id = ?";
                $stmt = $this->connect()->prepare($sql);
    
                if (!$stmt->execute([$current_ad_id])) {
                    $stmt = null;
                }
                $resultCheck = "";
                if ($stmt->rowCount() > 0) {
                    $resultCheck = $stmt->fetchAll();
                } else {
                    $resultCheck = false;
                }
                return $resultCheck;
        }

                    //UPDATE LIST ID
        public function update_list_id($listId,$number)
        {
            try {
                $sql = "UPDATE earn_user SET active_list_id =? WHERE phone=?";
                $stmt = $this->connect()->prepare($sql);
                if (!$stmt->execute([$listId,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }
            //UPDATE STATUS AND QUESTION 1
        public function update_Q1_sts($sts,$number)
        {
            try {
                $usts = "UPDATE earn_user SET status =? WHERE phone=?";
                $stmt = $this->connect()->prepare($usts);
                if (!$stmt->execute([$sts,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

                    //UPDATE STATUS AND QUESTION 1
        public function update_Q1_ansr($listId,$number)
        {
            try {
                $ansr = "UPDATE earn_user SET question1_user_answer =? WHERE phone=?";
                $stmt = $this->connect()->prepare($ansr);
                if (!$stmt->execute([$listId,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

            //UPDATE STATUS AND QUESTION 2
        public function update_Q2_sts($listId,$sts,$number)
        {
            $rmove_q2prfix = substr($listId, 4);
            try {
                $sts_q2 = "UPDATE earn_user SET question2_user_answer =?, status =? WHERE phone=?";
                $stmt = $this->connect()->prepare($sts_q2);
                if (!$stmt->execute([$rmove_q2prfix,$sts,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

                 //FETCH user status
    public function current_usr_sts($number)
        {
            $stmt = $this->connect()->prepare('SELECT status FROM earn_user WHERE phone = ? ');
            if (!$stmt->execute(array($number))) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchColumn();
            } else {
                $resultCheck = false;
            }
            return $resultCheck;
    }

            //UPDATE HIGH PONTS AND BUDJET
    public function update_high_point_budjt($towncoins,$budjet,$number,$current_ad_id,$value_array,$totalarrcunts,$current_user_time)
        {
            //$arrynumbers = rand(0,3);
            //shuffle($arrynumbers);
            $totaltowncoins = $towncoins+$value_array[$totalarrcunts];
            $earnings = $totaltowncoins/1000;                                      
            $budjet = $budjet-1;
            try {
                $sql = "UPDATE earn_user mu JOIN earn_bss_rgstr mb ON (mu.current_ad_id = mb.Ad_id) 
                SET mu.towncoins= ?, mb.budjet = ?,	mu.earnings =?,mu.current_user_time =?, mu.highcoin_arraycount=?  WHERE mu.phone = ? AND mb.Ad_id=?";
                $stmt = $this->connect()->prepare($sql);
                if (!$stmt->execute([$totaltowncoins,$budjet,$earnings,$current_user_time,$totalarrcunts,$number,$current_ad_id])) {
                    $stmt = null;
                    $res = true;
                }
                    $stmt = null;
                    $res = false;
                    return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }  

                    //UPDATE low PONTS AND BUDJET
    public function update_low_point_budjt($towncoins,$budjet,$number,$current_ad_id,$low_value,$lowarrcunts,$current_user_time)
    {

        $totaltowncoins = $towncoins+$low_value[$lowarrcunts];
        $earnings = $totaltowncoins/1000;                                      
        $budjet = $budjet-1;
        try {
            $sql = "UPDATE earn_user mu JOIN earn_bss_rgstr mb ON (mu.current_ad_id = mb.Ad_id) 
            SET mu.towncoins= ?, mb.budjet = ?,	mu.earnings =?, mu.current_user_time =?, mu.lowcoin_arraycount=?  WHERE mu.phone = ? AND mb.Ad_id=?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$totaltowncoins,$budjet,$earnings,$current_user_time,$lowarrcunts,$number,$current_ad_id])) {
                $stmt = null;
                $res = true;
            }
                $stmt = null;
                $res = false;
                return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
        }
    } 

        public function check_vdo_cunt($number)
        {
            $stmt = $this->connect()->prepare('SELECT daily_video_cont FROM earn_user WHERE phone = ?');
            if (!$stmt->execute(array($number))) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchColumn();
            } else {
                $resultCheck = false;
            }
            return $resultCheck;
        }

                    //UPDATE DAILY LIMIT
        public function update_daily_lmt($dailylimit,$limitsts,$referalcode,$refstatus,$number)
        {
            try {
                $Dlimit = "UPDATE earn_user SET daily_limit =?, dailylimit_sts=?, referel_code=?, referral_status=? WHERE phone=?";
                $stmt = $this->connect()->prepare($Dlimit);
                if (!$stmt->execute([$dailylimit,$limitsts,$referalcode,$refstatus,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }   

                            //UPDATE REFERAL CODE
        public function update_referal_code($referalcode,$refstatus,$number)
        {
            try {
                $Dlimit = "UPDATE earn_user SET referel_code=?,referral_status=? WHERE phone=?";
                $stmt = $this->connect()->prepare($Dlimit);
                if (!$stmt->execute([$referalcode,$refstatus,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }
        
        
        //UPDATE TOMORROWs LIMIT
        public function update_tomrrw_lmt($increased_daily_limit,$number)
        {
            try {
                $tomLimit = "UPDATE earn_user SET daily_limit =? WHERE phone=?";
                $stmt = $this->connect()->prepare($tomLimit);
                if (!$stmt->execute([$increased_daily_limit,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }
            //UPDATE DAILY LIMIT STATUS 
        public function update_dailylmt_sts($dailylimit,$number)
        {
            try {
                $Dlimit = "UPDATE earn_user SET dailylimit_sts =? WHERE phone=?";
                $stmt = $this->connect()->prepare($Dlimit);
                if (!$stmt->execute([$dailylimit,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }
            //CHECK DAILY LIMIT STATUS
        public function check_dailylmt_sts($number)
        {
            $stmt = $this->connect()->prepare('SELECT dailylimit_sts FROM earn_user WHERE phone = ?');
            if (!$stmt->execute(array($number))) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchColumn();
            } else {
                $resultCheck = false;
            }
            return $resultCheck;
        }

        public function reset_coin_arrys_cunt($number)
        {
            try {
                $reset = "UPDATE earn_user SET highcoin_arraycount =-1 WHERE phone=?";
                $stmt = $this->connect()->prepare($reset);
                if (!$stmt->execute([$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }


        
                //UPDATE USER NUMBER TO COIN VALUE TABLE
        public function update_user_coinvalue($user_dateTime,$pushName,$number)
        {
            try {
                $stmt = $this->connect()->prepare('INSERT INTO earn_coinvalues (datetime,name,phone) VALUES (?,?,?)');
                if (!$stmt->execute(array($user_dateTime,$pushName,$number))) {
                    $stmt = null;
        
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
                return $return;
            }
        }

                //GENARATE 15 RANDOM VALUES -TOTAL 15000
        public function divideIntoFifteen($value, $min ,$max) {
            $parts = array();
            $parts[] = mt_rand($min, min($max, $value - 14 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - 13 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - 12 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - 11 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - 10 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - 9 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - 8 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - 7 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - $parts[7] - 6 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - $parts[7] - $parts[8] - 5 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - $parts[7] - $parts[8] - $parts[9] - 4 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - $parts[7] - $parts[8] - $parts[9] - $parts[10] - 3 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - $parts[7] - $parts[8] - $parts[9] - $parts[10] - $parts[11] - 2 * $min));
            $parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - $parts[7] - $parts[8] - $parts[9] - $parts[10] - $parts[11] - $parts[12]  - 1 * $min));
            //$parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - $parts[7] - $parts[8] - $parts[9] - $parts[10] - $parts[11] - $parts[12]  - $parts[13] - $min));
            //$parts[] = mt_rand($min, min($max, $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] - $parts[6] - $parts[7] - $parts[8] - $parts[9] - $parts[10] - $parts[11] - $parts[12]  - $parts[13] - $parts[14] - $min));
            $parts[] = $value - $parts[0] - $parts[1] - $parts[2] - $parts[3] - $parts[4] - $parts[5] -$parts[6] - $parts[7] - $parts[8] - $parts[9] - $parts[10] - $parts[11] - $parts[12] - $parts[13] ;
            return $parts;
        }

        public function update_15000_TC_values($parts,$number)
        {
            try {
                $update_15000 = "UPDATE earn_coinvalues SET value1 =?,value2 =?,value3 =?,value4 =?,value5 =?,value6 =?,value7 =?,value8 =?,value9 =?,value10 =?,value11 =?,value12 =?,value13 =?,value14 =?,value15 =?,
                status='value_updated' WHERE phone=?";
                $stmt = $this->connect()->prepare($update_15000);
                if (!$stmt->execute([$parts[0],$parts[1],$parts[2],$parts[3],$parts[4],$parts[5],$parts[6],$parts[7],$parts[8],$parts[9],$parts[10],$parts[11],$parts[12],$parts[13],$parts[14],$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

        public function reset_TC_values($null,$sts_null,$number)
        {
            try {
                $reset_15000 = "UPDATE earn_coinvalues SET value1 = ?,value2 =?,value3 =?,value4 =?,value5 =?,value6 =?,value7 =?,value8 =?,value9 =?,value10 =?,value11 =?,value12 =?,value13 =?,value14 =?,value15 =?, status=? WHERE phone=?";
                $stmt = $this->connect()->prepare($reset_15000);
                if (!$stmt->execute([$null,$null,$null,$null,$null,$null,$null,$null,$null,$null,$null,$null,$null,$null,$null,$sts_null,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

                //FETCH ALL COIN VALUES
        public function fetch_coinvalues($number)
        {
            $sql = "SELECT * FROM earn_coinvalues WHERE phone =?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$number])) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchAll();
            } else {
                $resultCheck = false;
            }
                return $resultCheck;
        }


        public function check_number_coinvalue($number)
        {
            $stmt = $this->connect()->prepare('SELECT phone FROM earn_coinvalues WHERE phone = ?');
            if (!$stmt->execute(array($number))) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchColumn();
            } else {
                $resultCheck = false;
            }
            return $resultCheck;
        }


                    //ADD REFERRAL COINS
        public function add_referral_coins($coins,$reffbonus,$conversation,$number)
        {
            $totalcoin = $coins+$reffbonus;
            try {
                $reset = "UPDATE earn_user SET towncoins =?, refered_code=? WHERE phone=?";
                $stmt = $this->connect()->prepare($reset);
                if (!$stmt->execute([$totalcoin,$conversation,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

                    //ADD REFERRAL COINS TO REFARRED USER
        public function add_coins_to_tefarred_user($totalcoin,$addrefrr,$reff_code)
        {

            try {
                $reset = "UPDATE earn_user SET towncoins =?, total_refarrals=? WHERE referel_code=?";
                $stmt = $this->connect()->prepare($reset);
                if (!$stmt->execute([$totalcoin,$addrefrr,$reff_code])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }
        
                    //referral status and video count

        public function check_referral_sts($reff_code)
            {
                $sql = "SELECT * FROM earn_user WHERE referel_code = ?";
                $stmt = $this->connect()->prepare($sql);
                if (!$stmt->execute([$reff_code])) {
                    $stmt = null;
                }
                $resultCheck = "";
                if ($stmt->rowCount() > 0) {
                    $resultCheck = $stmt->fetchAll();
                } else {
                    $resultCheck = false;
                }
                    return $resultCheck;
            }

                    //FETCH REFERAL CODE
            public function check_teferl_code($number)
            {
                $stmt = $this->connect()->prepare('SELECT refered_code FROM earn_user WHERE phone = ?');
                if (!$stmt->execute(array($number))) {
                    $stmt = null;
                }
                $resultCheck = "";
                if ($stmt->rowCount() > 0) {
                    $resultCheck = $stmt->fetchColumn();
                } else {
                    $resultCheck = false;
                }
                return $resultCheck;
            }

                                //UPDATE REFERRAL STATUS
        public function update_referral_sts($refrral_sts,$number)
        {
            try {
                $refsts = "UPDATE earn_user SET referral_status=? WHERE phone=?";
                $stmt = $this->connect()->prepare($refsts);
                if (!$stmt->execute([$refrral_sts,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

             //CHECK DELIVERY ADDRESS
            public function check_delivry_address($number)
            {
                $stmt = $this->connect()->prepare('SELECT delivery_address FROM earn_user WHERE phone = ?');
                if (!$stmt->execute(array($number))) {
                    $stmt = null;
                }
                $resultCheck = "";
                if ($stmt->rowCount() > 0) {
                    $resultCheck = $stmt->fetchColumn();
                } else {
                    $resultCheck = false;
                }
                return $resultCheck;
            }
        
             //UPDATE DELIVERY ADDRESS
        public function update_delivery_address($conversation,$number)
        {
            try {
                $delv_address = "UPDATE earn_user SET delivery_address =? WHERE phone=?";
                $stmt = $this->connect()->prepare($delv_address);
                if (!$stmt->execute([$conversation,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }
            //FETCH PRODUCT DETAILS TO MARKETPLACE
        public function fetch_products($category,$crrnt_pro_count)
        {
            $sql = "SELECT * FROM earn_marketplace_products where category=? and id > ? order by id limit 1";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$category,$crrnt_pro_count])) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchAll();
            } else {
                $resultCheck = false;
            }
                return $resultCheck;
        }

            //FETCH PRODUCT based on id
        public function fetch_products_with_id($pro_id1)
        {
            $proid = "SELECT * FROM earn_marketplace_products where product_id=?";
            $stmt = $this->connect()->prepare($proid);
            if (!$stmt->execute([$pro_id1])) {
                $stmt = null;
            }
            $resultCheck = "";
            if ($stmt->rowCount() > 0) {
                $resultCheck = $stmt->fetchAll();
            } else {
                $resultCheck = false;
            }
                return $resultCheck;
        }

        //UPDATE MARKETPLACE USER

   public function insert_new_order($number,$pushName,$order_time,$order_address,$pro_id2,$order_sts,$pro_name1,$pro_price1)
    {
        try {
            $stmt = $this->connect()->prepare('INSERT INTO earn_marketplace_user (datetime,name,phone,address,product_id,status,product_price,product_name) VALUES (?,?,?,?,?,?,?,?)');
            if (!$stmt->execute(array($order_time,$pushName,$number,$order_address,$pro_id2,$order_sts,$pro_price1,$pro_name1))) {
                $stmt = null;
    
                $res = true;
            }
            $stmt = null;
            $res = false;
            return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
            return $return;
        }
    }

                 //UPDATE CURRENT PRODUCT ID
        public function update_current_product_id($pro_id,$id,$number)
        {
            try {
                $delv_address = "UPDATE earn_user SET current_product_id =?,current_pro_count=? WHERE phone=?";
                $stmt = $this->connect()->prepare($delv_address);
                if (!$stmt->execute([$pro_id,$id,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

                     //CHECK CATEGORY
            public function check_category($actve_list_id)
            {
                $stmt = $this->connect()->prepare('SELECT category FROM earn_marketplace_products where category=? ');
                if (!$stmt->execute(array($actve_list_id))) {
                    $stmt = null;
                }
                $resultCheck = "";
                if ($stmt->rowCount() > 0) {
                    $resultCheck = $stmt->fetchColumn();
                } else {
                    $resultCheck = false;
                }
                return $resultCheck;
            }

                             //UPDATE TOWN COINS AFTER PRODUCT PURCHASE
        public function update_town_coins_after_purchase($coins,$number)
        {
            try {
                $delv_address = "UPDATE earn_user SET towncoins =? WHERE phone=?";
                $stmt = $this->connect()->prepare($delv_address);
                if (!$stmt->execute([$coins,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

           //RESET PRODUCT LIST ID
        public function reset_product_list_id($pro_count,$number)
        {
            try {
                $delv_address = "UPDATE earn_user SET current_pro_count =? WHERE phone=?";
                $stmt = $this->connect()->prepare($delv_address);
                if (!$stmt->execute([$pro_count,$number])) {
                    $stmt = null;
                    $res = true;
                }
                $stmt = null;
                $res = false;
                return $res;
            } catch (PDOException $e) {
                //error
                $return = "Your fail message: " . $e->getMessage();
            }
        }

                //UPDATE BUSINESS DEMO BUTTON ID IN EARN_USER
    public function update_demo_ad_id($ad_id,$number)
    {
       
        try {
            $sql = "UPDATE earn_user SET current_ad_id =? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$ad_id,$number])) {
                $stmt = null;
                $res = true;
            }
            $stmt = null;
            $res = false;
            return $res;
        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
        }
    }
}