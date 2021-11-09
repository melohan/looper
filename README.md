# Looper

> Project MAW 1.1
> Reproduction of [Looper](https://stormy-plateau-54488.herokuapp.com)

## Authors

- [Ohan Mélodie](https://github.com/melohan)
- [Samoutphonh Souphakone](https://github.com/Souphakone)

## Installing

### Built With

- [Font Awesome Free 5.15.4 by @fontawesome](https://fontawesome.com)
- [Milligram v1.4.1](https://milligram.io)
- [Normalize.css v8.0.1](github.com/necolas/normalize.css)
- [PHPUnit](https://phpunit.de/getting-started/phpunit-9.html)

### Prerequisites

- PHP 8.0.0 or greater
- MariaDB 10.6.4
- Composer
- npm

## Setting up Dev

```shell
git clone https://github.com/melohan/looper.git
cd looper/
git checkout develop
mkdir config
touch config/db.php
composer i
npm i
sass resources\scss:public\css
```

To run looper project 
```shell
cd public
php -S localhost:8000
```

### Configuration

#### Database

Create from the root `config/db.php` and set up your database information in these constant :

```php
// config/db.php
<?php 
const HOST = '';
const PORT = '';
const USER = '';
const PWD = '';
const DB_NAME = 'looper';
```

Then execute in your MySQL client the database from `/database/database.sql`

### Run project

```shell
cd public\
php -S localhost:8000
```

## Test environment

Update `config/db.php` with your test environnment, testDataBase.sql will drop current looper database for each
unitTests.

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