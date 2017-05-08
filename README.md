# testTasks

Before you use the application, you need to make a small settings.
Firstly, after downloading the application, you need to configure the database. After you configure the connection to the database, you must start the migration. Now you need to fill the Vocabulary table with the some data.Then configure the apache or simply run the command  php artisan serve from the application folder to start it. 

After that it is necessary to adjust the crontab by adding this line:

"* * * * * php /your-path-to/LaravelTest/artisan schedule:run >> /dev/null 2>&1"

Now in the folder public/html/ every 11 minutes a new xml document will be created.
This document will contain information about user, their saved hashes, origin words and similar words from database.
User information include ip, browser, cookie and country of the user.

Now you can go to the homepage of the application and select words and hashing algorithms, аfter selecting which hashes you need, click the save button and that's it.
You again at home page. 
If you wanna get all yours saved hases in json format, just press All hashes. You will get all origin words and hashes which were saved by you, this is determined by ip adress. 
Also you can get the same by sending http request to "SiteName/getSavedHashes/{ip}", where {ip} is ip of requested user.
Or if you wanna get hashes, that you created the last time, press Last hashes.
That`s all.


