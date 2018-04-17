<!DOCTYPE HTML>
<html>
    <head>
        <title>Stock Overflow</title>
        <script type="text/javascript" src="../d3/d3.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="../buttons.css">
        <link rel="stylesheet" href="../tableModel.css">


            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          <link rel="stylesheet" href="../generalStyle.css">
    </head>
    <body>



        <div class="jumbotron">
          <div class="container text-center" id="logo">

              <a href="../homepage.html"><img src="../images/logo.png" height="250px"></a>

          </div>
        </div>
        <div id="buttonArea">
        <div class="container-fluid bg-3 text-center">
              <h3>Top 5 Performing Companies (Per Sector):</h3><br>
              <div class="row" id="paragraphArea">

                  <div id="tableData">


                    <?php
                    //establish a connection to the database
                    include 'shared.php';
                    try {$conn = new PDO("mysql:host=" . $servername . ";dbname=" . $dbname, $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                         //query being passed to the database
                        /* $sql = "SELECT ticker, company, `AVG(q.close)` AS 'Average Closing Price for 2017', sector
                                FROM(SELECT *,
                                    @sector_rank := IF(@current_sector = sector, @sector_rank + 1, 1) AS sector_rank,
                                    @current_sector := sector
                                FROM (SELECT q.ticker, AVG(q.close), s.sector, s.company
                                      FROM sp500_quotes as q JOIN sp500_stocks as s ON q.ticker=s.ticker
                                      WHERE YEAR(date) = 2017
                                      GROUP BY q.ticker) AS sub
                                ORDER BY sector, `AVG(q.close)` + 0 DESC) AS ranked
                                WHERE sector_rank <= 5;";*/

                        $sql = "(SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Consumer Discretionary'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Consumer Staples'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Energy'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                        UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Financials'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Health Care'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Industrials'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Information Technology'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Materials'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Real Estate'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Telecommunication Services'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)
                            UNION
                            (SELECT q.ticker, AVG(q.close), s.sector, s.company
                            FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
                            WHERE YEAR(date) = 2017 AND s.sector = 'Utilities'
                            GROUP BY q.ticker
                            ORDER BY AVG(q.close) DESC LIMIT 5)";


                        //prepping the query and passing it to the database
                         $stmt = $conn->prepare($sql);
                         $stmt->execute();
                         $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                         $numRows = $stmt->rowCount();
                         $numCols = $stmt->columnCount(); //get number of columns

                         //$fields = array_keys($stmt->fetch(PDO::FETCH_ASSOC)); // fill array with column names



                                //printing the results to the datbase
                         if($numRows > 0){ // run if there are rows to be fetched. Otherwise, show no results
                            echo '<table>';
                            echo '<th>ticker</th><th>avg closing price</th><th>company</th><th>sector</th>';
                            while($row = $stmt->fetch()){ // iterate through and put tuples into table
                                echo '<tr>'; // beginning of row.
                            // output data of each row
                                // putting table data in each row.
                                    echo '<td>' . $row['ticker'] . '</td>' .
                                    '<td>' . $row['AVG(q.close)'] . '</td>' .
                                    '<td>' . $row['company'] . '</td>' .
                                    '<td>' . $row['sector'] . '</td>';
                                 // for
                                echo '</tr>'; // end of row
                            } // while
                                echo '</table>'; //
                            }
                            else{
                                echo 'No results';
                            }
                        }

                        // error handling
                        catch (PDOException $e) {
                                die('Database connection failed: ' . $e->getMessage());
                            }

                    $conn = null;
                    ?>


                  </div>







              </div>
            </div><br>
            




        </div><br>
            <div class="container-fluid bg-3 text-center">
              <div class="row">
                <div class="col-sm-6">

                    <form action="top5date.php">
                    <button class="bttn-fill bttn-lg bttn-warning">Top 5, Top 5, Top 5</button>
                    </form>
                </div>
                <div class="col-sm-6">

                    <form action="graph.php">
                        <button class="bttn-fill bttn-lg bttn-primary">Tickerish</button>
                    </form>
                </div>


              </div>

                <br>

                <div class="row">

                <div class="col-sm-6">
                    <form action="pricerange.php">
                        <button class="bttn-fill bttn-lg bttn-success">Date-ta-Pricefy</button>
                    </form>
                </div>
                <div class="col-sm-6">
                    <form action="bargraph.php">
                    <button class="bttn-fill bttn-lg bttn-royal">(Top 10 Closing Prices) Bargraphify</button>
                    </form>
                </div>

              </div>
            </div><br><br>

            <footer class="container-fluid text-center">
              <p>StockOverFlow 2017</p>
            </footer>
        </div>




    </body>
</html>
