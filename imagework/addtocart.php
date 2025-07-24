<?php
session_start();
include 'db.php';

// Check if the form is submitted and item ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $product_id = $_POST['id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Fetch product from DB
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $item = [
            'id' => $result['id'],
            'name' => $result['name'],
            'price' => $result['price'],
            'image' => $result['image'],
            'quantity' => $quantity
        ];

        // Check if cart exists in session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if item is already in cart
        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] == $product_id) {
                $cartItem['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        unset($cartItem);

        if (!$found) {
            $_SESSION['cart'][] = $item;
        }

        // Insert the item into the database (cart table)
        $session_id = session_id();
        $checkStmt = $conn->prepare("SELECT id FROM cart WHERE session_id = ? AND product_id = ?");
        $checkStmt->bind_param("si", $session_id, $product_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // If the item is already in the cart, update quantity
            $updateStmt = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE session_id = ? AND product_id = ?");
            $updateStmt->bind_param("isi", $quantity, $session_id, $product_id);
            $updateStmt->execute();
        } else {
            // If it's a new item, insert it into the cart table
            $insertStmt = $conn->prepare("INSERT INTO cart (session_id, product_id, name, price, image, quantity) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("sisssi", $session_id, $item['id'], $item['name'], $item['price'], $item['image'], $item['quantity']);
            $insertStmt->execute();
        }

        // Redirect to the homepage
        header("Location: index.php");
        exit();
    }
}
?>
