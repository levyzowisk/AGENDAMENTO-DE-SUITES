# Enpoints para o sistema de aluguel de suítes.

## Suítes

### GET api/suite/available

Retorna uma lista de suítes disponíveis para aluguel.

```
[
{
    "id": 1,
    "types": "simples",
    "amountPerHour": "100.00",
    "availableCount": 6,
    "features": ["TV", "Ar-condicionado"]
},
{
    "id": 2,
    "types": "duplo",
    "amountPerHour": "150.00",
    "availableCount": 4,
    "features": ["TV", "Ar-condicionado", "Frigobar"]
}
]
```


### GET api/suite/suite-map

Retorna um mapa de suítes com seus status atuais.

```
[
  {
    "id": 1,
    "type": "simples",
    "status": "FREE",
    "lastCleaning": "2025-02-25T05:00:00Z"
  },
  {
    "id": 5,
    "type": "premium",
    "status": "OCCUPIED",
    "checkInTime": 1740482400000,
    "timer": "02:15:10",
    "pendingMessages": 2
  },
  {
    "id": 8,
    "type": "plus",
    "status": "BOOKED",
    "booking": {
      "customerName": "João Silva",
      "scheduledTime": "14:30"
    }
  }
]
```

## Bookings (agendamentos)

### GET /api/bookings

Retorna o histórico e o status dos agendamentos.

```
[
  {
    "id": 50,
    "suiteId": 1,
    "scheduledTime": "2026-02-25T14:30:00Z",
    "checkInTime": "2026-02-25T14:45:00Z",
    "checkOutTime": null,
    "reservationFeePaid": 50.00,
    "status": "confirmed"
  }
]
```

## Consumables (consumiveis)

### GET /api/consumables

Lista os itens disponíveis para consumo e estoque atual.

```
[
  {
    "id": 10,
    "name": "Água Mineral",
    "amount": 5.00,
    "currentStock": 150
  },
  {
    "id": 11,
    "name": "Cerveja Lata",
    "amount": 8.50,
    "currentStock": 48
  }
]
```