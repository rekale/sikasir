<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\PurchaseOrder;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class PurchaseOrderTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    
    protected $availableIncludes = [
        'items',
        'supplier',
    ];

    public function transform(PurchaseOrder $purchase)
    {
        
        $data = [
            'id' => $this->encode($purchase->id),
            'note' => $purchase->note,
            'status' => (boolean) $purchase->status,
            'input_at' => $purchase->input_at,
        ];
        
        if (isset($purchase->pivot)) {
            $data['purchase_total'] = $purchase->pivot->total;
        }
        
        return $data;
    }
    
    public function includeItems(PurchaseOrder $purchase, ParamBag $params = null)
    {
       $collection = $purchase->items;
        
        return $this->collection($collection, new ItemTransformer);
    }
    
    public function includeSupplier(PurchaseOrder $purchase, ParamBag $params = null)
    {
       $item = $purchase->supplier;
        
        return $this->item($item, new SupplierTransformer);
    }
    
}
