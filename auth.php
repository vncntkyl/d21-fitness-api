<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle OPTIONS request (Preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . "/controller/auth.php";
require_once __DIR__ . "/controller/user.php";
require_once __DIR__ . "/helper/security.php";

$controller = new AuthController();

try {
    $resource = $_REQUEST['resource'] ?? null;

    if ($resource === null) {
        throw new Exception("No resource found.");
    }

    switch ($resource) {
        case "login":
            if ($_SERVER['REQUEST_METHOD'] !== "POST") {
                throw new Exception("Unauthorized access.");
            }
            if ($_POST['username'] === "" || $_POST['password'] === "") {
                throw new Exception("Username or password must not be empty.");
            }
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $controller->login($username);

            if (!$user) {
                throw new Exception("User not found.");
            }

            $hashPassword = $user->password;

            if (!password_verify($password, $hashPassword)) {
                throw new Exception("The password you have entered is incorrect.");
            }

            $token = create_JWT();

            if ($controller->addToken($user->ID, $token)) {
                $controller = new UserController();
                $controller->send($controller->getOne($user->ID));
            }
            break;
        case "me":
            $controller = new UserController();
            if (!isset($_POST['token'])) {
                throw new Exception("Token not found.");
            }
            $controller->send($controller->getOne($_POST['token']));
    }


} catch (Exception $e) {
    // Output only the error message
    $controller->send(['error' => $e->getMessage()], 400);
}