<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>endpoint list</title>
    </head>
    <body>
        <h1>List EndPoint yang udah di bikin</h1>
        link yg di bold adalah endpoint terbaru
        link yg di <i>italic</i> adalah endpint yg di edit
        
       	parameter di GET yg bisa dipakai: include, order_by:{field}|asc/desc
        
        <ul>
        <li> POST auth/login </li>
        <li> POST auth/refresh </li>
        <li> POST auth/mobile/login </li>	
        <li> POST auth/register </li>
        <br>
        <li> GET /?include= users, outlets, taxes, categories, discounts, payments </li>
        <li> GET /business_field </li>
        <br>
        <li> POST owners </li>
        <li> PUT owners/{id} </li>
        <li> DELETE owners/{id} </li>
        <br>
        
        <li> GET customers </li>
        <li> GET customers/search/{field}/{word} </li>//contoh jika ingin mencari nama customer: customers/search/name/agus
        <li> GET customers/{id} </li>
        <li> POST customers </li>
        <li> PUT customers/{id} </li>
        <li> DELETE customers/{id} </li>
        <li>GET customers/{id}/histories/{dateRange}</li> //contoh: sikasir.herokuapp.com/v1/customers/D/histories/2016-02-01,2017-12-01
        
        <br>
        <br>
        <li> GET employees?include=abilities </li>
        <li> GET employees/search/{field}/{word} </li>
        <li> GET employees/{id}/reports/{dateRange}</li>
       	<li> GET employees/reports/{dateRange}</li>
        <li> GET employees/{id}?include=abilities </li>
        <li> POST employees </li>
        <li> PUT employees/{id} </li>
        <li> DELETE employees/{id} </li>
        <br>
        
        <li> GET suppliers </li>
        <li> GET suppliers/search/{field}/{word} </li>
        <li> GET suppliers/{id} </li>
        <li> POST suppliers </li>
        <li> PUT suppliers/{id} </li>
        <li> DELETE suppliers/{id} </li>
        <li>GET suppliers/{id}/purchases?include=variants</li>
        <li>GET suppliers/{id}/purchases/search/{field}/{word}?include=variants</li>
        
        <br>
        <li> GET outlets?include=users,printers</li>
        <li> GET outlets/search/{field}/{word} </li>
        <li> GET outlets/{id}?include=users, printers</li>
        <br>
        <li> GET outlets/all/orders/{dateRange}?include= outlet, operator, variants.product.category, customer, discount, tax, payment </li>
        <li> GET outlets/{id}/orders/{dateRange}?include= operator, variants.product.category  customer, discount, tax, payment </li>
         
        <li> GET outlets/all/orders/{dateRange}/void?include= operator,variants.product.category, customer, discount, tax, payment  </li>
        <li> GET outlets/{id}/orders/{dateRange}/void?include= operator,variants.product.category, customer, discount, tax, payment  </li>
        
        <li> GET outlets/all/orders/{dateRange}/debt?include= debt, operator, variants.product.category  customer, discount, tax, payment  </li>
        <li> GET outlets/{id}/orders/{dateRange}/debt?include= debt, operator, variants.product.category  customer, discount, tax, payment  </li>
        
        <li> GET outlets/all/orders/{dateRange}/debt-settled?include= debt, operator, variants.product.category  customer, discount, tax, payment </li>
        <li> GET outlets/{id}/orders/{dateRange}/debt-settled?include= debt, operator, variants.product.category  customer, discount, tax, payment </li>
        
        <li> POST outlets/{id}/orders</li>
        <li> PUT orders/{id}/void</li>
        <li> PUT orders/{id}/debt</li>
        <li> PUT orders/{id}/debt-settled</li>
        
        
        <br>
        <li> GET outlets/all/products/reports/{dateRange}?include=outlet,category,variants </li>
        <li> GET outlets/{id}/products/reports/{dateRange}?include=outlet,category,variants </li>
        <li> GET outlets/{outletId}/products/reports/{dateRange}/best-seller</li>
        <br>
        <li> GET outlets/all/categories/reports/{dateRange}</li>
        <li> GET outlets/{id}/categories/reports/{dateRange}</li>
        <br>
        <li> GET outlets/all/payments/reports/{dateRange}</li>
        <li> GET outlets/{id}/payments/reports/{dateRange}</li>
        <br>
        <li> GET outlets/all/products?include=outlet,category,variants </li>
        <li> GET outlets/{id}/products?include=category,variants </li>
        <li> GET outlets/{outletId}/products/{productId}?include=category,variants </li>
        <li> PUT outlets/{outletId}/products/{productId} </li>
        <li> DELETE outlets/{outletId}/products/{productId} </li>
        <br>
        <li>GET outlets/{id}/entries?include=operator, variants.product.category</li>
        <li>GET outlets/{id}/entries/{id}</li>
        <li>GET outlets/{id}/entries/search/{field}/{word}</li>
        <li>POST outlets/{id}/entries</li>
        <br>
        <li>GET outlets/{id}/outs?include=operator, variants.product.category</li>
       	<li>GET outlets/{id}/outs/{id}</li>
        <li>GET outlets/{id}/entries/search/{field}/{word}</li>
        <li>POST outlets/{id}/outs</li>
        <br>
        <li>GET outlets/{id}/opnames?include=operator, variants.product.category</li>
        <li>POST outlets/{id}/opnames</li>
        <br>
        <li>GET outlets/{id}/purchases?include=supplier, variants.product.category</li>
        <li>GET outlets/{id}/purchases/{id}</li>
        <li>POST outlets/{id}/purchases</li>
        <br>
        <li> GET outlets/{id}/incomes </li>
         <li> GET outlets/{id}/incomes/search/{field}/{word} </li>
        <li> POST outlets/{id}/incomes </li>
        <li> DELETE outlets/{id}/incomes </li>
        <br>
        <li> GET outlets/{id}/outcomes </li>
        <li> GET outlets/{id}/outcomes/search/{field}/{word} </li>
        <li> POST outlets/{id}/outcomes </li>
        <li> DELETE outlets/{id}/outcomes </li>
        <br>
        <br>
        <li> GET outlets/{id}/printers</li>
        <li> GET outlets/{id}/printers/{printerId} </li>
        <li> GET outlets/{id}/printers/search/{field}/{word} </li>
        <li> POST outlets/{id}/printers </li>
        <li> PUT outlets/{id}/printers/{printerId} </li>
        <li> DELETE outlets/{id}/printers/{printerId} </li>
        <br>
        <li> POST outlets </li>
        <li> DELETE outlets/{id} </li>
        <br>
        <li> POST categories/{id}/products </li>
        <li> PUT categories/{categoryId}/products/{id} </li>
        <li> DELETE categories/{categoryId}/products/{id} </li>
        <li> DELETE variants/{id} </li>
        <br>
        <li> GET categories/{id}?include=products, products.variants </li>
        <li> GET categories/search/{field}/{word} </li>
        <li> PUT categories </li>
        <li> POST categories </li>
        <li> DELETE categories/{id} </li>
        <br>
        <li> get discounts/{id} </li>
        <li> GET discounts/search/{field}/{word} </li>
        <li> POST discounts </li>
        <li> PUT discounts/{id} </li>
        <li> DELETE discounts/{id} </li>
        <br>
        <br>
        <li> GET taxes/{id} </li>
        <li> GET taxes/search/{field}/{word} </li>
        <li> POST taxes </li>
        <li> PUT taxes/{id} </li>
        <li> DELETE taxes/{id} </li>
        <br>
        <br>
        <li> GET payments </li>
        <li> GET payments/{id} </li>
        <li> GET payments/search/{field}/{word} </li>
        <li> POST payments </li>
        <li> PUT payments/{id} </li>
        <li> DELETE payments/{id} </li>
        <br>
    </body>
</html>
