<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/db.php");

class Review {
    public function __construct(
        public int $id = 0,
        public string $username = "",
        public string $review_text = "",
        public int $rating = 0,
        public string $review_date = "",
        public string $color_issue = ""
    ) {}
}

// Получение списка всех отзывов
function selectAllReview(): array {
    $conn = openDbConnection();
    $queryStr = "SELECT id, username, review_text, rating, review_date, color_issue FROM reviews;";
    $result = $conn->query($queryStr);

    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = new Review(
            (int)$row["id"],
            $row["username"],
            $row["review_text"],
            (int)$row["rating"],
            $row["review_date"],
            $row["color_issue"]
        );
    }

    $conn->close();
    return $reviews;
}

// Обработка POST-запроса (добавление нового отзыва)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = openDbConnection();

    // Проверка обязательных полей
    if (isset($_POST['username'], $_POST['review_text'], $_POST['rating'], $_POST['review_date'])) {
        $username = trim($_POST['username']);
        $review_text = trim($_POST['review_text']);
        $rating = (int)$_POST['rating'];
        $review_date = $_POST['review_date'];
        $color_issue = isset($_POST['color_issue']) ? 1 : 0;

        // Подготовка запроса
        $stmt = $conn->prepare("INSERT INTO reviews (username, review_text, rating, review_date, color_issue) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisi", $username, $review_text, $rating, $review_date, $color_issue);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Отзыв успешно добавлен!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Ошибка при добавлении: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Не все поля заполнены."]);
    }

    $conn->close();
    exit;
}

// GET-запрос: получение всех отзывов
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $conn = openDbConnection();

    $reviews = [];
    $result = $conn->query("SELECT username, review_text, rating, review_date, color_issue FROM reviews ORDER BY review_date DESC");

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }
    $conn->close();
}



