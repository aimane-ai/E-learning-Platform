# Bright Future - Online Learning Platform

A modern online learning platform developed in PHP with PDO for managing courses, enrollments, and student interactions.

## 🌟 Features

- **Secure authentication** (Students and Administrators)
- **Course management** with images and descriptions
- **Course enrollment system**
- **Responsive and modern interface**
- **Comments/testimonials system**
- **Complete admin dashboard**
- **User profile** with editing capabilities
- **Course search functionality**

## 🛠️ Technologies Used

- **Backend**: PHP 7.4+ with PDO
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Libraries**: Font Awesome, Owl Carousel, jQuery
- **Security**: Password hashing with `password_hash()`

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or MariaDB 10.2+
- Web server (Apache/Nginx)
- PHP Extensions: PDO, PDO_MySQL

## 🚀 Installation

### 1. Clone the project
```bash
git clone https://github.com/your-username/bright-future.git
cd bright-future
```

### 2. Database configuration

1. Create a MySQL database:
```sql
CREATE DATABASE centre CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Copy the configuration file:
```bash
cp connection_db.example.php connection_db.php
```

3. Modify `connection_db.php` with your settings:
```php
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';
```

### 3. Database schema import

Create the necessary tables by running the `database_schema.sql` file in your database:
```bash
mysql -u your_username -p centre < database_schema.sql
```

### 4. Permission configuration

Make sure the `image/` and `images/` directories are writable:
```bash
chmod 755 image/
chmod 755 images/
```
## 📁 Project Structure

```
bright-future/
├── connection_db.example.php    # Database configuration template
├── connection_db.php           # Database configuration (ignored by Git)
├── index.php                   # Homepage
├── log.php                     # Login page
├── register.php                # Registration page
├── adm.php                     # Admin dashboard
├── tableau.php                 # Student dashboard
├── profile.php                 # User profile
├── allcourses.php              # Course listing
├── formation.php               # Course management
├── style.css                   # Main styles
├── script.js                   # JavaScript
├── image/                      # Course images
├── images/                     # Site images
├── database_schema.sql         # Database schema
├── DEPLOYMENT.md               # Deployment guide
└── README.md                   # This file
```

## 🔐 Security

### Implemented security features

- ✅ **Password hashing** with `password_hash()`
- ✅ **Secure verification** with `password_verify()`
- ✅ **Prepared statements** PDO to prevent SQL injection
- ✅ **Separate DB configuration** (file ignored by Git)
- ✅ **Secure session management**
- ✅ **User input validation**

### Production recommendations

1. **Change default passwords**
2. **Use HTTPS** in production
3. **Configure appropriate firewall**
4. **Regularly backup** the database
5. **Update** PHP and MySQL regularly

## 👥 Usage

### Account creation

1. **Students**: Register via the registration page
2. **Administrators**: Create the first admin account via registration, then modify permissions

### User roles

- **Students**: Can enroll in courses, view their profile, leave comments
- **Administrators**: Complete management of courses, users and comments

## 🐛 Troubleshooting

### Common issues

1. **Database connection error**: Check `connection_db.php`
2. **Images not displaying**: Check directory permissions
3. **Error 500**: Enable error display in development
4. **Authentication issue**: Verify that passwords are properly hashed

### Error logs

Errors are logged in web server logs. In development, you can enable PHP error display.

## 🤝 Contributing

1. Fork the project
2. Create a branch for your feature
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License. See the `LICENSE` file for more details.

## 👨‍💻 Author

**Aimane Elouarrate**
- Email: thegoat6864@gmail.com

## 🙏 Acknowledgments

- Font Awesome for icons
- Owl Carousel for carousels
- All project contributors

---

**Note**: This project is ready for production after proper database and web server configuration.
