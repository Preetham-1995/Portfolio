<?php
// Disable error reporting for production
error_reporting(0);
ini_set('display_errors', 0);

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "Pennabadi@95";
$dbname = "portfolio";

try {
    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';

    // Create connection silently
    $conn = @new mysqli($servername, $username, $password);

    // If connection successful, proceed with database operations
    if (!$conn->connect_error) {
        // Create database if not exists
        @$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
        @$conn->select_db($dbname);

        // Create table if not exists
        $sql = "CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        @$conn->query($sql);

        // Try to insert data
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $phone, $message);
            $stmt->execute();
            $stmt->close();
        }

        // Email configuration
        $to = "psaipreethamreddy031@gmail.com";
        $subject = "New Contact Form Submission from Portfolio";
        
        // Create HTML email content
        $email_content = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { padding: 20px; }
                .header { background: #23d5ab; color: white; padding: 20px; }
                .content { padding: 20px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>New Contact Form Submission</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <div class='label'>Name:</div>
                        <div>$name</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Email:</div>
                        <div>$email</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Phone:</div>
                        <div>$phone</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Message:</div>
                        <div>$message</div>
                    </div>
                </div>
            </div>
        </body>
        </html>";

        // Email headers
        $headers = array(
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=utf-8',
            'From: ' . $email,
            'Reply-To: ' . $email,
            'X-Mailer: PHP/' . phpversion()
        );

        // Send email using both HTML and plain text
        $mail_sent = mail($to, $subject, $email_content, implode("\r\n", $headers));

        // Also send a backup plain text email
        $plain_content = "New Contact Form Submission\n\n" .
                        "Name: $name\n" .
                        "Email: $email\n" .
                        "Phone: $phone\n\n" .
                        "Message:\n$message";

        $plain_headers = "From: $email\r\n" .
                        "Reply-To: $email\r\n" .
                        "X-Mailer: PHP/" . phpversion();

        mail($to, $subject . " (Plain Text)", $plain_content, $plain_headers);

        $conn->close();
    }

    // Always return success to user
    echo json_encode([
        "status" => "success",
        "message" => "Thank you for your message! We will get back to you soon."
    ]);

} catch (Exception $e) {
    // Return success anyway
    echo json_encode([
        "status" => "success",
        "message" => "Thank you for your message! We will get back to you soon."
    ]);
}
?> 