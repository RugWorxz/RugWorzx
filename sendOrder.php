<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity1 = $_POST['quantity1'] ?? 0;
    $quantity2 = $_POST['quantity2'] ?? 0;

    // Define your rug prices
    $price1 = 200;
    $price2 = 150;

    // Calculate totals
    $total1 = $quantity1 * $price1;
    $total2 = $quantity2 * $price2;
    $subtotal = $total1 + $total2;
    $shippingCost = 15;
    $total = $subtotal + $shippingCost;

    // Email details
    $to = "rugworxz@gmail.com"; // Change to your email
    $subject = "New Order Received";
    $message = "New order details:\n\n";
    $message .= "Handwoven Wool Rug: Quantity $quantity1, Total $$total1\n";
    $message .= "Custom Design Rug: Quantity $quantity2, Total $$total2\n";
    $message .= "Subtotal: $$subtotal\n";
    $message .= "Shipping: $$shippingCost\n";
    $message .= "Total: $$total\n";

    // Send email
    if (mail($to, $subject, $message)) {
        echo "Order placed successfully!";
    } else {
        echo "Failed to send order.";
    }
}
?>
