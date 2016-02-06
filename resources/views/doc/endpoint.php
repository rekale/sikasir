<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF</li>8">
        <title>endpoint list</title>
    </head>
    <body>
        <h1>List EndPoint yang udah di bikin</h1>
        link yg di bold adalah endpoint terbaru
        link yg di <i>italic</i> adalah endpint yg di edit
        
        <ul>
        <li> POST auth/login </li>
        <li> POST auth/mobile/login </li>	
        <li> POST auth/register </li>
        <br>
        <li> GET /?include= users, outlets, taxes, categories, discounts, payments </li>
        <br>
        <li> POST owners </li>
        <li> PUT owners/{id} </li>
        <li> DELETE owners/{id} </li>
        <br>
        <b>
        <li> GET customers </li>
        <li> GET customers/{id} </li> // edit
        <li> POST customers </li>
        <li> PUT customers/{id} </li>
        <li> DELETE customers/{id} </li>
        <li>GET customers/{id}/histories{dateRange}</li> //contoh: sikasir.herokuapp.com/v1/customers/D/histories/2016-02-01,2017-12-01
        </b>
        <br>
        <br>
        <li> GET employees </li>
        <li> GET employees/{id} </li>
        <li> POST employees </li>
        <li> PUT employees/{id} </li>
        <li> DELETE employees/{id} </li>
        <br>
        <b>
        <li> GET suppliers </li>
        <li> GET suppliers/{id} </li>
        <li> POST suppliers </li>
        <li> PUT suppliers/{id} </li>
        <li> DELETE suppliers/{id} </li>
        <li>GET suppliers/{id}/purchases?include=variants</li>
        </b>
        <br>
        <li> GET outlets?include=users,printers</li>
        <li> GET outlets/{id}?include=users, printers</li>
        <br>
        <li> GET outlets/{id}/orders?include=<b>operator, items, items.variant, items.variant.product, items.variant.product.category </b> customer, discount, tax </li>
        <li> GET outlets/{id}/orders/void?include=<b>operator, items, items.variant, items.variant.product, items.variant.product.category </b> customer, discount, tax  </li>
        <li> GET outlets/{id}/orders/paid?include= <b>operator, items, items.variant, items.variant.product, items.variant.product.category </b> customer, discount, tax  </li>
        <li> GET outlets/{id}/orders/unpaid?include= <b>operator, items, items.variant, items.variant.product, items.variant.product.category </b> customer, discount, tax </li>
        <br>
        <li> GET outlets/{id}/products?include=category,variants </li> 
        <br>
        <li>GET outlets/{id}/entries?include=<b>operator, variants, variants.product, variants.product.category</b></li>
        <b><li>POST outlets/{id}/entries</li></b>
        <br>
        <li>GET outlets/{id}/outs?include=<b>operator, variants, variants.product, variants.product.category</b></li>
        <b><li>POST outlets/{id}/outs</li></b>
        <br>
        <li>GET outlets/{id}/opnames?include=<b>operator, variants, variants.product, variants.product.category</b></li>
        <b><li>POST outlets/{id}/opnames</li></b>
        <br>
        <li>GET outlets/{id}/purchases?include=<b>supplier, variants, variants.product, variants.product.category</b></li>
        <b><li>POST outlets/{id}/purchases</li></b>
        <br>
        <li> GET outlets/{id}/incomes </li>
        <li> POST outlets/{id}/incomes </li>
        <li> DELETE outlets/{id}/incomes </li>
        <br>
        <li> GET outlets/{id}/outcomes </li>
        <li> POST outlets/{id}/outcomes </li>
        <li> DELETE outlets/{id}/outcomes </li>
        <br>
        <li> POST outlets </li>
        <li> PUT outlets/{id} </li>
        <li> DELETE outlets/{id} </li>
        <br>
        <li> GET products/{id}?include=variants,<b> category</b> </li>
        <li> POST products </li>
        <li> PUT products/{id} </li>
        <li> DELETE products/{id} </li>
        <br>
        <li> GET categories?include=products, products.variants </li>
        <li> PUT categories </li>
        <li> POST categories </li>
        <li> DELETE categories/{id} </li>
        <br>
        <li> POST discounts </li>
        <li> PUT discounts/{id} </li>
        <li> DELETE discounts/{id} </li>
        <br>
        <br>
        <li> POST taxes </li>
        <li> PUT taxes/{id} </li>
        <li> DELETE taxes/{id} </li>
        <br>
        <br>
        <li> POST payments </li>
        <li> PUT payments/{id} </li>
        <li> DELETE payments/{id} </li>
        <br>
    </body>
</html>
