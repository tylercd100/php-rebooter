# PHP Rebooter
[![Latest Version](https://img.shields.io/github/release/tylercd100/php-rebooter.svg?style=flat-square)](https://github.com/tylercd100/php-rebooter/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/tylercd100/php-rebooter.svg?branch=master)](https://travis-ci.org/tylercd100/php-rebooter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tylercd100/php-rebooter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tylercd100/php-rebooter/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tylercd100/php-rebooter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tylercd100/php-rebooter/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/56f3252c35630e0029db0187/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56f3252c35630e0029db0187)
[![Total Downloads](https://img.shields.io/packagist/dt/tylercd100/php-rebooter.svg?style=flat-square)](https://packagist.org/packages/tylercd100/php-rebooter)

This package will allow you to reboot, boot, and shutdown your servers remotely.

Currently supported:
- [Linode](https://www.linode.com)

Planned support for:
- [Amazon EC2](https://aws.amazon.com/ec2)
- SSH

## Installation

Install via [composer](https://getcomposer.org/) - In the terminal:
```bash
composer require tylercd100/php-rebooter
```

## Usage

```php
use Tylercd100\Rebooter\Api\LinodeRebooter;

$token = "secret";
$linode_id = 1234;

$server = new LinodeRebooter($token,$linode_id);

$server->reboot();
# or $server->boot();
# or $server->shutdown();

```
