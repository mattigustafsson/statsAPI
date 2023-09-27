To run the container enter "docker-compose up --build"
Then using postman/Insomnia access the two endpoints "/averageOrderValue" and /topThreeProducts.
There is no authentication on the request.

ex. GET -> http://localhost/averageOrderValue

To run the not functioning test, access the docker container either by docker desktop or the terminal and enter.
1. cd /var/www/html
2. phpunit myTest.php

accessing the container by terminal use this command:
"sudo docker exec -i -t stats-api-1 sh"

// Mattias