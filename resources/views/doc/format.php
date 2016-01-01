<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF</li>8">
        <title>endpoint list</title>
    </head>
    <body>
        <h1>FORMAT POST / UPDATE</h1>
        <pre>
        --OWNER--
        {
            "name":"Dr. Willa Goldner", //required untuk post
            "email": "email@baru.com", //required untuk post dna harus unik
            "password": "12345", //required untuk post
            "business_name":"Morissette and Sons", //required untuk post
            "phone":"201.200.3668x8049", //required untuk post
            "address":"45277 Haley Summit Apt. 223\nSouth Elisa, MI 55720-5644", //required untuk post
            "active":true   //required untuk post  
        }

        --EMPLOYEE-- //staff atau manager

        {
            "name":"Dr. Willa Goldner", //required untuk post
            "title": "manager", //required untuk post
            "gender": "wanita", //required untuk post
            "email": "email@aku.com", //required untuk post dan harus unik
            "password": "12345", //required untuk post
            "phone":"201.200.3668x8049", //required untuk post
            "outlet_id": [ "D", "L"], //required untuk post dan put, minimal harus ada 1 value di array
            "address":"45277 Haley Summit Apt. 223\nSouth Elisa, MI 55720-5644", //required untuk post
            "void_access" : true //required untuk post
        }

        --CASHIER--
        {
            "name" : "rekale", //required untuk post
            "gender": "pria", //required untuk post
            "email" : "rekale@asu1.com", //required untuk post dan harus unik
            "password": "12345", //required untuk post
            "outlet_id": "D", //required untuk post
            "business_name" :"tukang bakso", //required untuk post
            "phone" :"087808738790", //required untuk post
            "address" :"dimana aja lah" //required untuk post
        }

        --OUTLET--

        {
            "name": "kfc", //required untuk post
            "code": "1234", //required untuk post
            "business_field_id": "D", //required untuk post
            "tax_id": "Z",
            "address": "01815 Wallace Flats Suite 760\nSouth Nyahburgh, NE 05239-4018",
            "province": "quos",
            "city": "South Elizaview",
            "pos_code": "MQ",
            "phone1": "+56(2)4639380169",
            "phone2": "(115)548-8064"
        }

        --PRODUCT--
        {
            "category_id": "D",
            "name": "rekale", 
            "description": "asu banget", 
            "barcode": "23424", 
            "unit" : "kg",
            "variants": [
                {
                    "name": "kampret", 
                    "code": "34234", 
                    "price" : 234234, 
                    "track_stock": true,
                    "stock": 22,
                    "alert": false,
                    "alert_at": "10"
                },
                {
                    "name": "kampret", 
                    "code": "34234", 
                    "price" : 234234, 
                    "track_stock": true,
                    "stock": 22,
                    "alert": true,
                    "alert_at": "10"
                },

                {
                    "name": "kampret", 
                    "code": "34234", 
                    "price" : 234234, 
                    "track_stock": true,
                    "stock": 22,
                    "alert": true,
                    "alert_at": "10"
                }
            ]
        }

        --STOCK ENTRY--
        {
            date: ,
            note: ,
            "variants": [
                {
                    "id": "D",
                    "total": 10
                },
                {
                    "id": "D",
                    "total": 10 
                },

                {
                    "id": "D",
                    "total": 10
                }
            ]

        }
        </pre>
    </body>
</html>
