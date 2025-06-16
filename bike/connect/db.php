<?php
// db.php
function openDbConnection() {
    $servername = "db";
    $username = "root";
    $password = "root";
    $dbname = "bike_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    return $conn;
}

function getAllChatMessages($conn) {
    $chatMessages = [];
    $msgResult = $conn->query("SELECT username, message FROM chat_messages ORDER BY created_at ASC");

    if ($msgResult && $msgResult->num_rows > 0) {
        while ($msgRow = $msgResult->fetch_assoc()) {
            $chatMessages[] = $msgRow;
        }
    }

    return $chatMessages;
}



/*if (!$conn) {
    die("No connect!". mysqli_connect_error());
}else {
    echo "Ok connect!";
}*/





