<?php


// CREATE TABLE action_task_vps_vn (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_email TEXT,
//     task TEXT,
//     value_task TEXT,
//     id_vps TEXT,
//     dateCreated DATE DEFAULT CURRENT_TIMESTAMP
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




function createTaskVPSVN ($user_email, $task, $value_task, $id_vps) {
    global $conn;
    if (checkExistTask($user_email, $id_vps, $task, $value_task)) {
        return;
    }
    $sql = "INSERT INTO action_task_vps_vn (
        user_email,
        task,
        value_task,
        id_vps
    ) VALUES (
        '$user_email',
        '$task',
        '$value_task',
        '$id_vps'
    )";
    $conn->query($sql);

    return $conn->insertId();

}

function checkExistTask ($user_email, $vps_id, $action, $value_task) {
    global $conn;
    $sql = "SELECT * FROM action_task_vps_vn WHERE user_email = '$user_email' AND id_vps = '$vps_id' AND task = '$action' AND value_task = '$value_task'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function getCountTaskByEmailVPSVN ($user_email) {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM action_task_vps_vn WHERE user_email = '$user_email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row["count"];
}


function getAndDeleteTaskVPSVPN () {
    global $conn;
    $sql = "SELECT * FROM action_task_vps_vn LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $user_email = $row["user_email"];
        $task = $row["task"];
        $value_task = $row["value_task"];
        $id_vps = $row["id_vps"];
        $sql = "DELETE FROM action_task_vps_vn WHERE id = $id";
        $conn->query($sql);
        return array(
            "id" => $id,
            "user_email" => $user_email,
            "task" => $task,
            "value_task" => $value_task,
            "id_vps" => $id_vps
        );
    } else {
        return false;
    }
}
?>