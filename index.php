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

require_once __DIR__ . "/controller/role.php";
require_once __DIR__ . "/controller/memberships.php";
require_once __DIR__ . "/controller/subscriptions.php";
require_once __DIR__ . "/helper/security.php";

$routes = [
    "roles" => new RoleController(),
    "memberships" => new MembershipController(),
    "subscriptions" => new SubscriptionController(),
];


$resource = $_REQUEST['resource'] ?? null;
$controller = null;

if ($resource !== null) {
    $controller = $routes[$resource] ?? null;
}
if ($controller === null) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(["error" => "No Controller Found"]);
    exit;
}
try {

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if (isset($_REQUEST['id'])) {
                $controller->send($controller->getOne($_REQUEST['id']));
            }
            $controller->send($controller->get());
            break;
        case "POST":
            if (!isset($_REQUEST['data'])) {
                $controller->send(["error" => "Data not found."], 404);
            }

            $data = $_REQUEST['data'];
            $data = json_decode($data, true);
            $controller->add($data);
            break;
        case "PUT":
            $request = json_decode(file_get_contents('php://input'), true);

            if (!isset($request['id']) || !isset($request['data']) || !isset($request['columns'])) {
                $controller->send(["error" => "Data not found."], 404);
            }

            $controller->edit($request['id'], $request['columns'], $request['data']);
            break;
        case "DELETE":
            if (!isset($_GET['id'])) {
                $controller->send(["error" => "ID not found."], 404);
            }
            $controller->delete($_GET['id']);
            break;
    }
} catch (Exception $e) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}