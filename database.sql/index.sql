-- Create Database
CREATE DATABASE IF NOT EXISTS form_builder;
USE form_builder;

-- Forms table
CREATE TABLE forms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    structure_json TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Form submissions table
CREATE TABLE form_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT NOT NULL,
    response_json TEXT NOT NULL,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (form_id) REFERENCES forms(id) ON DELETE CASCADE
);

-- Sample Form Data
INSERT INTO forms (title, description, structure_json) VALUES (
    'Student Registration Form',
    'Collect basic student details',
    '[
        {
            "label": "Name",
            "type": "text",
            "required": true
        },
        {
            "label": "Age",
            "type": "number",
            "required": false
        },
        {
            "label": "Gender",
            "type": "dropdown",
            "options": ["Male", "Female", "Other"],
            "required": true
        },
        {
            "label": "Skills",
            "type": "checkbox",
            "options": ["HTML", "CSS", "JavaScript", "PHP"],
            "required": false
        }
    ]'
);
