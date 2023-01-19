<?php
include_once 'headerr.php';
$conn=mysqli_connect("localhost","root","","zlatnipojas");

if(mysqli_connect_error())
{
    echo "Cannot connect";
} else {
    // echo "Connected";
}

    if(isset($_FILES['profilna']))
    {
        $erorr=arraY();
        $file_name=$_FILES['profilna']['name'];
        $file_size=$_FILES['profilna']['size'];
        $file_tmp=$_FILES['profilna']['tmp_name'];
        $file_type=$_FILES['profilna']['type'];

        $tmp = explode('.', $file_name);
        $file_ext = end($tmp);
        //slika.JPG-->slika.jpg
        $extensions=array("jpeg","jpg","png","JPG","PNG","JPEG");
        //ako ima gresaka
        if(in_array($file_ext, $extensions)==false)
        {
            $erorr[]="Molimo Vas izaberite fotografiju u jpg, jpeg ili png formatu!";
        }
        //ako nema gresaka
        if(empty($erorr)==true)
        {
            move_uploaded_file($file_tmp,"profilne/" . $file_name);
            $path="profilne/". $file_name;

            if($_POST['password']==$_POST['password_p'])
            {
              $passHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
              $sql=
              "INSERT INTO pom_tabela (ime,prezime,korisnicko_ime, datum_rodjenja, mesto_rodjenja, drzava_rodjenja,
              jmbg,email,lozinka,pol,disciplina,kilaza,trener,ime_kluba,grad,uloga,profilna)
              VALUES ('$_POST[UserName]','$_POST[UserSurname]','$_POST[User]', '$_POST[datum_rodjenja]', '$_POST[mesto]','$_POST[drzava]','$_POST[jmbg]',
                '$_POST[UserEmail]','$passHash','$_POST[pol]','$_POST[disciplina]','$_POST[kilaza]','$_POST[trener]','$_POST[klub]','$_POST[grad]','$_POST[uloga]','$path')";
              $query=$conn->query($sql);
              if($query)
              {
                  echo "RADI";
              } else
              {
                  echo mysqli_error($conn);
              }
            }
            else
            {
              header('Location: registracija.php');
            }
        } else
        {
            print_r($erorr);
            header('Location: registracija.php');
        }
      }
?>

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
    </style>
</head>
<body class="prijava">
    <main>
        <a href="index.php"><img src="./img/logo.PNG" alt="Logo" width="150px" height="150px" id="logo"></a>
        <h2 style="margin-left: 80px;">Karate turnir "ZLATNI POJAS"</h2>
        <p style="margin-left: 20px;">Unesite podatke za registraciju.</p>
        <form role="form" style="margin-left: 80px;" action="registracija.php" method="post" enctype="multipart/form-data">
            <div class="contact-form-text">
                <input type="text" name="UserName" id="" placeholder="Ime" required>
            </div>
            <div class="contact-form-text">
                <input type="text" name="UserSurname" id="" placeholder="Prezime" required>
            </div>
            <div class="contact-form-text">
                <input type="date" name="datum_rodjenja" id="" placeholder="Datum rođenja" min="1991-12-31" max="2015-12-31" required>
            </div>
            <div class="contact-form-text">
                <input type="text" name="mesto" id="" placeholder="Mesto rođenja">
            </div>
            <div class="contact-form-text">
                <input type="text" name="drzava" id="" placeholder="Država rođenja">
            </div>
            <div class="contact-form-text">
                <input type="number" name="jmbg" id="" placeholder="JMBG">
            </div>
            <div class="contact-form-text">
                <input type="email" name="UserEmail" id="" placeholder="Email" required>
            </div>
            <div class="contact-form-text">
                <input type="text" name="User" id="" placeholder="Korisničko ime" required>
            </div>
            <div class="contact-form-text">
                <input type="password" name="password" id="Lozinka" placeholder="Lozinka" required>
            </div>
            <div class="contact-form-text">
                <input type="password" name="password_p" id="" placeholder="Potvrda lozinke" required>
            </div>
            <label for="profilna" class="profilna">Profilna fotografija:</label>
            <input type="file" name="profilna" id="profilna" required>
            <div class="contact-form-text">
                <label for="pol" style="color: white;">Pol:</label>
                <select id="pol" name="pol">
                <option value="M" width="100px">Muško</option>
                <option value="Ž">Žensko</option>
                </select>
            </div>
            <div class="contact-form-text">
                <label for="pol" style="color: white;">Registrujem se kao:</label>
                <select id="uloga" name="uloga">
                    <option value="Takmicar" width="100px">Takmičar</option>
                    <option value="Trener">Trener</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <div class="contact-form-text">
                <label for="disciplina" class="disciplina">Izaberite disciplinu:</label>
                <select id="disciplina" name="disciplina">
                    <option value="kate" width="100px">Kate</option>
                    <option value="borbe">Borbe</option>
                </select>
            </div>
            <div class="contact-form-text">
                <input type="text" name="kilaza" id="" placeholder="Kilaža">
            </div>
            <div class="contact-form-text">
                <input type="text" name="trener" id="" placeholder="Trener">
            </div>
            <div class="contact-form-text">
                <input type="text" name="klub" id="" placeholder="Ime kluba" required>
            </div>
            <div class="contact-form-text">
                <input type="text" name="grad" id="" placeholder="Grad" required>
            </div>
            <div class="contact-form-text">
                <button type="submit" name="submit">REGISTRUJ SE</button>
            </div>
        </form>
    </main>

</body>
</html>
