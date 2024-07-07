# User-Authentication
Steps to Run the Project :

1. Clone the Project or Download Zip
   Clone the project or download the zip file from GitHub:
   git clone https://github.com/indhumathypj/User-Authentication.git
   Alternatively, download the zip file from GitHub.

2. Place the Project in XAMPP
   Place the project folder in the path C:\xampp\htdocs\.

3. Import Database
   Import the db.sql file into your MySQL database. This can be done using phpMyAdmin or via the command line:
   mysql -u username -p database_name < C:\xampp\htdocs\User-Authentication\db.sql
   Replace username, database_name, and the path to db.sql with your actual MySQL username, database name, and the path to the db.sql file.

4. Configure Database Connection
   Replace the username, password, and database_name in config/database.php file with your actual MySQL credentials.

5. Start Apache and MySQL
   Open XAMPP and start Apache and MySQL.

6. Access the Project
   Open your browser and navigate to:
   http://localhost/User-Authentication/

7. Signup and Email Verification
   After signing up, the system will send an email to the users. For demo purposes, Mailtrap is used in PHPMailer. The Mailtrap SMTP demo account  only sends email to the account registered email (indhumathypj@gmail.com).

8. Verify Email
   You can verify the email after signing in with the following Gmail account:
   Email: indhumathypj@gmail.com
   Password: Indhumathy@123

9. Login and Remember Me Feature
   After the verification process, you can log in and use the remember_me feature for persistent login sessions.

10. Welcome Page and Logout
    After logging in, you can view the welcome page and log out from that page.

11. Security Features
    User Validations: Added user validations to ensure data integrity.
    CSRF Protection: Implemented Cross-Site Request Forgery protection.
    Input Sanitization: Sanitized user inputs using PDO (PHP Data Object) to prevent SQL injection and other vulnerabilities.
    Password Hashing: Stored passwords securely using the password_hash function.

12. Command to install PHPMAILER
    composer require phpmailer/phpmailer






