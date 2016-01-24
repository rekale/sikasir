<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF</li>8">
        <title>endpoint list</title>
    </head>
    <body>
        <h1>List EndPoint yang udah di bikin</h1>
        <pre>
        note:
	v1/owners?include=employees:per_page(15):current_page(1)
        maksud dari per_page(15) adalah data yang di ambil tiap page adalah 15 data,
        dan maksud current_page(1) adalah halaman paging saat ini

        default perPage : 15
        default current_page: 1

        
         </pre>
        link yg di bold adalah endpoint terbaru
        link yg di <i>italic</i> adalah endpint yg di edit
        
        <ul>
        <li> POST auth/login </li>
        <li> POST auth/mobile/login </li>	
        <li> POST auth/register </li>
        <br>
        <b><li> GET /?include=employees ,cashiers, outlets, products, taxes, categories, discounts, payments, printers</li></b>
        <br>
        <li> POST owners </li>
        <li> PUT owners/{id} </li>
        <li> DELETE owners/{id} </li>
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
        </b>
        <br>
        <li> GET outlets?include=employees, incomes,outcomes, customers, <b>variants, printers</b></li>
        <li> GET outlets/{id}?include=employees, incomes, outcomes, customers, <b>variants, printers</b>  </li>
        <br>
        <li> GET outlets/{id}/orders?include= items, items.stock, customer, user, discount, tax </li>
        <li> GET outlets/{id}/orders/void?include= items, items.stock, customer, user, discount, tax  </li>
        <li> GET outlets/{id}/orders/paid?include= items, items.stock, customer, user, discount, tax  </li>
        <li> GET outlets/{id}/orders/unpaid?include= items, items.stock, customer, user, discount, tax  </li>
        <br>
        <li>GET outlets/{id}/entries?include=operator, items, items.stock</li>
        <li>GET outlets/{id}/outs?include=operator, items, items.stock</li>
        <li>GET outlets/{id}/opnames?include=operator, items, items.stock</li>
        <li>GET outlets/{id}/purchases?include=supplier, items, items.stock</li>
        <br>
        <li> GET outlets/{id}/stocks?include=items</li>
        <br>
        <li> GET outlets/{id}/customers</li>
        <br>
        <li> GET outlets/{id}/incomes </li>
        <li> POST outlets/{id}/incomes </li>
        <li> DELETE outlets/{id}/incomes </li>
        <br>
        <li> GET outlets/{id}/outcomes </li>
        <li> POST outlets/{id}/outcomes </li>
        <li> DELETE outlets/{id}/outcomes </li>
        <li> POST outlets </li>
        <li> PUT outlets/{id} </li>
        <li> DELETE outlets/{id} </li>
        <br>
        <li> GET outlets/{id}/products </li> 
        <li> DELETE outlets/{id}/products/{id} </li> 
        <br>
        <li> GET products?include=variants </li>
        <li> GET products/{id}?include=variants </li>
        <li> POST products </li>
        <li> PUT products/{id} </li>
        <li> DELETE products/{id} </li>
        <br>
        <li> GET categories?include=products, products.variants </li>
        <li> PUT categories </li>
        <li> POST categories </li>
        <li> DELETE categories/{id} </li>
    </body>
</html>
