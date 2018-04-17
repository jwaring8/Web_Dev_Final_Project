        <?php
    if(isset($_POST['date']) & $_POST !== null){
        include("shared.php");
        $date = $_POST['date'];
        $db = new mysqli($servername, $username, $password, $dbname);
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $query = "SELECT q1.ticker, q1.company, q2.open, q1.close, (((q1.close - q2.open) / q2.open) * 100) AS PercentGrowth
        FROM(SELECT q.ticker, s.company, q.close
			FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
			WHERE (q.date = '" .$date. "')) AS q1
            INNER JOIN
            (SELECT q.ticker, s.company, q.open
			FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
			WHERE (q.date = '". $date ."')) AS q2
            ON q1.ticker = q2.ticker
		ORDER BY PercentGrowth DESC
        LIMIT 5;";

        if(!$result = $db->query($query)){
            die('There was an error running the query [' . $db->error . ']');
        }
        $row_count = $result->num_rows;
        if($row_count < 1){
            echo '<h2>No data for this date!</h2>';
        } else{
            echo '<table id="companies">';
            echo '<caption><h3 style="text-align: center">Top 5 growing companies for ' . $date .'!</h3></caption>';
            echo '<th>ticker</th><th>company</th><th>open</th>
            <th>close</th><th>% Growth</th>';
            while($row = $result->fetch_assoc()){
                echo '<tr>';
                echo '<td>' . $row['ticker'] .
                    '</td><td>' . $row['company'] .
                    '</td><td>' . $row['open'] .
                    '</td><td>' . $row['close'] .
                    '</td><td>' . $row['PercentGrowth'] . '</tr>';
            }
        }
    }
        ?>
