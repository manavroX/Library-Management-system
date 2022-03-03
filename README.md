# Library-Management-system

## About
This is a project of a Library Management System, driven by real business requirements. You can manage different functionalities like book issue, return, add to waitlist and recommendations that are personalized according to the member's reading history.

You will first need to create an account(which will be approved by the admin) after which, you can issue a book. 

The Library Management System uses a Level 1 **Apriori algorithm** to recommend books to a used which are personalised to the user's reading history.

## Database Structure
The ER diagram of our Database:
[DBS_ER.pdf](https://github.com/manavroX/Library-Management-system/files/8179584/DBS_ER.pdf)

The Relational Schema of our Database:
[FINAL_RELATIONAL_SCHEMA.pdf](https://github.com/manavroX/Library-Management-system/files/8179590/FINAL_RELATIONAL_SCHEMA.pdf)

## Screenshots

### Login Page
![2022-03-03](https://user-images.githubusercontent.com/38128162/156616069-5c7c3ca7-7918-4d1d-bfcd-62f1bfb8f03f.png)

### Admin Home Page
![2022-03-03 (1)](https://user-images.githubusercontent.com/38128162/156616096-be29ab0b-f80b-42ee-913f-394e5e8bd302.png)

### Student Home Page
![2022-03-03 (5)](https://user-images.githubusercontent.com/38128162/156616044-3f0027a7-91f4-4ebd-9e54-f1fc83de33a5.png)

### Search Book Page
![2022-03-03 (2)](https://user-images.githubusercontent.com/38128162/156616108-d9971dc3-1d9d-45ff-ae6a-ac1d74ee3e73.png)

### Book Details Page
![2022-03-03 (8)](https://user-images.githubusercontent.com/38128162/156617517-7231d099-8a14-4b23-96a8-2a442435f42b.png)

### Search User page(Only Admin has the access)
![2022-03-03 (3)](https://user-images.githubusercontent.com/38128162/156615992-92c68b7a-9c43-4814-81af-ea55f9e296da.png)

### User History Page
![2022-03-03 (7)](https://user-images.githubusercontent.com/38128162/156617473-03037a7b-76a8-406d-ba93-482ff8d8eac3.png)

## How To Set Up
1) Install xampp
2) copy the folder in xampp/htdocs/Library-Management-system
3) open xampp and click on start besides apache.
4) Set up the database
  - open xampp and click on start besides mySql.
  - paste the following links in your browser address bar in the given order:
    - http://localhost/Library-Management-system/config/createDB.php
    - http://localhost/Library-Management-system/config/connectDB.php
    - http://localhost/Library-Management-system/config/createDB.php
    - http://localhost/Library-Management-system/config/createTable.php
    - http://localhost/Library-Management-system/config/alterTables.php
    - http://localhost/Library-Management-system/config/insertValues.php
  - you can open xampp, and see the database structure and the data inside the database
6) Open your browser and paste this in the address bar : http://localhost/Library-Management-system/index.php
7) you are Ready to Go 🥳🎉
