# Inventory

This directory contains all files related to Gaia's Inventory namespace.

## Supported Methods

- `712: Inventory.loadItemData`

## Code Examples

### Setup

```php
use GlowGaia\Grabbit\Common\Connectors\GSIConnector;
use GlowGaia\Grabbit\Inventory\DTOs\Item;
use GlowGaia\Grabbit\Inventory\Requests\LoadItemData;
use Illuminate\Support\Collection;

$connector = new GSIConnector();
```

### 712: Inventory.loadItemData

```php
// Get single Item By ID
$response = $connector->inventory()->loadItemData(1404);
/** @var Collection $items */
$items = $response->dto();
/** @var Item $item */
$item = $items->first();

// Get single Item By ID with package_item_ids
$response = $connector->inventory()->loadItemData(1404, true);
/** @var Collection $items */
$items = $response->dto();
/** @var Item $item */
$item = $items->first();

// Get multiple items by ID
$response = $connector->send(
    new LoadItemData([1425, 1426]),
);
/** @var Collection<Item> $items */
$items = $response->dto();
```