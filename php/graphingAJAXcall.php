       <?php
        if(isset($_REQUEST['ticker']) && $_REQUEST['ticker'] !== 'null'){
            $name = $_REQUEST['ticker'];
            echo '<h2 style="text-align: center; text-decoration: underline">' .$name.'</h2>';
            ?>
            <?php
            
            include("shared.php");
        $db = new mysqli($servername, $username, $password, $dbname);
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }    
            $query = "SELECT ticker, ROUND(AVG(close),2) AS 'average closing price',
            ROUND(AVG(high),2) AS 'average high price', ROUND(AVG(low),2) AS
            'average low price', YEAR(date) AS 'year' 
	FROM sp500_quotes
	WHERE ticker='".$name ."'
	GROUP BY YEAR(date);";


            if(!$result = $db->query($query)){
                die('There was an error running the query [' . $db->error . ']');
            }
            //$result2 = $result;
            if(!$result2 = $db->query($query)){
                die('There was an error running the query [' . $db->error . ']');
            }
            if(!$result3 = $db->query($query)){
                die('There was an error running the query [' . $db->error . ']');
            }
            if(!$result4 = $db->query($query)){
                die('There was an error running the query [' . $db->error . ']');
            }
        }
        else{
            
            echo 'No company selected!';
        }?>
<?php
echo <<<EOT
        
        <script type='text/javascript'>
            
            var chart = c3.generate({
                data: {
                    x:'year',
                    columns: [

EOT;
?>
        <?php 
        echo "['year'";
        while($row = $result->fetch_assoc()){
            echo ", " ."'" .$row['year']. "'";
        }
        echo "],";
        echo "['avg closing price for each year'";
        while($row = $result2->fetch_assoc()){
            echo ", " ."'" .$row['average closing price']. "'";
        }
        echo "],";
        echo "['avg low price for each year'";
        while($row = $result3->fetch_assoc()){
            echo ", " ."'" .$row['average low price']. "'";
        }
        echo "],";
        echo "['avg high price for each year'";
        while($row = $result4->fetch_assoc()){
            echo ", " ."'" .$row['average high price']. "'";
        }
        echo "]";
        ?> 
<?php
echo <<<EOT
                ],
                }

            });
        </script>
EOT;
?>