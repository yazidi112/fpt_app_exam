<?php
$mysqli = new mysqli("localhost","root","","examenspn1920");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$mysqli -> set_charset("utf8");

if ($result = $mysqli -> query("SELECT * FROM repartition")) {
  
  while($row = $result->fetch_array(MYSQLI_ASSOC)){
      $rep[$row["ref_module"]] = $row;
  }
  
}

//print_r($rep);

print($rep['M21']['salle']);

if ($result = $mysqli -> query("SELECT * FROM etudiant")) {
  
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $etd[] = $row;
    }
    
  }
  

$mysqli -> close();
 


?>

<table border="1">
    <?php foreach($etd as $v): ?>
    <tr>
        <td><?php echo $v['ref_filiere'] ?></td>
        <td><?php echo $v['nom'] ?></td>
        <td><?php echo $v['numexam'] ?></td>
        <td>
            <table border="1">
                <tr>
                    <td>M21</td>
                    <td>M22</td>
                    <td>M23</td>
                    <td>M24</td>
                    <td>M25</td>
                    <td>M26</td>
                    <td>M27</td>
                </tr>
                <tr>
                    <td><?php echo $v['M21']=="" ? $rep['M21']['salle']:$v['M21'] ?></td>
                    <td><?php echo $v['M22']=="" ? "a4":$v['M21'] ?></td>
                    <td><?php echo $v['M23']=="" ? "a4":$v['M21'] ?></td>
                    <td><?php echo $v['M24']=="" ? "a4":$v['M21'] ?></td>
                    <td><?php echo $v['M25']=="" ? "a4":$v['M21'] ?></td>
                    <td><?php echo $v['M26']=="" ? "a4":$v['M21'] ?></td>
                    <td><?php echo $v['M27']=="" ? "a4":$v['M21'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <?php endforeach; ?>
</table>