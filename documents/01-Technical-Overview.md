# NIRCRM - Technical Overview

## System Introduction

**NIRCRM** (Niranjan Enterprises Customer Relationship Management) is a comprehensive Laravel-based CRM system with a WhatsApp-inspired user interface. The system is designed to manage customer relationships, leads, employees, departments, invoices, and business operations through an intuitive, modern interface.

### Core Technologies

- **Backend**: Laravel 9.x (PHP 8.0+)
- **Frontend**: Blade Templates, TailwindCSS, JavaScript
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Sanctum
- **PDF Generation**: DomPDF
- **Excel Handling**: Maatwebsite Excel
- **Image Processing**: Intervention Image

## Architecture Overview

### MVC Pattern
The system follows the Model-View-Controller (MVC) architectural pattern:

- **Models**: Located in `app/Models/` - Handle data logic and database interactions
- **Views**: Located in `resources/views/` - Handle presentation logic
- **Controllers**: Located in `app/Http/Controllers/` - Handle application logic

### Key Directories

```
nircrm/
├── app/
│   ├── Models/           # Eloquent Models
│   ├── Http/Controllers/ # Application Controllers
│   ├── Services/         # Business Logic Services
│   └── Helpers/          # Utility Functions
├── database/
│   ├── migrations/       # Database Schema Migrations
│   └── seeders/         # Database Seeders
├── resources/
│   ├── views/           # Blade Templates
│   ├── css/            # Custom Stylesheets
│   └── js/             # JavaScript Files
├── routes/             # Route Definitions
├── config/             # Configuration Files
└── storage/            # File Storage
```

## Core Features

### 1. User Management & Authentication
- Multi-role authentication system
- Role-based access control (RBAC)
- Department-based user organization
- OTP-based verification
- Session management

### 2. Lead Management System
- Lead capture and tracking
- Status and priority management
- Assignment to team members
- Follow-up scheduling
- Department-based lead distribution

### 3. Employee Management
- Employee profiles and records
- Department assignments
- Manager-subordinate relationships
- Shift management
- Attendance tracking

### 4. Attendance System
- Check-in/Check-out functionality
- Shift-based attendance
- Late arrival tracking
- Attendance reports and analytics

### 5. Leave Management
- Leave request submission
- Multi-level approval workflow
- Leave type management
- Leave balance tracking
- Department-wise leave policies

### 6. Invoice Management
- Invoice creation and management
- Installment support
- PDF generation
- Email delivery
- Payment tracking

### 7. Quotation System
- Quotation creation
- Service management
- Customer approval workflow
- Email notifications

### 8. Notification System
- Real-time notifications
- Email notifications
- Lead reaction notifications
- Activity logging

### 9. WhatsApp-Style UI
- Modern, responsive interface
- Chat-style detail views
- Dark/Light theme support
- Mobile-responsive design
- Collapsible sidebar navigation

## User Roles & Permissions

### Role Hierarchy
1. **Super Admin (Role 1)**
   - Full system access
   - User and department management
   - System configuration

2. **General Manager (Role 5)**
   - Multi-department oversight
   - High-level approvals
   - Report access

3. **Manager (Role 4)**
   - Department management
   - Team supervision
   - Leave approvals

4. **Employee (Role 2)**
   - Basic system access
   - Lead management
   - Personal dashboard

5. **Customer (Role 3)**
   - Customer portal access
   - Quotation viewing
   - Invoice access

### Department Structure
- Hierarchical department organization
- Department-based data filtering
- Manager assignments
- Cross-department collaboration

## Database Design Principles

### Key Relationships
- Users belong to Departments
- Users can manage other Users (Manager-Subordinate)
- Leads are assigned to Users and Departments
- Invoices belong to Customers
- Quotations can have multiple Services
- Activity Logs track all system changes

### Data Integrity
- Foreign key constraints
- Cascade delete operations
- Soft deletes for critical data
- Audit trails through activity logs

## Security Features

### Authentication & Authorization
- Laravel Sanctum for API authentication
- Role-based middleware
- CSRF protection
- Input validation and sanitization

### Data Protection
- Password hashing
- OTP verification
- Session management
- Secure file uploads

## Performance Optimizations

### Database Optimization
- Indexed columns for frequent queries
- Eager loading for relationships
- Query optimization
- Database connection pooling

### Frontend Optimization
- Lazy loading for large datasets
- CSS/JS minification
- Image optimization
- Caching strategies

## Integration Capabilities

### External Integrations
- Email services (SMTP)
- Payment gateways (extendable)
- Third-party APIs
- File storage systems

### API Support
- RESTful API endpoints
- API authentication
- Rate limiting
- Response formatting

## Development Standards

### Code Quality
- PSR-4 autoloading
- Object-oriented programming
- Design patterns implementation
- Code documentation

### Testing
- Unit tests with PHPUnit
- Feature testing
- Browser testing
- API testing

## Deployment Architecture

### Environment Support
- Development environment
- Staging environment
- Production environment
- Docker containerization support

### Monitoring & Logging
- Laravel logging system
- Error tracking
- Performance monitoring
- Activity audit trails

## Scalability Considerations

### Horizontal Scaling
- Load balancing support
- Database replication
- File storage separation
- Caching layers

### Vertical Scaling
- Resource optimization
- Memory management
- CPU utilization
- Storage optimization

## Maintenance & Support

### Backup Strategies
- Database backups
- File system backups
- Configuration backups
- Disaster recovery planning

### Update Management
- Version control
- Migration management
- Dependency updates
- Security patches

---

## System Requirements

### Minimum Requirements
- PHP 8.0+
- MySQL 5.7+ / MariaDB 10.3+
- Web Server (Apache/Nginx)
- 2GB RAM
- 10GB Storage

### Recommended Requirements
- PHP 8.1+
- MySQL 8.0+ / MariaDB 10.6+
- SSD Storage
- 4GB+ RAM
- Dedicated server

---

**Version**: 1.0.0  
**Last Updated**: February 2026  
**Framework**: Laravel 9.x  
**License**: Proprietary (Niranjan Enterprises)
