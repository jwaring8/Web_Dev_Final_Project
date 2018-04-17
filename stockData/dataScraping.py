'''
This python script will scrape the Yahoo Finance
website for 5 years worth of historical stock
data from 40 random companies in the S&P 500 index. 
Data will be stored in both a CSV file, as well as a JSON file.
'''

import urllib2
from bs4 import BeautifulSoup
from yahoo_finance import Share
import pandas as pd
import random
from datetime import datetime
from dateutil.relativedelta import relativedelta

'''
scrape_symbols: function that will scrape Wikipedia 
website for S&P 500 stock symbols

Returns a python list with the scraped stock symbols 
'''

def scrape_symbols():
    #information we want from the table
    symbols = []
    
    #pass the page to the parser
    url = 'https://en.wikipedia.org/wiki/List_of_S%26P_500_companies'
    response = urllib2.urlopen(url)
    soup = BeautifulSoup(response, "lxml", from_encoding="utf-8")
        
    #Rows of table start with div id = historicalContainer
    table = soup.find_all('table', {'class': 'wikitable sortable'})

    #loop to iterate over table
    for entry in table:
        rows = entry.find_all('tr')
        for row in rows:
            columns = row.find_all('td')
            for column in columns:
                symbol = ''
                if(column.find('a', {'class', 'external text'}) != None):
                    symbol = column.find('a', {'class', 'external text'}).get_text()
                if(symbol != '' and symbol != 'reports'):
                    symbols.append(symbol)
    return symbols
     
#call function to scrape the symbxols
symbols = scrape_symbols()
 
#dates we are dealing with to scrape data
currentDate = datetime.now().date()
fiveYearsAgo = datetime.now() - relativedelta(years=5)
fiveYearsAgo = fiveYearsAgo.date()
startDate = fiveYearsAgo.strftime('%Y-%m-%d')
endDate =  currentDate.strftime('%Y-%m-%d')

#remove symbols that won't have 5 years worth of data
for symbol in symbols:
    try:
        stock = Share(symbol)
        plusMonth = fiveYearsAgo + relativedelta(days=30)
        endDate2 = plusMonth.strftime('%Y-%m-%d')
        stock.get_historical_data(startDate, endDate2)
    except:
        symbols.remove(symbol)

#print len(symbols)


#pick 40 random stocks to scrape for 5 years 
#sample_size = 40
#sample_symbols = random.sample(symbols, sample_size)

#data to scrape
data = {'Symbol' : [],
        'Date' : [],
        'Open' : [],
        'High' : [],
        'Low' : [],
        'Close': [],
        'Volume': []}

#scrape the data
for symbol in symbols:
    try:
        stock = Share(symbol)
        tuples = stock.get_historical(startDate,endDate)
        for row in tuples:
            data['Symbol'].append(symbol)
            data['Date'].append(datetime.strptime(row['Date'], '%Y-%m-%d'))
            data['Open'].append(round(float(row['Open']),2))
            data['High'].append(round(float(row['High']), 2))
            data['Low'].append(round(float(row['Low']),2))
            data['Close'].append(round(float(row['Close']),2))
            data['Volume'].append(int(row['Volume']))
    except:
        pass

#Build dataframe and export to csv and JSON
df = pd.DataFrame(data, columns = ['Symbol', 'Date', 'Open', 'High', 'Low', 'Close', 'Volume'])
df.to_csv('stockData.csv', mode='w', index= False, 
                          encoding='utf-8')
df.to_json('stockData.json')
