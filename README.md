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

### Setting up Dev

```shell
git clone https://github.com/melohan/looper.git
cd looper/
composer i
npm i
sass resources\scss:public\css
```

#### Run project
```shell
cd public\
php -S localhost:8000
```