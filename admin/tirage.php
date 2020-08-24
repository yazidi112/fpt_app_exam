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
                <div class="form-group">
                    <label>Filière</label>
                    <select class="form-control" name="filiere">
                        <?php
                            if ($result = $mysqli -> query("SELECT * FROM filiere")) {
  
                                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                    echo"<option>".$row['ref_filiere']."</option>";
                                }
                              }
                                                        
                        ?>
                       
                    </select>
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
            <div style="margin-top:20px"></div>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Filière</th>
                        <th>Modules</th>
                        <th>Salle / Taux Etudiants</th>                        
                        <th>Date d'examen</th>
						<th>Prison</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(isset($_GET['filiere'])){
                        if ($result = $mysqli -> query("
                                    SELECT * 
                                    FROM calendrier c, module m 
                                    where c.ref_module = m.ref_module  
                                    AND c.ref_filiere='".$_GET['filiere']."'")) {
                        
                            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                echo"<tr>";
                                echo"<td>".$row['ref_filiere']."</td>";
                                echo"<td>".$row['intitule_module']."</td>";
                                echo"<td style='padding:0'>";
                                echo"<table class='w-100'>";
                                if ($res2 = $mysqli -> query("
                                    SELECT * 
                                    FROM repartition r 
                                    where r.ref_module='".$row['ref_module']."'")) {
                                        while($row2 = $res2->fetch_array(MYSQLI_ASSOC)){
                                        
                                            echo"<tr>
                                                <td class='w-50'>".$row2['salle']."</td>
                                                <td>".($row2['capacite']+3)."</td>
                                            </tr>";
                                        
                                    }
                                }
                                echo"</table>";
                                echo"</td>";
                                echo"<td>".$row['date']."</td>";
                                echo"<td>--</td>";
                                echo"</tr>";
                            }
                        }
                    }
                ?>
                 
                </tbody>
            </table>
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

