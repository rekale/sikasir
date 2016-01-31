<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF</li>8">
        <title>endpoint list</title>
    </head>
    <body>
        <h1>FORMAT POST / UPDATE</h1>
        <pre>
        
        --EMPLOYEE-- //staff atau manager

        {
            "name":"Dr. Willa Goldner", //required untuk post
            "title": "manager", //required untuk post
            "gender": "wanita", //required untuk post
            "email": "email@aku.com", //required untuk post dan harus unik
            "password": "12345", //required untuk post,
            "phone":"201.200.3668x8049", //required untuk post
            "outlet_id": [ "D", "L"], //required untuk post dan put, minimal harus ada 1 value di array
            "address":"45277 Haley Summit Apt. 223 South Elisa, MI 55720-5644", //required untuk post
            "void_access" : true, //required untuk post
            "privileges": [1, 2, 3, 4], // 1: produk 2:daftar transaksi dan daftar void 3: laporan 4:billing
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
        //jika product tidak punya variant
        {
            category_id": "D",
            "name": "rekale", 
            "description": "asu banget", 
            "barcode": "23424", 
            "unit" : "kg",
            "icon" : "http://lorempixel.com/200/100/food",
            "outlet_ids": ["L", "Z"], 
            "price_init" : 10000,  
            "price" : 234234,
            countable: true,
            "track_stock": true,
            "stock": 22,
            "alert": false,
            "alert_at": "10"
        }
        //jika punya variant
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
                    "icon" : "http://lorempixel.com/200/100/food"
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
                    "icon" : "http://lorempixel.com/200/100/food"
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
                    "icon" : "http://lorempixel.com/200/100/food"
                    "countable": false, 
                    "track_stock": false,
                    "stock": 0,
                    "alert": false,
                    "alert_at": "0"
                }
            ]
        }

        --CATEGORIES--
        {
            "name": "baju"
        }


        --ORDERS--
        POST|PUT v1/outlets/{id}/orders
        {
            "customer_id": "Z",
            "operator_id": "T", //required
            "payment_id": "D", //required
            "discount_id": "D",
            "tax_id" : "Z", //required
            "note": "lalala yeyeye",
            "total": 1000, //required, kalo ngutang valuenya isi 0 aja
            "paid": true, //field untuk menandakan ngutang atau enggak. kalo ini gak di isi defaultnya true
            "products": [
                {
                    "id" : "Z",
                    "quantity": 3
                },
                {
                    "id" : "L",
                    "quantity": 1
                }
            ]
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
        </pre>
    </body>
</html>
