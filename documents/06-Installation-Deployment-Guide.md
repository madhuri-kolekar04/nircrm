# NIRCRM - Installation & Deployment Guide

## Table of Contents

1. [System Requirements](#system-requirements)
2. [Installation Overview](#installation-overview)
3. [Local Development Setup](#local-development-setup)
4. [Production Deployment](#production-deployment)
5. [Database Configuration](#database-configuration)
6. [Environment Configuration](#environment-configuration)
7. [Web Server Configuration](#web-server-configuration)
8. [SSL Certificate Setup](#ssl-certificate-setup)
9. [Backup & Maintenance](#backup--maintenance)
10. [Troubleshooting](#troubleshooting)

---

## System Requirements

### Minimum Requirements

#### Software
- **PHP**: 8.0.2 or higher
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Composer**: 2.0+
- **Node.js**: 16.0+ (for asset compilation)
- **npm**: 8.0+ (for asset compilation)

#### Hardware
- **CPU**: 2 cores or more
- **RAM**: 4GB minimum, 8GB recommended
- **Storage**: 20GB available space
- **Network**: Stable internet connection

### Recommended Requirements

#### Production Environment
- **PHP**: 8.1+ (latest stable)
- **Web Server**: Nginx 1.20+ with PHP-FPM
- **Database**: MySQL 8.0+ or MariaDB 10.6+
- **RAM**: 8GB minimum, 16GB recommended
- **Storage**: 50GB SSD storage
- **CPU**: 4 cores or more

#### Development Environment
- **PHP**: 8.1+
- **Database**: MySQL 8.0+ or MariaDB 10.6+
- **RAM**: 8GB
- **Storage**: 20GB
- **CPU**: 2 cores minimum

### PHP Extensions Required

```bash
# Required Extensions
php-cli
php-fpm
php-mysql
php-xml
php-curl
php-zip
php-gd
php-mbstring
php-bcmath
php-json
php-tokenizer
php-fileinfo
php-intl

# Optional but Recommended
php-opcache    # Performance optimization
php-xdebug     # Development debugging
php-redis      # Caching (if using Redis)
```

---

## Installation Overview

### Installation Methods

1. **Manual Installation** - Step-by-step manual setup
2. **Automated Script** - One-click installation script
3. **Docker Deployment** - Containerized deployment
4. **Cloud Deployment** - Cloud platform deployment

### Installation Flow

```
1. Environment Setup
   ├── Install dependencies (PHP, Database, Web Server)
   ├── Configure PHP settings
   └── Setup database

2. Application Setup
   ├── Download NIRCRM files
   ├── Install Composer dependencies
   ├── Install npm dependencies
   └── Configure environment

3. Database Setup
   ├── Create database
   ├── Run migrations
   └── Seed initial data

4. Final Configuration
   ├── Set file permissions
   ├── Configure web server
   ├── Set up SSL
   └── Test application
```

---

## Local Development Setup

### Step 1: Environment Preparation

#### Install XAMPP (Recommended for Windows)
```bash
# Download and install XAMPP from https://www.apachefriends.org
# Ensure the following components are selected:
# - Apache
# - MySQL
# - PHP (8.0+)
# - phpMyAdmin
```

#### Verify Installation
```bash
# Check PHP version
php --version

# Check Composer
composer --version

# Check Node.js
node --version
npm --version
```

### Step 2: Database Setup

#### Create Database
```sql
-- Using phpMyAdmin or MySQL command line
CREATE DATABASE nircrm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'nircrm_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON nircrm.* TO 'nircrm_user'@'localhost';
FLUSH PRIVILEGES;
```

### Step 3: Application Setup

#### Download and Extract
```bash
# Extract the NIRCRM archive to your web directory
# For XAMPP: C:/xampp/htdocs/nircrm/
```

#### Install Dependencies
```bash
# Navigate to project directory
cd C:/xampp/htdocs/nircrm/

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

#### Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env file with your configuration
```

#### Environment File (.env) Configuration
```env
APP_NAME="NIRCRM"
APP_ENV=local
APP_KEY=base64:your_generated_key_here
APP_DEBUG=true
APP_URL=http://localhost/nircrm

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nircrm
DB_USERNAME=nircrm_user
DB_PASSWORD=strong_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 4: Database Migration

```bash
# Run database migrations
php artisan migrate

# Seed initial data (optional)
php artisan db:seed

# Create storage links
php artisan storage:link
```

### Step 5: Asset Compilation

```bash
# Compile frontend assets
npm run build

# Or for development
npm run dev
```

### Step 6: Start Development Server

```bash
# Start Laravel development server
php artisan serve

# Or access via XAMPP Apache
# http://localhost/nircrm
```

### Step 7: Initial Setup

1. **Access the Application**
   - Navigate to `http://localhost/nircrm`
   - Follow the setup wizard
   - Create admin account

2. **Configure Basic Settings**
   - Company information
   - Email settings
   - Default departments
   - User roles

---

## Production Deployment

### Option 1: Traditional Server Deployment

#### Server Preparation

##### Update System Packages
```bash
# Ubuntu/Debian
sudo apt update && sudo apt upgrade -y

# CentOS/RHEL
sudo yum update -y
```

##### Install Required Software
```bash
# Ubuntu/Debian
sudo apt install -y nginx mysql-server php8.1-fpm php8.1-mysql php8.1-xml php8.1-curl php8.1-zip php8.1-gd php8.1-mbstring php8.1-bcmath php8.1-intl php8.1-cli composer nodejs npm

# CentOS/RHEL
sudo yum install -y nginx mariadb-server php81-php-fpm php81-php-mysqlnd php81-php-xml php81-php-curl php81-php-zip php81-php-gd php81-php-mbstring php81-php-bcmath php81-php-intl composer nodejs npm
```

#### Database Configuration

##### Secure MySQL Installation
```bash
# Secure MySQL
sudo mysql_secure_installation

# Create Database
mysql -u root -p
CREATE DATABASE nircrm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'nircrm_user'@'localhost' IDENTIFIED BY 'very_strong_password';
GRANT ALL PRIVILEGES ON nircrm.* TO 'nircrm_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Application Deployment

##### Deploy Application Files
```bash
# Create application directory
sudo mkdir -p /var/www/nircrm
sudo chown $USER:$USER /var/www/nircrm

# Clone or upload application files
cd /var/www/nircrm
# Upload your files here or clone from repository

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install --production
npm run build

# Set permissions
sudo chown -R www-data:www-data /var/www/nircrm
sudo chmod -R 755 /var/www/nircrm
sudo chmod -R 777 /var/www/nircrm/storage
sudo chmod -R 777 /var/www/nircrm/bootstrap/cache
```

##### Environment Configuration
```bash
# Copy and configure environment file
cp .env.example .env
php artisan key:generate

# Edit .env for production
nano .env
```

##### Production Environment Configuration
```env
APP_NAME="NIRCRM"
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nircrm
DB_USERNAME=nircrm_user
DB_PASSWORD=very_strong_password

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

##### Run Deployment Commands
```bash
# Clear and cache configurations
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Create storage links
php artisan storage:link

# Optimize for production
php artisan optimize
```

### Option 2: Docker Deployment

#### Dockerfile
```dockerfile
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear package cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . /var/www

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
```

#### Docker Compose
```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: nircrm-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./storage/app/public:/var/www/storage/app/public
    networks:
      - nircrm-network
    depends_on:
      - database
      - redis

  webserver:
    image: nginx:alpine
    container_name: nircrm-nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www
      - ./docker/nginx/nginx.conf:/etc/nginx/nginx.conf
      - ./docker/nginx/sites/:/etc/nginx/sites-available
      - ./docker/nginx/ssl/:/etc/nginx/ssl/
    networks:
      - nircrm-network
    depends_on:
      - app

  database:
    image: mysql:8.0
    container_name: nircrm-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: nircrm
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_PASSWORD: user_password
      MYSQL_USER: nircrm_user
    volumes:
      - dbdata:/var/lib/mysql
    ports:
      - "3306:3306"
    networks:
      - nircrm-network

  redis:
    image: redis:7-alpine
    container_name: nircrm-redis
    restart: unless-stopped
    ports:
      - "6379:6379"
    volumes:
      - redisdata:/data
    networks:
      - nircrm-network

networks:
  nircrm-network:
    driver: bridge

volumes:
  dbdata:
    driver: local
  redisdata:
    driver: local
```

#### Docker Deployment Commands
```bash
# Build and start containers
docker-compose up -d --build

# Run database migrations
docker-compose exec app php artisan migrate --force

# Create storage link
docker-compose exec app php artisan storage:link

# Clear caches
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

---

## Database Configuration

### MySQL Configuration

#### Production MySQL Settings
```ini
# /etc/mysql/mysql.conf.d/mysqld.cnf

[mysqld]
# Basic Settings
user = mysql
pid-file = /var/run/mysqld/mysqld.pid
socket = /var/run/mysqld/mysqld.sock
port = 3306
basedir = /usr
datadir = /var/lib/mysql
tmpdir = /tmp
lc-messages-dir = /usr/share/mysql

# Performance Settings
innodb_buffer_pool_size = 2G
innodb_log_file_size = 256M
innodb_flush_method = O_DIRECT
innodb_flush_log_at_trx_commit = 2
innodb_file_per_table = 1

# Connection Settings
max_connections = 200
max_connect_errors = 1000
wait_timeout = 300
interactive_timeout = 300

# Character Set
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci

# Security
local-infile = 0
skip-show-database = 1
```

#### Database Optimization
```sql
-- Create indexes for performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_department ON users(department_id);
CREATE INDEX idx_leads_assigned ON leads(assigned_to);
CREATE INDEX idx_leads_status ON leads(lead_status);
CREATE INDEX idx_attendance_date ON attendances(date);
CREATE INDEX idx_attendance_user ON attendances(user_id);
CREATE INDEX idx_leaves_user ON leaves(user_id);
CREATE INDEX idx_leaves_status ON leaves(status);

-- Optimize tables
OPTIMIZE TABLE users, leads, attendances, leaves, invoices;
```

### Redis Configuration (Optional)

#### Redis Setup
```bash
# Install Redis
sudo apt install redis-server

# Configure Redis
sudo nano /etc/redis/redis.conf
```

#### Redis Configuration
```ini
# /etc/redis/redis.conf

# Memory
maxmemory 512mb
maxmemory-policy allkeys-lru

# Persistence
save 900 1
save 300 10
save 60 10000

# Security
requirepass your_redis_password
bind 127.0.0.1

# Performance
tcp-keepalive 300
timeout 0
```

---

## Environment Configuration

### Environment Variables

#### Core Application Settings
```env
# Application
APP_NAME="NIRCRM"
APP_ENV=production
APP_KEY=base64:your_key_here
APP_DEBUG=false
APP_URL=https://your-domain.com

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nircrm
DB_USERNAME=nircrm_user
DB_PASSWORD=secure_password
```

#### Cache and Session Settings
```env
# Cache
CACHE_DRIVER=redis
FILESYSTEM_DISK=local

# Session
SESSION_DRIVER=redis
SESSION_LIFETIME=120

# Queue
QUEUE_CONNECTION=redis
```

#### Email Configuration
```env
# Mail Settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### File Storage Settings
```env
# File Storage
FILESYSTEM_DISK=local

# AWS S3 (Optional)
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### Security Configuration

#### Security Headers
```php
// app/Http/Middleware/SecurityHeaders.php
public function handle($request, Closure $next)
{
    $response = $next($request);
    
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
    $response->headers->set('Content-Security-Policy', "default-src 'self' 'unsafe-inline' 'unsafe-eval';");
    
    return $response;
}
```

---

## Web Server Configuration

### Nginx Configuration

#### Nginx Server Block
```nginx
# /etc/nginx/sites-available/nircrm
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com www.your-domain.com;

    root /var/www/nircrm/public;
    index index.php index.html index.htm;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types
        text/plain
        text/css
        text/xml
        text/javascript
        application/json
        application/javascript
        application/xml+rss
        application/atom+xml
        image/svg+xml;

    # Laravel Specific
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_param HTTPS on;
    }

    # Static Assets Caching
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Deny access to .htaccess files
    location ~ /\.ht {
        deny all;
    }

    # PHP-FPM Status (Optional)
    location /status {
        allow 127.0.0.1;
        deny all;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### Enable Site
```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/nircrm /etc/nginx/sites-enabled/

# Test configuration
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx
```

### Apache Configuration

#### Apache Virtual Host
```apache
# /etc/apache2/sites-available/nircrm.conf
<VirtualHost *:80>
    ServerName your-domain.com
    ServerAlias www.your-domain.com
    Redirect permanent / https://your-domain.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName your-domain.com
    ServerAlias www.your-domain.com
    DocumentRoot /var/www/nircrm/public

    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/your-domain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/your-domain.com/privkey.pem
    SSLCertificateChainFile /etc/letsencrypt/live/your-domain.com/chain.pem

    # Security Headers
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set X-Content-Type-Options "nosniff"
    Header always set Referrer-Policy "no-referrer-when-downgrade"

    # Enable Rewrite Engine
    RewriteEngine On

    # Handle Laravel Routes
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [L]

    # PHP Settings
    <FilesMatch \.php$>
        SetHandler "proxy:unix:/var/run/php/php8.1-fpm.sock|fcgi://localhost/"
    </FilesMatch>

    # Security
    <Directory /var/www/nircrm>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Logging
    ErrorLog ${APACHE_LOG_DIR}/nircrm_error.log
    CustomLog ${APACHE_LOG_DIR}/nircrm_access.log combined
</VirtualHost>
```

#### Enable Apache Modules
```bash
# Enable required modules
sudo a2enmod rewrite
sudo a2enmod ssl
sudo a2enmod headers
sudo a2enmod proxy_fcgi

# Enable site
sudo a2ensite nircrm.conf

# Test configuration
sudo apache2ctl configtest

# Restart Apache
sudo systemctl restart apache2
```

---

## SSL Certificate Setup

### Let's Encrypt Certificate

#### Install Certbot
```bash
# Ubuntu/Debian
sudo apt install certbot python3-certbot-nginx

# CentOS/RHEL
sudo yum install certbot python3-certbot-nginx
```

#### Obtain SSL Certificate
```bash
# For Nginx
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# For Apache
sudo certbot --apache -d your-domain.com -d www.your-domain.com
```

#### Auto-Renewal Setup
```bash
# Test renewal
sudo certbot renew --dry-run

# Add cron job for auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### Custom SSL Certificate

#### Generate Private Key and CSR
```bash
# Generate private key
openssl genrsa -out nircrm.key 2048

# Generate CSR
openssl req -new -key nircrm.key -out nircrm.csr
```

#### Configure SSL in Web Server
```nginx
# Nginx SSL Configuration
ssl_certificate /path/to/your/certificate.crt;
ssl_certificate_key /path/to/your/private.key;
```

---

## Backup & Maintenance

### Database Backup

#### Automated Backup Script
```bash
#!/bin/bash
# /usr/local/bin/backup-nircrm.sh

# Configuration
DB_NAME="nircrm"
DB_USER="nircrm_user"
DB_PASS="secure_password"
BACKUP_DIR="/var/backups/nircrm"
DATE=$(date +%Y%m%d_%H%M%S)
RETENTION_DAYS=30

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# File backup
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz /var/www/nircrm/storage/app /var/www/nircrm/public/uploads

# Clean old backups
find $BACKUP_DIR -name "*.gz" -mtime +$RETENTION_DAYS -delete

# Log backup
echo "Backup completed: $DATE" >> /var/log/nircrm-backup.log
```

#### Schedule Backups
```bash
# Add to crontab
sudo crontab -e

# Daily backup at 2 AM
0 2 * * * /usr/local/bin/backup-nircrm.sh

# Weekly optimization
0 3 * * 0 /usr/bin/mysql -u nircrm_user -p'secure_password' -e "OPTIMIZE TABLE users, leads, attendances, leaves, invoices;"
```

### Application Maintenance

#### Laravel Optimization Commands
```bash
#!/bin/bash
# /usr/local/bin/maintain-nircrm.sh

# Navigate to application directory
cd /var/www/nircrm

# Clear and cache
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize

# Clear application cache
php artisan cache:clear

# Log rotation
truncate -s 0 storage/logs/laravel.log

echo "Maintenance completed: $(date)" >> /var/log/nircrm-maintenance.log
```

#### Schedule Maintenance
```bash
# Weekly maintenance
sudo crontab -e
0 4 * * 0 /usr/local/bin/maintain-nircrm.sh
```

### Monitoring

#### System Monitoring Script
```bash
#!/bin/bash
# /usr/local/bin/monitor-nircrm.sh

# Check if application is responding
if ! curl -f -s https://your-domain.com > /dev/null; then
    echo "Application is down! Restarting services..." >> /var/log/nircrm-monitor.log
    sudo systemctl restart nginx
    sudo systemctl restart php8.1-fpm
    sudo systemctl restart redis
fi

# Check disk space
DISK_USAGE=$(df / | awk 'NR==2 {print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 80 ]; then
    echo "Disk usage is ${DISK_USAGE}%" >> /var/log/nircrm-monitor.log
fi

# Check memory usage
MEMORY_USAGE=$(free | awk 'NR==2{printf "%.2f", $3*100/$2}')
if (( $(echo "$MEMORY_USAGE > 80" | bc -l) )); then
    echo "Memory usage is ${MEMORY_USAGE}%" >> /var/log/nircrm-monitor.log
fi
```

---

## Troubleshooting

### Common Issues

#### 1. White Screen / 500 Error
**Possible Causes:**
- File permissions issue
- Missing dependencies
- Configuration error

**Solutions:**
```bash
# Check file permissions
sudo chown -R www-data:www-data /var/www/nircrm
sudo chmod -R 755 /var/www/nircrm
sudo chmod -R 777 /var/www/nircrm/storage
sudo chmod -R 777 /var/www/nircrm/bootstrap/cache

# Check Laravel logs
tail -f /var/www/nircrm/storage/logs/laravel.log

# Check web server logs
sudo tail -f /var/log/nginx/error.log
```

#### 2. Database Connection Error
**Possible Causes:**
- Database credentials incorrect
- Database server not running
- Firewall blocking connection

**Solutions:**
```bash
# Test database connection
mysql -u nircrm_user -p -h localhost nircrm

# Check MySQL status
sudo systemctl status mysql

# Check firewall
sudo ufw status
```

#### 3. Asset Loading Issues
**Possible Causes:**
- Assets not compiled
- Incorrect asset paths
- Permission issues

**Solutions:**
```bash
# Recompile assets
npm run build

# Clear view cache
php artisan view:clear

# Create storage link
php artisan storage:link
```

#### 4. Performance Issues
**Possible Causes:**
- Insufficient server resources
- Database not optimized
- Caching not configured

**Solutions:**
```bash
# Optimize database
mysql -u root -p -e "OPTIMIZE TABLE nircrm.users, nircrm.leads, nircrm.attendances;"

# Enable OPcache
sudo phpenmod opcache

# Configure Redis for caching
# Update .env file with Redis settings
```

### Debug Mode

#### Enable Debug Mode (Development Only)
```env
# .env file
APP_DEBUG=true
LOG_LEVEL=debug
```

#### Debug Commands
```bash
# Check Laravel status
php artisan about

# Check route list
php artisan route:list

# Check configuration
php artisan config:show

# Run diagnostics
php artisan tinker
# Then run: app()->environment()
```

### Performance Optimization

#### PHP Optimization
```ini
# /etc/php/8.1/fpm/php.ini

# Memory
memory_limit = 256M

# Execution time
max_execution_time = 300

# OPcache settings
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

#### Database Optimization
```sql
-- Analyze table performance
EXPLAIN SELECT * FROM users WHERE email = 'test@example.com';

-- Create missing indexes
CREATE INDEX idx_missing_column ON table_name(column_name);

-- Optimize tables
OPTIMIZE TABLE table_name;
```

---

## Security Best Practices

### Application Security

#### 1. Environment Security
```bash
# Secure .env file
chmod 600 .env

# Prevent .env from being served
# Add to .htaccess or nginx config
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

#### 2. Regular Updates
```bash
# Update system packages
sudo apt update && sudo apt upgrade

# Update Composer dependencies
composer update

# Update npm dependencies
npm update
```

#### 3. Security Headers
```nginx
# Add to nginx configuration
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header X-Content-Type-Options "nosniff" always;
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
```

### Monitoring and Alerting

#### Log Monitoring
```bash
# Monitor error logs
tail -f /var/www/nircrm/storage/logs/laravel.log

# Monitor access logs
tail -f /var/log/nginx/access.log
```

#### Uptime Monitoring
```bash
# Simple uptime check
curl -f https://your-domain.com/health || echo "Site is down"
```

---

**Version**: 1.0.0  
**Last Updated**: February 2026  
**Document Type**: Installation Guide  
**Complexity**: Intermediate to Advanced
