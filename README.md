<h1 align="center">Melody Skeleton</h1>

<p align="center">A skeleton for the <a href="https://github.com/Luhmm1/Melody">Melody</a> library.</p>

<p align="center">
  <a href="https://github.com/Luhmm1/Melody-Skeleton/actions/workflows/tests.yml">
    <img src="https://github.com/Luhmm1/Melody-Skeleton/actions/workflows/tests.yml/badge.svg" alt="Tests">
  </a>
  <a href="https://packagist.org/packages/luhmm1/melody-skeleton">
    <img src="https://flat.badgen.net/packagist/v/luhmm1/melody-skeleton" alt="Version">
  </a>
  <a href="https://www.php.net/">
    <img src="https://flat.badgen.net/packagist/php/luhmm1/melody-skeleton" alt="PHP">
  </a>
  <a href="https://github.com/Luhmm1/Melody-Skeleton/blob/master/LICENSE">
    <img src="https://flat.badgen.net/packagist/license/luhmm1/melody-skeleton" alt="License">
  </a>
</p>

## Features

- Configure multiple environments with **PHP dotenv**.
- Manage your dependencies with **PHP-DI**.
- Communicate to the database with **Doctrine**.
- Display pages with **Twig**.
- Define a routing strategy with **ViaRouter**.
- Manage assets with **Webpack**.

## Installation

### 1. Prerequisites

- PHP (^8.0)
- Composer
- npm

### 2. Install Melody Skeleton

You can install Melody Skeleton using this Composer command:

```
composer create-project luhmm1/melody-skeleton:dev-master my-project
```

### 3. Install dependencies

To install the dependencies, run these two commands:

```
composer install & npm install
```

### 4. Compile assets

Before displaying your website, you need to compile the assets by running this command:

```
npm run build-prod
```

## Documentation

You can view the documentation on [our official website](https://melody.deville.dev/).
