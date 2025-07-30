-- Create roles table
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Insert default roles
INSERT INTO roles (name) VALUES ('Admin'), ('Teacher'), ('Student');

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create user_roles table to link users and roles
CREATE TABLE IF NOT EXISTS user_roles (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Create courses table
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    teacher_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create enrollments table
CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Create lessons table
CREATE TABLE IF NOT EXISTS lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    video_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Sample Data
-- Users
INSERT INTO users (username, password, email) VALUES
('admin', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'admin@example.com'),
('teacher1', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'teacher1@example.com'),
('teacher2', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'teacher2@example.com'),
('student1', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'student1@example.com'),
('student2', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'student2@example.com'),
('student3', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'student3@example.com');

-- User Roles
INSERT INTO user_roles (user_id, role_id) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 3),
(5, 3),
(6, 3);

-- Courses
INSERT INTO courses (title, description, teacher_id) VALUES
('Introduction to PHP', 'Learn the basics of PHP programming.', 2),
('Advanced JavaScript', 'Master advanced JavaScript concepts.', 2),
('Database Design', 'Learn how to design and manage databases.', 3);

-- Enrollments
INSERT INTO enrollments (student_id, course_id) VALUES
(4, 1),
(4, 3),
(5, 2),
(6, 1),
(6, 2),
(6, 3);

-- Lessons
INSERT INTO lessons (course_id, title, content, video_url) VALUES
(1, 'PHP Basics', 'This lesson covers the basics of PHP.', 'https://www.youtube.com/watch?v=zZ6vybT1H_Y'),
(1, 'Variables and Data Types', 'Learn about variables and data types in PHP.', NULL),
(2, 'Closures and Callbacks', 'This lesson covers closures and callbacks in JavaScript.', 'https://www.youtube.com/watch?v=3a0I8ICR1Vg'),
(3, 'Normalization', 'Learn about database normalization.', NULL);
