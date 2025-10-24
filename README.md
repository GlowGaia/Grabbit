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

`composer require glowgaia/grabbit`

## Usage

### Supported Methods

For the supported methods, there will be helper classes for *creating* requests, and Data Transfer Objects (DTOs) for the responses. These DTOs will generally try to match the responses you'd expect from Gaia Online's GSI API, although there are some exceptions.

#### Users

You can grab a user by their ID, username, email address, or session ID.  
In response, you'll be given a `User` object that closely matches the GSI response data you'd get via GSI method `102`.

```php
$gaia = new GaiaConnector;
$request = GetUser::byId(3);

$lanzer = $request->createDtoFromResponse(
    $gaia->send($request)
);//User (DTO)
```

#### Items

You can grab an item by its ID.  
In response, you'll be given an `Item` object.

```php
$gaia = new GaiaConnector;
$request = GetItem::byId(1404);

$angelic_halo = $request->createDtoFromResponse(
    $gaia->send($request)
); //Item (DTO)
```

#### Aquariums (User Environments)
You can grab an aquarium by its ID.  
In response, you'll be given an `Environment` object.

```php
$gaia = new GaiaConnector;
$request = GetUserEnvironment::byId(9116373);

$user_environment = $request->createDtoFromResponse(
    $gaia->send($request)
); //UserEnvironment (DTO)
```

#### Aquarium Inhabitants
You can grab an aquarium's inhabitants by the Aquarium ID.  
In response, you'll be given a `Collection` of `Inhabitant` objects.

```php
$gaia = new GaiaConnector;
$request = GetInhabitants::byId(7);

$inhabitants = $request->createDtoFromResponse(
    $gaia->send($request)
); //RecursiveCollection<InhabitantDTO>
```

## License
Grabbit is open-source software licensed under the [MIT license](LICENSE).