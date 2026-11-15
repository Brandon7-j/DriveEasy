\# DriveEase Car Rental Management System



DriveEase is a web-based car rental management system developed using PHP and MySQL. It provides a platform where customers can explore available vehicles, register accounts, and make car bookings. Administrators can manage vehicles, customers, bookings, and payment records.



\## Features



\### Customer Features

\- Customer registration and login.

\- Browse available rental vehicles.

\- View car details and rental prices.

\- Book available vehicles.

\- View personal booking history.



\### Administrator Features

\- Secure administrator login.

\- Dashboard displaying system statistics.

\- Add, edit, and delete vehicle records.

\- View registered customers.

\- Manage customer bookings.

\- Update booking statuses.

\- View payment records.



\## Technologies Used



\- PHP

\- MySQL

\- HTML5

\- CSS3

\- JavaScript

\- XAMPP

\- Git and GitHub



\## Installation and Setup



1\. Install XAMPP on your computer.

2\. Clone this repository into the XAMPP `htdocs` directory:



&#x20;  ```bash

&#x20;  git clone https://github.com/Brandon7-j/DriveEasy.git

&#x20;  ```



3\. Start Apache and MySQL from XAMPP Control Panel.

4\. Open phpMyAdmin and create a database named:



&#x20;  `car\_rental\_db`



5\. Import the project's database SQL schema.

6\. Copy `config/database.example.php` to `config/database.php`.

7\. Update the database credentials in `config/database.php`.

8\. Open your browser and visit:



&#x20;  `http://localhost/driveeasy/`



\## Database Tables



The system uses the following database tables:



\- users

\- categories

\- cars

\- bookings

\- payments

\- reviews



\## Project Structure



```text

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

```



\## Project Status



The core customer and administrator features have been developed and tested locally.



Payment records can be managed, but live payment gateway integration is not currently included.



\## Developer



\*\*Brandon7-j\*\*



GitHub Repository: https://github.com/Brandon7-j/DriveEasy

