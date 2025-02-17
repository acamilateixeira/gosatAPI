# 🏦 API de Consulta de Ofertas de Crédito

consulta e simulação de ofertas de crédito, permitindo que usuários consultem instituições financeiras e simulem valores e taxas de juros. O front-end foi desenvolvido em Vue.js e o back-end em Laravel.

---

## 🚀 **Tecnologias Utilizadas**

-   **Back-end:** Laravel 10, MySQL, Swagger (l5-swagger)
-   **Front-end:** Vue.js 3, Tailwind CSS, Axios, Chart.js
-   **Documentação:** Swagger UI
-   **Banco de Dados:** MySQL

---

## 🛠 **Pré-requisitos**

Antes de rodar o projeto, instale as seguintes ferramentas:

-   [PHP 8+](https://www.php.net/)
-   [Composer](https://getcomposer.org/)
-   [Node.js 16+](https://nodejs.org/)
-   [MySQL 8+](https://www.mysql.com/)
-   [NPM ou Yarn](https://nodejs.org/)

---

## 🏗 **Passo a Passo para Rodar o Projeto**

### 🔹 **1. Clonar o Repositório**

```sh
git clone https://github.com/acamilateixeira/gosatAPI.git
cd gosatAPI
```

---

### 🔹 **2. Configurar o Back-end (Laravel)**

#### **2.1 Instalar as Dependências**

```sh
composer install
```

#### **2.2 Criar o Arquivo `.env`**

Copie o arquivo de configuração:

```sh
cp .env.example .env
```

#### **2.3 Configurar as Variáveis de Ambiente**

Edite o arquivo `.env` e configure a conexão com o banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=credit_db
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

#### **2.4 Criar o Banco de Dados**

No MySQL, crie o banco de dados manualmente:

```sql
CREATE DATABASE credit_db;
```

Ou use um cliente MySQL como **phpMyAdmin** ou **MySQL Workbench**.

#### **2.5 Rodar as Migrations**

```sh
php artisan migrate
```

Se quiser popular o banco com dados de teste:

```sh
php artisan db:seed
```

#### **2.6 Gerar a Chave da Aplicação**

```sh
php artisan key:generate
```

#### **2.7 Criar a Tabela de Cache**

Caso necessário, execute:

```sh
php artisan cache:table
php artisan migrate
```

#### **2.8 Gerar a Documentação da API (Swagger)**

```sh
php artisan l5-swagger:generate
```

Acesse no navegador:

```
http://127.0.0.1:8000/api/documentation
```

#### **2.9 Rodar o Servidor Laravel**

```sh
php artisan serve
```

A API estará rodando em:

```
http://127.0.0.1:8000
```

---

### 🔹 **3. Configurar o Front-end (Vue.js)**

#### **3.1 Instalar as Dependências**

```sh
cd resources/js
npm install
```

#### **3.2 Configurar o Tailwind CSS**

```sh
npx tailwindcss init -p
```

Certifique-se de que o arquivo `tailwind.config.js` está assim:

```js
module.exports = {
    content: ["./resources/**/*.blade.php", "./resources/**/*.vue"],
    theme: {
        extend: {},
    },
    plugins: [],
};
```

#### **3.3 Rodar o Front-end**

```sh
npm run dev
```

## 🎯 **Rotas da API**

### 📌 **Consultar Ofertas**

```http
POST /api/credit-offer
```

#### **Body:**

```json
{
    "cpf": "1111111111"
}
```

#### **Resposta:**

```json
{
    "instituicoes": [
        {
            "nome": "Banco A",
            "modalidades": [{ "nome": "Crédito Pessoal", "cod": "001" }]
        }
    ]
}
```

---

### 📌 **Simular Oferta**

```http
POST /api/credit-simulation
```

#### **Body:**

```json
{
    "cpf": "11111111111",
    "institution_id": 1,
    "codModalidade": "13"
}
```

#### **Resposta:**

```json
{
    "QntParcelaMin": 12,
    "QntParcelaMax": 48,
    "valorMin": 5000,
    "valorMax": 8000,
    "jurosMes": 0.0495
}
```

---

## 🔧 **Comandos Úteis**

### **Limpando Cache**

```sh
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### **Recriando Banco de Dados**

```sh
php artisan migrate:fresh --seed
```

### **Gerando Documentação do Swagger**

```sh
php artisan l5-swagger:generate
```

---

## 🖥 **Acessando o Projeto**

-   **API Laravel:** `http://127.0.0.1:8000`
-   **Documentação Swagger:** `http://127.0.0.1:8000/api/documentation`
-   **Front-end Vue.js:** `http://127.0.0.1:5173`

---

🚀 **Agora você está pronto para rodar e testar a API!** 😊

```

### **📌 O que tem no README:**
✔️ Instalação do Laravel
✔️ Configuração do Banco de Dados
✔️ Instalação do Front-end Vue.js
✔️ Rotas da API
✔️ Como rodar Swagger
✔️ Comandos úteis
✔️ Links de acesso

```
