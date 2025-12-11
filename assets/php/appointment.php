<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$message = trim($_POST["message"] ?? "");

$errors = [];

if ($name === "") $errors[] = "Name is required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
if ($phone === "" || !preg_match("/^[0-9+\- ]{6,}$/", $phone)) $errors[] = "Valid phone number is required.";
if ($message === "") $errors[] = "Message is required.";

if (!empty($errors)) {
    echo json_encode(["success" => false, "message" => implode(" ", $errors)]);
    exit;
}

$to = "your-email@example.com";
$subject = "New Appointment Request from $name";
$body = "
Name: $name
Email: $email
Phone: $phone

Message:
$message
";
$headers = "From: $email";

@mail($to, $subject, $body, $headers);

echo json_encode(["success" => true, "message" => "Appointment submitted successfully."]);
exit;
?>
