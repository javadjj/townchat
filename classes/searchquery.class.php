<?php

class SearchQuery extends Dbh
{

//reset main and previous columns
    public function reset_stmt($number, $main, $previous, $search)
    {

        try {
            $sql = "UPDATE bot_query SET main_query=?, previous_query=?, search_keyword = ? WHERE phone = ?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$main, $previous, $search, $number])) {
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



    public function update_search_key($conversation, $number)
    {
        try {
            $sql = "UPDATE bot_query SET search_keyword = ? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$conversation, $number])) {
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


    //fetching column value
    public function get_search_key($number)
    {

        $stmt = $this->connect()->prepare('SELECT search_keyword FROM bot_query WHERE phone = ?');

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



///*** BUSINESS SEARCH STMT */

    //fetch closest bs_keywords
    public function get_business_keys($latitude, $longitude, $search_keyword)
    {
        try {
            $sql = "SELECT  `phone`, `keyword`, `latitude`, `longitude`, ( 6367 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM bs_keywords WHERE keyword = ? order by distance limit 5";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$latitude, $longitude, $latitude, $search_keyword])) {
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


//get all values business
    public function get_business($phone)
    {

            $sql = "SELECT * FROM bs_register WHERE phone = ?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$phone])) {
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



///*** PROFESSIONAL SEARCH STMT */
public function get_profession_keys($latitude, $longitude, $search_keyword)
    {
        try {
            $sql = "SELECT  `phone`, `keyword`, `latitude`, `longitude`, ( 6367 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM pr_keywords WHERE keyword = ? order by distance limit 5";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$latitude, $longitude, $latitude, $search_keyword])) {
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


//get all values business
    public function get_professionals($phone)
    {
        try {
            $sql = "SELECT * FROM pr_register WHERE phone = ?";
            $stmt = $this->connect()->prepare($sql);

            $stmt->execute([$phone]);
            $resultCheck = $stmt->fetchAll();

            return $resultCheck;

        } catch (PDOException $e) {
            $return = "Your fail message: " . $e->getMessage();
        }
    }




//**DRIVER SEARCH STMT */

//get closest driver details
public function get_driver($latitude, $longitude, $search_keyword)
    {
        try {
            $sql = "SELECT `name`, `phone`, `latitude`, `longitude`, `vehicle_number`, `app_version`, ( 6367 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM town_drivers WHERE vehicle_type = ? order by distance limit 5";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$latitude, $longitude, $latitude, $search_keyword])) {
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



//**BLOOD SEARCH STMT*/

//fetch donor details

public function get_donor($latitude, $longitude, $search_keyword){
    try {
        $sql = "SELECT `name`, `phone`, `latitude`, `longitude`, `blood_group`, ( 6367 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM blood_donors WHERE blood_group = ? order by distance limit 5";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute([$latitude, $longitude, $latitude, $search_keyword])) {
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

}