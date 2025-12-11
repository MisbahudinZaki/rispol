<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$email = trim($_POST["email"] ?? "");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email address."]);
    exit;
}

// Example: Save to file (can be replaced with database)
$file = "newsletter-list.txt";
file_put_contents($file, $email . PHP_EOL, FILE_APPEND);

echo json_encode(["success" => true, "message" => "Successfully subscribed."]);
exit;
?>
