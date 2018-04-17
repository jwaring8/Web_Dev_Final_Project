        <?php 
    if(isset($_POST['date']) & $_POST !== null){
        include("shared.php");
        $date = $_POST['date'];
        $db = new mysqli($servername, $username, $password, $dbname);
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }              
        $query = "SELECT s.ticker, s.company, q.close, q.date
	       FROM sp500_stocks AS s, sp500_quotes AS q
	       WHERE q.date='". $date . "' AND s.ticker=q.ticker
	       ORDER BY q.close DESC
	       LIMIT 10;";
        
        if(!$result = $db->query($query)){
            die('There was an error running the query [' . $db->error . ']');
        }
        if(!$result2 = $db->query($query)){
            die('There was an error running the query [' . $db->error . ']');
        }
        
    } else{
            
            echo 'No company selected!';
        }
        ?>
<?php
echo <<<EOT
        
        <script type='text/javascript'>
            
            var chart = c3.generate({
                data: {
                    x:'ticker',
                    columns: [

EOT;
?>
        <?php 
        echo "['ticker'";
        while($row = $result->fetch_assoc()){
            echo ", " ."'" .$row['ticker']. "'";
        }
        echo "],";
        echo "['avg closing price for each ticker'";
        while($row = $result2->fetch_assoc()){
            echo ", " ."'" .$row['close']. "'";
        }
        echo "]";
        ?> 
<?php
echo <<<EOT
                ],
                    type: 'bar'
                },
                axis: {
                    x: {
                      type: 'category'
                    }
                }

            });
        </script>
EOT;
?>