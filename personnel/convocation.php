<?php
include("cnx.php");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$mysqli -> set_charset("utf8");

$result = $mysqli -> query("SELECT * 
                            FROM personnel 
                            WHERE cin='".$_POST['cin']."' AND num_somme='".$_POST['numsom']."'");
  
$infos = $result->fetch_array(MYSQLI_ASSOC);

if(!$infos){
  header('location: index.php?msg="Personnel introuvable !"');
}
  
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Gestion Examen</title>
  </head>
  <body>
    <h1></h1>
    <div class="container">
	
      <?php
        include("menu.php");
      ?>
       
      <table style="margin-top:30px">
            <tr>
                <td>
                    <strong>
                        UNIVERSITE SIDI MOHAMED BEN ABDELLAH
                        Faculté polydisciplinaire de Taza
                    </strong>
                </td>
                <td style="width:400px"></td>
                <td style="text-align:right">
                    <strong>
                        جامعة سیدي محمد بن عبد الله
                        الكلیة متعددة التخصصات- تازة
                    </strong>
                </td>
            </tr>
            </table>
        <div  class="text-center">
          <h1>Convocation</h1>
          <h3>Le Doyen</h3>
          <p>À M (Mlle/Mme) : <strong><?php echo $infos['nomfr'] ?> <?php echo $infos['prenomfr'] ?></strong></p>
        </div>
        <div>
          <h3>Objet: Surveillance</h3>
          <p>
          Cher(e) collègue, <br/>
          Je vous prie de bien vouloir participer à la surveillance des examens de la Session du printemps -
          rattrapage du 2 , 4 et 6 Semestre de l'année universitaire 2019/2020, conformément au
          planning indiqué ci-dessous :
          </p>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Date</th> <th>Horaire</th> <th>Filière/Semèstre</th> 
                <th>Module</th> <th>Salle</th> <th>Responsable de la salle</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if ($result = $mysqli -> query("SELECT * 
                                                  FROM calendrier c, reppartition r , module m, filiere f
                                                  WHERE c.ref_filiere = r.ref_filiere
                                                  AND c.ref_module = r.ref_module
                                                  AND m.ref_filiere = c.ref_filiere
                                                  AND m.ref_module = c.ref_module
                                                  AND f.ref_filiere = c.ref_filiere
                                                  AND (r.ref_perso1='".$infos['ref_perso']."'
                                                    or r.ref_perso2='".$infos['ref_perso']."'
                                                    or r.ref_perso3='".$infos['ref_perso']."'
                                                  )
                                                   ")) {
                  
                      while($row = $result->fetch_array(MYSQLI_ASSOC)){
                          
                          echo"<tr>";
                          echo"<td>".$row['date']."</td>";                      
                          echo"<td>".$row['horaire']."</td>"; 
                          echo"<td>".$row['intitule_filiere']."</td>"; 
                          echo"<td>".$row['ref_module']." - ".$row['intitule_module']."</td>"; 
                          echo"<td>".$row['salle']."</td>"; 
                          echo"<td>";
                          if ($res2 = $mysqli -> query("
                                        SELECT * 
                                        FROM personnel  
                                        where ref_perso = '".$row['ref_perso1']."'")) {
                                        $row2 = $res2->fetch_array(MYSQLI_ASSOC);
                                        echo"".$row2['nomfr']." ";
                                        echo"".$row2['prenomfr']."";
                                            
                                    }
                          echo"</td>"; 
                          echo"</tr>";
                      
                  }
                }
                    
              ?>
            </tbody>
        </table>
        <div>
          <p>Prière de bien vouloir se présenter 30 minutes avant le début de l'examen.</p>
          <p class="text-center" style="margin-bottom:300px"><strong>Le Doyen</strong></p>
        </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>