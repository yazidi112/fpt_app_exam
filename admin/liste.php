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
                     
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date</label>
                            <select class="form-control" name="date">
                                <?php
                                    if ($result = $mysqli -> query("SELECT distinct(date) FROM calendrier")) {

                                        while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                             if(isset($_GET['date']) && $_GET['date'] == $row['date']){
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Horaire</label>
                            <select class="form-control" name="horaire">
                                <?php
                                    if ($result = $mysqli -> query("SELECT distinct(horaire) FROM calendrier")) {

                                        while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                            if(isset($_GET['horaire']) && $_GET['horaire'] == $row['horaire']){
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Salle</label>
                            <select class="form-control" name="salle">
                                <?php
                                    if ($result = $mysqli -> query("SELECT distinct(salle) FROM reppartition order by salle")) {

                                        while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                            if(isset($_GET['salle']) && $_GET['salle'] == $row['salle']){
                                                echo "<option selected>".$row['salle']."</option>";
                                            }else{
                                                echo "<option>".$row['salle']."</option>";
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
            <?php
                if(isset($_GET['date'])){
                    $sql = "
                    SELECT * 
                    FROM reppartition r, calendrier c
                    where c.ref_filiere = r.ref_filiere and r.ref_module = c.ref_module
                    AND date='".$_GET['date']."' 
                    and horaire='".$_GET['horaire']."' 
                    and salle='".$_GET['salle']."'

                ";
                //echo $sql;
                    if ($result = $mysqli -> query($sql)) {
                    
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                    }
                }
            ?>
            <div style="margin-top:20px" class="row">
                <div class="col-md-4">Salle: <strong><?php echo $row['salle'] ?></strong> </div>
                <div class="col-md-4">Resp du module: <strong><?php echo $row['ref_module'] ?></strong></div>
                <div class="col-md-4">Nombre étudiants: <strong id="count">0</strong></div>
                <div class="col-md-6">Resp de la salle: <strong> </strong></div>
                <div class="col-md-6">Surveillants: <strong>   </strong></div>
            </div>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>CNE</th>  <th>Nom</th>  <th>Prénom</th>  <th>N° examen</th>  <th>Signature</th> 
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                        $m=substr($row['ref_module'],0,1).substr($row['ref_module'],2,2);
                        $sql2 = "
                            SELECT * 
                            FROM etudiant 
                            where ref_filiere = '".$row['ref_filiere']."'
                            AND $m = '".$row['salle']."'
                        ";
                        echo "<code>".$sql2."</code>";
                        if ($result2 = $mysqli -> query($sql2)) {
                            $count = $result2->num_rows;
                            while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
                                echo"<tr>";
                                echo"<td>".$row2['cne']."</td>";
                                echo"<td>".$row2['nom']."</td>";
                                echo"<td>".$row2['prenom']."</td>";
                                echo"<td>".$row2['numexam']."</td>";
                                echo"<td></td>";
                                echo"</tr>";
                            }
                        }
                    
                ?>
                 
                </tbody>
            </table>
            <script>
                window.onload= function(){
                    $('#count').html('<?php echo $count; ?>');
                }
            </script>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    $mysqli -> close();
?>

