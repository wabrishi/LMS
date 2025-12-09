<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Database Connection
function getDbConnection() {
    $host = getenv('DB_HOST') ?: 'localhost';
    $dbname = getenv('DB_NAME') ?: 'orders_db';
    $user = getenv('DB_USER') ?: 'user';
    $pass = getenv('DB_PASS') ?: 'password';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Create table if not exists (simple migration)
        $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(255) NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            total_price DECIMAL(10, 2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Order Service is running");
    return $response;
});

// Create Order
$app->post('/orders', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();

    // Basic validation
    if (!isset($data['user_id']) || !isset($data['product_id']) || !isset($data['quantity']) || !isset($data['total_price'])) {
        $response->getBody()->write(json_encode(['error' => 'Missing required fields']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $pdo = getDbConnection();
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (:user_id, :product_id, :quantity, :total_price)");
    $stmt->execute([
        ':user_id' => $data['user_id'],
        ':product_id' => $data['product_id'],
        ':quantity' => $data['quantity'],
        ':total_price' => $data['total_price']
    ]);

    $orderId = $pdo->lastInsertId();

    $response->getBody()->write(json_encode([
        'id' => $orderId,
        'user_id' => $data['user_id'],
        'product_id' => $data['product_id'],
        'status' => 'created'
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

// List Orders
$app->get('/orders', function (Request $request, Response $response, $args) {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM orders");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response->getBody()->write(json_encode($orders));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
