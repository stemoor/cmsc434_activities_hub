# Activities Hub


Software required:
    XAMPP installed to run Apache and MySql
        -> Download and Install XAMPP
            1. In the (C:) folder find the XAMPP folder and paste this entire project with root folder "activities_hub" in the htdoc folder (C:\xampp\htdocs)
        -> Open XAMPP control Panel
            1. Test it this worked by opening the Chrome and going to "http://localhost/activities_hub/#". If the website loads, you are good to go.
        -> Start Apache and MySql

USAGE:

        To use this application you must first create the following database, grant permission and create the tables described below:

        1. With MySql running through XAMPP, open PowerShell. From the C: directory go to .\xampp\mysql\bin\

            cd .\xampp\mysql\bin\

        3. Run this command to start mySql console:

            .\mysql.exe -u root

        4. Create a database called "activities_hub" with the command below

            create database activities_hub;
            use activities_hub;

        5. Give permission to main admin user

            grant all on activities_hub.* to dbuser@localhost identified by "genericPassword";

        6. Copy paste the command below to create the "user" table:

            create table users (
                                    id int PRIMARY KEY AUTO_INCREMENT,
                                    email varchar(100) NOT NULL UNIQUE,
                                    first_name varchar(100),
                                    last_name varchar(100),
                                    password varchar(60) NOT NULL,
                                    avatar blob,
                                    is_planner BOOLEAN
                                );

        -> use "describe users" to make user that the table looks like the one below:

            +------------+--------------+------+-----+---------+----------------+
            | Field      | Type         | Null | Key | Default | Extra          |
            +------------+--------------+------+-----+---------+----------------+
            | id         | int(11)      | NO   | PRI | NULL    | auto_increment |
            | email      | varchar(100) | NO   | UNI | NULL    |                |
            | name       | varchar(100) | YES  |     | NULL    |                |
            | password   | varchar(60)  | NO   |     | NULL    |                |
            | avatar     | blob         | YES  |     | NULL    |                |
            | is_planner | tinyint(1)   | YES  |     | NULL    |                |
            +------------+--------------+------+-----+---------+----------------+


        7. Copy paste the command below to create the "planners" table

            create table planners (
                                    id int PRIMARY KEY,
                                    organization varchar(200) NOT NULL,
                                    phone_number varchar(12),
                                    website varchar(100)
                                );


        -> use "describe planners " to make user that the table looks like the one below:

            +--------------+--------------+------+-----+---------+-------+
            | Field        | Type         | Null | Key | Default | Extra |
            +--------------+--------------+------+-----+---------+-------+
            | id           | int(11)      | NO   | PRI | NULL    |       |
            | organization | varchar(200) | NO   |     | NULL    |       |
            | phone_number | varchar(12)  | YES  |     | NULL    |       |
            | website      | varchar(100) | YES  |     | NULL    |       |
            +--------------+--------------+------+-----+---------+-------+

        8. Copy paste the command below to create the "events" table

            create table events (
                                    id int  PRIMARY KEY  AUTO_INCREMENT,
                                    planner_id int NOT NULL,
                                    title varchar(250) NOT NULL,
                                    event_type ENUM('techtalk', 'club', 'workshop', 'other') NOT NULL,
                                    location varchar(250),
                                    start_datetime datetime  NOT NULL,
                                    end_datetime datetime  NOT NULL,
                                    description TEXT,
                                    event_status ENUM('closed', 'open') NOT NULL,
                                    publish_status ENUM('unpublished', 'published') NOT NULL,
                                    picture blob
                                );

        -> use "describe events " to make user that the table looks like the one below:

            +----------------+--------------------------------------------+------+-----+---------+----------------+
            | Field          | Type                                       | Null | Key | Default | Extra          |
            +----------------+--------------------------------------------+------+-----+---------+----------------+
            | id             | int(11)                                    | NO   | PRI | NULL    | auto_increment |
            | planner_id     | int(11)                                    | NO   |     | NULL    |                |
            | title          | varchar(250)                               | NO   |     | NULL    |                |
            | event_type     | enum('techtalk','club','workshop','other') | NO   |     | NULL    |                |
            | location       | varchar(250)                               | YES  |     | NULL    |                |
            | start_datetime | datetime                                   | NO   |     | NULL    |                |
            | end_datetime   | datetime                                   | NO   |     | NULL    |                |
            | description    | text                                       | YES  |     | NULL    |                |
            | event_status   | enum('closed','open')                      | NO   |     | NULL    |                |
            | publish_status | enum('unpublished','published')            | NO   |     | NULL    |                |
            | picture        | blob                                       | YES  |     | NULL    |                |
            +----------------+--------------------------------------------+------+-----+---------+----------------+

        9. Copy paste the command below to create the "rsvp_list" table

            create table rsvp_list (
                                        event_id int  PRIMARY KEY  AUTO_INCREMENT,
                                        user_id int  NOT NULL
                                    );


        10. Copy paste the command below to create the "favorited_events" table

            create table favorited_events   (
                                                user_id int PRIMARY KEY,
                                                event_id int  NOT NULL
                                            );


        11. Insert test data to the user table

            INSERT INTO users (email, first_name, last_name, password, is_planner)
                VALUES ('user@test.com', 'Test', 'User', "$2y$10$eDzDDxOjCf3QdepWGdkXQuec8Xur5ImLOpfMcbJ2LGNGjWlzjDnsm", true);


            INSERT INTO planners (id, organization)
                VALUES (1, 'Microsfot');

            INSERT INTO events (planner_id, title, event_type, location,
                                start_datetime, end_datetime, description,
                                event_status, publish_status)
                VALUES (1, 'Robotics Tech Talk', 'techtalk', 'CSIC Building #2364',
                        '12/12/17 05:00 pm', '12/12/17 10:00 pm', 'No Description',
                        'open', 'published');
