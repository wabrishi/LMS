-- Create roles table
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Insert default roles
INSERT INTO roles (name) VALUES ('Admin'), ('Teacher'), ('Student');

-- Insert default admin user
INSERT INTO users (username, password, email) VALUES ('admin', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'admin@example.com');
SET @admin_id = LAST_INSERT_ID();
INSERT INTO user_roles (user_id, role_id) VALUES (@admin_id, (SELECT id FROM roles WHERE name = 'Admin'));

-- Insert default teacher user
INSERT INTO users (username, password, email) VALUES ('teacher', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'teacher@example.com');
SET @teacher_id = LAST_INSERT_ID();
INSERT INTO user_roles (user_id, role_id) VALUES (@teacher_id, (SELECT id FROM roles WHERE name = 'Teacher'));

-- Insert default student user
INSERT INTO users (username, password, email) VALUES ('student', '$2y$10$E.qJ4qgL9qK7qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A/b9qZ.y5Y.jJ.A', 'student@example.com');
SET @student_id = LAST_INSERT_ID();
INSERT INTO user_roles (user_id, role_id) VALUES (@student_id, (SELECT id FROM roles WHERE name = 'Student'));

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create user_roles table to link users and roles
CREATE TABLE user_roles (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Create courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    teacher_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create enrollments table
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Create lessons table
CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    video_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);
