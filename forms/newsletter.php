<?php
/**
 * KML Group Newsletter Subscription Handler
 */

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and validate email
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    
    if (empty($email)) {
        // Redirect back with error message
        header("Location: ../contact.html?newsletter_status=error&newsletter_message=" . urlencode("Email address is required."));
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back with error message
        header("Location: ../contact.html?newsletter_status=error&newsletter_message=" . urlencode("Please enter a valid email address."));
        exit;
    }
    
    // Admin email
    $admin_email = "kmlgroup.co@gmail.com";
    $website_name = "KML Group";
    
    // Email content for admin notification
    $admin_subject = "New Newsletter Subscription - KML Group";
    $admin_message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #1a472a 0%, #2e8b57 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 8px 8px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Newsletter Subscription</h2>
                <p>KML Group Website</p>
            </div>
            <div class='content'>
                <p><strong>New subscriber:</strong> $email</p>
                <p><strong>Subscription Date:</strong> " . date('F j, Y \a\t g:i A') . "</p>
                <p><strong>IP Address:</strong> " . $_SERVER['REMOTE_ADDR'] . "</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $admin_headers = "From: $website_name <noreply@kmlgroup.com>\r\n";
    $admin_headers .= "Reply-To: $email\r\n";
    $admin_headers .= "MIME-Version: 1.0\r\n";
    $admin_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // Welcome email to subscriber
    $welcome_subject = "Welcome to KML Group - A Legacy of 60 Years";
    $welcome_message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #1a472a 0%, #2e8b57 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 8px 8px; }
            .cta-button { display: inline-block; background: linear-gradient(135deg, #1a472a 0%, #2e8b57 100%); color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
            .social-links { margin: 20px 0; }
            .sectors { background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 15px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Welcome to KML Group!</h2>
                <p>A Legacy of Excellence Spanning 60 Years</p>
            </div>
            <div class='content'>
                <p>Dear Subscriber,</p>
                
                <p>🎉 Thank you for joining the KML Group community! We're delighted to welcome you to our network of partners, clients, and well-wishers who have been part of our 60-year journey.</p>
                
                <p><strong>What you'll receive from our newsletter:</strong></p>
                <ul>
                    <li>📈 Business insights and industry updates</li>
                    <li>🏢 Latest developments across our business sectors</li>
                    <li>🤝 Partnership and investment opportunities</li>
                    <li>📅 Event invitations and corporate announcements</li>
                    <li>🎯 Exclusive insights from our legacy of excellence</li>
                </ul>
                
                <div class='sectors'>
                    <p><strong>Our Business Sectors:</strong></p>
                    <ul>
                        <li>🚚 Logistics & Supply Chain (KML Logistics)</li>
                        <li>💼 Investments & Holdings (KML Holdings)</li>
                        <li>📦 Distribution & Merchandising (Kurunegala Merchants)</li>
                        <li>🎬 Entertainment & Media (Kanlark Entertainment)</li>
                    </ul>
                </div>
                
                <p><strong>Explore Our Business:</strong></p>
                <div style='text-align: center;'>
                    <a href='https://kmlgroup.com/services.html' class='cta-button'>Our Services</a>
                    <a href='https://kmlgroup.com/about.html' class='cta-button'>Our Legacy</a>
                    <a href='https://kmlgroup.com/kurunegala-merchants.html' class='cta-button'>Our Sectors</a>
                </div>
                
                <div class='social-links'>
                    <p><strong>Connect with us:</strong></p>
                    <p>
                        <a href='https://www.youtube.com/@KMLGroup'>YouTube</a> | 
                        <a href='https://web.facebook.com/profile.php?id=61571840660818'>Facebook</a>
                    </p>
                </div>
                
                <p>For business inquiries or partnership opportunities:<br>
                Call us: <strong>+94 37 222 2353</strong> | Email: <strong>kmlgroup.co@gmail.com</strong></p>
                
                <p>Warm regards,<br>
                <strong>The KML Group Team</strong></p>
                
                <p><em>Building on a legacy of trust since 1964</em></p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $welcome_headers = "From: KML Group <kmlgroup.co@gmail.com>\r\n";
    $welcome_headers .= "Reply-To: kmlgroup.co@gmail.com\r\n";
    $welcome_headers .= "MIME-Version: 1.0\r\n";
    $welcome_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // Send emails
    $admin_sent = mail($admin_email, $admin_subject, $admin_message, $admin_headers);
    $welcome_sent = mail($email, $welcome_subject, $welcome_message, $welcome_headers);
    
    if ($admin_sent || $welcome_sent) {
        // Log successful subscription
        logNewsletterSubscription($email, 'success');
        
        // Redirect back to contact page with success message
        header("Location: ../contact.html?newsletter_status=success&newsletter_message=" . urlencode("Thank you! You have successfully subscribed to KML Group newsletter. Check your email for a welcome message!"));
        exit;
    } else {
        // Log failed subscription
        logNewsletterSubscription($email, 'email_failed');
        
        // Redirect back with error message
        header("Location: ../contact.html?newsletter_status=error&newsletter_message=" . urlencode("There was a problem with your subscription. Please try again."));
        exit;
    }
    
} else {
    // Not a POST request
    header("Location: ../contact.html?newsletter_status=error&newsletter_message=" . urlencode("Invalid request method."));
    exit;
}

// Log subscription
function logNewsletterSubscription($email, $status) {
    $log_file = __DIR__ . '/newsletter_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] Email: $email | Status: $status\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

?>