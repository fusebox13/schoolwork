<?php
    $myLabels = array();
    $myValues = array();
    if(isset($_POST['label'])) {
        $n = count($_POST['label']) + 1;
        
        for($i=0; $i < $n; $i++) {
            if(isset($_POST['label'][$i])
                    && $_POST['label'][$i] != '' 
                    && isset($_POST['value'][$i])
                    && $_POST['value'][$i] != ''
                    
              ) {
                $myLabels = $_POST['label'][$i];
                $myValues[] = $_POST['value'][$i];
                
            }
        }
    } else {
        $n = 1;
    }
?>

<form method="post">
    <table border='1'>
        <tr>
            <th>Label</th>
            <th>Number</th>
        </tr>
        <?php
            
      
            for($i=0; $i < $n; $i++) {
                echo '<tr>';
                //name
                echo "<td>";
                $v =(isset($_POST['value'][$i]))?$_POST['value'][$i]:'';
                echo "<input type = 'text' size ='16' value='$v' name='label[]'/>";
                echo "</td>";
                //number
                echo "<td>";
                $v =(isset($_POST['value'][$i]))?$_POST['value'][$i]:'';
                echo "<input type = 'text' size ='4' value ='$v' name ='value[]'/>";
                echo"</td>";
                echo "</tr>";
            
            }
        ?>
        
    </table>
    <input type ='submit' value='Submit'/>
</form>

<?php 
    //$pie_array = array();
    //$n = count($myLabels);
    //for($i= 0; $i < $n; $i++) {
        //$k = $myLabels[$i];
        //$v = $myValues[$i];
        //$pie_array[$k] = $v;
$pie_array = array_combine($myLabels, $myValues);
$json = json_encode($pie_array);
?>

<img src='pie_image.php?input=<?=$json?>'/>
