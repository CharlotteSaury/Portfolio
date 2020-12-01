# CV & Porfolio - Backend PHP / Symfony developer

Personnal portfolio, online here => [charlottesaury.fr]("http://charlottesaury.fr")

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/1bd65488cbf44c008e1bd3c37428f671)](https://www.codacy.com/gh/CharlotteSaury/Portfolio/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=CharlotteSaury/Portfolio&amp;utm_campaign=Badge_Grade)


## Description

* Just graduated from PHP/Symfony application developper from OpenClassrooms, I developed this portfolio to improve my symfony skills and develop my online visibility
* The homepage will display my last realizations and skills level
* Administration pages will allow dynamic creation of new skills and realization to easily implement my portfolio in the future


## Environment : Symfony 5 project

Project require:
* [Composer]("https://getcomposer.org/")
* PHP 7.4

## Installation

#### 1 - Git clone the project
`https://github.com/CharlotteSaury/Portfolio.git`

#### 2 - Install libraries
`php bin/console composer install`

#### 3 - Create database
* a) Update DATABASE_URL .env file with your database configuration.
    `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`
* b) Create database: 
    `php bin/console doctrine:database:create`
* c) Create database structure:
    `php bin/console doctrine:schema:update --force`

#### 4 - Start server
`symfony serve -d`

#### 5 - Open portfolio
`symfony open:local`

## Usage

You can now use this app. To access admin dashboard to manage realizations and skills, you just have to create directly your account in the database with your email and hashed password :
`php bin/console security:encode-password`
Login form is then available at '/login'.
Register form might be implemented in further version of the website.
