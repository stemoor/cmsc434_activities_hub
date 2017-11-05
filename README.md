# Activities Hub


Software required:
    XAMPP installed to run Apache and MySql)
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
                                    email varchar(100) primary key,
                                    name varchar(100),
                                    username varchar(60),
                                    password varchar(60),
                                    avatar blob,
                                    is_planner BOOLEAN
                                );

        -> use "describe users" to make user that the table looks like the one below:

            +------------+--------------+------+-----+---------+-------+
            | Field      | Type         | Null | Key | Default | Extra |
            +------------+--------------+------+-----+---------+-------+
            | email      | varchar(100) | NO   | PRI | NULL    |       |
            | name       | varchar(100) | YES  |     | NULL    |       |
            | username   | varchar(60)  | YES  |     | NULL    |       |
            | password   | varchar(60)  | YES  |     | NULL    |       |
            | avatar     | blob         | YES  |     | NULL    |       |
            | is_planner | tinyint(1)   | YES  |     | NULL    |       |
            +------------+--------------+------+-----+---------+-------+


        7. Copy paste the command below to create the "planners" table

            create table planners (
                                    email varchar(100) primary key,
                                    contact_name varchar(100),
                                    contact_email varchar(100),
                                    phone_number varchar(12),
                                    website varchar(100)
                                );


        -> use "describe planners " to make user that the table looks like the one below:

            +---------------+--------------+------+-----+---------+-------+
            | Field         | Type         | Null | Key | Default | Extra |
            +---------------+--------------+------+-----+---------+-------+
            | email         | varchar(100) | NO   | PRI | NULL    |       |
            | contact_name  | varchar(100) | YES  |     | NULL    |       |
            | contact_email | varchar(100) | YES  |     | NULL    |       |
            | phone_number  | varchar(12)  | YES  |     | NULL    |       |
            | website       | varchar(100) | YES  |     | NULL    |       |
            +---------------+--------------+------+-----+---------+-------+

        8. Copy paste the command below to create the "events" table

            create table events (
                                    id int primary key AUTO_INCREMENT,
                                    planner varchar(100),
                                    building_name varchar(250),
                                    room_num int,
                                    latitude_o double,
                                    longitude_o double,
                                    start_datetime datetime,
                                    end_datetime datetime,
                                    description TEXT,
                                    is_published BOOLEAN,
                                    is_open BOLLEAN,
                                    picture blob
                                );

        9. Copy paste the command below to create the "rsvp_list" table

            create table rsvp_list (
                                        event_id int primary key AUTO_INCREMENT,
                                        user varchar(100)
            )


        10. Copy paste the command below to create the "favorited_events" table

            create table favorited_events (
                                        user varchar(100) primary key,
                                        event_id int,
            )
