<?php


class BusinessQuery extends Dbh
{

    public function check_bs_user($number)
    {
        $phone = substr($number, 2);

        $stmt = $this->connect()->prepare('SELECT phone FROM bs_register WHERE phone = ?');

        if (!$stmt->execute(array($phone))) {
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


    public function get_bs_stmt($number)
    {
        $phone = substr($number, 2);


        try {
            $sql = "SELECT * FROM bs_register WHERE phone = ?";
            $stmt = $this->connect()->prepare($sql);

            $stmt->execute([$phone]);
            $numbers = $stmt->fetchAll();

            // foreach($names as $name){
            //     echo $name['username'];
            // }

            return $numbers;

        } catch (PDOException $e) {
            //error
            $return = "Your fail message: " . $e->getMessage();
        }

    }



    //inserting new user
    public function insert_new_bs($number, $time)
    {

        $phone = substr($number, 2);

        try {
            $stmt = $this->connect()->prepare('INSERT INTO bs_register (phone, created_date) VALUES (?, ?)');

            if (!$stmt->execute(array($phone, $time))) {
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


    public function update_bs_name($conversation, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE bs_register SET name = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$conversation, $phone])) {
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


    public function update_bs_category($conversation, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE bs_register SET category = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$conversation, $phone])) {
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


    public function update_bs_contact($conversation, $number){

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE bs_register SET contact = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$conversation, $phone])) {
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


    public function update_bs_keywords($conversation, $number){

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE bs_register SET keyword = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$conversation, $phone])) {
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


    public function update_bs_location($latitude, $longitude, $time, $bs_status, $number){

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE bs_register SET latitude = ?, longitude = ?, location_time = ?, bs_status = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$latitude, $longitude, $time, $bs_status, $phone])) {
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


    public function update_bs_search_key($conversation, $number){

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE bs_register SET search_keyword = ? WHERE phone = ?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$conversation, $phone])) {
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


    public function insert_bs_keyword($number, $keyword){

        $phone = substr($number, 2);

        try {
            $sql = "INSERT INTO bs_keywords (phone, keyword) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$phone, $keyword])) {
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


    public function update_keyword_location($lat, $log, $number){

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE bs_keywords SET latitude = ?, longitude = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$lat, $log, $phone])) {
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


    public function check_bs_status($number)
    {

        $phone = substr($number, 2);

        $stmt = $this->connect()->prepare('SELECT bs_status FROM bs_register WHERE phone = ?');

        if (!$stmt->execute(array($phone))) {
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
}