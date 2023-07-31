# Conta horas por turno

Essa SPA (Sinle Page Application) foi construído, utilizando Laravel e Vue.js. Essa aplicação permite realizar o cálculo da quantidade de horas diurnas e norturnas, contidas em um determinado período de tempo, informado pelo usuário.

## Requisitos

Antes de rodar a aplicação, certifique-se de ter os seguintes requisitos instalados em seu sistema.

1. PHP (>= 8.2)
2. Composer
3. Node.js (>= 18.17)
4. npm ou Yarn
5. MySQL ou qualquer outro banco de dados, suportado pelo Laravel (se preferir, opte por usar sqlite).

## Rodando localmente

Siga os seguintes passos para subir e rodar a aplicação em sua máquina local.

### 1. Clonar o repositório

```bash
git clone 
cd conta-horas-por-turno
```

### 2. Instalar dependencias do PHP

```bash
composer install
```


### 3. Instalar dependencias do JavaScript

```bash
npm install
```

### 4. Configurando Ambiente

Crie uma cópia do arquivo .env.example e renomeie para .env. Em seguida, atualize as configurações necessárias, como credenciais do banco de dados.


```bash
cp .env.example .env
php artisan key:generate
```

### 5. Rodando Migrações do banco de dados

```bash
php artisan migrate
```

### 6. Servir a aplicação

```bash
npm run dev
php artisan serve
```

A aplicação deverá estar acessível através do endereço: http://localhost:8000
A funcionalidade para calcular as horas por turno, estará disponível em http://localhost:8000/periods