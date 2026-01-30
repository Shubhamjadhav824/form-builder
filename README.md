# Form Builder Lite – Dynamic Form System

## Overview
Form Builder Lite is a simplified Google Forms–like system where an admin can create dynamic forms and users can submit responses. All form structures and submissions are stored dynamically in MySQL using JSON.

## Features
- Dynamic form creation (Admin panel)
- Multiple field types (Text, Number, Dropdown, Checkbox)
- Required field validation
- Public form submission via shareable URL
- Admin dashboard to view submissions
- JSON-based form and response storage

## Tech Stack
- Backend: Core PHP
- Frontend: HTML, CSS, Vanilla JavaScript
- Database: MySQL
- Version Control: Git & GitHub

## Database Setup
1. Create a MySQL database
2. Import `database.sql`
3. Update credentials in `configuration/db.php`

## Running Locally
```bash
docker compose up --build
