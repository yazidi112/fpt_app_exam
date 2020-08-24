<?php
include("cnx.php");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$mysqli -> set_charset("utf8");



?>
<!doctype html>
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
        
        
    
        <div class="container">
            <?php
                include("menu.php");
            ?>

            <div class="d-print-none bg-dark p-3 text-white">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <select class="form-control" name="date">
                                    <?php
                                        if ($result = $mysqli -> query("SELECT distinct(date) FROM calendrier order by date asc")) {
  
                                            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                                if($_GET['date']==$row['date']){
                                                    echo "<option selected>".$row['date']."</option>";
                                                }else{
                                                    echo "<option>".$row['date']."</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Horaire</label>
                                <select class="form-control" name="horaire">
                                    <?php
                                        if ($result = $mysqli -> query("SELECT distinct(horaire) FROM calendrier")) {
  
                                            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                                
                                                if($_GET['horaire']==$row['horaire']){
                                                    echo "<option selected>".$row['horaire']."</option>";
                                                }else{
                                                    echo "<option>".$row['horaire']."</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="OK" />
                    <input type="button" class="btn btn-secondary" value="Imprimer" onclick="window.print()" />
                </form>
            </div>
           
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
                <div class="row">
                    <div class="col-md-4">Date: <strong><?php if(isset($_GET['date'])) echo $_GET['date'] ?></strong></div>
                    <div class="col-md-4">Horaire: <strong><?php if(isset($_GET['date'])) echo $_GET['horaire'] ?></strong></div>
                    <div class="col-md-4 text-right">Année universitaire: <strong>2019/2020</strong></div>
                </div>
                <div style="margin-top:20px"></div>
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>Filière</th>
                            <th>Modules</th>
                            <th>Effectifs</th>
                            <th>Responsable</th>
                            <th>Salle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $total = 0;
                        if(isset($_GET['date'])){
                            
                            if ($result = $mysqli -> query("
                                        SELECT * 
                                        FROM calendrier c, module m 
                                        where c.ref_module = m.ref_module AND c.ref_filiere = m.ref_filiere  
                                        AND c.date='".$_GET['date']."' AND c.horaire='".$_GET['horaire']."'")) {
                            
                                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                    $total = $total + $row['effectif'];
                                    echo"<tr>";
                                    echo"<td>".$row['ref_filiere']."</td>";
                                    echo"<td><small>".$row['ref_module']."</small> - ".$row['intitule_module']."</td>";
                                    echo"<td>".$row['effectif']."</td>";
                                    echo"<td>";
                                    if ($res2 = $mysqli -> query("
                                        SELECT * 
                                        FROM personnel p,intervenant i 
                                        where p.ref_perso = i.ref_perso AND i.ref_module='".$row['ref_module']."'
                                        AND i.ref_filiere='".$row['ref_filiere']."'")) {
                                            while($row2 = $res2->fetch_array(MYSQLI_ASSOC)){
                                                echo"<small>".$row2['ref_perso']."</small> - ";
                                                echo"".$row2['nomfr']." ";
                                                echo"".$row2['prenomfr'].", ";
                                            
                                        }
                                    }
                                    echo"</td>";
                                    echo"<td>";
                                    if ($res2 = $mysqli -> query("
                                        SELECT * 
                                        FROM reppartition r 
                                        where r.ref_module='".$row['ref_module']."'
                                        AND r.ref_filiere='".$row['ref_filiere']."'")) {
                                            while($row2 = $res2->fetch_array(MYSQLI_ASSOC)){
                                                echo"".$row2['salle'].", ";
                                            
                                        }
                                    }
                                    echo"</td>";
                                    echo"</tr>";
                                }
                            }
                        }
                    ?>   
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>TOTAL</th>
                            <th colspan="4"><?php echo $total ?></th>
                        </tr>
                    </tfoot>
                </table>
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>

