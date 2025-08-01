## 📰 News Portal Web Application

A dynamic and responsive full-stack News Portal built using **PHP**, **MySQL**, **HTML**, **CSS**, **JavaScript**, and **Bootstrap**. This application allows users to view news articles by category, manage user profiles, and provides admins with tools to manage articles, users, and categories.

---

## 🚀 Features

- 🔐 User Authentication (Signup/Login/Logout)
- 🧑 Role-Based Access (Admin/User)
- 🗞️ View articles by category
- 📋 Admin Dashboard:
  - Manage Articles (Add, Edit, Delete)
  - Manage Categories
  - Manage Users
- 👤 User Profile with update functionality
- 📨 Contact and About Pages
- 🖥️ Responsive UI with Bootstrap

---

## ⚙️ Technologies Used

- **Frontend:** HTML5, CSS3, Bootstrap, JavaScript
- **Backend:** PHP 7+
- **Database:** MySQL

---

## 🛠️ Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/news_portal.git


2. **Import the database**

   * Open `phpMyAdmin`
   * Create a database (e.g., `news_portal`)
   * users (id INT, username VARCHAR(50), email VARCHAR(100), password VARCHAR(255), role VARCHAR(20), created_at DATETIME)
   * articles (id INT, title VARCHAR(255), content TEXT, author_id INT, category_id INT, created_at DATETIME)
   * categories (id INT, name VARCHAR(100), description TEXT)
   * contacts (id INT, name VARCHAR(100), email VARCHAR(100), message TEXT, submitted_at DATETIME)

3. **Configure database**

   * Update `/config/db.php` with your MySQL credentials.

4. **Run the project**

   * Use XAMPP/LAMP/MAMP
   * Place the project in `htdocs` (XAMPP) or appropriate server folder
   * Visit `http://localhost/news_portal/pages/index.php`

---

## 📬 Contact

For any queries, feel free to connect with me:
**Victor Paul Mallavalli**
Email: `victormallavalli7@gmail.com`
LinkedIn: `https://www.linkedin.com/in/victor-paul-mallavalli-a1a632299/`

---
