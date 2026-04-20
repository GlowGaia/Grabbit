# Grabbit

Grabbit is a [Saloon](https://github.com/saloonphp/saloon)-based SDK for Gaia Online. The goal is to provide
developers with a more consistent and reliable way of interacting with Gaia's APIs, especially their [Game System
Interface (GSI)](https://gist.github.com/Butts/dc75175462eb5781ba34805405260f62).

```php
use GlowGaia\Grabbit\Common\Connectors\GSIConnector;
use GlowGaia\Grabbit\User\DTOs\UserInfo;
use GlowGaia\Grabbit\User\Requests\GetInfo;

$connector = new GSIConnector();
$response = $connector->user()->getInfo('Lanzer');

/** @var UserInfo $user */
$user = $response->dto();

$user->gaia_id; // 3
```

## Structure

Gaia's GSI methods all exist under certain "domains". For the purposes of everyone's sanity, this library maps to
those domains. The supported methods can be found by clicking into one of the domain folders and reading the README
file.

## Supported Domains

- [Environment](./src/Environment) (partial)
- [Inventory](./src/Inventory) (partial)
- [User](./src/User) (partial)

## License

Please note that this library (as of version 4) is licensed under the Mozilla Public License 2.0. You may want to read
Mozilla's [FAQ](https://www.mozilla.org/en-US/MPL/2.0/FAQ/) to learn about the license.

## Disclaimer

This project is not affiliated in any way with Gaia Online or Gaia Interactive.