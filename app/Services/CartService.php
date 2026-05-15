<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'foodmenu_cart';

    public function getRestaurantId(): ?int
    {
        return Session::get(self::SESSION_KEY.'.restaurant_id');
    }

    /**
     * @return array<int, array{menu_item_id:int, qty:int}>
     */
    public function lines(): array
    {
        return Session::get(self::SESSION_KEY.'.lines', []);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function setRestaurant(Restaurant $restaurant): void
    {
        if ($this->getRestaurantId() !== null && $this->getRestaurantId() !== (int) $restaurant->getKey()) {
            $this->clear();
        }

        Session::put(self::SESSION_KEY.'.restaurant_id', (int) $restaurant->getKey());
        if (! Session::has(self::SESSION_KEY.'.lines')) {
            Session::put(self::SESSION_KEY.'.lines', []);
        }
    }

    public function setRestaurantTable(?int $restaurantTableId): void
    {
        if ($restaurantTableId === null) {
            Session::forget(self::SESSION_KEY.'.restaurant_table_id');

            return;
        }

        Session::put(self::SESSION_KEY.'.restaurant_table_id', $restaurantTableId);
    }

    public function getRestaurantTableId(): ?int
    {
        $id = Session::get(self::SESSION_KEY.'.restaurant_table_id');

        return $id !== null ? (int) $id : null;
    }

    public function addLine(Restaurant $restaurant, int $menuItemId, int $qty): void
    {
        $this->setRestaurant($restaurant);
        $lines = $this->lines();
        $found = false;

        foreach ($lines as $i => $line) {
            if ((int) $line['menu_item_id'] === $menuItemId) {
                $lines[$i]['qty'] = max(1, (int) $line['qty'] + $qty);
                $found = true;

                break;
            }
        }

        if (! $found) {
            $lines[] = ['menu_item_id' => $menuItemId, 'qty' => max(1, $qty)];
        }

        Session::put(self::SESSION_KEY.'.lines', $lines);
    }

    public function updateLine(Restaurant $restaurant, int $menuItemId, int $qty): void
    {
        $this->setRestaurant($restaurant);
        $lines = $this->lines();

        foreach ($lines as $i => $line) {
            if ((int) $line['menu_item_id'] === $menuItemId) {
                if ($qty <= 0) {
                    unset($lines[$i]);
                    $lines = array_values($lines);
                } else {
                    $lines[$i]['qty'] = $qty;
                }

                break;
            }
        }

        Session::put(self::SESSION_KEY.'.lines', $lines);
    }

    public function removeLine(Restaurant $restaurant, int $menuItemId): void
    {
        $this->updateLine($restaurant, $menuItemId, 0);
    }

    /**
     * @return array{subtotal: string, lines: array<int, array{item: MenuItem, qty: int, line_total: string}>}
     */
    public function summarize(Restaurant $restaurant): array
    {
        $lines = $this->lines();
        $items = [];
        $subtotal = 0;

        foreach ($lines as $line) {
            $item = MenuItem::query()
                ->where('restaurant_id', $restaurant->getKey())
                ->whereKey($line['menu_item_id'])
                ->where('is_available', true)
                ->first();

            if (! $item) {
                continue;
            }

            $qty = (int) $line['qty'];
            $lineTotal = (float) $item->price * $qty;
            $subtotal += $lineTotal;
            $items[] = [
                'item' => $item,
                'qty' => $qty,
                'line_total' => number_format($lineTotal, 2, '.', ''),
            ];
        }

        return [
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'lines' => $items,
        ];
    }
}
