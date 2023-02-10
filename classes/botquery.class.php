<?php

class BotQuery extends Dbh
{

    //for validating is user exist or not
    public function validate_user($number)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM bot_query WHERE phone = ?');

        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }

        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck = true;
        } else {
            $resultCheck = false;
        }

        return $resultCheck;
    }


    //updating existing user with new btn id
    public function update_query($number, $buttonId, $listId)
    {

        try {
            $sql = "UPDATE bot_query SET phone=?, main_query=?, previous_query=? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$number, $buttonId, $listId, $number])) {
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


    //inserting new user
    public function insert_user($number, $buttonId)
    {

        try {
            $stmt = $this->connect()->prepare('INSERT INTO bot_query (phone, main_query) VALUES (?, ?)');

            if (!$stmt->execute(array($number, $buttonId))) {
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


    //updating existing user list id
    public function update_previous_query($number, $listId)
    {
        try {
            $sql = "UPDATE bot_query SET phone=?, previous_query=? WHERE phone=?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$number, $listId, $number])) {
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


//get main query value
public function check_main_qr($number)
    {
        $stmt = $this->connect()->prepare('SELECT main_query FROM bot_query WHERE phone = ?');

        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }

        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck =  $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }

        return $resultCheck;
    }



    public function check_previous_qr($number)
    {
        $stmt = $this->connect()->prepare('SELECT previous_query FROM bot_query WHERE phone = ?');

        if (!$stmt->execute(array($number))) {
            $stmt = null;
        }

        $resultCheck = "";
        if ($stmt->rowCount() > 0) {
            $resultCheck =  $stmt->fetchColumn();
        } else {
            $resultCheck = false;
        }

        return $resultCheck;
    }
}