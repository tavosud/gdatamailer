<?php 
    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception; 
    
    if(!(isset($_POST['smtpMail']))){ 
        echo "Requiere el cliente para proceder... "; 
    }else{ 
        require 'vendor/autoload.php'; 
        $file = fopen($_FILES['receptorMail']['tmp_name'], "r") or exit("Unable to open file!"); 
        while(!feof($file)) { 
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = $_POST['smtpMail'];
            $mail->SMTPAuth = true;
            $mail->Username = $_POST['userMail'];
            $mail->Password = $_POST['passwordMail'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom($_POST['emisorMail'],$_POST['aliasMail']); 
            $mail->addAddress(fgets($file));      
            if (is_uploaded_file($_FILES['fileMail']['tmp_name'][0])){ 
                for($ct=0;$ct<count($_FILES['fileMail']['tmp_name']);$ct++){ 
                    $mail->AddAttachment($_FILES['fileMail']['tmp_name'][$ct],$_FILES['fileMail']['name'][$ct]);
                } 
            } 
            $mail->isHTML(true);                                   
            $mail->Subject = $_POST['subjectMail']; 
            $mail->Body = $_POST['contenidoMail']; 
            if(!$mail->Send()) { 
                json_encode('{ "mensaje": "Error sending" }'); 
            }else{ 
                json_encode('{ "mensaje": "Mails enviados con exito" }'); 
            } 
            $mail = null; 
        } 
        
        fclose($file); 
    }



