<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Printer;
use \Sikasir\V1\Traits\IdObfuscater;
use League\Fractal\ParamBag;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class PrinterTransformer extends TransformerAbstract
{
    use IdObfuscater;
   
     protected $availableIncludes = [
        'outlet',
    ];


    public function transform(Printer $printer)
    {
        return [
            'id' => $this->encode($printer->id),
            'code' => $printer->code,
            'name' => $printer->name,
            'logo' => $printer->logo,
            'adddress' => $printer->address,
            'info' => $printer->info,
            'footer note' => $printer->footer_note,
            'size' => $printer->size,
        ];
        
    }
    
    public function includeOutlet(Printer $printer, ParamBag $params = null)
    {
        $item = $printer->outlet;
        
        return $this->item($item, new OutletTransformer);
    }
    
   

}
