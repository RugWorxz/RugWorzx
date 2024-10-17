<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve quantities from the form
    $quantity1 = $_POST['quantity1'] ?? 0;
    $quantity2 = $_POST['quantity2'] ?? 0;

    // Define your rug prices in Dirhams
    $price1 = 200; // Price for Handwoven Wool Rug
    $price2 = 150; // Price for Custom Design Rug

    // Calculate totals
    $total1 = $quantity1 * $price1;
    $total2 = $quantity2 * $price2;
    $subtotal = $total1 + $total2;
    $shippingCost = 15; // Shipping cost in Dirhams
    $total = $subtotal + $shippingCost;

    // Email details
    $to = "rugworxz@gmail.com"; // Change to your email
    $subject = "New Order Received";
    $message = "New order details:\n\n";
    $message .= "Handwoven Wool Rug: Quantity $quantity1, Total د.إ$total1\n"; // Total in Dirhams
    $message .= "Custom Design Rug: Quantity $quantity2, Total د.إ$total2\n"; // Total in Dirhams
    $message .= "Subtotal: د.إ$subtotal\n"; // Subtotal in Dirhams
    $message .= "Shipping: د.إ$shippingCost\n"; // Shipping in Dirhams
    $message .= "Total: د.إ$total\n"; // Total in Dirhams

    // Handle the uploaded custom image
    if (isset($_FILES['customImage'])) {
        $customImage = $_FILES['customImage'];
        $uploadDir = 'uploads/'; // Directory to store uploaded images

        // Check for upload errors
        if ($customImage['error'] == UPLOAD_ERR_OK) {
            // Validate file type
            $fileType = pathinfo($customImage['name'], PATHINFO_EXTENSION);
            if (strtolower($fileType) !== 'png') {
                echo "Error: Only PNG files are allowed.";
                exit;
            }

            // Check file size (limit to 2MB for example)
            if ($customImage['size'] > 2 * 1024 * 1024) {
                echo "Error: File size exceeds 2MB limit.";
                exit;
            }

            // Create the upload directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Create a unique filename to avoid conflicts
            $uniqueFileName = uniqid('rug_', true) . '.' . $fileType;
            $uploadFile = $uploadDir . $uniqueFileName;

            // Move the uploaded file to the designated folder
            if (move_uploaded_file($customImage['tmp_name'], $uploadFile)) {
                $message .= "Custom Image: $uploadFile\n"; // Include image path in the email
            } else {
                echo "Error: There was a problem uploading your file.";
            }
        } else {
            echo "Error: File upload error. Code: " . $customImage['error'];
        }
    } else {
        echo "Error: No file uploaded.";
    }

    // Send email
    if (mail($to, $subject, $message)) {
        echo "Order placed successfully!";
    } else {
        echo "Failed to send order.";
    }
}
?>
