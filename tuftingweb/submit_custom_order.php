<?php
// Configuration
$to = 'rugworxz@gmail.com';
$subject = 'New Custom Rug Design Submission';

// Collect form data
$description = htmlspecialchars($_POST['description']);
$file = $_FILES['rug_image'];

// Handle file upload
$file_name = basename($file['name']);
$file_name = preg_replace('/[^a-zA-Z0-9-_\.]/', '', $file_name); // Sanitize file name
$file_tmp = $file['tmp_name'];
$file_size = $file['size'];
$file_error = $file['error'];

// File upload validation
$allowed_extensions = ['jpg', 'jpeg', 'png'];
$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

if ($file_error === UPLOAD_ERR_OK) {
    if (in_array($file_ext, $allowed_extensions) && $file_size <= 5000000) { // 5MB max file size
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . uniqid() . '-' . $file_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file_tmp, $upload_file)) {
            // Compose email
            $message = "<h1>New Custom Rug Design Submission</h1>";
            $message .= "<p><strong>Description:</strong> $description</p>";
            $message .= "<p><strong>Uploaded Design:</strong></p>";
            $message .= "<img src='$upload_file' alt='Rug Design' style='max-width: 600px; height: auto;'>";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // Send email
            if (mail($to, $subject, $message, $headers)) {
                echo 'Your custom rug design has been submitted successfully.';
            } else {
                echo 'Failed to send email.';
            }
        } else {
            echo 'Failed to move uploaded file.';
        }
    } else {
        echo 'Invalid file type or file too large.';
    }
} else {
    echo 'File upload failed with error code: ' . $file_error;
}
?>
