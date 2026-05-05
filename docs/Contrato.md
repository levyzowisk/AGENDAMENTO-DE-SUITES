# Enpoints para o sistema de aluguel de suítes.

## Suítes

### GET api/suite

Retorna uma lista de suítes disponíveis para aluguel.

```
[
{
    "id": 1,
    "type": "simples",
    "amountPerHour": "100.00",
    "availableCount": 6,
    "features": ["TV", "Ar-condicionado"]
},
{
    "id": 2,
    "type": "duplo",
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

## Schedules (Agendamentos)

### GET /api/schedules

Retorna o histórico e o status dos agendamentos.

```json
[
  {
    "id": 1,
    "user_id": 1,
    "suite_id": 1,
    "suite_unit_id": 2,
    "check_in": "2026-05-10T14:00:00Z",
    "check_out": "2026-05-12T12:00:00Z",
    "status": "PENDING",
    "total_price": "150.00",
    "notes": "Preparar decoração romântica",
    "created_at": "2026-05-05T19:30:00.000000Z",
    "updated_at": "2026-05-05T19:30:00.000000Z"
  }
]
```

### POST /api/schedules

Cria um novo agendamento.

```json
{
  "user_id": 1,
  "suite_id": 1,
  "suite_unit_id": 2,
  "check_in": "2026-05-10 14:00:00",
  "check_out": "2026-05-12 12:00:00",
  "status": "PENDING",
  "total_price": 150.00,
  "notes": "Preparar decoração romântica"
}
```

### GET /api/schedules/{id}

Retorna os detalhes de um agendamento específico.

```json
{
  "id": 1,
  "user_id": 1,
  "suite_id": 1,
  "suite_unit_id": 2,
  "check_in": "2026-05-10T14:00:00Z",
  "check_out": "2026-05-12T12:00:00Z",
  "status": "PENDING",
  "total_price": "150.00",
  "notes": "Preparar decoração romântica",
  "created_at": "2026-05-05T19:30:00.000000Z",
  "updated_at": "2026-05-05T19:30:00.000000Z"
}
```

### PATCH /api/schedules/{id}

Edita as informações de um agendamento.

```json
{
  "status": "CONFIRMED",
  "notes": "Nova observação para a reserva"
}
```

### DELETE /api/schedules/{id}

Deleta um agendamento específico.


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
&ensp;

## Gestão de Equipe (Usuários)

### GET api/users

Retorna a lista de usuários cadastrados

```
[
  {
    "id": 1,
    "name": "Fulano de tal",
    "email": "fulanodetal@email.com",
    "role": {
      "id": 1,
      "name": "admin": {
        "permissions": [
          {"id": 1, name: "create_user"},
          {"id": 2, name: "edit_user"},
          {"id": 3, name: "create_suite"},
          {"id": 4, name: "edit_suite"},
        ]
      }
    }
  },
  {
    "id": 2,
    "name": "Seu Zé",
    "email": "seu.ze@hotmail.com",
    "role": {
      "operator": {
        "permissions": [
          {"id": 3, name: "create_suite"},
          {"id": 4, name: "edit_suite"},
        ]
      }
    }
  }
]
```


### POST api/users

Criar um usuário

```
 {
  "id": 1,
  "name": "Fulano de tal",
  "email": "fulanodetal@email.com",
  "role": {
    "id": 1,
    "name": "admin": {
      "permissions": [
        {"id": 1, name: "create_user"},
        {"id": 2, name: "edit_user"},
        {"id": 3, name: "create_suite"},
        {"id": 4, name: "edit_suite"},
      ]
    }
  }
}
```

### PATCH api/users/1

Editar um usuário

```
{
  "name": "Fulano de tal",
  "email": "fulanodetal@email.com",
  "role": {
    "id": 2,
    "name": "operator": {
      "permissions": [
        {"id": 1, name: "create_user"},
        {"id": 2, name: "edit_user"},
        {"id": 3, name: "create_suite"},
        {"id": 4, name: "edit_suite"},
      ]
    }
  }
}
```

### DELETE api/users/1

Deletar um usuário

```
{
  "id": 1
}
```