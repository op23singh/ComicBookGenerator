<?php
require 'dbcon.php';
while (1) {
    set_time_limit(0);
    $apiUrl = "https://xkcd.com/info.0.json";
    $comic_data = json_decode(file_get_contents($apiUrl));
    // echo $comic_data->link;
    $api_Url_First_part = "https://xkcd.com/";
    $api_Url_Second_part = rand(1, (int)$comic_data->num);
    $api_Url_third_part = "/info.0.json";
    $complete_apiUrl = "$api_Url_First_part$api_Url_Second_part$api_Url_third_part";
    $Comic_data = json_decode(file_get_contents($complete_apiUrl));
    $img_url = $Comic_data->img;
    $img_new = file_put_contents("image.png", file_get_contents($img_url));
    $img_full_url = base64_encode(file_get_contents("image.png"));
    if ($con) {
        $getQuery = "select email,username,status,token from registration where status='active' ";
        $executeQuery = mysqli_query($con, $getQuery);
        $resultArr = mysqli_fetch_all($executeQuery);
        $to = "";
        $to_email = "techg0345@gmail.com";

        // Sender 
        $from = 'indinikumar01200';
        $fromName = 'admin';

        // Email subject 
        $subject = 'PHP Email with Attachment by admin';

        // Attachment file 
        $file = "image.png";

        // Email body content 
        $htmlContent = " 
    <h3>PHP Email with Attachment as well as inline image</h3> 
    <p>This email is sent from the PHP script with attachment.</p> 
    <img src='$img_url'>
";

        // Header for sender info 
        $headers = "From: $fromName" . " <" . $from . ">";

        // Boundary  
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        // Headers for attachment  
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

        // Multipart boundary  
        $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

        // Preparing attachment 
        if (!empty($file) > 0) {
            if (is_file($file)) {
                $message .= "--{$mime_boundary}\n";
                $fp =    @fopen($file, "rb");
                $data =  @fread($fp, filesize($file));

                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: image/png; name=\"" . basename($file) . "\"\n" .
                    "Content-Description: " . basename($file) . "\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        $message .= "--{$mime_boundary}--";
        $returnpath = "-f" . $from;
        foreach ($resultArr as $user) {
            $Email = trim($user[0]);
            //unsubscribe link formation
            $temp_unsubscribe = 'http://localhost/vscode_php/unsubscribe.php?token=' . $user[3];

            $html_content2 = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n";
            $tempt = "<a href='$temp_unsubscribe'>Unsubscribe<a/>.\n\n";
            $html_content2 .= $tempt;
            $html_content2 .= $message;
            $message = $html_content2;
            // Send email 
            $mail = @mail($Email, $subject, $message, $headers, $returnpath);
            if ($mail) {
                echo "email sent successfully '$Email'";
            } else {
                echo "email not sent ";
            }
        }
    }
    sleep(300);
}
// $subject = "enjoy your comic";
//     $mailMessage = "<img src='$img_url'>";
//     $mailAttach = basename("image.png");
//     $content = chunk_split($img_full_url);
//     $mailHead = implode("\r\n", [
//         "MIME-Version: 1.0",
//         "Content-Type:multipart/mixed",
//         "From: indinikumar01200@gmail.com"
//     ]);

//     $mailBody = implode("\r\n", [
//         $mailMessage
//     ]);
//     $mailBody .= implode("\r\n", [
//         "Content-Type: multipart/fixed",
//         "Content-Disposition: attachment",
//         "Content-Type: image/png; name=\"" . $mailAttach . "\"\r\n",
//         "Content-Transfer-Encoding: base64\r\n",
//         "Content-Disposition: attachment; filename=\"" . $mailAttach . "\"\r\n\r\n",
//         $mailAttach . "\r\n\r\n",
//     ]);
//     if (mail($to, $subject, $mailBody, $mailHead)) {
//         echo "mail successfully sent to '$to'";
//     } else {
//         echo "mail not sent ";
//     }
// echo $headers;
// $email = new \SendGrid\Mail\Mail();
// $email->setFrom("onkarpreetsingh23@gmail.com", "op23singh");
// $email->setSubject("Sending with SendGrid is Fun");
// $email->addTos($to);
// $email->addContent("text/plain", "enjoy your comic");
// $email->addContent("text/html", "<img src='$img_url'>");
// $email->addAttachment(base64_encode(file_get_contents("image.png")), 'image/png', "image", "attachment", "image");
// $sendgrid = new \SendGrid(SENDGRID_APIKEY);
// try {
//     $response = $sendgrid->send($email);
//     print $response->statusCode() . "\n";
//     print_r($response->headers());
//     print $response->body() . "\n";
// } catch (Exception $e) {
//     echo 'Caught exception: ' . $e->getMessage() . "\n";
// }
// }