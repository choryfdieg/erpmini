<?php

require_once ('class.phpmailer.php');

class Mail {

    private $from;
    private $fromName;
    private $to;
    private $subject;
    private $body;
    private $host;
    private $user;
    private $pass;

    public function sendMail() {

        $mail = new PHPMailer();

        $mail->From = $this->from;
        $mail->FromName = $this->fromName;

        $correos = explode(",", $this->to);

        foreach ($correos as $value) {
            $mail->AddAddress($value);
        }        

        //$mail->WordWrap = 50; // Largo de las lineas
        $mail->IsHTML(true); // Podemos incluir tags html
        $mail->Subject = $this->subject;
        $this->agregarFirma();
        $mail->Body = $this->body;

        $mail->IsSMTP(); // vamos a conectarnos a un servidor SMTP
        $mail->Host = $this->host; // direccion del servidor
        $mail->SMTPAuth = false; // usaremos autenticacion
        $mail->Username = $this->user; // usuario
        $mail->Password = $this->pass; // contraseña
        $mail->SMTPAuth = true; // usaremos autenticacion
        $mail->Username = "dfgarcia@comfamiliar.com"; // usuario
        $mail->Password = "camino06=&"; // contraseña
        $mail->IsHTML(); // Habilitar formato HTML

        if (!$mail->Send())
            return $mail->ErrorInfo;

        return true;
    }
    
    public function agregarFirma(){
        $this->body .= '<div style = "text-align: center; margin-top: 20px;">
                            <img class="transparent" alt="https://correo.comfamiliar.com/firma.gif" src="https://correo.comfamiliar.com/firma.gif">
                        </div>';
    }

    public function getFrom() {
        return $this->from;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function getFromName() {
        return $this->fromName;
    }

    public function setFromName($fromName) {
        $this->fromName = $fromName;
    }

    public function getTo() {
        return $this->to;
    }

    public function setTo($to) {
        $this->to = $to;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }
}