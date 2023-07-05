<?php

// This PHP code sends a notification to a user in the system for a vehicle booking status.

// Import the necessary libraries.
require_once('vendor/autoload.php');

// Connect to the database.
$db = new PDO('mysql:host=localhost;dbname=carrental', 'root', '');

// Get the booking status.
$sql = 'SELECT status FROM bookings WHERE bookingid = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$status = $stmt->fetchColumn();

// Get the user information.
$sql = 'SELECT name, staff_email FROM staff WHERE staffid = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch();

// Send the notification.
$subject = 'Vehicle Booking Status';
$message = 'Your vehicle booking has been updated to status: ' . $status;

// Send the notification to the user.
$notification = new \stdClass();
$notification->subject = $subject;
$notification->message = $message;
$notification->user = $user;

$mailer = new \PHPMailer\PHPMailer();
$mailer->isSMTP();
$mailer->Host = 'smtp.example.com';
$mailer->SMTPAuth = true;
$mailer->Username = 'user@example.com';
$mailer->Password = 'password';
$mailer->setFrom('user@example.com', 'John Doe');
$mailer->addAddress($user->email, $user->name);
$mailer->Subject = $notification->subject;
$mailer->Body = $notification->message;

if ($mailer->send()) {
  // The notification was sent successfully.
} else {
  // The notification was not sent successfully.
  echo $mailer->ErrorInfo;
}

?>
