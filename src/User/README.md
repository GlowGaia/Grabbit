# User

This directory contains all files related to Gaia's User namespace.

## Supported Methods

- `102: User.getinfo`
- `107: User.authInfo`

## Code Examples

### Setup

```php
use GlowGaia\Grabbit\Common\Connectors\GSIConnector;

$connector = new GSIConnector();
```

### 102: User.getinfo

```php
use GlowGaia\Grabbit\User\DTOs\UserInfo;
use GlowGaia\Grabbit\User\Requests\GetInfo;

// Get User By ID
$response = $connector->user()->getInfo(3);
/** @var UserInfo $user */
$user = $response->dto();

// Get User By Username
$response = $connector->user()->getInfo('Lanzer');
/** @var UserInfo $user */
$user = $response->dto();

// Get User By Email Address
$response = $connector->user()->getInfo('example@example.com');
/** @var UserInfo $user */
$user = $response->dto();
```

### 107: User.authInfo

```php
use GlowGaia\Grabbit\User\DTOs\UserInfo;
use GlowGaia\Grabbit\User\Requests\AuthInfo;

$response = $connector->user()->authInfo('SESSION_ID');
/** @var UserInfo $user */
$user = $response->dto();
```