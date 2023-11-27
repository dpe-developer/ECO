<h2 align="center">ECO | Dizon Vision Clinic</h2>

### Built with:

 - Laravel 7.X <i>(Laravel Framework 7.30.6)</i>
 - AdminLTE 3.2.0
---

<p>Installation on Windows with XAMPP:</p>

- Download and install the following:
  - <a href="https://www.apachefriends.org/xampp-files/7.4.24/xampp-windows-x64-7.4.24-0-VC15-installer.exe" target="_blank">XAMPP</a>
  - <a href="https://getcomposer.org/Composer-Setup.exe" target="_blank">Composer</a>
  - <a href="https://git-scm.com/download/win" target="_blank">Git</a>
- Open windows Powershell or Windows Terminal.
- Execute this on shell/terminal: 
  ```
  cd C:/xampp/htdocs
  ```
- Execute this on shell/terminal: 
  ```
  git clone https://github.com/dpe-developer/ECO.git eco
  ```
- Execute this on shell/terminal: 
  ```
  cd eco
  ```
- Execute this on shell/terminal: 
  ```
  composer install
  ```
- Execute this on shell/terminal: 
  ```
  cp .env.example .env
  ```
- Create database on http://localhost/phpmyadmin
  - Database Name: <code>eco</code>
  - Collation: <code>utf8mb4_unicode_ci</code>
- Execute this on shell/terminal: 
  ```
  php artisan key:generate
  ```
- Execute this on shell/terminal: 
  ```
  php artisan config:cache
  ```
- Execute this on shell/terminal: 
  ```
  php artisan artisan install
  ```
- Execute this on shell/terminal: 
  ```
  php artisan config:cache
  ```
- Open 
  ```
  C:/xampp/apache/conf/extra/httpd-vhost.conf
  ```
   and add
    ```
    <VirtualHost *:80>
        DocumentRoot "C:/xampp/htdocs/eco/public"
        ServerName eco.local
    </VirtualHost>
    ```
    and save.
- Launch notepad as administrator and open <code>C:/Windows/System32/drivers/etc/hosts</code> file and add
    ```
    127.0.0.1   eco.local
    ```
    and save
- Restart your Apache in XAMPP Control Panel.
- Open your browser and copy this link http://eco.local to access the Web Application. Your can login as System Administrator using the credential below:
  - Username: master
  - Password: admin