# Laravel API Rest - Ejercicio sencillo

A continuación tenemos una secuencia de peticiones que se utilizarán para probar la API.

## Restablecer el estado antes de iniciar las pruebas

```
POST /reset
200 OK
```


## Restablecer el estado antes de iniciar las pruebas

```
GET /balance?account_id=1234
404 0
```

## Crear una cuenta con saldo inicial

```
POST /event {"type":"deposit", "destination":"100", "amount":10}
201 {"destination": {"id":"100", "balance":10}}
```

## Depósito en la cuenta existente

```
POST /event {"type":"deposit", "destination":"100", "amount":10}
201 {"destination": {"id":"100", "balance":20}}
```

## Obtener el saldo de la cuenta existente

```
GET /balance?account_id=100
200 20
```

## Retirar de una cuenta inexistente

```
POST /event {"type":"withdraw", "origin":"200", "amount":10}
404 0
```

## Retirar de la cuenta existente

```
POST /event {"type":"withdraw", "origin":"100", "amount":5}
201 {"origin": {"id":"100", "balance":15}}
```

## Transferencia desde una cuenta existente

```
POST /event {"type":"transfer", "origin":"100", "amount":15, "destination":"300"}
201 {"origin": {"id":"100", "balance":0}, "destination": {"id":"300", "balance":15}}
```

## Transferencia desde una cuenta inexistente

```
POST /event {"type":"transfer", "origin":"200", "amount":15, "destination":"300"}
404 0
```