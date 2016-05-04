<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>endpoint list</title>
    </head>
    <body>
        <h1>FORMAT POST / UPDATE</h1>
        <pre>
        
        --EMPLOYEE-- //staff atau manager

        {
            "name":"Dr. Willa Goldner",
            "title": 1, //1. manager/staff 2.kasir
            "gender": "wanita",
            "email": "email@aku.com",
            "password": "12345",
            "phone":"201.200.3668x8049",
            "outlet_id": [ "D", "L"],
            "address":"45277 Haley Summit Apt. 223 South Elisa, MI 55720-5644",
            "void_access" : true,
            "privileges": [1, 2, 3, 4, 5]
        }

        --CUSTOMER-- 

        {
            "name":"Dr. Willa Goldner",
            "email": "email@aku.com",
            "sex": "male",
            "phone":"201.200.3668x8049",
            "address":"45277 Haley Summit Apt. 223 South Elisa, MI 55720-5644",
            "city": "jakarta",
            "pos_code": "12345"
        }

        --OUTLET--

        {
            "name": "kfc",
            "code": "1234",
            "business_field_id": "D",
            "tax_id": "Z",
            "address": "01815 Wallace Flats Suite 760\nSouth Nyahburgh, NE 05239-4018",
            "province": "quos",
            "city": "South Elizaview",
            "pos_code": "MQ",
            "phone1": "+56(2)4639380169",
            "phone2": "(115)548-8064"
        }

        --PRODUCT-- //POST
        {
            "category_id": "D",
            "name": "rekale", 
            "description": "asu banget", 
            "unit": "kg",
            "icon" : "http://lorempixel.com/200/100/food",
            "outlet_ids": ["L", "Z"], 
            "variants": [
                {
                    "name": "kampret", 
                    "barcode": "34234",
                    "price_init" : 10000,  
                    "price" : 234234,
                    "icon" : "http://lorempixel.com/200/100/food",
                    "countable": true,
                    "track_stock": true,
                    "stock": 22,
                    "alert": false,
                    "alert_at": "10"
                },
                {
                    "name": "kampret", 
                    "barcode": "34234", 
                    "price_init" : 10000,
                    "price" : 234234,
                    "icon" : "http://lorempixel.com/200/100/food",
                    "countable": true, 
                    "track_stock": true,
                    "stock": 22,
                    "alert": true,
                    "alert_at": "10"
                },

                {
                    "name": "kampret", 
                    "barcode": "34234", 
                    "price_init" : 10000,
                    "price" : 234234,
                    "icon" : "http://lorempixel.com/200/100/food",
                    "countable": false, 
                    "track_stock": false,
                    "stock": 0,
                    "alert": false,
                    "alert_at": "0"
                }
            ]
        }

        --PRODUCT-- //PUT
        {
            "category_id": "D",
            "name": "rekale", 
            "description": "asu banget", 
            "unit": "kg",
            "icon" : "http://lorempixel.com/200/100/food",
            "variants": [
                {
                    "id": "D",
                    "name": "kampret", 
                    "barcode": "34234",
                    "price_init" : 10000,  
                    "price" : 234234,
                    "icon" : "http://lorempixel.com/200/100/food",
                    "countable": true,
                    "track_stock": true,
                    "stock": 22,
                    "alert": false,
                    "alert_at": "10"
                },
                {
                    "id": "Z"
                    "name": "kampret", 
                    "barcode": "34234", 
                    "price_init" : 10000,
                    "price" : 234234,
                    "icon" : "http://lorempixel.com/200/100/food",
                    "countable": true, 
                    "track_stock": true,
                    "stock": 22,
                    "alert": true,
                    "alert_at": "10"
                },
                {//bikin baru, gak pake id
                    "name": "kampret", 
                    "barcode": "34234", 
                    "price_init" : 10000,
                    "price" : 234234,
                    "icon" : "http://lorempixel.com/200/100/food",
                    "countable": true, 
                    "track_stock": true,
                    "stock": 22,
                    "alert": true,
                    "alert_at": "10"
                },
            ]
        }

        --CATEGORIES--
        {
            "name": "baju",
            "description: "lalala yeyeye"
        }


        --ORDERS--
        POST|PUT v1/outlets/{id}/orders
        {
            "customer_id": "Z",
            "user_id": "T", //required
            "payment_id": "D", //required
            "discount_id": "L",
            "no_order": 001,
            "tax_id" : "Z", //required
            "note": "lalala yeyeye",
            "variants": [
                {
                    "id" : "Z",
                    "quantity": 3,
                    "nego":2000
                },
                {
                    "id" : "L",
                    "quantity": 1,
                    "nego": 2000
                }
            ],
        }
		
		--VOID ORDER--
		{
			"note": "asdfsafasd"
		}
		
		--DEBT ORDER--
		{
			"due_date": "2016-05-01",
			"total": 123453,
		}
		
        --SUPPLIER--
        {
            "name": "sukajaya",
            "email": "sukajaya@gmail.com",
            "phone": "12345688",
            "address": "dimana mana"
        }

        --ENTRY/OUT --
{
    "user_id": "Z",
    "note": "asdfadgsaf",
    "input_at": "2016-01-08",
    "variants": [
        {
            "id" : "Z",
            "total": 3
        },
        {
            "id" : "L",
            "total": 4
        }
    ]
}

        --OPNAME --
{
    "user_id": "Z",
    "note": "asdfadgsaf",
    "input_at": "2016-01-08",
    "status" :true,
    "variants": [
        {
            "id" : "Z",
            "total": 3
        },
        {
            "id" : "L",
            "total": 4
        }
    ]
}

        --PURCHASE ORDER --
    {
        "supplier_id": "Z",
        "po_number": "12345",
        "note": "asdfadgsaf",
        "input_at": "2016-01-08",
        "variants": [
            {
                "id" : "Z",
                "total": 3
            },
            {
                "id" : "L",
                "total": 4
            }
        ]
    }

--DISCOUNT/TAX--
{
    "name": "diskon aja",
    "amount": 7
}

--PAYMENT--
{
    "name": "diskon aja",
    "description": "lalala"
}

--PRINTER--
{
    "code": "234",
    "name": "asdfaf",
    "logo": "asdfasdfsa.jpg",
    "address": "dimana mana",
    "info": "yeyeye",
    "footer_note": "asdfsa",
    "size": 1 //1.A4 2.	Receipt Paper Roll
}

--INCOME/OUTCOME--
{
	"total": 40000,
	"note": "asdfasfdsafasdfsad"
}

        </pre>
    </body>
</html>
