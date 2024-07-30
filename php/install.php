<?php
    // Connect to database
    $servername = "localhost";
    $username = "root";        // put your phpmyadmin username.(default is "root")
    $password = "";            // if your phpmyadmin has a password put it here.(default is "root")
    $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Create database
    $sql = "CREATE DATABASE biometricattendace";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    echo "<br>";

    $dbname = "biometricattendace";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // sql to create table Teachers
    $sql = "CREATE TABLE IF NOT EXISTS Teachers (
        TeacherID INT PRIMARY KEY AUTO_INCREMENT,
        TeacherName VARCHAR(100),
        Department VARCHAR(100)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    if ($conn->query($sql) === TRUE) {
        echo "Table Teachers created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table Users
    $sql = "CREATE TABLE IF NOT EXISTS Users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(100),
        add_fingerid TINYINT,
        del_fingerid TINYINT,
        email VARCHAR(100),
        fingerprint_id INT,
        fingerprint_select TINYINT,
        gender VARCHAR(10),
        serialnumber DOUBLE,
        time_in TIME,
        user_date DATE
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    if ($conn->query($sql) === TRUE) {
        echo "Table Users created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table Subjects
    $sql = "CREATE TABLE IF NOT EXISTS Subjects (
        SubjectID INT PRIMARY KEY AUTO_INCREMENT,
        SubjectName VARCHAR(100),
        Credits INT
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    if ($conn->query($sql) === TRUE) {
        echo "Table Subjects created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table Classes
    $sql = "CREATE TABLE IF NOT EXISTS Classes (
        ClassID INT PRIMARY KEY AUTO_INCREMENT,
        ClassName VARCHAR(100),
        SubjectID INT,
        TeacherID INT,
        Schedule VARCHAR(100),
        FOREIGN KEY (SubjectID) REFERENCES Subjects(SubjectID),
        FOREIGN KEY (TeacherID) REFERENCES Teachers(TeacherID)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    if ($conn->query($sql) === TRUE) {
        echo "Table Classes created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table Enrollments
    $sql = "CREATE TABLE IF NOT EXISTS Enrollments (
        EnrollmentID INT PRIMARY KEY AUTO_INCREMENT,
        UserID INT,
        ClassID INT,
        FOREIGN KEY (UserID) REFERENCES Users(id),
        FOREIGN KEY (ClassID) REFERENCES Classes(ClassID)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    if ($conn->query($sql) === TRUE) {
        echo "Table Enrollments created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table Attendance
    $sql = "CREATE TABLE IF NOT EXISTS Attendance (
        AttendanceID INT PRIMARY KEY AUTO_INCREMENT,
        EnrollmentID INT,
        AttendanceDate DATE,
        Status VARCHAR(50),
        FOREIGN KEY (EnrollmentID) REFERENCES Enrollments(EnrollmentID)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    if ($conn->query($sql) === TRUE) {
        echo "Table Attendance created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table Accounts
    $sql = "CREATE TABLE IF NOT EXISTS Accounts (
        acc VARCHAR(50) PRIMARY KEY,
        pass VARCHAR(100),
        TeacherID INT,
        FOREIGN KEY (TeacherID) REFERENCES Teachers(TeacherID)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    if ($conn->query($sql) === TRUE) {
        echo "Table Accounts created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
?>
