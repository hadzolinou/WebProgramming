<?php
header('Content-Type: application/json');

require_once 'utils/Database.php';
require_once 'dao/UserDAO.php';
require_once 'dao/ProductDAO.php';

$userDAO = new UserDAO();
$productDAO = new ProductDAO();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$resource = $requestUri[0];

switch ($resource) {
    case 'login':
        if ($requestMethod == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            $user = $userDAO->checkUserCredentials($username, $password);

            if ($user) {
                echo json_encode(['success' => true, 'message' => 'Login successful']);
            } else {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
        }
        break;
    case 'users':
        switch ($requestMethod) {
            case 'POST':
                // Add a new user
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $userDAO->addUser($data['username'], $data['password'], $data['email'], $data['fullName'], $data['address'], $data['phone']);
                echo json_encode(['result' => $result]);
                break;
            case 'GET':
                if ($id) {
                    // Get a single user by ID
                    $user = $userDAO->getUserById($id);
                    echo json_encode($user);
                } else {
                    // Getting all users or a specific search could be implemented here
                }
                break;
            case 'PUT':
                // Update a user
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $userDAO->updateUser($id, $data['email'], $data['fullName'], $data['address'], $data['phone']);
                echo json_encode(['result' => $result]);
                break;
            case 'DELETE':
                // Delete a user
                $result = $userDAO->deleteUser($id);
                echo json_encode(['result' => $result]);
                break;
        }
        break;
    case 'products':
        switch ($requestMethod) {
            case 'POST':
                // Add a new product
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $productDAO->addProduct($data['name'], $data['description'], $data['price'], $data['stock'], $data['image']);
                echo json_encode(['result' => $result]);
                break;
            case 'GET':
                if ($id) {
                    // Get a single product by ID
                    $product = $productDAO->getProductById($id);
                    echo json_encode($product);
                } else {
                    // Get all products
                    $products = $productDAO->getAllProducts();
                    echo json_encode($products);
                }
                break;
            case 'PUT':
                // Update a product
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $productDAO->updateProduct($id, $data['name'], $data['description'], $data['price'], $data['stock'], $data['image']);
                echo json_encode(['result' => $result]);
                break;
            case 'DELETE':
                // Delete a product
                $result = $productDAO->deleteProduct($id);
                echo json_encode(['result' => $result]);
                break;
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Resource not found']);
        break;
}
?>
