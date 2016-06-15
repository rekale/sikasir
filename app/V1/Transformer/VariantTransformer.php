<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Products\Variant;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class VariantTransformer extends TransformerAbstract
{
   use \Sikasir\V1\Traits\IdObfuscater;

    protected $availableIncludes = [
        'product',
        'orders',
    ];

    public function transform(Variant $variant)
    {

        $rules = [
            'id' => $this->encode($variant->id),
            'name' => $variant->name,
            'barcode' => $variant->barcode,
            'icon' => $variant->icon,
            'price_init'  => (int) $variant->price_init,
            'price' => (int) $variant->price,
            'countable' => (boolean) $variant->countable,
            'track_stock' => (boolean) $variant->track_stock,
            'stock' => (int) $variant->stock,
        	'current_stock' => (int) $variant->current_stock,
            'current_weight' => (float) $variant->current_weight,
            'alert' => (boolean) $variant->alert,
            'alert_at' => (int) $variant->alert_at,
        ];

        if (isset($variant->pivot)) {
            $foreign = explode('_', $variant->pivot->getForeignKey());

            $total = $foreign[0] . '_total';
            $rules[$total] = $variant->pivot->total;
            $weight = $foreign[0] . '_weight';
            $rules[$weight] = $variant->pivot->weight;
        }

        return $rules;
    }

    public function includeProduct(Variant $variant)
    {
        return $this->item($variant->product, new ProductTransformer);
    }

    public function includeOrders(Variant $variant)
    {
        return $this->collection($variant->orders, new OrderTransformer);
    }





}
