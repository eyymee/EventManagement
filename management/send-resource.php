<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host='smtp.gmail.com';
$mail->Port=587;
$mail->SMTPAuth=true;
$mail->SMTPSecure='tls';

$mail->Username='eventmgt.developer@gmail.com';
$mail->Password='P@55wOrd';

    $message1="";
    $error="";
    include_once 'dbconnect.php';

    if (isset($_GET['id']))
            $id = $_GET['id'];
        else
            $id = 0;

        $query = "SELECT * FROM resource  where id = '$id'";
        $result = mysqli_query($conn,$query) or die('SQL error retrieve resource ');
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

     if(isset($_POST['hantar']))
      {
        $nfc = addslashes($_POST['rfid']);
        $organizer = $_SESSION['email'];

        $query1 = "SELECT a.*, b.* FROM participant a, attendance b  where b.rfid = '$nfc' AND a.ic=b.ic";
        $result1 = mysqli_query($conn,$query1) or die('SQL error check participant ');
        $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

        $email = $row1['email'];
        $siapa = $row1['name'];
        $resource = $row['file'];

            if($row1){
                // Recipient
                $mail->addAddress($email);

                // Sender
                $mail->setFrom('eventmgt.developer@gmail.com','Event Management');
                $mail->addReplyTo('noreply@eventmanagement.com');
                $mail->isHTML(true);
                // Email subject
                $mail->Subject='Your requested resource from Event Management';

                // Attachment file
                $mail->addAttachment('resources/'. $resource .'');

                // Email body content
                $mail->Body='
                    <h3>Hi '.$siapa.'! Here we deliver to you :)</h3>
                    <p>This email is sent from Event Management with attachment of file '. $resource .' </p>
                ';


                // Preparing attachment
                if($mail->send()){
                    $message1 = "Your resource is on its way! Thank you $email";
                }
            }
                else
                    $error="Your RFID tag was not registered for this event";

        }
?>
