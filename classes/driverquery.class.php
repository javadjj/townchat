<?php


class DriverQuery extends Dbh
{

    public function check_driver_user($number)
    {

        $phone = substr($number, 2);

        $stmt = $this->connect()->prepare('SELECT phone FROM town_drivers WHERE phone = ?');

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


    public function get_driver_stmt($number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "SELECT * FROM town_drivers WHERE phone = ?";
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
    public function insert_town_driver($number, $uniqueId, $time)
    {

        $phone = substr($number, 2);

        try {
            $stmt = $this->connect()->prepare('INSERT INTO town_drivers (phone, user_id, created_date) VALUES (?, ?, ?)');

            if (!$stmt->execute(array($phone, $uniqueId, $time))) {
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


    public function update_driver_name($conversation, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE town_drivers SET name = ? WHERE phone=?";
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


    //for updating location 
    public function update_driver_location($latitude, $longitude, $time, $driver_status, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE town_drivers SET latitude = ?, longitude = ?, location_time = ?, driver_status = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$latitude, $longitude, $time, $driver_status, $phone])) {
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


    public function update_driver_type($buttonId, $number)
    {

        $phone = substr($number, 2);

        try {
            $sql = "UPDATE town_drivers SET vehicle_type = ? WHERE phone=?";
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


    public function check_driver_status($number)
    {

        $phone = substr($number, 2);

        $stmt = $this->connect()->prepare('SELECT driver_status FROM town_drivers WHERE phone = ?');

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