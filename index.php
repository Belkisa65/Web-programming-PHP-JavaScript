<!DOCTYPE html>
<html lang="sr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link href="/your-path-to-fontawesome/css/all.css" rel="stylesheet">
    <link rel="icon" href="./img/logo.PNG" type="image/gif" >
    <title>Zlatni pojas</title>
    <style media="screen">
    div.jumbotron {
        margin-left: 0px !important;
        margin-bottom: 40px;
        /* box-shadow: 1px 1px 1px 1px #7d7d7d; */
        height: 81.8vh;
        background-image: linear-gradient(rgba(0, 0, 0, 0.7),rgba(0, 0, 0, 0.7)), url(./img/zastave.jpg);
        background-position: bottom;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        margin-top: 0 !important;
    }
    .jumbotron h1 {
      padding-top: 50px;
      /* padding-right: 250px; */
      color: white;
    }
    .jumbotron img {
      margin-left: 100px;
      margin-top: 190px;
    }
    </style>
</head>
<body>
    <!--HEADER-->
    <div class="header">
        <div class="container">
            <div class="navbar2">
                <div class="row1">
                    <ul>
                        <li><i class="far fa-clock" id="clock"></i>Pon-Pet / 09-21h</li>
                        <li><a href="mailto:zlatnipojascacka@gmail.com" class="email"><i class="far fa-envelope" id="email"></i>zlatnipojascacka@gmail.com</a></li>
                        <li><a href="#" class="links link1"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" class="links"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#" class="links"><i class="fab fa-twitter"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar">
        <div class="container">
            <div class="row">
                <p>
                  <a href="index.php"><img src="./img/logo.PNG" alt="Logo" width="80px" height="80px" id="logo"></a>
                </p>
                <ul>
                    <li><a href="#" class="active">Početna</a></li>
                    <li><a href="posts.php">Vesti</a></li>
                    <li><a href="prijava.php">Prijava</a></li>
                    <li><a href="registracija.php">Registracija</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--MAIN-->
    <div class="jumbotron">
        <div class="container">
            <!-- <h1>Zlatni pojas Čačka</h1> -->
            <img src="./img/logoi-removebg-preview.png" alt="Diploma" height="150px" width="930px">
        </div>
    </div>
    <div class="main omeni">
        <div class="container">
            <!--DOBRODOSLICA-->
            <h1>Najkvalitetniji i najstariji karate turnir na ovim prostorima</h1>
            <div class="clearfix">
                <div class="col1 photo-diploma">
                    <img src="./img/zastave.jpg" alt="Diploma" height="290px" width="540px" class="slika1">
                    <img src="./img/turnir.jpg" alt="Diploma" height="290px" width="540px" class="slika1">
                </div>
                <div class="col2 licni-podaci">
                    <img src="./img/piper.jpg" alt="Slavoljub Piper" height="185px" width="140px" class="piper">
                    <h3 class="heading-tertiary naslov">Slavoljub Piper<br>Predsednik Karate federacije Srbije<br>Generalni sekretar Karate federacije Balkana</h3>
                    <p class="paragraph-omeni" id="dobrodoslica">
                        <br>Veliko mi je zadovoljstvo pozdraviti sve učesnike 49.
                        Međunarodnog karate turnira ZLATNI POJAS.
                        Srbija i Čačak su tradicionalni domaćini jedne velike
                        sportske manifestacije kakvo je ovo takmičenje.
                        <br><br>Organizujući ovaj turnir želeli smo da pokažemo svima koliko
                        je karate pozitivan, masovan i popularan sport.
                        <br>Ovaj događaj je više od samog takmičenja. On će biti
                        spoj prijateljstva, umetnosti i karatea. Uveren sam da će Srbija i Čačak, kao i mnogo puta do sada
                        opravdati ukazano poverenje.
                        <br>Svim učesnicima želim da ovaj događaj, za njih same ali i za
                        karate sport, bude doživljen kao nejezičan dijalog u duhu
                        sportske filozofije. Jer, karate svojom savremenošću govori
                        sve jezike i povezuje sve ljude i generacije, bez obzira na
                        rasu, pol, veru i politički status.
                        <br><br>Neka pobedi najbolji!
                        Dobrodošli u grad Čačak.</p>

                    </div>
            </div>
         </div>
    </div>
        <!--KONTAKT-->
        <div class="kontakt">
            <h2 id="naslov-v">Kontaktirajte nas</h2>
            <div class="container clearfix">
                <div class="c-1">
                    <article class="contact-form">
                        <p id="paragraph-v">Ako imate bilo kakvih pitanja, jednostavno koristite sledeće podatke za kontakt.</p>
                        <ul>
                            <li id="adresa"><b>Adresa</li>
                            <li class="link"><i class="fas fa-map-marker"></i>Vuk Karadžić 28, Čačak</li>
                            <li id="tel"><b>Telefon</li>
                            <li class="link"><i class="fas fa-phone-alt"></i>020-811-951</li>
                            <li><b>Email</li>
                            <li class="link"><a href="mailto:zlatnipojascacka@gmail.com"><i class="far fa-envelope"></i>zlatnipojascacka@gmail.com</a></li><hr>
                        </ul>
                    </article>
                </div>
                <div class="c-2">
                    <article>
                        <div>
                            <form method="post" action="">
                                <div class="contact-form-text">
                                  <label for="name">Ime i prezime <span>*</span></label>
                                  <input type="text" name="name" id="name" required>
                                </div>
                                <div class="contact-form-text">
                                  <label for="email">E-mail <span>*</span></label>
                                  <input type="email" name="email" id="email" required>
                                </div>
                                <div class="contact-form-text">
                                  <label for="message">Poruka <span>*</span></label>
                                  <textarea name="message" id="message" required></textarea>
                                </div>
                                <input type="submit" name="submit" class="btn btn-blue btn-animated" id="posalji" value="Pošalji" onclick="proveraForme()">
                            </form>
                        </div>
                    </article>
                </div>
                <div class="c-3">
                    <article>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46006.12154837977!2d20.32642327402332!3d43.88934210301476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4757723fdaf79e2d%3A0x46460a390c51b8ce!2z0KfQsNGH0LDQug!5e0!3m2!1ssr!2srs!4v1615726085291!5m2!1ssr!2srs" width="367px" height="470px" style="border:0;" frameborder="0"  aria-hidden="false" tabindex="0">
                        </iframe></iframe>
                    </article>
                </div>
            </div>
        </div>
<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail=new PHPMailer(true);
$alert='';

if(isset($_POST['submit'])) {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $message=$_POST['message'];

    try {
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth=true;
        $mail->Username='belkisa.dazdarevic1@gmail.com';
        $mail->Password='kvazilend5';
        $mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port='587';

        $mail->setFrom('belkisa.dazdarevic1@gmail.com');
        $mail->addAddress('belkisa.dazdarevic1@gmail.com');

        $mail->isHTML(true);
        $mail->Subject='Email od posetioca sajta ZLATNI POJAS ČAČKA';
        $mail->Body=
        '<h1>Podaci o pošiljaocu poruke:</h1><br>
        <h3>Ime i prezime: $name</h3>
        <h3>Email: $email</h3><br><br>
        <p>Poruka: $message</p>';

        $mail->send();
        $alert='<div>Poruka je uspešno poslata!</div>';
    } catch (Exception $e) {
        $alert='<div>'.$e->getMessage().'</div>';
    }

}
?>
<?php include_once 'footer.php'; ?>
