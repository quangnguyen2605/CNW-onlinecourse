CREATE TABLE IF NOT EXISTS instructor_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    experience VARCHAR(50) NOT NULL,
    education VARCHAR(255) NOT NULL,
    bio TEXT NOT NULL,
    courses TEXT NOT NULL,
    availability VARCHAR(50) NOT NULL,
    salary VARCHAR(100),
    portfolio VARCHAR(255),
    cv_file VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
