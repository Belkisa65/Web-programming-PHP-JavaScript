<?php
session_start();
include('conn.php');

if(isset($_POST['submit']))
{
    // izvrsava se jedan od ova 3 slucaja
    $query="SELECT `uloga` FROM 'admin_table' WHERE `korisnicko_ime`='$_POST[name]'";
    $result=mysqli_query($conn, $query);
    if($result='Admin')
    {

        $query="SELECT * FROM `admin_table` WHERE `korisnicko_ime`='$_POST[name]'";
        $result=mysqli_query($conn, $query);
        if(mysqli_num_rows($result)!=0)
        {
            $_SESSION['AdminLoginId']=$_POST['name'];
            header("location: adminPanel.php");
        }
    }

    $query3="SELECT `uloga` FROM 'competitor_table' WHERE `korisnicko_ime`='$_POST[name]'";
    $result3=mysqli_query($conn, $query3);
    if($result3='Takmicar')
    {
        $query="SELECT * FROM `competitor_table` WHERE `korisnicko_ime`='$_POST[name]'";
        $result=mysqli_query($conn, $query);

        while($row=mysqli_fetch_assoc($result))
        {
            $pass_db = $row['lozinka'];
            if(password_verify($_POST['password'], $pass_db))
            {
                $_SESSION['CompetitorLoginId'] = $_POST['name'];
                header("location: competitorPanel.php");
            }
        }
    }
    $query1="SELECT `uloga` FROM 'coordinator_table' WHERE `korisnicko_ime`='$_POST[name]'";
    $result1=mysqli_query($conn, $query1);
    if($result1='Trener')
    {
        $query="SELECT * FROM `coordinator_table` WHERE `korisnicko_ime`='$_POST[name]'";
        $result=mysqli_query($conn, $query);

        while($row=mysqli_fetch_assoc($result))
        {
            $pass_db = $row['lozinka'];
            if(password_verify($_POST['password'], $pass_db))
            {
                $_SESSION['CoordinatorLoginId']=$_POST['name'];
                header("location: coordinatorPanel.php");
            }
        }
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    include_once 'phpmailer/Exception.php';
    require_once 'phpmailer/PHPMailer.php';
    require_once 'phpmailer/SMTP.php';

    $mail = new PHPMailer(true);
    $alert = '';

// LOGOUT
if(isset($_POST['logout']))
{
    session_destroy();
    header('Location: prijava.php');
    exit(0);
}

// DELETE ADMIN
if(isset($_POST['delete_admin']))
{
    $user_id = $_POST['delete_admin_id'];

    $query = "DELETE FROM admin_table WHERE id_admina='$user_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_delete_admin'] = " Uspešno ste izvršili brisanje administratora.";
        header("Location: admini.php");
    }
    else
    {
        header('Location: admini.php');
    }
}

// ODBIJANJE ZAHTEVA ZA REGISTRACIJU
if(isset($_POST['delete_user']))
{
    $user_id = $_POST['delete_user_id'];
    $user_email = $_POST['user_email'];
    $query = "DELETE FROM pomocna_tabela WHERE id='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_izbrisano'] = "Uspešno ste izbrisali zahtev za registraciju.";
        header("Location: zahtevi.php");
    }
    else
    {
        header('Location: zahtevi.php');
    }

        // ODBIJEN ZAHTEV
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'belkisa.dazdarevic1@gmail.com';
            $mail->Password = 'kvazilend5';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = '587';

            $mail->setFrom('belkisa.dazdarevic1@gmail.com');
            $mail->addAddress($user_email); //kome saljemo poruku na email

            $mail->isHTML(true);
            $mail->Subject='Odbijen zahtev za registraciju - ZLATNI POJAS';
            $mail->Body =
            '<p style="font-size: 18px;">Postovani,<br>
                Vas zahtev za registraciju je odbijen.
            </p><br>
            <p style="color: gray;">
                Zlatni pojas<br>
                Administracija<br>
                <span style="font-size: 15px; color: grey;">E-mail: zlatnipojascacka@gmail.com<br>
                Web stranica: </span><br>
            </p>';

            $mail->send();
            $alert = '<div>Poruka je uspešno poslata!</div>';

        } catch (Exception $e) {
            $alert = '<div>'.$e->getMessage().'</div>';
        }
}

// PRIHVATANJE ZAHTEVA ZA REGISTRACIJU
if(isset($_POST['add_user']))
{
    $user_id = $_POST['add_user_id'];
    $admin = $_POST['admin'];
    $uloga = $_POST['uloga'];
    $user_email = $_POST['email'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];


    // NOVO KORISNICKO IME
    $korisnicko_ime = strtolower($ime.'.'.$prezime.rand(1,99));

    $queryUpdate = "UPDATE `pom_tabela`
    SET `korisnicko_ime`='$korisnicko_ime', `id_admina`='$admin'
    WHERE id='$user_id'";
    $query_run_update = mysqli_query($conn, $queryUpdate);


    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'belkisa.dazdarevic1@gmail.com';
        $mail->Password = 'kvazilend5';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = '587';

        $mail->setFrom('belkisa.dazdarevic1@gmail.com');
        $mail->addAddress($user_email); //kome saljemo poruku na email

        $mail->isHTML(true);
        $mail->Subject='Registracija - ZLATNI POJAS';
        $mail->Body =
        '<p style="font-size: 18px;">Uspešno ste se registrovali na aplikaciji Zlatni pojas.<br>
        Prilikom prijave na sistem, koristite novo korisničko ime koje Vam šaljemo u prilogu.</p><br>
        <h2 style="color: #e63946">Novo korisničko ime: '.$korisnicko_ime.'</h2><br>
        <p style="color: gray;">
            Zlatni pojas<br>
            Administracija<br>
            <span style="font-size: 15px; color: grey;">E-mail: zlatnipojascacka@gmail.com<br>
            Web stranica: </span><br>
        </p>';

        $mail->send();
        $alert = '<div>Poruka je uspešno poslata!</div>';
    }
    catch (Exception $e) {
        $alert = '<div>'.$e->getMessage().'</div>';
    }

    // DODAVANJE U NOVU TABELU - ovo mi ne radi
    if($uloga=='Admin')
    {
        $sql = "SELECT * FROM  pom_tabela WHERE `id`='$user_id'";
        $query=mysqli_query($conn, $sql);
        while($row=mysqli_fetch_assoc($query))
        {

          $id = $row['id'];
          $korisnicko_ime = $row['korisnicko_ime'];
          $ime = $row['ime'];
          $prezime = $row['prezime'];
          $datum_rodjenja = $row['datum_rodjenja'];
          $mesto_rodjenja = $row['mesto_rodjenja'];
          $drzava_rodjenja = $row['drzava_rodjenja'];
          $jmbg = $row['jmbg'];
          $email = $row['email'];
          $lozinka = $row['lozinka'];
          $profilna = $row['profilna'];
          $uloga = $row['uloga'];


        $sql1 = "INSERT INTO `admin_table`(`id_admina`, `korisnicko_ime`, `datum_rodjenja`, `ime`, `prezime`, `lozinka`, `email`, `uloga`, `profilna`, `mesto_rodjenja`, `drzava_rodjenja`, `jmbg`)
        VALUES ('$id','$korisnicko_ime','$datum_rodjenja','$ime','$prezime','$lozinka',
        '$email','$uloga','$profilna','$mesto_rodjenja','$drzava_rodjenja','$jmbg')";
        $query1=mysqli_query($conn, $sql1);

        if($query1)
            {
                echo "RADI";
            } else
            {
                echo mysqli_error($conn);
            }
          }
    }
    if($uloga=='Trener')
    {
        $sql = "SELECT * FROM  pom_tabela WHERE `id`='$user_id'";
        $query=mysqli_query($conn, $sql);
        while($row=mysqli_fetch_assoc($query))
        {

          $id = $row['id'];
          $korisnicko_ime = $row['korisnicko_ime'];
          $ime = $row['ime'];
          $prezime = $row['prezime'];
          $datum_rodjenja = $row['datum_rodjenja'];
          $mesto_rodjenja = $row['mesto_rodjenja'];
          $drzava_rodjenja = $row['drzava_rodjenja'];
          $jmbg = $row['jmbg'];
          $email = $row['email'];
          $lozinka = $row['lozinka'];
          $profilna = $row['profilna'];
          $uloga = $row['uloga'];


        $sql1 = "INSERT INTO `coordinator_table`(`id`, `korisnicko_ime`, `datum_rodjenja`, `ime`, `prezime`, `lozinka`, `email`, `uloga`, `profilna`, `mesto_rodjenja`, `drzava_rodjenja`, `jmbg`)
        VALUES ('$id','$korisnicko_ime','$datum_rodjenja','$ime','$prezime','$lozinka',
        '$email','$uloga','$profilna','$mesto_rodjenja','$drzava_rodjenja','$jmbg')";
        $query1=mysqli_query($conn, $sql1);

        if($query1)
            {
                echo "RADI";
            } else
            {
                echo mysqli_error($conn);
            }
          }
    }
    if($uloga=='Takmicar')
    {
        $sql = "SELECT * FROM  pom_tabela WHERE `id`='$user_id'";
        $query=mysqli_query($conn, $sql);
        while($row=mysqli_fetch_assoc($query))
        {

          $id = $row['id'];
          $id_admina = $row['id_admina'];
          $korisnicko_ime = $row['korisnicko_ime'];
          $ime = $row['ime'];
          $prezime = $row['prezime'];
          $pol = $row['pol'];
          $datum_rodjenja = $row['datum_rodjenja'];
          $mesto_rodjenja = $row['mesto_rodjenja'];
          $drzava_rodjenja = $row['drzava_rodjenja'];
          $jmbg = $row['jmbg'];
          $email = $row['email'];
          $lozinka = $row['lozinka'];
          $profilna = $row['profilna'];
          $uloga = $row['uloga'];
          $kilaza = $row['kilaza'];
          $disciplina = $row['disciplina'];
          $trener = $row['trener'];
          $ime_kluba = $row['ime_kluba'];
          $grad = $row['grad'];



        $sql1 = "INSERT INTO `competitor_table`(`id`, `id_admina`, `korisnicko_ime`, `ime`, `prezime`, `datum_rodjenja`, `mesto_rodjenja`,
          `drzava_rodjenja`, `jmbg`, `email`, `lozinka`, `pol`, `disciplina`, `kilaza`, `trener`, `ime_kluba`, `grad`, `profilna`, `uloga`, `kategorija`, `beleska`, `statusTakmicara`)
        VALUES ('$id','$id_admina', '$korisnicko_ime','$ime','$prezime','$datum_rodjenja','$mesto_rodjenja',
        '$drzava_rodjenja','$jmbg','$email','$lozinka','$pol', '$disciplina','$kilaza', '$trener', '$ime_kluba', '$grad','$profilna','$uloga','','','')";


        $query1=mysqli_query($conn, $sql1);

        if($query1)
            {
                echo "RADI";
            } else
            {
                echo mysqli_error($conn);
            }
          }
    }

    // BRISANJE IZ STARE TABELE
    $query = "DELETE FROM pom_tabela WHERE id='$user_id'";
    $query_run = mysqli_query($conn, "DELETE FROM pom_tabela WHERE id='$user_id'");

    if($query_run)
    {
        $_SESSION['status_odobreno'] = " Uspešno ste odobrili zahtev za registraciju.";
        header('Location: code.php');
    }
    else
    {
        header('Location: zahtevi.php');
    }

}

// UPDATE ADMIN
if(isset($_POST['update']))
{
  $id_admina = $_POST['id_admina'];
  $ime = $_POST['ime_update'];
  $prezime = $_POST['prezime_update'];
  $mesto_rodjenja = $_POST['mesto_rodjenja_update'];
  $drzava_rodjenja = $_POST['drzava_rodjenja_update'];
  $email = $_POST['email_update'];
  $uloga = $_POST['uloga_update'];

  $queryUpdate =
      "UPDATE admin_table
      SET ime = '$ime', prezime = '$prezime', mesto_rodjenja = '$mesto_rodjenja',  drzava_rodjenja = '$drzava_rodjenja',
      email = '$email', uloga = '$uloga'
      WHERE id_admina='$id_admina'";

  $query_run_update = mysqli_query($conn, $queryUpdate);

  if($query_run_update)
  {
      $_SESSION['status_update'] = " Uspešno ste izvršili ažuriranje.";
      header('Location: admini.php');
  }
  else
  {
      header('Location: updateAdmin.php');
  }

}

// ADD NEW ADMIN
if(isset($_POST['addAdmin']))
{
if(isset($_FILES['profilna'])) {
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

        $sql=
        "INSERT INTO admin_table (korisnicko_ime, ime, prezime, lozinka, email, uloga, profilna,
           mesto_rodjenja, drzava_rodjenja, jmbg, pol)
        VALUES ('$_POST[korisnicko_ime]', '$_POST[ime]', '$_POST[prezime]', '$_POST[lozinka]', '$_POST[email]','$_POST[uloga]', '$path',
          '$_POST[mesto_rodjenja]', '$_POST[drzava_rodjenja]', '$_POST[jmbg]', '$_POST[pol]')";
        $query_run_insert = mysqli_query($conn, $sql);

        if($query_run_insert)
        {
            $_SESSION['status_insert'] = " Uspešno ste dodali novog administratora.";
            header('Location: admini.php');
            echo "RADI";
        } else
        {
            header('Location: addAdmin.php');
            echo mysqli_error($conn);
        }
    } else
     {
        print_r($erorr);
     }
  }
}

// ADD NEW COORDINATOR
if(isset($_POST['addCoordinator']))
{
if(isset($_FILES['profilna'])) {
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

        $sql=
        "INSERT INTO coordinator_table (id_admina, korisnicko_ime, ime, prezime, lozinka, email, uloga, profilna,
           mesto_rodjenja, drzava_rodjenja, jmbg, pol)
        VALUES ('$_POST[admin]', '$_POST[korisnicko_ime]', '$_POST[ime]', '$_POST[prezime]', '$_POST[lozinka]', '$_POST[email]','$_POST[uloga]', '$path',
          '$_POST[mesto_rodjenja]', '$_POST[drzava_rodjenja]', '$_POST[jmbg]', '$_POST[pol]')";
        $query_run_insert = mysqli_query($conn, $sql);

        if($query_run_insert)
        {
            $_SESSION['status_insert'] = " Uspešno ste dodali novog koordinatora.";
            header('Location: koordinatori.php');
            echo "RADI";
        } else
        {
            header('Location: addCoordinator.php');
            echo mysqli_error($conn);
        }
    } else
     {
        print_r($erorr);
     }
  }
}

// DELETE COORDINATOR
if(isset($_POST['delete_coordinator']))
{
    $user_id = $_POST['delete_coordinator_id'];
    $query = "DELETE FROM coordinator_table WHERE id='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_delete_admin'] = " Uspešno ste izvršili brisanje koordinatora.";
        header("Location: koordinatori.php");
    }
    else
    {
        header('Location: koordinatori.php');
    }
}

// UPDATE COORDINATOR
if(isset($_POST['update_coor']))
{
  $id = $_POST['id'];
  $ime = $_POST['ime_update'];
  $prezime = $_POST['prezime_update'];
  $mesto_rodjenja = $_POST['mesto_rodjenja_update'];
  $drzava_rodjenja = $_POST['drzava_rodjenja_update'];
  $email = $_POST['email_update'];
  $uloga = $_POST['uloga_update'];

  $queryUpdate =
      "UPDATE coordinator_table
      SET ime = '$ime', prezime = '$prezime', mesto_rodjenja = '$mesto_rodjenja',  drzava_rodjenja = '$drzava_rodjenja',
      email = '$email', uloga = '$uloga'
      WHERE id='$id'";

  $query_run_update = mysqli_query($conn, $queryUpdate);

  if($query_run_update)
  {
      $_SESSION['status_update'] = " Uspešno ste izvršili ažuriranje.";
      header('Location: koordinatori.php');
  }
  else
  {
      header('Location: updateCoordinator.php');
  }
}

if(isset($_POST['update_coordinator']))
{
      $id = $_POST['id'];
      $_SESSION['id_koordinatora'] = "$id";
      header('Location: updateCoordinator.php');
}

// DELETE COMPETITOR
if(isset($_POST['delete_competitor']))
{
    $user_id = $_POST['delete_competitor_id'];
    $query = "DELETE FROM competitor_table WHERE id='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_delete_admin'] = " Uspešno ste izvršili brisanje takmičara.";
        header("Location: takmicari.php");
    }
    else
    {
        header('Location: takmicari.php');
    }
}

// ADD NEW COMPETITOR
if(isset($_POST['addCompetitor']))
{
if(isset($_FILES['profilna'])) {
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

        $sql=
        "INSERT INTO competitor_table
          (id_admina, ime, prezime, korisnicko_ime, mesto_rodjenja,
          drzava_rodjenja, jmbg, email, lozinka, pol, disciplina, kilaza,
          trener, ime_kluba, grad, profilna, uloga)
        VALUES
          ('$_POST[admin]', '$_POST[ime]', '$_POST[prezime]', '$_POST[korisnicko_ime]', '$_POST[mesto_rodjenja]',
          '$_POST[drzava_rodjenja]','$_POST[jmbg]', '$_POST[email]', '$_POST[lozinka]', '$_POST[pol]', '$_POST[disciplina]', '$_POST[kilaza]',
          '$_POST[trener]', '$_POST[klub]', '$_POST[grad]', '$path', '$_POST[uloga]')";
        $query_run_insert = mysqli_query($conn, $sql);


        if($query_run_insert)
        {
            $_SESSION['status_insert'] = " Uspešno ste dodali novog takmičara.";
            header('Location: takmicari.php');
            echo "RADI";
        } else
        {
            header('Location: addCompetitor.php');
            echo mysqli_error($conn);
        }
    } else
     {
        print_r($erorr);
     }
  }
}

// UPDATE COMPETITOR
if(isset($_POST['update_competitor']))
{
      $id = $_POST['id'];
      $_SESSION['id_takmicara'] = "$id";
      header('Location: updateCompetitor.php');
}
if(isset($_POST['update_comp']))
{
  $id = $_POST['id'];
  $ime = $_POST['ime_update'];
  $prezime = $_POST['prezime_update'];
  $disciplina = $_POST['disciplina'];
  $drzava_rodjenja = $_POST['drzava_rodjenja_update'];
  $email = $_POST['email_update'];
  $uloga = $_POST['uloga_update'];

  $queryUpdate =
      "UPDATE competitor_table
      SET ime = '$ime', prezime = '$prezime', disciplina = '$disciplina',  drzava_rodjenja = '$drzava_rodjenja',
      email = '$email', uloga = '$uloga'
      WHERE id='$id'";

  $query_run_update = mysqli_query($conn, $queryUpdate);

  if($query_run_update)
  {
      $_SESSION['status_update'] = " Uspešno ste izvršili ažuriranje.";
      header('Location: takmicari.php');
  }
  else
  {
      header('Location: updateCompetitor.php');
  }
}

// ADD NEW POST
if(isset($_POST['addNewPost']))
{
  if(isset($_FILES['naslovna']))
  {
      $erorr=arraY();
      $file_name=$_FILES['naslovna']['name'];
      $file_size=$_FILES['naslovna']['size'];
      $file_tmp=$_FILES['naslovna']['tmp_name'];
      $file_type=$_FILES['naslovna']['type'];

      $tmp = explode('.', $file_name);
      $file_ext = end($tmp);
      //slika.JPG-->slika.jpg
      $extensions=array("jpeg","jpg","png");
      //ako ima gresaka
      if(in_array($file_ext, $extensions)==false)
      {
          $erorr[]="Molimo Vas izaberite fotografiju u jpg, jpeg ili png formatu!";
      }
      //ako nema gresaka
      if(empty($erorr)==true)
      {
          move_uploaded_file($file_tmp,"vesti/" . $file_name);
          $path="vesti/". $file_name;
          $sql="INSERT INTO vesti(id_admina, naslov, sadrzaj, slika, tip) VALUES ('$_POST[id_admina]', '$_POST[naslov]','$_POST[sadrzaj]','$path','$_POST[tip]')";
          $query=$conn->query($sql);
          if($query)
          {
              $_SESSION['status_insert'] = " Uspešno ste kreirali novu vest.";
              header('Location: vesti2.php');
              echo "RADI";
          } else
          {
              header('Location: vesti2.php');
              echo "NE RADI";
          }
      } else
      {
          print_r($erorr);
      }
  }
}

// ADD NEW PHOTO
if(isset($_POST['addNewPhoto']))
{

  if(isset($_FILES['foto']))
  {
      $erorr=arraY();
      $file_name=$_FILES['foto']['name'];
      $file_size=$_FILES['foto']['size'];
      $file_tmp=$_FILES['foto']['tmp_name'];
      $file_type=$_FILES['foto']['type'];

      $tmp = explode('.', $file_name);
      $file_ext = end($tmp);
      //slika.JPG-->slika.jpg
      $extensions=array("jpeg","jpg","png");
      //ako ima gresaka
      if(in_array($file_ext, $extensions)==false) {
          $erorr[]="Molimo Vas izaberite fotografiju u jpg, jpeg ili png formatu!";
      }
      //ako nema gresaka
      if(empty($erorr)==true)
       {
          move_uploaded_file($file_tmp,"uploads/" . $file_name);
          // $path=$_SERVER['HTTP_REFERER'] . "uploads/". $file_name;
          $path="uploads/". $file_name;
          $sql="INSERT INTO slike(id_admina, slika, opis) VALUES ('$_POST[id_admina]', '$path', '$_POST[opis]')";
          $query=$conn->query($sql);
          if($query)
          {
              $_SESSION['status_insert'] = " Uspešno ste dodali novu fotografiju u galeriju.";
              header('Location: galerija.php');
              echo "RADI";
          } else
          {
              header('Location: galerija.php');
              echo "NE RADI";
          }
      } else {
          print_r($erorr);
      }
  }
}

// DELETE PHOTO FROM GALLERY
if(isset($_POST['delete_photo']))
{
    $photo_id = $_POST['delete_photo_id'];
    $admin_id = $_POST['delete_photo_admin_id'];
    $query = "DELETE FROM `slike` WHERE `id`='$photo_id' AND `id_admina` = '$admin_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_delete_admin'] = " Uspešno ste izbrisali fotografiju iz galerije.";
        header("Location: novosti.php");
        echo "radi";
    }
    else
    {
        header('Location: novosti.php');
        echo "ne radi";
    }
}

// DELETE POST
if(isset($_POST['delete_post']))
{
    $post_id = $_POST['delete_post_id'];
    $admin_id = $_POST['delete_post_admin_id'];
    $query = "DELETE FROM `vesti` WHERE `id_vesti`='$post_id' AND `id_admina` = '$admin_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_delete_admin'] = " Uspešno ste izbrisali fotografiju iz galerije.";
        header("Location: novosti.php");
        echo "radi";
    }
    else
    {
        header('Location: novosti.php');
        echo "ne radi";
    }
}

// DELETE PROFILE PHOTO
if(isset($_POST['delete_profile_photo']))
{
    $pp_id = $_POST['profilna_id'];
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $query = "DELETE profilna FROM `admin_table` WHERE `korisnicko_ime`='$korisnicko_ime'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_delete_admin'] = " Uspešno ste izbrisali fotografiju iz galerije.";
        header("Location: adminPanel.php");
        echo "radi";
    }
    else
    {
        header('Location: adminPanel.php');
        echo "ne radi";
    }
}

// UPDATE POST
if(isset($_POST['update_post_now']))
{
  $id_vesti = $_POST['id_vesti'];
  $naslov = $_POST['naslov'];
  $sadrzaj = $_POST['sadrzaj'];
  $tip = $_POST['tip'];
  $admin_id = $_POST['update_post_admin_id'];
  echo "RADI";
        $sql="UPDATE vesti SET naslov = '$_POST[naslov]', sadrzaj = '$_POST[sadrzaj]', tip = '$_POST[tip]' WHERE id_vesti = '$id_vesti'";
        $query=$conn->query($sql);
        if($query)
        {
            $_SESSION['status_insert'] = " Uspešno ste dodali ažurirali vest.";
            header('Location: novosti.php');
            echo "RADI";
        } else
        {
            header('Location: novosti.php');
            echo "NE RADI";
        }
}

// UPDATE PROFILE PHOTO ADMIN
if(isset($_POST['snimi_avatar']))
{
  // $profilna_id = $_POST['profilna_id'];
  $korisnicko_ime = $_POST['korisnicko_ime'];

  if(isset($_FILES['profilna_nova']))
  {
      $erorr=arraY();
      $file_name=$_FILES['profilna_nova']['name'];
      $file_size=$_FILES['profilna_nova']['size'];
      $file_tmp=$_FILES['profilna_nova']['tmp_name'];
      $file_type=$_FILES['profilna_nova']['type'];

      $tmp = explode('.', $file_name);
      $file_ext = end($tmp);
      //slika.JPG-->slika.jpg
      $extensions=array("jpeg","jpg","png");
      //ako ima gresaka
      if(in_array($file_ext, $extensions)==false) {
          $erorr[]="Molimo Vas izaberite fotografiju u jpg, jpeg ili png formatu!";
      }
      //ako nema gresaka
      if(empty($erorr)==true)
       {
          move_uploaded_file($file_tmp,"uploads/" . $file_name);
          // $path=$_SERVER['HTTP_REFERER'] . "uploads/". $file_name;
          $path="uploads/". $file_name;
          $sql="UPDATE admin_table SET profilna = '$path' WHERE korisnicko_ime = '$korisnicko_ime'";
          $query=$conn->query($sql);
          if($query)
          {
              $_SESSION['status_update'] = " Uspešno ste promenili profilnu fotografiju.";
              header('Location: adminPanel.php');
              echo "RADI";
          } else
          {
              header('Location: adminPanel.php');
              echo "NE RADI";
          }
      } else {
          print_r($erorr);
      }
  }
}

// UPDATE PROFILE ADMIN
if(isset($_POST['update_my_profile_admin']))
{
  $korisnicko_ime = $_POST['korisnicko_ime'];
  $mesto_rodjenja = $_POST['mesto_rodjenja'];
  $drzava_rodjenja = $_POST['drzava_rodjenja'];
  $email = $_POST['email'];

  $queryUpdate =
      "UPDATE admin_table
      SET mesto_rodjenja = '$mesto_rodjenja',  drzava_rodjenja = '$drzava_rodjenja',
      email = '$email'
      WHERE korisnicko_ime='$korisnicko_ime'";

  $query_run_update = mysqli_query($conn, $queryUpdate);

  if($query_run_update)
  {
      $_SESSION['status_update'] = " Uspešno ste izvršili ažuriranje.";
      header('Location: adminPanel.php');
  }
  else
  {
      header('Location: adminPanel.php');
  }
}


// UPDATE PASSWORD - CHANGING PASSWORD
if(isset($_POST['update_password_a']))
{
  $korisnicko_ime = $_POST['korisnicko_ime'];
  $lozinka = $_POST['lozinka'];
  $lozinka_potvrda = $_POST['lozinka_potvrda'];

  if($lozinka==$lozinka_potvrda)
  {
    $queryUpdate =
        "UPDATE admin_table
        SET lozinka = '$lozinka'
        WHERE korisnicko_ime='$korisnicko_ime'";

    $query_run_update = mysqli_query($conn, $queryUpdate);

    if($query_run_update)
    {
        $_SESSION['status_update'] = " Uspešno ste promenili lozinku.";
        header('Location: adminPanel.php');
    }
    else
    {
        header('Location: adminPanel.php');
    }
  }
  else
  {
    header('Location: adminPanel.php');
  }
}

// UPDATE PROFILE COORDINATOR
if(isset($_POST['update_my_profile_coordinator']))
{
  $korisnicko_ime = $_POST['korisnicko_ime'];
  $mesto_rodjenja = $_POST['mesto_rodjenja'];
  $drzava_rodjenja = $_POST['drzava_rodjenja'];
  $email = $_POST['email'];

  $queryUpdate =
      "UPDATE coordinator_table
      SET mesto_rodjenja = '$mesto_rodjenja',  drzava_rodjenja = '$drzava_rodjenja',
      email = '$email'
      WHERE korisnicko_ime='$korisnicko_ime'";

  $query_run_update = mysqli_query($conn, $queryUpdate);

  if($query_run_update)
  {
      $_SESSION['status_update'] = " Uspešno ste izvršili ažuriranje.";
      header('Location: coordinatorPanel.php');
  }
  else
  {
      header('Location: coordinatorPanel.php');
  }
}

// UPDATE PASSWORD COORDINATOR- CHANGING PASSWORD
if(isset($_POST['update_password_k']))
{
  $korisnicko_ime = $_POST['korisnicko_ime'];
  $lozinka = $_POST['lozinka'];

  $queryUpdate =
      "UPDATE coordinator_table
      SET lozinka = '$lozinka'
      WHERE korisnicko_ime='$korisnicko_ime'";

  $query_run_update = mysqli_query($conn, $queryUpdate);

  if($query_run_update)
  {
      $_SESSION['status_update'] = " Uspešno ste promenili lozinku.";
      header('Location: coordinatorPanel.php');
  }
  else
  {
      header('Location: coordinatorPanel.php');
  }
}

// UPDATE PROFILE PHOTO COORDINATOR
if(isset($_POST['snimi_avatar_k']))
{
  // $profilna_id = $_POST['profilna_id'];
  $korisnicko_ime = $_POST['korisnicko_ime'];

  if(isset($_FILES['profilna_nova']))
  {
      $erorr=arraY();
      $file_name=$_FILES['profilna_nova']['name'];
      $file_size=$_FILES['profilna_nova']['size'];
      $file_tmp=$_FILES['profilna_nova']['tmp_name'];
      $file_type=$_FILES['profilna_nova']['type'];

      $tmp = explode('.', $file_name);
      $file_ext = end($tmp);
      //slika.JPG-->slika.jpg
      $extensions=array("jpeg","jpg","png");
      //ako ima gresaka
      if(in_array($file_ext, $extensions)==false) {
          $erorr[]="Molimo Vas izaberite fotografiju u jpg, jpeg ili png formatu!";
      }
      //ako nema gresaka
      if(empty($erorr)==true)
       {
          move_uploaded_file($file_tmp,"uploads/" . $file_name);
          // $path=$_SERVER['HTTP_REFERER'] . "uploads/". $file_name;
          $path="uploads/". $file_name;
          $sql="UPDATE coordinator_table SET profilna = '$path' WHERE korisnicko_ime = '$korisnicko_ime'";
          $query=$conn->query($sql);
          if($query)
          {
              $_SESSION['status_update'] = " Uspešno ste promenili profilnu fotografiju.";
              header('Location: coordinatorPanel.php');
              echo "RADI";
          } else
          {
              header('Location: coordinatorPanel.php');
              echo "NE RADI";
          }
      } else {
          print_r($erorr);
      }
  }
}

// ADDING COMPETITOR CATEGORY BY CoordinatorLoginId
if(isset($_POST['add_competitor_category']))
{
    $id_koordinatora = $_POST['id_koordinatora'];
    $id_takmicara = $_POST['id'];
    $datum_rodjenja = $_POST['datum_rodjenja'];

    $godina_rodjenja = mb_substr($datum_rodjenja, 0, -6);
    $naziv_kategorije = "";


    switch ($godina_rodjenja)
    {
        case 2010:
        case 2011:
        case 2012:
        case 2013:
        case 2014:
        case 2015:
          $naziv_kategorije = "Poletarci";
          break;
        case 2009:
        case 2008:
          $naziv_kategorije = "Pioniri";
          break;
          case 2007:
          case 2006:
            $naziv_kategorije = "Nade";
            break;
          case 2005:
          case 2004:
            $naziv_kategorije = "Kadeti";
            break;
          case 2003:
          case 2002:
            $naziv_kategorije = "Juniori";
            break;
          case 2001:
          case 2000:
          case 1999:
          case 1998:
          case 1997:
            $naziv_kategorije = "Mlađi seniori";
            break;
          case 1996:
          case 1995:
          case 1994:
          case 1993:
          case 1992:
          case 1991:
            $naziv_kategorije = "Seniori";
            break;
          default:
            $naziv_kategorije = "";
    }

    $query=
    "UPDATE competitor_table SET kategorija = '$naziv_kategorije', id_koordinatora = '$id_koordinatora' WHERE id = $id_takmicara";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        // $_SESSION['status_insert'] = " Uspešno ste dodali novog administratora.";
        header('Location: takmicari_k.php');
        echo "RADI";
    } else
    {
        header('Location: takmicari_k.php');
        echo mysqli_error($conn);
    }
}

// DELETE COMPETITOR - BY: COORDINATOR
if(isset($_POST['delete_comp']))
{
    $comp_id = $_POST['delete_comp_id'];
    $coordinator_id = $_POST['delete_comp_coordinator_id'];
    $query = "DELETE FROM `competitor_table` WHERE `id`='$comp_id' AND `id_koordinatora` = '$coordinator_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_delete_admin'] = " Uspešno ste izbrisali takmičara.";
        header("Location: coordinatorPanel.php");
        echo "radi";
    }
    else
    {
        header('Location: coordinatorPanel.php');
        echo "ne radi";
    }
}

// UPDATE COMPETITOR'S DATAS - BY: COORDINATOR
if(isset($_POST['update_comp_now']))
{
  $id = $_POST['id'];
  $ime = $_POST['ime'];
  $prezime = $_POST['prezime'];
  $beleska = $_POST['beleska'];

        $sql="UPDATE competitor_table SET ime = '$ime', prezime = '$prezime', beleska = '$beleska' WHERE id = '$id'";
        $query=$conn->query($sql);
        if($query)
        {
            $_SESSION['status_insert'] = " Uspešno ste ažurirali podatke o takmičaru.";
            header('Location: coordinatorPanel.php');
        } else
        {
            header('Location: coordinatorPanel.php');
        }
}

// DODAJ NOVI TURNIR
if(isset($_POST['dodajTurnir']))
{
          $sql="INSERT INTO turniri (id_koordinatora, naziv, opis, kategorija, disciplina) VALUES ('$_POST[id_koordinatora]', '$_POST[naziv]','$_POST[opis]', '$_POST[kategorija]', '$_POST[disciplina]')";
          $query=$conn->query($sql);
          if($query)
          {
              $_SESSION['status_insert'] = " Uspešno ste kreirali novi turnir.";
              header('Location: turniri.php');
              echo "RADI";
          } else
          {
              header('Location: turniri.php');
              echo "NE RADI";
          }
          echo "radi";
}

// DELETE POST
if(isset($_POST['delete_tournament']))
{
    $id_turnira = $_POST['id_turnira'];
    $admin_id = $_POST['delete_post_admin_id'];
    $query = "DELETE FROM `turniri` WHERE `id_turnira` = $id_turnira";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status_delete_admin'] = " Uspešno ste izbrisali turnir.";
        header("Location: novosti_k.php");
        echo "radi";
    }
    else
    {
        header('Location: novosti_k.php');
        echo "ne radi";
    }
}

// UPDATE PROFILE COMPETITOR
if(isset($_POST['update_my_profile_competitor']))
{
  $korisnicko_ime = $_POST['korisnicko_ime'];
  $mesto_rodjenja = $_POST['mesto_rodjenja'];
  $drzava_rodjenja = $_POST['drzava_rodjenja'];
  $kilaza = $_POST['kilaza'];
  $email = $_POST['email'];

  $queryUpdate =
      "UPDATE competitor_table
      SET mesto_rodjenja = '$mesto_rodjenja',  drzava_rodjenja = '$drzava_rodjenja', kilaza = $kilaza, email = '$email'
      WHERE korisnicko_ime='$korisnicko_ime'";

  $query_run_update = mysqli_query($conn, $queryUpdate);

  if($query_run_update)
  {
      $_SESSION['status_update'] = " Uspešno ste izvršili ažuriranje.";
      header('Location: competitorPanel.php');
  }
  else
  {
      header('Location: competitorPanel.php');
  }
}

// UPDATE PASSWORD COORDINATOR- CHANGING PASSWORD
if(isset($_POST['update_password_t']))
{
  $korisnicko_ime = $_POST['korisnicko_ime'];
  $lozinka = $_POST['lozinka'];

  $queryUpdate =
      "UPDATE competitor_table
      SET lozinka = '$lozinka'
      WHERE korisnicko_ime='$korisnicko_ime'";

  $query_run_update = mysqli_query($conn, $queryUpdate);

  if($query_run_update)
  {
      $_SESSION['status_update'] = " Uspešno ste promenili lozinku.";
      header('Location: competitorPanel.php');
  }
  else
  {
      header('Location: competitorPanel.php');
  }
}

// UPDATE PROFILE PHOTO
if(isset($_POST['snimi_avatar_t']))
{
  // $profilna_id = $_POST['profilna_id'];
  $korisnicko_ime = $_POST['korisnicko_ime'];

  if(isset($_FILES['profilna_nova']))
  {
      $erorr=arraY();
      $file_name=$_FILES['profilna_nova']['name'];
      $file_size=$_FILES['profilna_nova']['size'];
      $file_tmp=$_FILES['profilna_nova']['tmp_name'];
      $file_type=$_FILES['profilna_nova']['type'];

      $tmp = explode('.', $file_name);
      $file_ext = end($tmp);
      //slika.JPG-->slika.jpg
      $extensions=array("jpeg","jpg","png");
      //ako ima gresaka
      if(in_array($file_ext, $extensions)==false) {
          $erorr[]="Molimo Vas izaberite fotografiju u jpg, jpeg ili png formatu!";
      }
      //ako nema gresaka
      if(empty($erorr)==true)
       {
          move_uploaded_file($file_tmp,"uploads/" . $file_name);
          // $path=$_SERVER['HTTP_REFERER'] . "uploads/". $file_name;
          $path="uploads/". $file_name;
          $sql="UPDATE competitor_table SET profilna = '$path' WHERE korisnicko_ime = '$korisnicko_ime'";
          $query=$conn->query($sql);
          if($query)
          {
              $_SESSION['status_update'] = " Uspešno ste promenili profilnu fotografiju.";
              header('Location: competitorPanel.php');
              echo "RADI";
          } else
          {
              header('Location: competitorPanel.php');
              echo "NE RADI";
          }
      } else {
          print_r($erorr);
      }
  }
}

$status=0;
// PRIJAVA ZA TAKMICENJE
if(isset($_POST['prijaviSe']))
{
      $id_koordinatora = $_POST['id_koordinatora'];
      $id_takmicara = $_POST['id_takmicara'];
      $id_turnira = $_POST['id_turnira'];
      $status = $_POST['statusTakmicara'];


      $sql="INSERT INTO turniri_takmicari (id_koordinatora, id_takmicara, id_turnira, status) VALUES ('$id_koordinatora','$id_takmicara','$id_turnira', '$status')";
      $query=$conn->query($sql);

      // $status  = $status + 1;
      //
      // $sql2="UPDATE competitor_table SET statusTakmicara = '$status' WHERE id='$id_takmicara'";
      // $query2=$conn->query($sql2);

      // $status  = $status + 2;
      $sql3="UPDATE turniri SET status = '$status' WHERE id_turnira = '$id_turnira'";
      $query3=$conn->query($sql3);

      if($query3)
      {
          $_SESSION['status_update'] = " Uspešno ste se prijavili na turnir.";
          header('Location: competitorPanel.php');
          echo "RADI";
      } else
      {
          header('Location: competitorPanel.php');
          echo "NE RADI";
      }

}
?>
