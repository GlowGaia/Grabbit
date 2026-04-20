# Environment

This directory contains all files related to Gaia's "Environment" (Aquariums) namespace.

## Supported Methods

- `6500: Environment.getEnvironment`
- `6510: Environment.getUserEnvironment`
- `6511: Environment.getUserInhabitants`

## Code Examples

### Setup

```php
use GlowGaia\Grabbit\Common\Connectors\GSIConnector;

$connector = new GSIConnector();
```

### 6500: Environment.getEnvironment

```php
use GlowGaia\Grabbit\Environment\DTOs\Environment;
use GlowGaia\Grabbit\Environment\Requests\GetEnvironment;

$response = $connector->Environment->getEnvironment(1);
/** @var Environment $environment */
$environment = $response->dto();
```

### 6510: Environment.getUserEnvironment

```php
use GlowGaia\Grabbit\Environment\DTOs\UserEnvironment;
use GlowGaia\Grabbit\Environment\Requests\GetUserEnvironment;

$response = $connector->environment()->getUserEnvironment(9116373);
/** @var UserEnvironment $user_environment */
$user_environment = $response->dto();
```

### 6511: Environment.getUserInhabitants

```php
use GlowGaia\Grabbit\Environment\DTOs\Inhabitant;
use GlowGaia\Grabbit\Environment\Requests\GetUserInhabitants;
use Illuminate\Support\Collection;

$response->Environment()->getUserInhabitants(9116373);
/** @var Collection<Inhabitant> $inhabitants */
$inhabitants = $response->dto();
```