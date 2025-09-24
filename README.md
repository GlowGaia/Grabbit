# Grabbit

Grabbit delivers developers a simple way to retrieve data from Gaia Online. It's built with [Saloon](https://github.com/saloonphp/saloon), and provides a convenient API for making GSI requests, and sane DTOs in response.

**Note: This project is not affiliated with Gaia Online or Gaia Interactive in any way.**

## About
### Why Grabbit?

- Interacting with Gaia Online's GSI API is a huge pain.
- There are no official libraries for interacting with the GSI API.
- Grabbit makes interacting with the GSI API delightful
- There is nobody else in this market

### Why "Grabbit"?

It's a play on Gaia's famous "Grunny" character. Plus, it breaks down into "grab" and "it" - which is funny for making and sending API requests.

## Installation

`composer require saloonlabs/grabbit`

## Usage

### Supported Methods

For the supported methods, there will be helper classes for *creating* requests, and Data Transfer Objects (DTOs) for the responses. These DTOs will generally try to match the responses you'd expect from Gaia Online's GSI API, although there are some exceptions.

#### Users

You can grab a user by their ID, username, email address, or session ID.  
In response, you'll be given a `UserDTO` object that closely matches the GSI response data you'd get via GSI method `102`.

```php
$lanzer = Grabbit::grab(GetUser::byId(3)); //UserDTO
```

#### Items

You can grab an item by its ID.  
In response, you'll be given an `ItemDTO` object.

```php
$angelic_halo = Grabbit::grab(GetItem::byId(1404)); //ItemDTO
```

#### Aquariums (User Environments)
You can grab an aquarium by its ID.  
In response, you'll be given an `AquariumDTO` object.

```php
$aquarium = Grabbit::grab(GetUserEnvironment::byId(9116373)); //UserEnvironmentDTO
```

#### Aquarium Inhabitants
You can grab an aquarium's inhabitants by the Aquarium ID.  
In response, you'll be given a `Collection` of `InhabitantDTO` objects.

```php
$inhabitants = Grabbit::grab(GetInhabitants::byId(9116373)); //Collection<InhabitantDTO>
```

### Multiple Requests

You can make multiple requests at once by providing an array to the `grab` method.  
In response, you'll be given a `Collection` of `DTO` objects.

```php
$aquarium = Grabbit::grab([
    GetUserEnvironment::byId(9116373),
    GetInhabitant::byId(9116373),
]);//Collection<UserEnvironmentDTO, InhabitantDTO>
```

### Unsupported Methods

Grabbit exists as a wrapper around Saloon. As such, if you need to make GSI requests that are not supported, you can take advantage of the `GSIRequest` class directly.

```php
$connection = new GaiaConnector();
$operation = new GSIOperation(2100);
$request = new GSIRequest(collect([$operation]));

$online_users = $connection->send($request)->json();
```

## License
Grabbit is open-source software licensed under the [MIT license](LICENSE).