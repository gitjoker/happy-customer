# 📌 Ananta Test Project

The project made from Laravel version 12.

---

> [!CAUTION]
> This project requires running commands to migrate and seed data first !!.

## 📌 Prerequisites
Before you begin, make sure you have the following installed:
- **PHP** (>=8.2)
- **Composer** (latest version)
- **Node.js** & **npm** (latest LTS version)
- **MySQL**

---

## 🚀 Step-by-Step Installation

### **1️⃣ Clone the repository**
```bash
git clone https://github.com/gitjoker/happy-customer.git
cd happy-customer
```

### **2️⃣ Install dependencies**
```bash
composer install
npm install
```

### **3️⃣ Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

### **4️⃣ Run database migrations and seed data**
```bash
php artisan migrate:fresh --seed
```

### **5️⃣ Start the development server**
```bash
php artisan serve
```

Laravel application should now be accessible

---

## 📌 In Case use Sail

---

1️⃣
```bash
composer require laravel/sail --dev
```
2️⃣
```bash
cp .env.example .env
```
3️⃣
```bash
php artisan sail:install
```
4️⃣
```bash
php artisan key:generate
```
5️⃣
```bash
sail up
```
6️⃣
```bash
sail artisan migrate:fresh --seed
```

> [!CAUTION]
> This project requires running commands to migrate and seed data first !!.