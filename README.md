# Durjay Views

A simple, polymorphic view counter for Laravel. Track views for Blogs, Products, and Homepages in a single table.

## Installation
composer require durjaygp/durjay-views

## Setup
1. Publish migration:
php artisan vendor:publish --provider="Durjaygp\DurjayViews\DurjayViewsServiceProvider" --tag="migrations"

2. Run migration:
php artisan migrate

## Usage
Add the trait to your model:
use Durjaygp\DurjayViews\Traits\Viewable;

class Product extends Model {
    use Viewable;
}

Record a view in your controller:
$product->recordView();

Get total views:
echo $product->view_count;
