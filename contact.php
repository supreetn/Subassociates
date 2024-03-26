<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // File attachment
    $file = $_FILES['attachment'];
    $attachment = chunk_split(base64_encode(file_get_contents($file['tmp_name'])));
    $filename = $file['name'];

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

    // Email body
    $body = "--boundary\r\n";
    $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= "$message\r\n";
    $body .= "--boundary\r\n";
    $body .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment\r\n\r\n";
    $body .= "$attachment\r\n";
    $body .= "--boundary--";

    // Send email
    $success = mail('anchu.nandi@gmail.com.com', $subject, $body, $headers);

    if ($success) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email. Please try again later.";
    }
}
?>
