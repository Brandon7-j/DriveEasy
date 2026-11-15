# &#x20;***DriveEasy Car Rental Management System***



DriveEasy is a web-based car rental management system developed using PHP and MySQL. It provides a platform where customers can explore available vehicles, register accounts, and make car bookings. Administrators can manage vehicles, customers, bookings, and payment records.

##### 

##### **Features**



##### &#x20;Customer Features

1. &#x20;Customer registration and login.
2. &#x20;Browse available rental vehicles.
3. &#x20;View car details and rental prices.
4. &#x20;Book available vehicles.
5. &#x20;View personal booking history.

##### 

##### **Administrator Features**

* &#x20;Secure administrator login.
* &#x20;Dashboard displaying system statistics.
* &#x20;Add, edit, and delete vehicle records.
* &#x20;View registered customers.
* &#x20;Manage customer bookings.
* &#x20;Update booking statuses.
* &#x20;View payment records.

##### 

##### &#x20;Technologies Used



1. &#x20;PHP
2. &#x20;MySQL
3. &#x20;HTML5
4. &#x20;CSS3
5. &#x20;JavaScript
6. &#x20;XAMPP
7. &#x20;Git and GitHub



##### Installation and Setup



1\. Install XAMPP on your computer.

2\. Clone this repository into the XAMPP `htdocs` directory:



&#x20;  bash

&#x20;  git clone https://github.com/YOUR USERNAME/DriveEasy.git

&#x20;  



3\. Start Apache and MySQL from XAMPP Control Panel.

4\. Open phpMyAdmin and create a database named:



&#x20;  `car\_rental\_db`



5\. Import the project's database SQL schema.

6\. Copy `config/database.example.php` to `config/database.php`.

7\. Update the database credentials in `config/database.php`.

8\. Open your browser and visit:



&#x20;  `http://localhost/driveeasy/`

##### 

##### &#x20;Database Tables



The system uses the following database tables:



* &#x20;users
* &#x20;categories
* &#x20;cars
* &#x20;bookings
* &#x20;payments
* &#x20;reviews



##### Project Structure



text

driveeasy/

├── admin/

├── assets/

│   ├── css/

│   ├── images/

│   └── js/

├── config/

├── includes/

├── uploads/

│   └── cars/

├── booking.php

├── car-details.php

├── cars.php

├── contact.php

├── index.php

├── login.php

├── logout.php

├── my-bookings.php

└── register.php





##### Project Status



The core customer and administrator features have been developed and tested locally.



Payment records can be managed, but live payment gateway integration is not currently included.



Developer



Brandon7-j



GitHub Repository: https://github.com/Brandon7-j/DriveEasy

