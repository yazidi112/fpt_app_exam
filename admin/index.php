<?php
include("cnx.php");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$mysqli -> set_charset("utf8");


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
    <style>
      @media print{

        @page{

            margin : 0px;
            size: landscape;

        }

        .page{

            border: none;
            height: 100%;
            page-break-after: always;
            margin: 10px auto;
            overflow-x: auto;
            padding: 15px 10px 25px;
            position: relative;    
            width: 98%;
        }

      }


    </style>
  </head>
  <body>
    <h1></h1>
    <div class="container">
      <?php
        include("menu.php");
      ?>
                
                <?php

                  $result0 = $mysqli -> query("SELECT * from filiere");

                  while($row0 = $result0->fetch_array(MYSQLI_ASSOC)):
                     
                ?>
                <div class="page">
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
                  <hr/>
                  <h3 class="text-center">Calendrier des examens - Session du printemps - normale</h3>
                  <h2><?php echo $row0['intitule_filiere']."</h2>" ; ?>
                  <div style="margin-top:20px"></div>
                  <table class="table table-bordered ">
                      <thead>
                          <tr>
                              <th>Module</th>
                              <th>Date d'examen</th>
                              <th>Horaire</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                          
                              if ($result = $mysqli -> query("
                                          SELECT * 
                                          FROM calendrier c, module m 
                                          where c.ref_module = m.ref_module 
                                          AND c.ref_filiere = m.ref_filiere
                                          AND c.ref_filiere='".$row0['ref_filiere']."'
                                          order by date")) {
                              
                                  while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                      echo"<tr>";
                                      echo"<td>".$row['ref_module']." - ".$row['intitule_module']."</td>";
                                      echo"<td>".$row['date']."</td>";
                                      echo"<td>".$row['horaire']."</td>";
                                      echo"</tr>";
                                  }
                              }
                          
                      ?>   
                          
                      </tbody>
                      
                  </table>
              </div>
              
            <?php
              endwhile;
            ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>