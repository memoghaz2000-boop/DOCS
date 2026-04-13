# EDOCS - Effervescent Development & Optimization System

![EDOCS Banner](https://img.shields.io/badge/Status-Operational-success?style=for-the-badge) ![Version](https://img.shields.io/badge/Version-1.0.0-blue?style=for-the-badge) ![Laravel Version](https://img.shields.io/badge/Laravel-v11+-red?style=for-the-badge) ![Filament Version](https://img.shields.io/badge/Filament-v3/v5-yellow?style=for-the-badge)

## 🌟 Overview
**EDOCS** is a sophisticated pharmaceutical management system designed specifically for the development, optimization, and monitoring of **Effervescent Products**. It streamlines the transition from legacy paper-based or MS Access workflows to a modern, scalable web-based environment.

---

## 🚀 Key Modules & Features

### 1. 🏗️ Project Lifecycle Management
*   Track projects from prototype to commercial scale-up.
*   Manage metadata, target markets, and project statuses.
*   Localized interfaces (Arabic-English support).

### 2. 🧪 Formulation Engine
*   Manage active ingredients (APIs) and excipients.
*   Calculate effervescence ratios and cost-per-unit.
*   Map complex ingredient roles within formulas.

### 3. 📊 Experimental Operations
*   Record experimental runs with detailed batch size and equipment tracking.
*   Monitor process routes and experimental objectives.
*   Centralized results database for historical analysis.

### 4. 🛡️ Risk & Compliance Management
*   **FMEA Integrated:** Built-in Failure Mode and Effects Analysis.
*   **Automatic RPN Calculation:** Severity × Occurrence × Detectability calculation.
*   **Risk Level Badges:** Visual color indicators for critical risk priorities.
*   **Mitigation Tracking:** Record and assign mitigation strategies.

### 5. 🌎 Multi-language (Internationalization)
*   Full support for **Arabic (RTL)** and **English (LTR)**.
*   One-click language switcher integrated into the dashboard and welcome page.
*   Session-persistent locale preference.

---

## 🛠️ Technical Implementation

*   **Backend:** Laravel Framework (v11/v12).
*   **Admin Dashboard:** Filament PHP for responsive CRUD operations.
*   **Real-time Logic:** LiveWire for dynamic RPN calculations and field updates.
*   **Architecture:** Modular schema design with dedicated Form, Table, and Resource components.

---

## ⚙️ Installation & Setup

1.  **Clone/Path:** Ensure you are in the project root: `c:\Users\Dell\Desktop\EDOS\edocs`
2.  **Run Server:** 
    ```powershell
    php artisan serve
    ```
3.  **Run Migrations:**
    ```powershell
    php artisan migrate
    ```
4.  **Access App:**
    *   **Public Front:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
    *   **Admin Panel:** [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

## 📝 Usage Guide

*   **Switching Language:** Click the user menu (top-right corner) and select the desired language.
*   **Adding a Risk:** Navigate to **Risk Management**, create a new record, and enter the S/O/D values. The RPN will calculate automatically.
*   **Creating a Project:** Use the **Projects** resource to start a new product development profile.

---

## 👨‍💻 Documentation & Support
This documentation describes the core features implemented to date. For extending resources, follow the standard Filament Resource pattern and use the `__(messages.field)` helper for labels.

&copy; {{ date('Y') }} EDOCS Team. All rights reserved.
