{"status":"true","msg":"Payment has been completed","data":{"id":"ch_3L3dZWJ02vlPsvqy0edo4iXS","object":"charge","amount":10000,"amount_captured":10000,"amount_refunded":0,"application":null,"application_fee":null,"application_fee_amount":null,"balance_transaction":"txn_3L3dZWJ02vlPsvqy0REybdIB","billing_details":{"address":{"city":null,"country":null,"line1":null,"line2":null,"postal_code":"44000","state":null},"email":null,"name":null,"phone":null},"calculated_statement_descriptor":"VIDEOATTENDANT","captured":true,"created":1653559538,"currency":"usd","customer":null,"description":"This payment is tested purpose phpcodingstuff.com","destination":null,"dispute":null,"disputed":false,"failure_balance_transaction":null,"failure_code":null,"failure_message":null,"fraud_details":[],"invoice":null,"livemode":false,"metadata":[],"on_behalf_of":null,"order":null,"outcome":{"network_status":"approved_by_network","reason":null,"risk_level":"normal","risk_score":39,"seller_message":"Payment complete.","type":"authorized"},"paid":true,"payment_intent":null,"payment_method":"card_1L3dZUJ02vlPsvqyvPY0vnEF","payment_method_details":{"card":{"brand":"visa","checks":{"address_line1_check":null,"address_postal_code_check":"pass","cvc_check":"pass"},"country":"US","exp_month":12,"exp_year":2022,"fingerprint":"odaOeLSsF1wwGcQR","funding":"credit","installments":null,"last4":"4242","mandate":null,"network":"visa","three_d_secure":null,"wallet":null},"type":"card"},"receipt_email":null,"receipt_number":null,"receipt_url":"https:\/\/pay.stripe.com\/receipts\/acct_1Kz28VJ02vlPsvqy\/ch_3L3dZWJ02vlPsvqy0edo4iXS\/rcpt_Ll9t693GkHSeJbduudXfUHHrrXWnEZU","refunded":false,"refunds":{"object":"list","data":[],"has_more":false,"total_count":0,"url":"\/v1\/charges\/ch_3L3dZWJ02vlPsvqy0edo4iXS\/refunds"},"review":null,"shipping":null,"source":{"id":"card_1L3dZUJ02vlPsvqyvPY0vnEF","object":"card","address_city":null,"address_country":null,"address_line1":null,"address_line1_check":null,"address_line2":null,"address_state":null,"address_zip":"44000","address_zip_check":"pass","brand":"Visa","country":"US","customer":null,"cvc_check":"pass","dynamic_last4":null,"exp_month":12,"exp_year":2022,"fingerprint":"odaOeLSsF1wwGcQR","funding":"credit","last4":"4242","metadata":[],"name":null,"tokenization_method":null},"source_transfer":null,"statement_descriptor":null,"statement_descriptor_suffix":null,"status":"succeeded","transfer_data":null,"transfer_group":null}}


{
  "status": "true",
  "msg": "Payment has been refunded",
  "data": {
    "id": "re_3L3dZWJ02vlPsvqy0XacO7N1",
    "object": "refund",
    "amount": 10000,
    "balance_transaction": "txn_3L3dZWJ02vlPsvqy0izBAX3X",
    "charge": "ch_3L3dZWJ02vlPsvqy0edo4iXS",
    "created": 1653560402,
    "currency": "usd",
    "metadata": [
      
    ],
    "payment_intent": null,
    "reason": null,
    "receipt_number": null,
    "source_transfer_reversal": null,
    "status": "succeeded",
    "transfer_reversal": null
  }
}