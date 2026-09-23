# Ticketing System

A ticketing system built with Laravel(Blade), Tailwind CSS, MySQL and MongoDB.

---

## Features

### Customer Features
- Ticket Status of a customer.
- Browse ticket by searching and filter(category, priority, status).
- Submit a ticket and uploading attachment file.
- See only their activities timelines.

### Agent Features
- Ticket Status only for that Agent.
- Update a ticket workflow by changing the status and download attachment.
- See agent and admin activities timelines.

### Admin Features
- All Ticket Status of Customer
- Browse ticket by searching and filter(category, priority, status).
- Submit a ticket for a customer.
- Update a ticket workflow by changing the status etc and download attachment.
- Assigning a ticket for Agent.
- See agent and admin activities timelines.

## Tech Stack

**Backend:** PHP, Laravel, MySQL, MongoDB  
**Frontend:** Blade, TailwindCSS

## Prerequisites

- PHP 8.2 --- 8.4
- Laravel 11
- MongoDB 5.8
- MySQL 8.0

make sure you have installed all of the above prerequisites.

## Quick Start

1. **Clone and Navigate**
```bash
git clone https://github.com/xdranel/ticketing-system
```
and then
```bash
cd ticketing-system
```  
---

2. **Configure Environment**

Copy & paste file `.env.example` and change the file name to `.env` and fill in the required values

or you can do it on terminal
```bash
cp .env.example .env
```  

Required changes in `.env`:  
uncomment the line below
and fill it with your database credentials
```
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
MONGODB_DATABASE=
```
---

3. **Create Database**  

If you using a mysql panel/tools you might want to make it from the panel  
and make database with the name of `value_of_DB_DATABASE` 

If you using a cli, you can just use
```bash
mysql -u value_of_DB_USERNAME -p -e "CREATE DATABASE value_of_DB_DATABASE;"
```  
---

4. **Setup Application**

Open Terminal and run:
```bash
composer install
npm install
```
and then
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```
---

5. **Run Application**

Open 2 terminal  

Terminal 1:
```bash
php artisan serve
```

Terminal 2:  
```bash
npm run dev
```
---

6. **Access Application**
```bash
http://localhost:8000/
or
http://127.0.0.1:8000/
```
---

### Existing Account for Testing
you can check on Database/Seeders/DatabaseSeeder.php
- Customer:  
customer1@example.com / password  
customer2@example.com / password  
customer3@example.com / password  

- Agent :  
agent1@example.com / password  
agent2@example.com / password  

- Admin :  
admin@example.com / password  
