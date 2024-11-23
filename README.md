# Fit4Life Project

## Database Setup Instructions

This project connects to a MySQL database via PHP. To get everything working properly, follow the steps below to configure the database connection.

### Database Connection Configuration

All pages in this project are connected to a MySQL database using PHP. The database connection settings can be found in the PHP code:

```php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = "Scgarnier2"; 
$dbname = "fit4life";
```
The default password in the configuration is Scgarnier2. You need to change this to match your own MySQL server's password.

You need to create a database named fit4life in your MySQL server.

Afterwards, download the RegisterTables.sql file and run all tables aswell as views to get the site to be working.


