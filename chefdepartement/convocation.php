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
                                <label>Filière</label>
                                <select class="form-control" name="filiere">
                                    <?php
                                        if ($result = $mysqli -> query("SELECT distinct(filiere) FROM personnel where disponible='oui'")) {
  
                                            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                                
                                                if($_GET['filiere']==$row['filiere']){
                                                    echo "<option selected >".$row['filiere']."</option>";
                                                }else{
                                                    echo "<option >".$row['filiere']."</option>";
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
                <h3 class="text-center">Convocations du personnel - Examens - Session du Printemps - Normale</h3>
                <?php
                    if(isset($_GET['filiere'])):
                        $result0 = $mysqli -> query("SELECT * FROM  personnel p
                        WHERE  p.filiere = '".$_GET['filiere']."'");

                        while($row0 = $result0->fetch_array(MYSQLI_ASSOC)):

                ?>
                <h3 class="my-5">Surveillant: <small><?php echo $row0['nomfr'] ?> <?php echo $row0['prenomfr'] ?></small></h3>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Date</th> <th>Horaire</th> <th>Filière/Semèstre</th> 
                        <th>Module</th> <th>Salle</th> <th>Responsable de la salle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                            $sql = "SELECT * 
                            FROM calendrier c, reppartition r , module m, filiere f
                            WHERE c.ref_filiere = r.ref_filiere
                            AND c.ref_module = r.ref_module
                            AND m.ref_filiere = c.ref_filiere
                            AND m.ref_module = c.ref_module
                            AND f.ref_filiere = c.ref_filiere
                            AND (r.ref_perso1='".$row0['ref_perso']."'
                            or r.ref_perso2='".$row0['ref_perso']."'
                            or r.ref_perso3='".$row0['ref_perso']."')";
                            
                        if ($result = $mysqli -> query($sql)) {
                        
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
        <?php
            endwhile;
        endif;
        ?>
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>

