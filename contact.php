<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // File upload
    if ($_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $attachment_name = $_FILES['attachment']['name'];
        $attachment_tmp_name = $_FILES['attachment']['tmp_name'];
    }

    // Prepare email content
    $to = "anchu.nandi@gmail.com"; // Your email address
    $subject = $subject;
    $message_body = "Full Name: $full_name\n";
    $message_body .= "Email: $email\n\n";
    $message_body .= "Message:\n$message";

    // Send email with attachment
    $headers = "From: $email";
    $headers .= "\r\nMIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"mixed_separator\"";
    $message = "--mixed_separator\r\n";
    $message .= "Content-type: text/plain; charset=\"UTF-8\"\r\n";
    $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $message .= "$message_body\r\n";
    if ($_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $file_content = file_get_contents($attachment_tmp_name);
        $message .= "--mixed_separator\r\n";
        $message .= "Content-Type: application/octet-stream; name=\"$attachment_name\"\r\n";
        $message .= "Content-Disposition: attachment\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "\r\n";
        $message .= chunk_split(base64_encode($file_content)) . "\r\n";
    }
    $message .= "--mixed_separator--";

    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you! Your message with attachment has been sent.";
    } else {
        echo "Sorry, there was an error sending your message. Please try again later.";
    }
} else {
    header("Location: contact.html");
}
?>
