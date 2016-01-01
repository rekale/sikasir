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
	v1/owners?include=employees:limit(15|1)
	maksud limit di sebelah employees berfungsi untuk mengambil data employees maksimal 15, dari id no 1
	jadi kalo employees:limit(10|5) artinya ambil data employees 10 di mulai dari id no 5
	
	kyk gini juga bisa
	v1/owners?include=employees:limit(15|1),cashiers(10),outlet:limit(5)
	
	default limit itu (15|1), jadi kalo link kyk gini
	v1/owners?include=employees
	sama aja kayak gini
	v1/owners?include=employees:limit(15|1)
        </pre>
        <ul>
        <li> POST auth/login </li>
        <li> POST auth/mobile/login </li>	
        <li> POST auth/register </li>
        <br>
        <li> GET owners?include=employees, cashiers, outlets, products, taxes </li> 
        <li> GET owners/{id}?include=employees ,cashiers,outlets, products, taxes </li>
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
        <li> GET outlets?include=employees, stocks, entries.stocks, incomes, outcomes, customers</li>
        <li> GET outlets/{id}?include=employees, stocks, entries.stocks, incomes, outcomes, customers </li>
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
