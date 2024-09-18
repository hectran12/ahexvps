<?php

// CREATE TABLE verifySession (
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     email TEXT NOT NULL,
//     code TEXT NOT NULL,
//     dateCreated DATETIME DEFAULT CURRENT_TIMESTAMP
// );

    function createSessionVerify ($email) {
        global $conn;
        deleteAllSessionByEmail($email);
        $code = randomCode();
        $sql = "INSERT INTO verifySession (email, code) VALUES ('$email', '$code')";
        $conn->query($sql);
        return $code;
    }


    function checkVerify ($email, $code) {
        global $conn;
        $sql = "SELECT * FROM verifySession WHERE email = '$email' AND code = '$code'";
        $conn->query($sql);
        if ($conn->numRows() > 0) {
            deleteAllSessionByEmail($email);
            return true;
        }
        return false;
    }

    function deleteAllSessionByEmail ($email) {
        global $conn;
        $sql = "DELETE FROM verifySession WHERE email = '$email'";
        $conn->query($sql);
    }

?>