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
        'supplier',
        'variants',
    ];

    public function transform(PurchaseOrder $purchase)
    {
        
        $data = [
            'id' => $this->encode($purchase->id),
            'po_number' => $purchase->po_number,
            'note' => $purchase->note,
            'input_at' => $purchase->input_at,
        ];
        
        if (isset($purchase->pivot)) {
            $data['total'] = $purchase->pivot->total;
        }
        
        return $data;
    }
    
    public function includevariants(PurchaseOrder $purchase, ParamBag $params = null)
    {
       $collection = $purchase->variants;
        
        return $this->collection($collection, new VariantTransformer);
    }
    
    public function includeSupplier(PurchaseOrder $purchase, ParamBag $params = null)
    {
       $item = $purchase->supplier;
        
        return $this->item($item, new SupplierTransformer);
    }
    
}
