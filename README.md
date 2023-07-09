# Rhino CMS and Application Framework 🦏 

![Build Status](https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Clone [this](https://github.com/Tyqo/rhino) Repo in the desired location.
3. Clone [Tusk](https://github.com/Tyqo/tusk) in `plugins/Tusk`
4. Run `composer install` for both.
5. Run `npm install && gulp build` for both
6. Make `tmp` writable.
7. Configure `config/app_local.php`
8. Run `bin/cake migrations migrate -p Tusk`
9. Default Login:

   ```
   User: Rhino
   Password: tusk
   ```
