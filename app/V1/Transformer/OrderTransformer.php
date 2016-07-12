<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Orders\Order;
use \Sikasir\V1\Traits\IdObfuscater;
use League\Fractal\ParamBag;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OrderTransformer extends TransformerAbstract
{
    use IdObfuscater;


    protected $availableIncludes = [
        'outlet',
        'operator',
        'customer',
        'variants',
        'tax',
        'discount',
        'void',
        'debt',
        'payment',
    ];

    public function transform(Order $order)
    {

        $data = [
            'id' => $this->encode($order->id),
            'no_order' => $order->no_order,
            'note' => $order->note,
            'created_at' => (string) $order->created_at,
        ];

        if( $this->isReport($order) )
        {
            $data = $data + [
                'calculation_type' => (int) $order->calculation_type,
                'customer_id' => $this->encode($order->customer_id),
                'customer_name' => $order->customer_name,
                'employee_id' => $this->encode($order->employee_id),
                'employee_name' => $order->employee_name,
                'employee_title' => $order->employee_title,
                'category_id' => $this->encode($order->category_id),
                'category_name' => $order->category_name,
                'product_id' => $this->encode($order->product_id),
                'product_name' => $order->product_name,
                'unit' => $order->unit,
                'variant_id' => $this->encode($order->variant_id),
                'variant_name' => $order->variant_name,
                'payment' => $order->payment,
                'tax_name' => $order->tax_name,
                'tax_amount' => (int) $order->tax_amount,
                'discount_name' => $order->discount_name,
                'discount_amount' => (int) $order->discount_amount,
                'order_total' => (int) $order->order_total,
                'gross_sales' => (int) $order->gross_sales,
                'gross_sales_weight' =>(float) $order->gross_sales_weight,
                'sales' => (int) $order->sales,
                'sales_weight' => (float) $order->sales_weight,
                'nego_sales' => (int) $order->sales_nego,
                'nego_sales_weight' => (int) $order->sales_nego_weight,
            ];
        }

        if(isset($order->pivot)) {
            $data['total'] = $order->pivot->total;
            $data['nego'] = $order->pivot->nego;
        }

        return $data;

    }

    public function includeVariants(Order $order, ParamBag $params = null)
    {
        $collection = $order->variants;

        return $this->collection($collection, new VariantTransformer);
    }

    public function includeCustomer(Order $order)
    {
        $item = $order->customer;


        return is_null($item) ? null  : $this->item($item, new CustomerTransformer);
    }

    public function includeOutlet(Order $order)
    {
        $item = $order->outlet;

        return $this->item($item, new OutletTransformer);
    }

    public function includeTax(Order $order)
    {
        $item = $order->tax;

        return $this->item($item, new TaxTransformer);
    }

    public function includeDiscount(Order $order)
    {
        $item = $order->discount;

        return is_null($item) ? null  : $this->item($item, new TaxTransformer);
    }

    public function includeOperator(Order $order)
    {
        $item = $order->operator;

        return $this->item($item, new UserTransformer);
    }

    public function includeVoid(Order $order)
    {
        $item = $order->void;


        return is_null($item) ? null  :  $this->item($item, new VoidTransformer);


    }

    public function includeDebt(Order $order)
    {
        $item = $order->debt;

        if(isset($item)) {
        	return $this->item($item, new DebtTransformer);
        }

    }

    public function includePayment(Order $order)
    {
        $item = $order->payment;

        return $this->item($item, new PaymentTransformer);
    }

    public function isReport($order)
    {
        return isset($order->calculation_type);
    }
}
