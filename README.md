# Search

**Search** is a simple search engine created with the help of PHP and Ajax. It's a very simple yet good looking one-paged theme created in bootstrap 4, PHP acts as a back-end while AJAX/Jquery processes its request to PHP in order to get the specified search results and it immediately displays them on the page because of AJAX/JQuery; nobody cares about page refresh nowadays anyway it's 2019! Security wise it should be secure since XSS nor MySQL injection works nor is there any other way unless you replace the MySQLi queries with deprecated MySQL ;)

It also has a simple web crawler which grabs title and description of a specific website in any protocol(http or https) and adds them into the database and after that you can immediately search a website using a specific keyword. The search engine is not that advanced yet but it is kind of enough to display simple results or search for simple results with your specific keyword. Pagination will be introduced soon and the project will be improved overtime as the way it searches through its database needs to be improved - which means I will need to use a search algorithm instead of depending on MySQL to find results. 

# How do I use it?

Just upload the .sql file in your database and configure config.php to match your database details. Upload the files and visit it from the web, to feed it some data just crawl websites and test it out. This project could be improved a lot if it gets enough contribution as the web crawler needs improvement too(To find internal links and crawl all the pages of a specific website).

# Improvements needed

1. Try to find a new way of searching a specific keyword instead of depending on MySQL.

2. Index all pages of a specific website and find internal links(Using this we can loop through these urls and crawl them).

3. Maybe make an automatic crawler which crawls through Google using a specified keyword and adds website into the database?

4. Add pagination if the results are more than 10: Although it shouldn't really lag the user as we are using Ajax/Jquery to display the result, it will just take some time to display the results depending if PHP returns it but pagination should improve the speed since we can display 10 results per page.
