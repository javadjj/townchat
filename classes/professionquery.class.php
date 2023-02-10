<?php


class ProfessionQuery extends Dbh
{

    public function check_pr_user($number)
    {

        $phone = substr($number, 2);

        $stmt = $this->connect()->prepare('SELECT phone FROM pr_register WHERE phone = ?');

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


    public function get_pr_stmt($number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "SELECT * FROM pr_register WHERE phone = ?";
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
            $stmt = $this->connect()->prepare('INSERT INTO pr_register (phone, created_date) VALUES (?, ?)');

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


    public function update_pr_name($conversation, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE pr_register SET name = ? WHERE phone=?";
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


    public function update_pr_category($conversation, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE pr_register SET category = ? WHERE phone=?";
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


    public function update_pr_contact($conversation, $number){

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE pr_register SET contact = ? WHERE phone=?";
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


    public function update_pr_keywords($conversation, $number){

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE pr_register SET keyword = ? WHERE phone=?";
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


    public function update_pr_location($latitude, $longitude, $time, $pr_status, $number){

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE pr_register SET latitude = ?, longitude = ?, location_time = ?, pr_status = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$latitude, $longitude, $time, $pr_status, $phone])) {
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


    public function insert_pr_keyword($number, $keyword){

        $phone = substr($number, 2);

        try {
            $sql = "INSERT INTO pr_keywords (phone, keyword) VALUES (?, ?)";
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
            $sql = "UPDATE pr_keywords SET latitude = ?, longitude = ? WHERE phone=?";
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


    public function check_pr_status($number)
    {

        $phone = substr($number, 2);

        $stmt = $this->connect()->prepare('SELECT pr_status FROM pr_register WHERE phone = ?');

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