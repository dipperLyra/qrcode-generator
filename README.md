QR Generator is a simple app for creating QR Code.

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
