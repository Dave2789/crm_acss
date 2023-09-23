<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Alerts;
use App\Models\Users_per_alert;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Permissions\UserPermits;

class MailController extends Controller {

    private $UserPermits;
    
	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
        }
        

       /* private $host     = "smtpout.secureserver.net";
        private $username = "development@appendcloud.com";
        private $password = "AdminDev18#";*/

     /*    private $host     = "mail.abrevia.com.mx";
        private $username = "info@abrevia.com.mx";
        private $password = "&*YD*_B4mz[]";*/

         private $host     = "correo.treebes.com";
        private $username = "atencion@abrevius.com";
        private $password = "atencion.1234";

        

        public function viewSendMail()
        {
            $arrayPermition = array();
            
            $document = DB::table('documents')
                          ->select('pkDocument'
                                  ,'name'
                                  ,'document')
                          ->where('status','=',1)
                          ->get();
            
            $arrayPermition["sendMail"]  = $this->UserPermits->getPermition("sendMail");
            return view('emails.viewSendMail')->with("arrayPermition",$arrayPermition)
                                              ->with("document",$document);
        }
        
        public function sendEmail(Request $request){
          $destinity         = $request->input("destinity");
          $subject           = $request->input("subject");
          $message           = $request->input("message");
          $document          = $request->input("document");
          $file              = $request->file("file");
          $pkUser            = Session::get("pkUser");
          $mail              = new PHPMailer(true);

          $emailSend = DB::table('users')
                          ->select('mail')
                          ->where('pkUser','=',$pkUser)
                          ->where('status','=',1)
                          ->first();

          try {

            $mail->SMTPDebug  = 4;                    // Enable verbose debug output
            $mail->isSMTP();                         // Set mailer to use SMTP
            $mail->Host       = $this->host;        // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;              // Enable SMTP authentication
            $mail->Username   = $this->username;  // SMTP username
            $mail->Password   = $this->password; // Enable TLS encryption, `ssl` also accepted
           // $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
           // $mail->Port       = 465;
            $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;
          

            $mail->setFrom($emailSend->mail, 'Abrevius');
            $mail->addAddress($destinity);     // Add a recipient
            $mail->addReplyTo($emailSend->mail, 'Abrevius');
            $mail->addCC('alanarellano@appendcloud.com');
            $mail->addCC('alanarellano77@gmail.com');
            
            if($document > 0){
                
                 $documentDb = DB::table('documents')
                          ->select('pkDocument'
                                  ,'name'
                                  ,'document')
                          ->where('status','=',1)
                          ->where('pkDocument','=',$document)
                          ->first();
                
              $mail->addAttachment(base_path('/public/document/'.$documentDb->document.''),$documentDb->name);   
            }
            
            if(!empty($file)){
            $mail->addAttachment(realpath($file),$file->getClientOriginalName());
            }

            $meesage = $message;

            $mail->isHTML(true);
            //$mail->CharSet = 'UTF-8'; // Set email format to HTML// Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $meesage;
            $mail->send();
            
            return "true";
        } catch (Exception $ex) {
             return "false";
        }
    }
        
	
}
