# Exercise Looper

> This website is a reproduction of
> [Exercise Looper](https://stormy-plateau-54488.herokuapp.com)


Looper is a website for creating exercises and answering questions. It also allows you to view the different answers.

### Authors

- [Ohan Mélodie](https://github.com/melohan)
- [Samoutphonh Souphakone](https://github.com/Souphakone)

## Table of contents

1. [Prerequisites](#prerequisites)
    1. [Built with](#built-with)
2. [Setting up Dev](#setting-up-dev)
    1. [Installation](#1-installation)
    2. [Import database](#2-import-database)
    3. [Complete configuration file](#3-complete-configuration-file)
    4. [Run looper project](#4-run-looper-project)
3. [Documentation](#documentation)
    1. [Contribute to the project](#contribute-to-the-project)
    2. [Route of this project](#route-of-this-project)
    3. [Database](#database)
    4. [UML schma](#uml-schema)
4. [Test environment](#test-environment)

## Prerequisites

### Built with

- PHP 8.1.0
- MariaDB 10.6.4
- Composer 2.1.14
- npm 8.1.2

## Setting up Dev

### 1 Installation

Execute these following command in your project directory:
> Composer, npm will install
> - [Font Awesome Free 5.15.4 by @fontawesome](https://fontawesome.com)
> - [Milligram v1.4.1](https://milligram.io)
> - [Normalize.css v8.0.1](github.com/necolas/normalize.css)
> - [PHPUnit](https://phpunit.de/getting-started/phpunit-9.html)
>
> The SASS command will create .css file based on Miligram, normalize and fontawesome css.

```shell
git clone https://github.com/melohan/looper.git
cd looper/
git checkout develop
touch config/db.php
composer i
npm i
sass resources\scss:public\css
```

### 2 Import database

Execute the script `/database/dataBase.sql` in your MySQL Database.

If you don't want to start with a blank project, run the script `/database/dataExample.sql`

### 3 Complete configuration file

Rename `/config/example.db.php` to `/config/db.php` and complete with your own database information.

### 4 Run looper project

Run the following command from the project root.

```shell
php -S localhost:8080 -t public/
```

## Documentation

### Contribute to the project

- [Create new content, controller or models](documentation/ContributeToLooper.md)

### Route of this project

- [Route and description](documentation/Routes.md)

### Database

- [MLD](documentation/db/MLD.PNG)
- [MCD](documentation/db/MCD_CHEN.PNG)

### UML schema

- [UML](documentation/uml/models.PNG)

## Test environment

Update `config/db.php` with your test environnment, testDataBase.sql will drop current looper database for each
unitTests.

Because Unit tests are run with theses commands, you'll need to replace this path:

`require_once(sprintf("%s/config/db.php", dirname($_SERVER['DOCUMENT_ROOT'])));`

To this one: `require_once './config/db.php';` in  `app/database/DB.php`

Execute these following commands:
> The parent model is abstracte and tested through its children.

```shell
php vendor\phpunit\phpunit\phpunit tests\models\DBTest.php
php vendor\phpunit\phpunit\phpunit tests\models\AnswerTest.php
php vendor\phpunit\phpunit\phpunit tests\models\ExerciseTest.php
php vendor\phpunit\phpunit\phpunit tests\models\QuestionTest.php
php vendor\phpunit\phpunit\phpunit tests\models\StatusTest.php
php vendor\phpunit\phpunit\phpunit tests\models\TypeTest.php
php vendor\phpunit\phpunit\phpunit tests\models\UserTest.php
```
