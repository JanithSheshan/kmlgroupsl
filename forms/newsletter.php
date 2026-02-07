<?php
/**
 * KML Group Newsletter Subscription Handler
 * Uses PHPMailer/SMTP for reliable email delivery
 */

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and validate email
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    
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
    
    // Log subscription attempt
    logNewsletterSubscription($email, 'processing');
    
    // Include PHPMailer
    require_once 'PHPMailer/PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/PHPMailer/src/SMTP.php';
    require_once 'PHPMailer/PHPMailer/src/Exception.php';
    
    try {
        // Create PHPMailer instance
        $mail = new PHPMailer(true);
        
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'kmlgroup.co@gmail.com';  // Your email
        $mail->Password = 'wunn meqb djyb uogs';  // Gmail App Password - CHANGE THIS!
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPDebug = 0;  // Set to 2 for debugging
        
        // 1. Send admin notification
        $mail->setFrom('noreply@kmlgroupsl.com', 'KML Group Website');
        $mail->addAddress('kmlgroup.co@gmail.com', 'KML Group Admin');
        $mail->addReplyTo($email);
        
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
                .field { margin-bottom: 10px; }
                .field-label { font-weight: bold; color: #1a472a; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>📬 New Newsletter Subscription</h2>
                    <p>KML Group Website</p>
                </div>
                <div class='content'>
                    <div class='field'>
                        <div class='field-label'>New Subscriber Email:</div>
                        <div>$email</div>
                    </div>
                    <div class='field'>
                        <div class='field-label'>Subscription Date:</div>
                        <div>" . date('F j, Y \a\t g:i A') . "</div>
                    </div>
                    <div class='field'>
                        <div class='field-label'>IP Address:</div>
                        <div>" . $_SERVER['REMOTE_ADDR'] . "</div>
                    </div>
                    <div class='field'>
                        <div class='field-label'>Total Subscribers:</div>
                        <div>" . (countSubscribers() + 1) . " (including this new subscription)</div>
                    </div>
                    <hr>
                    <p><strong>Quick Actions:</strong></p>
                    <p>• Add to mailing list: $email</p>
                    <p>• Send welcome package</p>
                    <p>• Tag as: New Subscriber</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $mail->isHTML(true);
        $mail->Subject = $admin_subject;
        $mail->Body = $admin_message;
        $mail->AltBody = "New newsletter subscriber: $email\nDate: " . date('F j, Y \a\t g:i A') . "\nIP: " . $_SERVER['REMOTE_ADDR'];
        
        // Send admin notification
        $admin_sent = $mail->send();
        
        if ($admin_sent) {
            // 2. Send welcome email to subscriber
            $mail->clearAddresses();
            $mail->clearReplyTos();
            
            $mail->setFrom('noreply@kmlgroupsl.com', 'KML Group');
            $mail->addAddress($email);
            $mail->addReplyTo('kmlgroup.co@gmail.com', 'KML Group');
            
            $welcome_subject = "Welcome to KML Group - A Legacy of 60 Years";
            $welcome_message = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                    .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
                    .header { background: linear-gradient(135deg, #1a472a 0%, #2e8b57 100%); color: white; padding: 30px 20px; text-align: center; }
                    .content { padding: 30px; }
                    .cta-button { display: inline-block; background: linear-gradient(135deg, #1a472a 0%, #2e8b57 100%); color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 5px; font-weight: bold; }
                    .sectors { background: #e8f5e8; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #1a472a; }
                    .benefits { margin: 25px 0; }
                    .benefit-item { display: flex; align-items: center; margin: 10px 0; }
                    .benefit-icon { font-size: 20px; margin-right: 10px; min-width: 30px; }
                    .social-links { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
                    .footer { background: #f1f1f1; padding: 20px; text-align: center; font-size: 12px; color: #666; margin-top: 30px; }
                    h2 { color: #1a472a; }
                    a { color: #1a472a; text-decoration: none; }
                    a:hover { text-decoration: underline; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1 style='margin: 0; font-size: 28px;'>Welcome to KML Group!</h1>
                        <p style='margin: 10px 0 0; font-size: 16px; opacity: 0.9;'>A Legacy of Excellence Spanning 60 Years</p>
                    </div>
                    
                    <div class='content'>
                        <p>Dear Subscriber,</p>
                        
                        <p style='font-size: 16px; line-height: 1.8;'>🎉 <strong>Thank you for joining the KML Group community!</strong> We're delighted to welcome you to our network of partners, clients, and well-wishers who have been part of our remarkable 60-year journey.</p>
                        
                        <div class='benefits'>
                            <h2>What You'll Receive:</h2>
                            <div class='benefit-item'>
                                <span class='benefit-icon'>📈</span>
                                <span><strong>Business Insights:</strong> Industry updates and market trends</span>
                            </div>
                            <div class='benefit-item'>
                                <span class='benefit-icon'>🏢</span>
                                <span><strong>Latest Developments:</strong> Updates across all our business sectors</span>
                            </div>
                            <div class='benefit-item'>
                                <span class='benefit-icon'>🤝</span>
                                <span><strong>Opportunities:</strong> Partnership and investment announcements</span>
                            </div>
                            <div class='benefit-item'>
                                <span class='benefit-icon'>📅</span>
                                <span><strong>Exclusive Invitations:</strong> Event invites and corporate announcements</span>
                            </div>
                            <div class='benefit-item'>
                                <span class='benefit-icon'>🎯</span>
                                <span><strong>Legacy Insights:</strong> Wisdom from 60 years of excellence</span>
                            </div>
                        </div>
                        
                        <div class='sectors'>
                            <h2 style='margin-top: 0;'>Our Business Sectors</h2>
                            <p><strong>🚚 KML Logistics</strong> - Supply chain & transportation solutions</p>
                            <p><strong>💼 KML Holdings</strong> - Strategic investments & portfolio management</p>
                            <p><strong>📦 Kurunegala Merchants</strong> - Distribution & retail operations</p>
                            <p><strong>🎬 Kanlark Entertainment</strong> - Media & entertainment ventures</p>
                        </div>
                        
                        <div style='text-align: center; margin: 30px 0;'>
                            <p><strong>Explore More About Us:</strong></p>
                            <a href='https://kmlgroup.com/about.html' class='cta-button'>Our 60-Year Legacy</a>
                            <a href='https://kmlgroup.com/services.html' class='cta-button'>Our Services</a>
                            <a href='https://kmlgroup.com/kurunegala-merchants.html' class='cta-button'>Business Sectors</a>
                        </div>
                        
                        <div class='social-links'>
                            <p><strong>Stay Connected:</strong></p>
                            <p>
                                <a href='https://www.youtube.com/@KMLGroup' style='margin: 0 10px;'>📺 YouTube</a> | 
                                <a href='https://web.facebook.com/profile.php?id=61571840660818' style='margin: 0 10px;'>📱 Facebook</a>
                            </p>
                        </div>
                        
                        <div style='background: #f0f8ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <p><strong>📞 Contact Us:</strong></p>
                            <p>For business inquiries or partnership opportunities:</p>
                            <p>Phone: <strong>+94 37 222 2353</strong><br>
                            Email: <strong>kmlgroup.co@gmail.com</strong><br>
                            Address: 118/3, Second Lane, Sumangala Mawatha, Kurunegala, Sri Lanka</p>
                        </div>
                        
                        <p style='text-align: center;'>
                            <em>Building on a legacy of trust, innovation, and excellence since 1964</em>
                        </p>
                    </div>
                    
                    <div class='footer'>
                        <p>You received this email because you subscribed to KML Group newsletter.</p>
                        <p>© " . date('Y') . " KML Group. All rights reserved.<br>
                        <small>To unsubscribe, reply to this email with 'UNSUBSCRIBE' in the subject.</small></p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $mail->Subject = $welcome_subject;
            $mail->Body = $welcome_message;
            $mail->AltBody = "Welcome to KML Group!\n\nThank you for subscribing to KML Group newsletter.\n\nAs a subscriber, you'll receive:\n- Business insights and industry updates\n- Latest developments across our sectors\n- Partnership opportunities\n- Event invitations\n- Exclusive legacy insights\n\nOur Business Sectors:\n- KML Logistics (Supply Chain)\n- KML Holdings (Investments)\n- Kurunegala Merchants (Distribution)\n- Kanlark Entertainment (Media)\n\nContact us:\nPhone: +94 37 222 2353\nEmail: kmlgroup.co@gmail.com\n\n© " . date('Y') . " KML Group";
            
            // Send welcome email
            $welcome_sent = $mail->send();
            
            if ($welcome_sent) {
                // Log success
                logNewsletterSubscription($email, 'success');
                storeSubscriberInDatabase($email);
                
                // Redirect with success message
                header("Location: ../contact.html?newsletter_status=success&newsletter_message=" . urlencode("Thank you! You've successfully subscribed to KML Group newsletter. Check your email for a welcome message!"));
                exit;
            } else {
                throw new Exception('Failed to send welcome email: ' . $mail->ErrorInfo);
            }
            
        } else {
            throw new Exception('Failed to send admin notification: ' . $mail->ErrorInfo);
        }
        
    } catch (Exception $e) {
        // Log error
        logNewsletterSubscription($email, 'smtp_error: ' . $e->getMessage());
        
        // Fallback to simple mail() function
        if (sendFallbackNewsletterEmail($email)) {
            logNewsletterSubscription($email, 'fallback_success');
            header("Location: ../contact.html?newsletter_status=success&newsletter_message=" . urlencode("Thank you! You've successfully subscribed to KML Group newsletter."));
        } else {
            header("Location: ../contact.html?newsletter_status=error&newsletter_message=" . urlencode("There was a problem with your subscription. Please try again or contact us directly."));
        }
        exit;
    }
    
} else {
    // Not a POST request
    header("Location: ../contact.html?newsletter_status=error&newsletter_message=" . urlencode("Invalid request method."));
    exit;
}

/**
 * Fallback email function using PHP's mail()
 */
function sendFallbackNewsletterEmail($email) {
    $admin_email = "kmlgroup.co@gmail.com";
    $website_name = "KML Group";
    
    // Admin notification
    $admin_content = "New Newsletter Subscription\n";
    $admin_content .= "===========================\n\n";
    $admin_content .= "Email: $email\n";
    $admin_content .= "Date: " . date('F j, Y \a\t g:i A') . "\n";
    $admin_content .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    $admin_headers = "From: $website_name Website <noreply@kmlgroupsl.com>\r\n";
    $admin_headers .= "Reply-To: $email\r\n";
    $admin_headers .= "X-Mailer: PHP/" . phpversion();
    
    // Simple welcome email
    $welcome_content = "Welcome to KML Group!\n\n";
    $welcome_content .= "Thank you for subscribing to our newsletter.\n\n";
    $welcome_content .= "You'll receive updates about our business sectors:\n";
    $welcome_content .= "- Logistics & Supply Chain\n";
    $welcome_content .= "- Investments & Holdings\n";
    $welcome_content .= "- Distribution & Merchandising\n";
    $welcome_content .= "- Entertainment & Media\n\n";
    $welcome_content .= "Contact: +94 37 222 2353 | kmlgroup.co@gmail.com\n\n";
    $welcome_content .= "© " . date('Y') . " KML Group";
    
    $welcome_headers = "From: KML Group <kmlgroup.co@gmail.com>\r\n";
    $welcome_headers .= "Reply-To: kmlgroup.co@gmail.com\r\n";
    $welcome_headers .= "X-Mailer: PHP/" . phpversion();
    
    $admin_sent = mail($admin_email, "New Newsletter Subscription", $admin_content, $admin_headers);
    $welcome_sent = mail($email, "Welcome to KML Group Newsletter", $welcome_content, $welcome_headers);
    
    return ($admin_sent || $welcome_sent);
}

/**
 * Log subscription
 */
function logNewsletterSubscription($email, $status) {
    $log_file = __DIR__ . '/newsletter_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] Email: $email | Status: $status | IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

/**
 * Count subscribers from log file
 */
function countSubscribers() {
    $log_file = __DIR__ . '/newsletter_log.txt';
    if (!file_exists($log_file)) {
        return 0;
    }
    
    $content = file_get_contents($log_file);
    $lines = explode("\n", $content);
    $count = 0;
    
    foreach ($lines as $line) {
        if (strpos($line, '| Status: success') !== false || strpos($line, '| Status: fallback_success') !== false) {
            $count++;
        }
    }
    
    return $count;
}

/**
 * Store subscriber in database (optional)
 */
function storeSubscriberInDatabase($email) {
    // Database configuration
    $db_host = 'localhost';
    $db_name = 'u979514944_newsroom';
    $db_user = 'u979514944_kmlgroup';
    $db_pass = 'KMLgroupsl#01';  // Change this!
    
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() == 0) {
            // Insert new subscriber
            $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, ip_address, subscribed_at, status) VALUES (?, ?, NOW(), 'active')");
            $stmt->execute([$email, $_SERVER['REMOTE_ADDR']]);
            return true;
        } else {
            // Update existing subscriber
            $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET status = 'active', last_updated = NOW() WHERE email = ?");
            $stmt->execute([$email]);
            return true;
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

?>