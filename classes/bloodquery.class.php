<?php


class BloodQuery extends Dbh
{

    //insert query`s

    //insert new entry in table
    public function insert_blood_donor($number, $listId, $time)
    {

        $phone = substr($number, 2);

        try {
            $stmt = $this->connect()->prepare('INSERT INTO blood_donors (phone, blood_group, created_date) VALUES (?, ?, ?)');

            if (!$stmt->execute(array($phone, $listId, $time))) {
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



    //fetch query`s

    //fetching matching column entry
    public function check_blood_user($number)
    {

        $phone = substr($number, 2);

        $stmt = $this->connect()->prepare('SELECT phone FROM blood_donors WHERE phone = ?');

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


    //fetching column value
    public function check_donor_status($number)
    {

        $phone = substr($number, 2);

        $stmt = $this->connect()->prepare('SELECT donor_status FROM blood_donors WHERE phone = ?');

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


    public function get_donor_stmt($number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "SELECT * FROM blood_donors WHERE phone = ?";
            $stmt = $this->connect()->prepare($sql);

            $stmt->execute([$phone]);
            $numbers = $stmt->fetchAll();

            return $numbers;

        } catch (PDOException $e) {
            $return = "Your fail message: " . $e->getMessage();
        }

    }


    //update stmt


    //update donor name
    public function update_donor_name($conversation, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE blood_donors SET name = ? WHERE phone=?";
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


    //updating lat long and time
    public function update_donor_location($latitude, $longitude, $currentTime, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE blood_donors SET latitude = ?, longitude = ?, location_time = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$latitude, $longitude, $currentTime, $phone])) {
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


    //updating donor gender
    public function update_donor_gender($buttonId, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE blood_donors SET gender = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$buttonId, $phone])) {
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



    //updating donor status
    public function update_donor_status($status, $currentTime, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE blood_donors SET donor_status = ?, last_login = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$status, $currentTime, $phone])) {
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




    //delete stmt

    //delete donor entry from table
    public function delete_donor_entry($number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "DELETE FROM `blood_donors` WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$phone])) {
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