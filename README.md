# 🎓 Alumni Management System

A complete web application for managing students and alumni within a university. Built with **pure PHP (MVC)** and **MySQL**, it provides an admin dashboard, alumni events, student-alumni interaction, feedback, donations, and more.

> **⚠️ Project Status:** Completed with all main features working (auth, CRUD, dashboard, feedback, donations, reports).

---

## ✨ Features

| Status | Feature |
|--------|---------|
| ✅ | Student & Alumni registration + login |
| ✅ | Profile pages for both roles |
| ✅ | Admin dashboard with statistics & reports |
| ✅ | Events creation, attendance tracking |
| ✅ | Feedback system (students ⇨ alumni) |
| ✅ | Alumni donation system |
| ✅ | Job listings & management |

---

## 🛠️ Tech Stack

### Core
- **PHP (Vanilla)** – backend logic
- **MySQL** – relational database
- **Bootstrap 5** – responsive UI

### Architecture
- **MVC** – Models / Views / Controllers
- Clean folder separation using `controllers/`, `models/`, `views/`, and `database/`.

---

## 📁 Project Structure (simplified)
````
/Alumni
├── controllers/ # App logic & request handling
├── models/ # Database interaction logic
├── views/ # HTML views (Bootstrap 5 styled)
│ └── Auth/ # Login & Registration pages
├── database/ # Database connection config
└── seproject.sql # SQL dump file
````


---


---

## 🚀 Getting Started Locally

1. **Clone the repository**
   ```bash
   git clone https://github.com/Aliaa-mohamed47/Alumni.git

 2. **Move the project to XAMPP htdocs**
    ```bash
    mv Alumni C:/xampp/htdocs/Alumni

 4. **Start XAMPP and run Apache + MySQL**

 5. **Create the database**
Go to:   ```bash http://localhost/phpmyadmin
Create a new database named seproject
Import the file: /database/seproject.sql

 6. **Visit the application**
   ```bash
   http://localhost/Alumni/login



## 🔐 Default Login Credentials

| Role    | Email            | Password     |
|---------|------------------|--------------|
| Admin   | aliaa@gmail.com  | Aliaa1234$   |
| Student | gehad@gmail.com  | Gehad1234$   |
| Alumni  | sama@gmail.com   | Sama1234$    |


## 🙋‍♀️ Author

**Aliaa Mohamed**  
[GitHub](https://github.com/Aliaa-mohamed47) • [LinkedIn](https://www.linkedin.com/in/aliaa-mohamed-abdo/)


