# Durjay Views

A simple view counter for Laravel. Track views for Blogs, Products, Services, and more in a single table using a helper function or a trait.

## Installation

You can install the package via composer:

```bash
composer require durjaygp/durjay-views
```

## Setup

1. Publish the migration:
```bash
php artisan vendor:publish --provider="Durjaygp\DurjayViews\DurjayViewsServiceProvider" --tag="migrations"
```

2. Run the migrations:
```bash
php artisan migrate
```

## Usage

### Using the Helper Function

You can easily track views for any entity using the provided global helper function:

```php
// Parameters: string $type, int $typeId
trackDurjayViews('product', $product->id);
trackDurjayViews('blog', $blog->id);
```

### Using the Trait

Alternatively, you can add the `Viewable` trait to your models:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Durjaygp\DurjayViews\Traits\Viewable;

class Product extends Model {
    use Viewable;
}
```

Then you can record a view directly on the model instance:

```php
$product->recordDurjayView();
```

To get the total view count (sum of all `views` increments):

```php
echo $product->view_count;
```
