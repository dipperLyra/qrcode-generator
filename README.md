# QR Code Generator

This is simple QRCode generator. It uses bacon/bacon-qr-code library.

## Aim

To refresh my memory on setting up projects in PHP without any framework.
 
### Features 
 
1. API request authentication
2. QR Code generation
3. Store links to QR Code images
4. Admin can retrieve a list of all QR codes generated.
5. Admin can retrieve the text of all QR codes generated.

### Tools

1. PHP
2. MYSQL
3. Composer
4. Postman
5. Libraries: see composer.json

### Project approach

#### Objects
1. Admin
2. QR Code

#### Schema

1. admin - id:int - primary key, username:string, password:text, created_at, updated_at.
2. image - id:int - primary key, file_path, qrcode_text, created_at, updated_at.
3. super_admin - id:int - primary key, username:string, password:text, created_at, updated_at.

#### Migrations

robmorgan/phinx library manages schema migrations.

#### API 
##### Authentication
I manually added super-admin details to the database. 
Super-admin regulates the creation of admin accounts in this project.

##### Endpoints

There are only three endpoints available.
1. /admin: uses POST method to create an admin
Sample:
{
"username":"kaladin",
"password": "mypassword"
}

2. /qrcode: POST creates a QR code
sample:
{
"text":"All thee that hate Go, look and see, has there ever been a language so ...",
}

3. /qrcode: GET retrieves all available images
