<?php
include("cnx.php");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$mysqli -> set_charset("utf8");

$result = $mysqli -> query("SELECT * 
                            FROM etudiant
                            WHERE numins='".$_POST['numins']."' AND cne='".$_POST['cne']."'");
 

$infos = $result->fetch_array(MYSQLI_ASSOC);

if($infos==""){
  header("location: index.php?msg=Etudiant introuvable !");
}
  
function calendrier($ref_filiere,$ref_module,$classe){
  global $mysqli;
  $result3 = $mysqli -> query("SELECT * 
                            FROM module
                            WHERE ref_filiere='".$ref_filiere."' 
                            AND ref_module='".$ref_module."'");

    $row3 = $result3->fetch_array(MYSQLI_ASSOC);
    echo"<td>";
    echo "<strong>".$row3['intitule_module']."</strong><br/>";
    if(is_numeric($classe) or $classe=="NI"){
    echo "Note: ".$classe."<br/>";
    }else if(!is_numeric($classe)){
      $result2 = $mysqli -> query("SELECT * 
                              FROM calendrier
                              WHERE ref_filiere='".$ref_filiere."' 
                              AND ref_module='".$ref_module."'");

      $row2 = $result2->fetch_array(MYSQLI_ASSOC);
      echo "Salle: ".$classe."<br/>";
      echo "<i>".$row2['date'];
      echo "<br/>";
      echo $row2['horaire']."</i>";
    }
    echo"</td>";
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
       
      <table style="margin-top:30px" class="w-100">
            <tr>
                <td>
                    <strong>
                        UNIVERSITE SIDI MOHAMED BEN ABDELLAH<br/>
                        Faculté polydisciplinaire de Taza
                    </strong>
                </td>
                <td style="width:200px"></td>
                <td style="text-align:right">
                    <strong>
                        جامعة سیدي محمد بن عبد الله<br/>
                        الكلیة متعددة التخصصات- تازة
                    </strong>
                </td>
            </tr>
            </table>
        <div  class="text-center">
          <h3 class="my-5 border p-3">Calendrier des examens - Session du Printemps Normal</h3>
        </div>
        <div class="row">
          <div class="col-md-3">
            Nom et prénom: <br/><strong> <?php echo $infos['nom'] ?> <?php echo $infos['prenom'] ?> </strong>
          </div>
          <div class="col-md-3">
            CNE: <br/><strong>  <?php echo $infos['cne'] ?> </strong>
          </div>
          <div class="col-md-3 text-right">
            N° Inscription: <br/><strong>  <?php echo $infos['numins'] ?> </strong>
          </div>
          <div class="col-md-3 text-right">
            Année universitaire: <br/><strong>2019/2020</strong>
          </div>
        </div>
        <table class="table table-bordered table-striped my-3">
            <thead>
              <tr>
               <th>N° examen</th>
               <th>Filière /Semestre</th> 
               <th>Module 1</th> 
               <th>Module 2</th>
               <th>Module 3</th>
               <th>Module 4</th>
               <th>Module 5</th>
               <th>Module 6</th>
               <th>Module 7</th>
              </tr>
            </thead>
            <tbody>
            <?php
                if ($result = $mysqli -> query("SELECT * 
                                                FROM etudiant e,filiere f
                                                WHERE e.ref_filiere = f.ref_filiere 
                                                AND numins='".$_POST['numins']."' 
                                                AND cne='".$_POST['cne']."'
                                                ORDER BY e.semestre")) {
                
                    while($row = $result->fetch_array(MYSQLI_ASSOC)){
                        
                        echo"<tr>";
                        echo"<td>".$row['numexam']."</td>";                      
                        echo"<td>".$row['intitule_filiere']."</td>"; 
                        $s = $row['semestre'];
                        calendrier($row['ref_filiere'],"M".$s."1",$row["M1"]);
                        calendrier($row['ref_filiere'],"M".$s."2",$row["M2"]);
                        calendrier($row['ref_filiere'],"M".$s."3",$row["M3"]);
                        calendrier($row['ref_filiere'],"M".$s."4",$row["M4"]);
                        calendrier($row['ref_filiere'],"M".$s."5",$row["M5"]);
                        calendrier($row['ref_filiere'],"M".$s."6",$row["M6"]);
                        if($s==2)
                          calendrier($row['ref_filiere'],"M".$s."7",$row["M7"]);
                        else
                          echo"<td></td>";
                        
                        echo"</tr>";
                    
                }
              }
                  
              ?>
            </tbody>
        </table>

         <p class="text-right p-3" style="direction:rtl">
                على الطلبة ,,,
         </p>
         
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>