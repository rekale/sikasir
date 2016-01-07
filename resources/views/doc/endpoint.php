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
        link yg di <b>bold</b> adalah endpoint terbaru
        link yg di <i>italic</i> adalah endpint yg di edit
        
        <ul>
        <li> POST auth/login </li>
        <li> POST auth/mobile/login </li>	
        <li> POST auth/register </li>
        <br>
        <li> GET owners?include=employees, cashiers, outlets, products, taxes, categories, <b>discounts</b> </li> 
        <li> GET owners/{id}?include=employees ,cashiers,outlets, products, taxes, categories, <b>discounts</b> </li>
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
        <li> GET cashiers </li>
        <li> GET cashiers/{id} </li>
        <li> POST cashiers </li>
        <li> PUT cashiers/{id} </li>
        <li> DELETE cashiers/{id} </li>
        <br>
        <li> GET outlets?include=employees, stocks, <b>stocks.items</b>, entries.items, incomes, outcomes, customers, <b>orders</b> </li>
        <li> GET outlets/{id}?include=employees, stocks, <b>stocks.items</b>, entries.items, incomes, outcomes, customers. <b>orders</b>  </li>
        <br>
        <li> <b>GET outlets/{id}?/orders?include= items, customer, user</b>  </li>
        <br>
        <li> <b>GET outlets/{id}?/orders/void?include= items, customer, user</b>  </li>
        <br>
        <li><b>GET outlets/{id}/entries?include=items</b></li>
        <li><b>GET outlets/{id}/outs?include=items</b></li>
        <br>
        <li> <b>GET outlets/{id}/stocks?include=entries, outs, items</b></li>
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
        <li> GET products </li>
        <li> GET products/{id} </li>
        <li> POST products </li>
        <li> PUT products/{id} </li>
        <li> DELETE products/{id} </li>
    </body>
</html>
