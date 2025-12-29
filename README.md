# 💊 Medicine Price & Alternative Finder (Bangladesh)

![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.x-orange?logo=mysql)
![HTML](https://img.shields.io/badge/HTML-5-E34F26?logo=html5&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?logo=tailwind-css)
![RxNorm API](https://img.shields.io/badge/API-RxNorm-2E7D32?logo=databricks&logoColor=white)
![OpenFDA API](https://img.shields.io/badge/API-OpenFDA-1565C0?logo=food&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)


A full-stack **Medicine Price & Alternative Finder** built with **PHP**, **MySQL**, **JavaScript**, **APIs**, and **Tailwind CSS**, designed specifically for Bangladesh.

This application helps users instantly search medicines, compare prices, find generic alternatives, and understand medicine information in a human-friendly, non-medical-advice format.

The system uses a hybrid architecture combining **external drug** **APIs** with local price control, making it scalable, accurate, and production-ready.

---
## 🎯 Core Objectives

- Instantly search medicines by brand or generic
- Show Bangladesh-specific pricing
- Provide cheaper alternatives with same generic
- Reduce manual data entry using trusted medical APIs
- Keep admin control over price accuracy and corrections
---

## 🚀 Key Features

### 🔍 Smart Medicine Search

- Search by brand name or generic name
- Partial keyword support
- Hybrid search:
 - Local database (fast, price-accurate)
 - External API fallback (millions of medicines)

### 🔁 Alternative Medicine Finder

- Same generic
- Same strength
- Same dosage form
- Sorted by lowest price
- Clear disclaimer before switching medicines

### 💰 Price Comparison (Bangladesh)
- Minimum price
- Maximum price
- Average price
- Manufacturer-wise listing


### 🏭 Manufacturer Information

- Company name
- Brand list
- Strength variations

### 🔐 Secure Admin Dashboard

- Session-based admin login
- Hashed passwords
- Add / edit medicines
- Control Bangladesh pricing
- No exposure of admin routes to public users

---

## 🧠 Hybrid Data Architecture (Very Important)

```text
User Search
   ↓
Local Database (Bangladesh prices)
   ↓ (if not found)
RxNorm / OpenFDA APIs
   ↓
Results shown to user
   ↓
(Optional) Cached locally
```
---

## 🌐 APIs Used

| Purpose                  | API                          |
| ------------------------ | ---------------------------- |
| Drug names & mapping     | RxNorm (NIH)                 |
| Brand & generic matching | RxNorm Approximate Search    |
| Drug information         | OpenFDA                      |
| Price data               | Locally managed (Bangladesh) |

> ⚠️ **Important Notice**
> No official Bangladesh medicine price API exists.
> Prices are maintained locally for accuracy. what would be the result?
---

## 🧑‍💻 Tech Stack

| Layer    | Technology                     |
| -------- | ------------------------------ |
| Frontend | HTML, Tailwind CSS, JavaScript |
| Backend  | PHP (PDO)                      |
| Database | MySQL / MariaDB                |
| APIs     | RxNorm, OpenFDA                |
| Server   | Apache (XAMPP / VPS)           |

---

## 📁 Project Structure

```text
medicine-finder/
├── admin/
│   ├── login.php
│   ├── .htaccess
│   ├── dashboard.php
│   ├── auth.php
│   ├── add-medicine.php
│   ├── edit-medicine.php
│   └── logout.php
│
├── api/
│   ├── search-medicine.php
│   ├── get-alternatives.php
│   └── medicine-details.php
│
├── assets/
│   ├── css/
│   └── js/
│       └── app.js
│
├── includes/
│   ├── db.php
│   ├── footer.php
│   └── header.php
│
├── index.php
├── medicine.php
├── database.sql
└── README.md
```
---
## ⚙️ Installation & Setup

### 1️⃣ Clone Repository
```text
git clone https://github.com/badhonacharia/medicine-price-finder-bd.git
```
### 2️⃣  Move to Server Root
```text
xampp/htdocs/medicine-finder
```

### 3️⃣ (Optional) Database Setup

- Create a MySQL database
- Import database.sql (only required for caching / sharing features)

### 4️⃣ Start Local Server

- Start Apache from XAMPP
- Open browser:

### 5️⃣ Run the Project
```text
http://localhost/medicine-finder
```
---
## 🔐 Admin Access
```text
http://localhost/medicine-finder/admin/login.php
```
- Secure session-based authentication
- Passwords stored using PHP password hashing
- Admin routes protected from public access
---

## 🔐 Security Notes
- No API keys are stored in frontend
- External APIs accessed via PHP to avoid CORS issues
- Prepared statements used (SQL injection safe)
- Session-based authentication
- Admin access isolated
---
## 🌱 Future Enhancements

- Admin approval workflow for API medicines
- Medicine popularity tracking
- User-submitted price corrections
- API rate-limit handling
- SEO-friendly URLs (/medicine/napa-500)
- Mobile app API
- India expansion support
- Pharmacy dashboard integration
---

## ⚠️ Disclaimer

> This application provides medicine price and alternative information for educational purposes only.
> Always consult a registered physician or pharmacist before using or switching medicines.

🔴 **It does not provide medical advice.**

---

## 📄 License
This project is licensed under the **MIT License**.
You are free to:
- Use the project for personal or commercial purposes
- Modify and distribute the code
- Use it in your own projects with proper attribution
See the [LICENSE](LICENSE) file for full details.
---

## 👨‍💻 Author

**[Badhon Acharia](https://octteen.com/badhonacharia/)**

Web Developer | PHP | WordPress | Backend System

**[GitHub](https://github.com/badhonacharia/)**   **[Portfolio](https://octteen.com/badhonacharia/)**

---
