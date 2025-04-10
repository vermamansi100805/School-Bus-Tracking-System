In 102track.html and map.html enter you own data in the following fields: like google api key

In forgot_password_driver.php  and forgot_password_parent.php and send_email_start.php and 
send_email_leave.php and send_email.php add your own google app password and email id 

Database is project and below are the table inside it

CREATE TABLE driver_login (
    id INT(11) NOT NULL AUTO_INCREMENT,
    bus_no VARCHAR(50) NOT NULL,
    driver_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    status ENUM('inactive', 'active') NOT NULL,
    contact_number VARCHAR(15) NOT NULL,
    home_address TEXT NOT NULL,
    PRIMARY KEY (id)
);



CREATE TABLE bus_locations (
    id INT(11) NOT NULL AUTO_INCREMENT,
    bus_no INT(11) DEFAULT NULL,
    latitude FLOAT(10,6) DEFAULT NULL,
    longitude FLOAT(10,6) DEFAULT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);


CREATE TABLE login (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'parent', 'driver') NOT NULL,
    contact_number VARCHAR(15) DEFAULT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE parent_login (
    roll_no INT(10) NOT NULL,
    student_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    Password VARCHAR(50) NOT NULL,
    contact_number CHAR(10) NOT NULL,
    home_address VARCHAR(255) NOT NULL,
    bus_stop VARCHAR(20) NOT NULL,
    bus_no INT(11) NOT NULL,
    class VARCHAR(10) NOT NULL,
    reset_token VARCHAR(64) DEFAULT NULL,
    reset_expiry DATETIME DEFAULT NULL,
    PRIMARY KEY (roll_no)
);
