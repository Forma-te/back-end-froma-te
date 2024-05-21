<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class CartPlan extends Model
{
    use HasFactory;

    public $items = [];

    public function __construct()
    {
        if (Session::has('cartPlan')) {
            $cartPlan = Session::get('cartPlan');
            $this->items = $cartPlan->items;
        }
    }

    public function add(Plan $plan)
    {
        if (isset($this->items[$plan->id])) {
            $this->items[$plan->id] = [
                'item' => $plan,
                'qtd' => $this->items[$plan->id]['qtd'] + 1,

            ];
        } else {
            $this->items[$plan->id] = [
                'item' => $plan,
                'qtd' => 1,
            ];
        }
    }

    public function decrementItem(Plan $plan)
    {
        if (isset($this->items[$plan->id])) {
            if ($this->items[$plan->id]['qtd'] == 1) {
                unset($this->items[$plan->id]);
            } else {
                $this->items[$plan->id] = [
                    'item' => $plan,
                    'qtd' => $this->items[$plan->id]['qtd'] - 1,
                ];
            }
        }
    }

    public function incrementItem(Plan $plan)
    {
        if (isset($this->items[$plan->id])) {
            $this->items[$plan->id] = [
                'item' => $plan,
                'qtd' => $this->items[$plan->id]['qtd'] + 1,

            ];
        } else {
            $this->items[$plan->id] = [
                'item' => $plan,
                'qtd' => 1,
            ];
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
}
