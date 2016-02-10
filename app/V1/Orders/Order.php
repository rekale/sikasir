<?php

namespace Sikasir\V1\Orders;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Outlets\Discount;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Orders\Void;
use Sikasir\V1\Orders\Debt;

class Order extends Model
{
   
    
    protected $fillable = [
        'customer_id',
        'outlet_id',
        'user_id',
        'payment_id',
        'discount_id',
        'tax_id',
        'note',
        'nego',
        'paid',
    ];
    
    /**
     * Scope calculate the revenue and profit from orders 
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetRevenueAndProfit($query)
    {
        $query->selectRaw(
                    "orders.*, " .
                   "sum( (variants.price - order_variant.nego) * order_variant.total ) as revenue, " .
                   "sum( ( (variants.price - order_variant.nego) * order_variant.total ) " //revenue
                       . " - " //dikurang
                       . "(variants.price_init * order_variant.total) ) " //modal awal
                       . "as profit " //jadi profit
               )
               ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
               ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
               ->groupBy('orders.id')
               ->orderBy('revenue', 'desc')
               ->orderBy('profit', 'desc');
    }
    
    /**
     * get the order that has been voided
     * 
     * @param Builder $query
     * @param boolean $voided
     */
    public function scopeIsVoid($query)
    {
        $query->whereExists(
            function ($closureQuery)
            {
                $closureQuery->selectRaw(1)
                             ->from('voids')
                             ->whereRaw('voids.order_id = orders.id');
            }
        );
    }
    
    /**
     * get the order that is not void
     * 
     * @param Builder $query
     * @param boolean $voided
     */
    public function scopeIsNotVoid($query)
    {
        $query->whereNotExists(
            function ($closureQuery)
            {
                $closureQuery->selectRaw(1)
                             ->from('voids')
                             ->whereRaw('voids.order_id = orders.id');
            }
        );
    }
    
    
    /**
     * get the order that have debt
     * 
     * @param Builder $query
     * @param boolean $param
     */
    public function scopeHaveDebt($query)
    {
        $query->whereExists(
            function ($closureQuery)
            {
                $closureQuery->selectRaw(1)
                             ->from('debts')
                             ->whereRaw('debts.order_id = orders.id');
            }
        );
    }
    
    /**
     * get the order that have debt
     * 
     * @param Builder $query
     * @param boolean $param
     */
    public function scopeDontHaveDebt($query)
    {
        $query->whereNotExists(
            function ($closureQuery)
            {
                $closureQuery->selectRaw(1)
                             ->from('debts')
                             ->whereRaw('debts.order_id = orders.id');
            }
        );
    }
    
    
    /**
     * 
     * @param Builder $query
     * @param integer $companyId
     */
    public function scopeOnlyFromCompany($query, $companyId)
    {
        $query->whereExists(
            function ($closureQuery) use($companyId) {
                $closureQuery->selectRaw(1)
                      ->from('outlets')
                      ->where('company_id', '=', $companyId)
                      ->whereRaw('outlets.id = orders.outlet_id');
        });
    }
    
    /**
     * 
     * @param Builder $query
     * @param array $dateRange
     */
    public function scopeDateRange($query, $dateRange)
    {
        $query->whereBetween('orders.created_at', $dateRange);
    }
    
    /**
     * 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    
    public function variants()
    {
        return $this->belongsToMany(Variant::class)
                    ->withPivot(['total', 'nego'])
                    ->withTimestamps();
    }
    
    
    public function void()
    {
        return $this->hasOne(Void::class);
    }
    
    public function debt()
    {
        return $this->hasOne(Debt::class);
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
     
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    
}
