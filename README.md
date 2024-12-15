# Shop Project with PHP

This project is a simple e-commerce web application developed using PHP. It allows users to manage products, categorize them, search for items, add products to a shopping cart, and download a product list as a PDF.

## Features

### 1. **Product Management**
- Add new products with relevant details, including tags and categories.
- Edit or delete existing products from the product list.

### 2. **Product List with Search and Categories**
- Display a list of all products.
- Search for products using a search bar.
- Filter products by category using the category menu located on the left side of the page.

### 3. **Shopping Cart**
- Add products to the shopping cart.
- View the list of selected products.
- Update product quantities or remove items from the cart.
- A purchase button is available that opens a confirmation window (simulated functionality).

### 4. **PDF Download**
- Download the product list in PDF format.
- The PDF generation feature uses the **FPDF** library. **Note:** The `fpdf` library is not included in the repository. Users need to manually download and place it into the `bootstrap/fpdf` directory.

## Folder Structure
```
project-folder/
├── asset/                  # CSS, JS, and images
│   ├── css/               
│   ├── Images/
│   └── js/
├── bootstrap/             # Core files
│   ├── config/
│   │   └── connect.php    # Database connection file
│   ├── init/
│   │   └── includes.php   # Initialization file
│   └── fpdf/              # PDF library (user needs to add this manually)
├── libs/                  # Functional files
│   ├── cart_func.php      # Cart functionalities
│   ├── category_func.php  # Category management
│   ├── edit_func.php      # Edit product functionalities
│   ├── product_func.php   # Product management functions
│   └── validate_func.php  # Validation functions
├── tpl/                   # Template files
│   ├── action-cart.php
│   ├── action-index.php
│   ├── action-view.php
│   ├── cart_tpl.php
│   ├── category_tpl.php
│   ├── edit_tpl.php
│   ├── index_tpl.php
│   └── view_tpl.php
├── cart.php               # Shopping cart page
├── category.php           # Category page
├── edit.php               # Edit product page
├── index.php              # Main page (product creation)
└── view.php               # Product list view page
```

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/0Xino0/Shop-Project-php
   ```

2. Install the **FPDF** library manually:
   - Download FPDF from the [official website](http://www.fpdf.org/).
   - Place the downloaded files into the `bootstrap/fpdf/` directory.

3. Configure the database connection:
   - Update the database credentials in `bootstrap/config/connect.php`.

4. Set up the database schema (not included).

5. Start the server:
   - Use XAMPP, WAMP, or MAMP to run the project.
   - Place the project folder in your server's `htdocs` directory.

6. Access the application:
   ```
   http://localhost/[project_folder_name]
   ```

## Usage

1. **Main Page**:
   - Add products with their details, tags, and categories.
2. **Product List Page**:
   - View all products.
   - Search and filter products by category.
   - Add products to the shopping cart.
3. **Edit Product Page**:
   - Modify existing product details.
4. **Shopping Cart Page**:
   - View, update, or remove products from the cart.
   - Simulate a purchase using the "Buy" button.
5. **PDF Download**:
   - Download the product list in PDF format.

## Notes
- The project uses **FPDF** for PDF generation. The library is not included in the repository and must be added manually.
- Ensure the database is correctly set up and the connection file is configured.

