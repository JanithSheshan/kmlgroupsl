<?php
/**
 * KML Group Contact Form Handler
 * Processes contact form submissions and sends emails to admin and user.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Validation
    $errors = [];
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email)) $errors[] = "Email is required";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if (empty($subject)) $errors[] = "Subject is required";
    if (empty($message)) $errors[] = "Message is required";
    elseif (strlen($message) < 10) $errors[] = "Message should be at least 10 characters long";

    if (empty($errors)) {

        // Company details
        $recipient = "kmlgroup.co@gmail.com"; // Admin email
        $website_name = "KML Group";
        $email_subject = "New Contact Form: $subject";

        // Email body (HTML)
        $email_content = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: 'Source Sans Pro', Arial, sans-serif; background: #f8f9fa; color: #333; }
                .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #007b5e, #00a86b); color: #fff; padding: 25px; text-align: center; }
                .header h2 { margin: 0; }
                .content { padding: 20px; }
                .field { margin-bottom: 15px; }
                .field-label { font-weight: bold; color: #007b5e; }
                .footer { background: #f1f1f1; padding: 10px 20px; text-align: center; font-size: 12px; color: #555; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>New Contact Form Submission</h2>
                    <p>From $website_name Website</p>
                </div>
                <div class='content'>
                    <div class='field'><span class='field-label'>Name:</span> $name</div>
                    <div class='field'><span class='field-label'>Email:</span> $email</div>
                    <div class='field'><span class='field-label'>Subject:</span> $subject</div>
                    <div class='field'><span class='field-label'>Message:</span><br>" . nl2br(htmlspecialchars($message)) . "</div>
                    <div class='field'><span class='field-label'>Submitted On:</span> " . date('F j, Y \a\t g:i A') . "</div>
                    <div class='field'><span class='field-label'>IP Address:</span> " . $_SERVER['REMOTE_ADDR'] . "</div>
                </div>
                <div class='footer'>
                    <p>This email was sent from the contact form on <strong>$website_name</strong>.</p>
                    <p>© " . date('Y') . " $website_name. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";

        // Headers
        $headers = "From: $website_name <noreply@kmlgroupsl.com>\r\n";
        $headers .= "Reply-To: $name <$email>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Send admin email
        if (mail($recipient, $email_subject, $email_content, $headers)) {

            // Auto-reply to user
            $user_subject = "Thank you for contacting KML Group";
            $user_message = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: 'Source Sans Pro', Arial, sans-serif; background: #f8f9fa; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                    .header { background: linear-gradient(135deg, #007b5e, #00a86b); color: #fff; padding: 25px; text-align: center; }
                    .content { padding: 20px; }
                    .footer { background: #f1f1f1; padding: 10px 20px; text-align: center; font-size: 12px; color: #555; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Thank You for Contacting KML Group!</h2>
                    </div>
                    <div class='content'>
                        <p>Dear $name,</p>
                        <p>Thank you for reaching out to <strong>KML Group</strong>. We have received your message and our team will get back to you shortly.</p>
                        <p><strong>Subject:</strong> $subject</p>
                        <p><strong>Your Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
                        <p>If your inquiry is urgent, please contact us at <strong>+94 37 222 2353</strong> or reply directly to this email.</p>
                        <p>Best regards,<br><strong>The KML Group Team</strong></p>
                    </div>
                    <div class='footer'>
                        <p>KML Group | Kurunegala, Sri Lanka<br>Email: kmlgroup.co@gmail.com</p>
                        <p>© " . date('Y') . " KML Group. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>";

            $user_headers = "From: KML Group <kmlgroup.co@gmail.com>\r\n";
            $user_headers .= "Reply-To: kmlgroup.co@gmail.com\r\n";
            $user_headers .= "MIME-Version: 1.0\r\n";
            $user_headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            mail($email, $user_subject, $user_message, $user_headers);

            echo json_encode([
                'status' => 'success',
                'message' => '✅ Thank you! Your message has been sent successfully. Our team will contact you soon.'
            ]);

        } else {
            echo json_encode([
                'status' => 'error',
                'message' => '❌ Sorry, there was a problem sending your message. Please try again later or contact us directly at kmlgroup.co@gmail.com.'
            ]);
        }

    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Please fix the following: ' . implode(', ', $errors)
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Invalid request. Please use the contact form.'
    ]);
}

// Optional logging
function logContactSubmission($name, $email, $subject, $status) {
    $log_file = __DIR__ . '/contact_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $entry = "[$timestamp] Name: $name | Email: $email | Subject: $subject | Status: $status\n";
    file_put_contents($log_file, $entry, FILE_APPEND | LOCK_EX);
}
?>
