## Webhook server for debugging callback events and payloads.

> Imagine you need to debug callback url payload for your development purpose.



## Usages


**Ping our callback server to make sure its live.**

`POST /api/ping`

`GET /api/ping`

**Request**
```curl
    curl -X POST http://localhost:8001/api/ping
```


**Response**

```json
{
    "status_code": 200,
    "message": "OK"
}
```


**Initiate request session for callback url and use generated callback url to pass to your provider.**

`POST /api/initiate`


**Request**
```curl
curl -X POST http://localhost:8001/api/initiate

```


**Response**

```json
{
    "data": {
        "request_datetime": "2021-02-08T10:39:57.253936Z",
        "updated_at": "2021-02-08T10:39:57.000000Z",
        "created_at": "2021-02-08T10:39:57.000000Z",
        "id": 4,
        "request_id": "1D67rjzKprnpGLMnmVaO",
        "callback_url": "http://localhost:8001/api/callback/send/1D67rjzKprnpGLMnmVaO"
    },
    "status_code": 201
}
```

### Listen to received status on our request session.


`POST /api/verify`

**Request**

```curl
   curl -X POST http://localhost:8001/api/verify \
   -H"content-type: application/json" \
   -d '{"request_id": "1D67rjzKprnpGLMnmVaO"}'

```


**Response**


```json
{
    "data": {
        "id": 3,
        "user_id": null,
        "request_id": "90L1V7M3YvEy5ajwmKPO",
        "payload": {
            "data": "this is data from callback server"
        },
        "request_headers": {
            "host": [
                "localhost:8001"
            ],
            "user-agent": [
                "curl/7.64.1"
            ],
            "accept": [
                "*/*"
            ],
            "content-type": [
                "application/json"
            ],
            "content-length": [
                "45"
            ]
        },
        "request_datetime": "2021-02-08 10:18:08",
        "received_datetime": "2021-02-08 10:24:34",
        "received": true,
        "created_at": "2021-02-08T10:18:08.000000Z",
        "updated_at": "2021-02-08T10:24:34.000000Z",
        "callback_url": "http://localhost:8001/api/callback/send/90L1V7M3YvEy5ajwmKPO"
    }
}
```