<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    public $items = [];

    public function __construct()
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $this->items = $cart->items;
        }
    }

    public function add(Course $course) 
    {
        if (isset($this->items[$course->id])) {
            $this->items[$course->id] = [
                'item' => $course,
                'qtd' => $this->items[$course->id]['qtd'] + 1,
            ];
        } else {
            $this->items[$course->id] = [
                'item' => $course, 
                'qtd' => 1,
            ];
        }
    }

    public function decrementItem(Course $course)
    {
        if (isset($this->items[$course->id])) {
            if ($this->items[$course->id]['qtd'] == 1) {
                unset($this->items[$course->id]);
            } else {
                $this->items[$course->id] = [
                    'item' => $course,
                    'qtd' => $this->items[$course->id]['qtd'] - 1,
                ];
            }
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function total()
    {
        $total = 0;

        if (count($this->items) == 0) {
            return $total;
        }

        foreach ($this->items as $item) {
            $subTotal = $item['item']->price * $item['qtd'];

            $total += $subTotal;
        }

        return $total;
    }

    public function totalItems()
    {
        return count($this->items);
    }
}
