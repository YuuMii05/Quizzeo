<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = $data['password'];

$usersFile = "users.json";
if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([]));
}
$users = json_decode(file_get_contents($usersFile), true);
$user = array_filter($users, fn($u) => $u['email'] === $email);

if ($user && password_verify($password, $user[array_key_first($user)]['password'])) {
    echo json_encode(["message" => "Login successful"]);
} else {
    echo json_encode(["message" => "Invalid credentials"]);
}
?>
