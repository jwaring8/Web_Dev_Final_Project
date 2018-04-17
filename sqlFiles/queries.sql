-- List of queries to implement for Term Project
-- QUERIES dealing with specific company:
     -- Query: Price of ticker for a specific date

	SELECT * FROM sp500_quotes
	WHERE date='2015-2-04' AND ticker='AMD';

     -- Query: Price of specific ticker for a date range
     	
	SELECT * FROM sp500_quotes
	WHERE ticker='AMD' AND
	date BETWEEN '2012-4-10' AND '2013-4-10';
     -- Query: The change in price for ticker for date range

	SELECT q.ticker, q.date, q.close - q.open AS delta
	FROM sp500_quotes AS q
	WHERE q.ticker='AMD' AND
	      (q.date BETWEEN '2014-1-30' AND '2014-3-30');

     -- Query: Show the average high for specific ticker per year

     	SELECT ticker, ROUND(AVG(high),2) AS 'average high', YEAR(date) AS 'year'
        FROM sp500_quotes
        WHERE ticker='AMD'
	GROUP BY YEAR(date);

     -- Query: Show the average low for specific ticker per year

	SELECT ticker, ROUND(AVG(low),2) AS 'average low', YEAR(date) AS 'year' 
	FROM sp500_quotes
	WHERE ticker='AMD'
	GROUP BY YEAR(date);

     -- Query: Show the average volume for specific ticker per year

	SELECT ticker, ROUND(AVG(volume),2) AS 'average volume', YEAR(date) AS 'year' 
	FROM sp500_quotes
	WHERE ticker='AMD'
	GROUP BY YEAR(date);


     -- Query: Show the average close price for specific ticker and year (All years)
     	
	SELECT ticker, ROUND(AVG(close),2) AS 'average closing price', YEAR(date) AS 'year' 
	FROM sp500_quotes
	WHERE ticker='AMD'
	GROUP BY YEAR(date);

     -- Query: Show the highest close price for specific ticker and year (All years)

	SELECT q.ticker, MAX(q.close) AS 'highest closing price', YEAR(q.date) 'year'
	FROM sp500_quotes AS q
	GROUP BY q.ticker, YEAR(date);

     -- Query: Average volume for ticker within daterange
     
	SELECT ticker, AVG(volume) AS avg_Volume
	FROM sp500_quotes
	WHERE ticker='AMD' AND date BETWEEN '2014-1-30' AND '2014-3-30'
	GROUP BY ticker;

     -- Query: Average price ticker for daterange (close)

	SELECT q.ticker, AVG(q.close) AS average
	FROM sp500_quotes AS q
	WHERE q.ticker='AMD' AND (date BETWEEN '2013-1-1' AND '2014-1-21')
	GROUP BY q.ticker;

     -- Query: Average price ticker for daterange (open)

	SELECT q.ticker, AVG(q.open) AS average
	FROM sp500_quotes AS q
	WHERE q.ticker='AMD' AND (date BETWEEN '2013-1-1' AND '2014-1-21')
	GROUP BY q.ticker;
-----------------------------------------------------------------------------------------------------------

-- QUERIES dealing with sector/industry analysis:
     -- Query: Show companies from same industry as selected ticker

	SELECT * FROM sp500_stocks 
	WHERE industry IN (
	      SELECT industry FROM sp500_stocks
	      WHERE ticker='AMD'
	      GROUP BY industry
	      );     	

     -- Query: Show all companies from same sector as selected ticker
	SELECT * FROM sp500_stocks
	WHERE sector IN (
	      SELECT sector FROM sp500_stocks
	      WHERE ticker='AMD'
	      GROUP BY sector
	      );


     -- Query: Change between price per year (close) for specific ticker
		
	SELECT q1.ticker, YEAR(q1.date) AS 'year', q2.close - q1.close AS 'delta'
	FROM((SELECT q.ticker, MIN(q.date) AS 'date', q.close
		  FROM sp500_quotes AS q
		  WHERE q.ticker = 'MMM'
		  GROUP BY YEAR(q.date)) AS q1, 
		  (SELECT q.ticker, MAX(q.date) AS 'date', q.close
		   FROM sp500_quotes AS q
		   WHERE q.ticker = 'MMM'
		   GROUP BY YEAR(q.date)) AS q2)
		WHERE YEAR(q1.date) = YEAR(q2.date);

     -- Query: Top 5 best performing companies per sector for year 2017
    
    SELECT ticker, company, `AVG(q.close)` AS 'Average Closing Price for 2017', sector
    FROM(SELECT *,
		@sector_rank := IF(@current_sector = sector, @sector_rank + 1, 1) AS sector_rank,
		@current_sector := sector 
    FROM (SELECT q.ticker, AVG(q.close), s.sector, s.company
		  FROM sp500_quotes as q JOIN sp500_stocks as s ON q.ticker=s.ticker
		  WHERE YEAR(date) = 2017
		  GROUP BY q.ticker) AS sub
	ORDER BY sector, `AVG(q.close)`+0 DESC) AS ranked
    WHERE sector_rank <= 5;
    
    (SELECT q.ticker, AVG(q.close), s.sector, s.company 
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
    ORDER BY AVG(q.close) DESC LIMIT 5);
    
    -- Query: Show the average volume for each sector on specific date
	
	SELECT q.date 'Date', s.sector 'Sector', ROUND(AVG(q.volume), 2) 'Average Sector Volume'
	FROM sp500_quotes AS q, sp500_stocks AS s
	WHERE q.ticker=s.ticker AND q.date='2016-3-30'
	GROUP BY s.sector;

-----------------------------------------------------------------------------------------------------------

-- QUERIES DEALING WITH COMPARISON BETWEEN COMPANIES:
     -- Query: Stocks with greatest change in price (close) for date range
		SELECT q1.ticker, q1.company, q2.open, q1.close, (((q1.close - q2.open) / q2.open) * 100) AS PercentGrowth
        FROM(SELECT q.ticker, s.company, q.close
			FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
			WHERE (q.date = '2017-3-15')) AS q1
            INNER JOIN 
            (SELECT q.ticker, s.company, q.open
			FROM sp500_quotes AS q JOIN sp500_stocks AS s ON q.ticker=s.ticker
			WHERE (q.date = '2017-3-15')) AS q2 
            ON q1.ticker = q2.ticker
		ORDER BY PercentGrowth DESC 
        LIMIT 5;

     -- Query: Show top 5 companies based on price (close) for date

	SELECT s.ticker, s.company, q.close, q.date
	FROM sp500_stocks AS s, sp500_quotes AS q
	WHERE q.date='2015-4-17' AND s.ticker=q.ticker
	ORDER BY q.close DESC
	LIMIT 10;
-----------------------------------------------------------------------------------------------------------

-- QUERIES DEALING WITH SEARCHING BY PRICE:
     -- Query: Ticker within a price range (close) for a specific date range
     
	*************************************************
	SELECT s.ticker, s.close
	FROM sp500_quotes AS s
	WHERE (s.close BETWEEN 100 AND 300)
	AND (s.date BETWEEN '2014-1-30' AND '2014-3-30');
	*************************************************

     -- Query: Tickers within price range (close) for a date range

	SELECT s.ticker, s.date, s.close
	FROM sp500_quotes AS s
	WHERE (s.close BETWEEN 40 AND 75) AND
	      (s.date BETWEEN '2014-1-30' AND '2014-3-30');
          
	-- Modified Query: Select distinct ticker within price range for a date range
    SELECT s.ticker, AVG(s.close) AS 'Average Price Across Date Range'
    FROM sp500_quotes AS s
    WHERE (s.close BETWEEN 100 AND 200) AND
	      (s.date BETWEEN '2014-1-30' AND '2014-3-30')
	GROUP BY s.ticker;

     -- Query: Show 10 companies within certain price range (close) for specific company
		
	SELECT q.ticker, q.close
	FROM sp500_quotes AS q
	WHERE q.date = '2014-4-1' AND 
	q.close BETWEEN (SELECT q.close - (q.close * 0.05)
					 FROM sp500_quotes AS q
					  WHERE q.ticker = 'MMM' AND q.date = '2014-4-1')
			AND
					(SELECT q.close + (q.close * 0.05)
					 FROM sp500_quotes AS q
					 WHERE q.ticker = 'MMM' AND q.date = '2014-4-1');

	-- Query: Show tickers within price range for year (per year)
		SELECT s.ticker, YEAR(s.date), s.close
		FROM sp500_quotes AS s
		WHERE (s.close BETWEEN 40 AND 75)
		GROUP BY YEAR(s.date);
    -----------------------------------------------------------------------------------------------------------
