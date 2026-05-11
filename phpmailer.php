<?php
require '../classes/Pdo.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

$id = $_GET['id'];

if ($id) {
    try {
        $gettemp = $db->prepare("SELECT reg_no, first_name, middle_name, last_name, affiliation, email, contact_no, receipt, license, date_created, specialization, date_exp, member, prc_name, sponsor, qr_event FROM temp_participants WHERE id = ?");
        $gettemp->execute([$id]);

        if ($gettemp->rowCount()) {
            foreach ($gettemp->fetchAll() as $key => $row) {
                // Insert into participants table
                $insert = $db->prepare("INSERT INTO  participants (reg_no, first_name, middle_name, last_name, affiliation, email, contact_no, receipt, license, date_created, specialization, date_exp, member, prc_name, sponsor, qr_event) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                !$insert->execute([
                    $row['reg_no'],
                    $row['first_name'],
                    $row['middle_name'],
                    $row['last_name'],
                    $row['affiliation'],
                    $row['email'],
                    $row['contact_no'],
                    $row['receipt'],
                    $row['license'],
                    $row['date_created'],
                    $row['specialization'],
                    $row['date_exp'],
                    $row['member'],
                    $row['prc_name'],
                    $row['sponsor'],
                    $row['qr_event'],
                ]);

                // Prepare and send email
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'visionarywebco@gmail.com';
                $mail->Password = 'kqrzoggmmufzxlpk';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('visionarywebco@gmail.com', 'PhilSPEN 17th Annual Convention');
                $mail->addAddress($row['email']);
                $mail->isHTML(true);

                $mail->Subject = 'Registration Confirmation';
                $mail->Body = '<pre>Dear ' . htmlspecialchars(strtoupper($row['first_name'])) . ' ' . htmlspecialchars(strtoupper($row['middle_name'])) . ' ' . htmlspecialchars(strtoupper($row['last_name'])) . ', <br><br>'
                    . 'Warm Greetings!
                       
                        We are pleased to confirm receipt of your payment for the 17th PhilSPEN Annual Convention, themed NUTRITION MEDICINE: Integrated Approach to Patient Care, to be held on November 20-21, 2025, at Novotel Manila, Araneta City.

                        Attached to this email is your unique QR code, which will serve as your entry pass to claim your convention ID and kit. It will also be used for attendance tracking throughout the event.

                        Important Reminders:
                        <li>Save your QR Code on your mobile device for easy access at the <b>Registration Table</b></li>
                        <li>Ensure the QR code is clearly visible for scanning</li>
                        <li>If you’re unable to present the QR code digitally, bring a printed copy as backup.</li>
                        <li>Have your valid ID ready for verification of registration details.</li>

                        Should you have any concerns, feel free to reach out to us at 87230101 loc 5706 / 09338534625 or email us at philspen.sec20@gmail.com.

                        We look forward to seeing you at the convention!

                        Best regards,

                        Racquel O. Cainap-Andaya, MD
                        Head, Registration and Membership Committee
                        Philippine Society for Parenteral and Enteral Nutrition
                        </pre>';

                // $mail->addAttachment("../events/qr/$row[qr_event]");
                $qrFile = realpath(__DIR__ . '/../events/qr/' . basename($row['qr_event']));
                if ($qrFile && file_exists($qrFile)) {
                    $mail->addAttachment($qrFile);
                }


                $mail->send();
                echo "<script>
                        alert('Email sent successfully');
                      </script>";
            }
        }
    } catch (Exception $e) {
        print_r($e);
        die();
    }



    $stmt = "DELETE FROM temp_participants WHERE id = ?";
    $st = $db->prepare($stmt);
    $st->execute([$id]);
    header("Location: ../index.php");
} else {
    header("Location: ../index.php");
}

?>