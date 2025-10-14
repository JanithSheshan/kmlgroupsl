<?php
/**
 * KML Group Newsletter Subscription Handler
 */

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and validate email
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Please enter your email address.'
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Invalid email format. Please use a valid email address.'
        ]);
        exit;
    }

    // Admin email
    $admin_email = "info@kmlgroup.lk";
    $website_name = "KML Group";

    // --------------------------
    // Admin Notification Email
    // --------------------------
    $admin_subject = "New Newsletter Subscription - KML Group";
    $admin_message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #333; background: #f5f5f5; }
            .container { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
            .header { background: linear-gradient(135deg, #002B5B, #005792); color: white; padding: 25px; text-align: center; }
            .content { padding: 25px; }
            p { margin-bottom: 10px; }
            .footer { text-align: center; font-size: 12px; color: #777; padding: 15px; border-top: 1px solid #eee; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Newsletter Subscription</h2>
            </div>
            <div class='content'>
                <p><strong>New subscriber email:</strong> $email</p>
                <p><strong>Subscription Time:</strong> " . date('F j, Y \a\t g:i A') . "</p>
                <p><strong>IP Address:</strong> " . $_SERVER['REMOTE_ADDR'] . "</p>
            </div>
            <div class='footer'>
                <p>© " . date('Y') . " $website_name. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>";

    $admin_headers = "From: $website_name <noreply@kmlgroup.lk>\r\n";
    $admin_headers .= "Reply-To: $email\r\n";
    $admin_headers .= "MIME-Version: 1.0\r\n";
    $admin_headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // --------------------------
    // Auto-Reply Email to User
    // --------------------------
    $welcome_subject = "Welcome to the KML Group Community!";
    $welcome_message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.7; color: #333; background: #f9f9f9; }
            .container { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
            .header { background: linear-gradient(135deg, #002B5B, #005792); color: white; padding: 25px; text-align: center; }
            .content { padding: 25px; }
            .cta-button { display: inline-block; background: #005792; color: white; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-weight: 500; margin: 15px 0; }
            .social-links a { text-decoration: none; color: #005792; margin: 0 8px; }
            .footer { text-align: center; font-size: 12px; color: #777; padding: 20px; border-top: 1px solid #eee; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Welcome to KML Group!</h2>
                <p>Innovating Sri Lanka’s Future</p>
            </div>
            <div class='content'>
                <p>Hello,</p>
                <p>🎉 Thank you for subscribing to the KML Group newsletter!</p>
                <p>You're now part of a growing network of innovation and excellence spanning across logistics, distribution, entertainment, and corporate development.</p>
                <p><strong>Here's what you can look forward to:</strong></p>
                <ul>
                    <li>📈 Updates on our latest business ventures</li>
                    <li>💡 Insights into innovation across Sri Lanka</li>
                    <li>🎤 Upcoming events, career opportunities, and more</li>
                </ul>
                <div style='text-align:center;'>
                    <a href='https://kmlgroup.lk/' class='cta-button'>Visit Our Website</a>
                </div>
                <p class='social-links' style='text-align:center;'>
                    <strong>Follow Us:</strong><br>
                    <a href='https://www.facebook.com/kmlgroup.lk'>Facebook</a> |
                    <a href='https://www.linkedin.com/company/kml-group-lk'>LinkedIn</a> |
                    <a href='https://www.instagram.com/kmlgroup.lk'>Instagram</a>
                </p>
                <p>For inquiries, contact us at <strong>info@kmlgroup.lk</strong></p>
                <p>Warm regards,<br>
                <strong>The KML Group Team</strong></p>
            </div>
            <div class='footer'>
                <p>KML Group | Kurunegala, Sri Lanka</p>
                <p>© " . date('Y') . " KML Group. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>";

    $welcome_headers = "From: KML Group <info@kmlgroup.lk>\r\n";
    $welcome_headers .= "Reply-To: info@kmlgroup.lk\r\n";
    $welcome_headers .= "MIME-Version: 1.0\r\n";
    $welcome_headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // --------------------------
    // Send Emails
    // --------------------------
    $admin_sent = mail($admin_email, $admin_subject, $admin_message, $admin_headers);
    $welcome_sent = mail($email, $welcome_subject, $welcome_message, $welcome_headers);

    if ($admin_sent || $welcome_sent) {
        logNewsletterSubscription($email, 'Success');
        echo json_encode([
            'status' => 'success',
            'message' => '✅ Thank you! You have successfully subscribed to the KML Group newsletter.'
        ]);
    } else {
        logNewsletterSubscription($email, 'Failed');
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Oops! Something went wrong while subscribing. Please try again later.'
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Invalid request method.'
    ]);
}

/**
 * Optional: Log subscriptions to a file
 */
function logNewsletterSubscription($email, $status) {
    $log_file = __DIR__ . '/newsletter_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] Email: $email | Status: $status\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}
?>
