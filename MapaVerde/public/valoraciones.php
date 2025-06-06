<?php
include_once 'db-connect.php';  

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_name = $_POST['user_name'];
    $user_rating = intval($_POST['user_rating']);
    $user_review = $_POST['user_review'];
    $datetime = time();

    $stmt = $conn->prepare("INSERT INTO review_table (user_name, user_rating, user_review, datetime) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisi", $user_name, $user_rating, $user_review, $datetime);
    $ok = $stmt->execute();
    $stmt->close();
    echo json_encode(["ok" => $ok]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $result = $conn->query("SELECT * FROM review_table ORDER BY review_id DESC LIMIT 5");
    $reviews = [];

    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    echo json_encode($reviews);
    exit;
}
?>
