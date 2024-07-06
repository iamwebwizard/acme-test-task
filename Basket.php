<?php

class Basket {
    private $catalogue;
    private $deliveryCharges;
    private $offers;
    private $items = [];

    public function __construct($catalogue, $deliveryCharges, $offers) {
        $this->catalogue = $catalogue;
        $this->deliveryCharges = $deliveryCharges;
        $this->offers = $offers;
    }

    public function add($productCode) {
        if (!isset($this->catalogue[$productCode])) {
            throw new Exception("Invalid product code: $productCode");
        }
        $this->items[] = $productCode;
    }

    public function total() {
        $total = 0;
        $itemCounts = array_count_values($this->items);

        // Calculate the total price for each item, including offers
        foreach ($itemCounts as $code => $count) {
            $price = $this->catalogue[$code];
            if (isset($this->offers[$code])) {
                $offer = $this->offers[$code];
                $total += $this->applyOffer($offer, $price, $count);
            } else {
                $total += $price * $count;
            }
        }

        // Calculate delivery charge
        $deliveryCharge = $this->calculateDeliveryCharge($total);
        $total += $deliveryCharge;

        return number_format($total, 2);
    }

    private function applyOffer($offer, $price, $count) {
        if ($offer['type'] === 'buy_one_get_one_half') {
            $fullPriceCount = intdiv($count, 2) + $count % 2;
            $halfPriceCount = intdiv($count, 2);
            return $fullPriceCount * $price + $halfPriceCount * $price / 2;
        }
        return $price * $count;
    }

    private function calculateDeliveryCharge($total) {
        foreach ($this->deliveryCharges as $threshold => $charge) {
            if ($total < $threshold) {
                return $charge;
            }
        }
        return 0;
    }
}

// Sample data
$catalogue = [
    'R01' => 32.95,
    'G01' => 24.95,
    'B01' => 7.95,
];

$deliveryCharges = [
    50 => 4.95,
    90 => 2.95,
    PHP_INT_MAX => 0,
];

$offers = [
    'R01' => ['type' => 'buy_one_get_one_half'],
];

// Example usage
$basket = new Basket($catalogue, $deliveryCharges, $offers);
$basket->add('B01');
$basket->add('G01');
echo "Total: $" . $basket->total() . "\n";

$basket = new Basket($catalogue, $deliveryCharges, $offers);
$basket->add('R01');
$basket->add('R01');
echo "Total: $" . $basket->total() . "\n";

$basket = new Basket($catalogue, $deliveryCharges, $offers);
$basket->add('R01');
$basket->add('G01');
echo "Total: $" . $basket->total() . "\n";

$basket = new Basket($catalogue, $deliveryCharges, $offers);
$basket->add('B01');
$basket->add('B01');
$basket->add('R01');
$basket->add('R01');
$basket->add('R01');
echo "Total: $" . $basket->total() . "\n";

?>
