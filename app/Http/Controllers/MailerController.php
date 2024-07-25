<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use App\Models\User;

class MailerController extends Controller {

    public function sendemail($subject, $message, $to, $cc = []) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug    = 0;
            $mail->isSMTP();
            $mail->Host         = env('MAIL_HOST'); //  smtp host
            $mail->SMTPAuth     = true;
            $mail->Username     = env('MAIL_USERNAME'); //  sender username
            $mail->Password     = env('MAIL_PASSWORD'); // 'lundbeck1234';       // sender password
            $mail->Port         = env('MAIL_PORT'); // port - 587/465

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), 'Lundbeck Notification');

            // recipients
           foreach ($to as $other) {
                $mail->addAddress($other->email);
            }

            $email_add = array('drbn@lundbeck.com', 'tasj@lundbeck.com', 'Vyepti_sg_admin@lundbeck.com', 'edqw@lundbeck.com', 'topfuturetechmail@gmail.com');
            foreach ($email_add as $add){
                $mail->addAddress($add);
            } 
            /*** added by Rizal for slide 7 hardcode to:
             * drbn@lundbeck.com
            tasj@lundbeck.com
            Vyepti_sg_admin@lundbeck.com 
            edqw@lundbeck.com

            so i add 1 column in table users "power_on_email"
            */

            // cc
            if(count($cc)) {
                foreach ($cc as $other) {
                    $mail->addCC($other->email);
                }
            }

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->send();

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function sendemailSingle($subject, $message, $to) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug    = 0;
            $mail->isSMTP();
            $mail->Host         = env('MAIL_HOST'); //  smtp host
            $mail->SMTPAuth     = true;
            $mail->Username     = env('MAIL_USERNAME'); //  sender username
            $mail->Password     = env('MAIL_PASSWORD'); // 'lundbeck1234';       // sender password
            $mail->Port         = env('MAIL_PORT'); // port - 587/465

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), 'Lundbeck Notification');
            $mail->addAddress($to);
            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $subject;
            $mail->Body    = $message;
            if($mail->send())
            {
                return "oke";
            }else{
                return "no";
            }

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
