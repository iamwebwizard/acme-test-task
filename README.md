# Acme Widget Co Basket System

This is a proof of concept for a sales system for Acme Widget Co. It includes a basket class that handles product additions, calculates the total cost, and applies delivery charges and special offers.

## Features

- Products: Red Widget (R01), Green Widget (G01), Blue Widget (B01)
- Delivery Charges:
  - Orders under $50: $4.95
  - Orders under $90: $2.95
  - Orders $90 or more: Free delivery
- Special Offers:
  - "Buy one red widget, get the second half price" (R01)

## Usage

1. Clone the repository or copy the files to your local environment.
2. Ensure you have PHP installed.
3. Run `Basket.php` to see example usage and total calculations.

## Example

```php
$basket = new Basket($catalogue, $deliveryCharges, $offers);
$basket->add('B01');
$basket->add('G01');
echo "Total: $" . $basket->total() . "\n"; // Total: $37.85
```
