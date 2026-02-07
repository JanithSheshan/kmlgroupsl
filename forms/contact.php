<?php
/**
 * KML Group Contact Form Handler
 * Processes contact form submissions using SMTP/PHPMailer for reliable email delivery
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
    
    // Get form data and sanitize
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"] ?? ''));
    $message = trim($_POST["message"] ?? '');
    $phone = strip_tags(trim($_POST["phone"] ?? ''));
    
    // Validation
    $errors = [];
    
    // Check required fields
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    } elseif (strlen($message) < 10) {
        $errors[] = "Message should be at least 10 characters long";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        
        // Log submission before attempting to send
        logContactSubmission($name, $email, $subject, 'processing');
        
        // Include PHPMailer
        require_once 'PHPMailer/PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/PHPMailer/src/SMTP.php';
        require_once 'PHPMailer/PHPMailer/src/Exception.php';
        
        try {
            // Create PHPMailer instance
            $mail = new PHPMailer(true);
            
            // SMTP Configuration (using Gmail SMTP as example)
            // You should use your own SMTP server or transactional email service
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'kmlgroup.co@gmail.com';  // Your email
            $mail->Password = '';  // Use App Password for Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            // Enable debugging if needed (0 = off, 1 = client messages, 2 = client and server messages)
            $mail->SMTPDebug = 0;
            
            // Email settings - ADMIN NOTIFICATION
            $mail->setFrom('noreply@kmlgroupsl.com', 'KML Group Website');
            $mail->addAddress('kmlgroup.co@gmail.com', 'KML Group Admin');
            $mail->addReplyTo($email, $name);
            
            // Email content for admin
            $email_subject = "New Contact Form: $subject";
            
            $email_content = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(135deg, #1a472a 0%, #2e8b57 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                    .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 8px 8px; }
                    .field { margin-bottom: 15px; }
                    .field-label { font-weight: bold; color: #1a472a; }
                    .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>New Contact Form Submission</h2>
                        <p>From KML Group Website</p>
                    </div>
                    <div class='content'>
                        <div class='field'>
                            <div class='field-label'>Name:</div>
                            <div>" . htmlspecialchars($name) . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>Email:</div>
                            <div>" . htmlspecialchars($email) . "</div>
                        </div>
                        " . (!empty($phone) ? "
                        <div class='field'>
                            <div class='field-label'>Phone:</div>
                            <div>" . htmlspecialchars($phone) . "</div>
                        </div>
                        " : "") . "
                        <div class='field'>
                            <div class='field-label'>Subject:</div>
                            <div>" . htmlspecialchars($subject) . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>Message:</div>
                            <div>" . nl2br(htmlspecialchars($message)) . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>Submitted On:</div>
                            <div>" . date('F j, Y \a\t g:i A') . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>IP Address:</div>
                            <div>" . $_SERVER['REMOTE_ADDR'] . "</div>
                        </div>
                    </div>
                    <div class='footer'>
                        <p>This email was sent from the contact form on KML Group website.</p>
                        <p>© " . date('Y') . " KML Group. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $mail->isHTML(true);
            $mail->Subject = $email_subject;
            $mail->Body = $email_content;
            $mail->AltBody = strip_tags($email_content);
            
            // Send admin notification
            $admin_sent = $mail->send();
            
            if ($admin_sent) {
                // Send auto-reply to user
                $mail->clearAddresses();
                $mail->clearReplyTos();
                
                $mail->setFrom('noreply@kmlgroupsl.com', 'KML Group');
                $mail->addAddress($email, $name);
                $mail->addReplyTo('kmlgroup.co@gmail.com', 'KML Group');
                
                $user_subject = "Thank you for contacting KML Group";
                $user_message = "
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: linear-gradient(135deg, #1a472a 0%, #2e8b57 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 8px 8px; }
                        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666; }
                        a { color: #1a472a; text-decoration: none; }
                        a:hover { text-decoration: underline; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>Thank You for Contacting KML Group!</h2>
                        </div>
                        <div class='content'>
                            <p>Dear " . htmlspecialchars($name) . ",</p>
                            
                            <p>Thank you for getting in touch with KML Group! We have received your message and our team will get back to you within 24 hours.</p>
                            
                            <p><strong>Here's a summary of your inquiry:</strong></p>
                            <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
                            <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
                            
                            <p><strong>About KML Group:</strong><br>
                            With a legacy spanning over 60 years, KML Group has established itself as a trusted name in multiple sectors including logistics, investments, distribution, and entertainment across Sri Lanka.</p>
                            
                            <p>In the meantime, you might find these resources helpful:</p>
                            <ul>
                                <li><a href='https://kmlgroup.com/services.html'>Explore Our Services</a></li>
                                <li><a href='https://kmlgroup.com/about.html'>Learn About Our Legacy</a></li>
                                <li><a href='https://kmlgroup.com/kurunegala-merchants.html'>Discover Our Business Sectors</a></li>
                            </ul>
                            
                            <p>For urgent inquiries, feel free to call us at <strong>+94 37 222 2353</strong>.</p>
                            
                            <p>Best regards,<br>
                            <strong>The KML Group Team</strong></p>
                        </div>
                        <div class='footer'>
                            <p>KML Group | 118/3, Second Lane, Sumangala Mawatha, Kurunegala, Sri Lanka<br>
                            Phone: +94 37 222 2353 | Email: kmlgroup.co@gmail.com</p>
                            <p>© " . date('Y') . " KML Group. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
                ";
                
                $mail->Subject = $user_subject;
                $mail->Body = $user_message;
                $mail->AltBody = strip_tags($user_message);
                
                $auto_reply_sent = $mail->send();
                
                // Log success
                logContactSubmission($name, $email, $subject, 'success');
                
                // Redirect with success message
                header("Location: ../contact.html?status=success&message=" . urlencode("Thank you! Your message has been sent successfully. We will get back to you within 24 hours."));
                exit;
                
            } else {
                throw new Exception('Failed to send admin notification: ' . $mail->ErrorInfo);
            }
            
        } catch (Exception $e) {
            // Log error
            logContactSubmission($name, $email, $subject, 'smtp_error: ' . $e->getMessage());
            
            // Fallback to simple mail() function if SMTP fails
            if (sendFallbackEmail($name, $email, $subject, $message, $phone)) {
                logContactSubmission($name, $email, $subject, 'fallback_success');
                header("Location: ../contact.html?status=success&message=" . urlencode("Thank you! Your message has been sent successfully. We will get back to you within 24 hours."));
            } else {
                header("Location: ../contact.html?status=error&message=" . urlencode("Sorry, there was a problem sending your message. Please try again or contact us directly at kmlgroup.co@gmail.com or call +94 37 222 2353"));
            }
            exit;
        }
        
    } else {
        // Validation errors
        logContactSubmission($name, $email, $subject, 'validation_failed: ' . implode(', ', $errors));
        
        // Redirect back with error message
        header("Location: ../contact.html?status=error&message=" . urlencode("Please fix the following errors: " . implode(', ', $errors)));
        exit;
    }
    
} else {
    // Not a POST request
    header("Location: ../contact.html?status=error&message=" . urlencode("Invalid request method. Please use the contact form."));
    exit;
}

/**
 * Fallback email function using PHP's mail()
 */
function sendFallbackEmail($name, $email, $subject, $message, $phone = '') {
    $admin_email = "kmlgroup.co@gmail.com";
    $website_name = "KML Group";
    
    // Simple text email for fallback
    $email_content = "New Contact Form Submission\n";
    $email_content .= "============================\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n";
    if (!empty($phone)) {
        $email_content .= "Phone: $phone\n";
    }
    $email_content .= "Subject: $subject\n";
    $email_content .= "Message:\n$message\n\n";
    $email_content .= "Submitted: " . date('F j, Y \a\t g:i A') . "\n";
    $email_content .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    $headers = "From: $website_name Website <noreply@kmlgroupsl.com>\r\n";
    $headers .= "Reply-To: $name <$email>\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    return mail($admin_email, "Contact Form: $subject", $email_content, $headers);
}

/**
 * Log the submission
 */
function logContactSubmission($name, $email, $subject, $status) {
    $log_file = __DIR__ . '/contact_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] Name: $name | Email: $email | Subject: $subject | Status: $status | IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}


?>
