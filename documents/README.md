# NIRCRM Documentation

This folder contains comprehensive documentation for the NIRCRM (Niranjan Enterprises Customer Relationship Management) system.

## Document Structure

### 📋 Core Documentation Files

1. **[00-Documentation-Index.md](./00-Documentation-Index.md)**
   - Complete documentation index and overview
   - Quick reference guide
   - Navigation help

2. **[01-Technical-Overview.md](./01-Technical-Overview.md)**
   - System architecture and technologies
   - Core features and capabilities
   - Security and performance considerations

3. **[02-Models-Database-Schema.md](./02-Models-Database-Schema.md)**
   - Complete database structure
   - Model relationships and documentation
   - Migration files and constraints

4. **[03-Controllers-API-Documentation.md](./03-Controllers-API-Documentation.md)**
   - API endpoints and controllers
   - Request/response formats
   - Authentication and authorization

5. **[04-UI-UX-Design-System.md](./04-UI-UX-Design-System.md)**
   - WhatsApp-inspired design system
   - Component library and patterns
   - Accessibility guidelines

6. **[05-User-Manual-Roles.md](./05-User-Manual-Roles.md)**
   - Role-based user guides
   - Daily workflows and procedures
   - Troubleshooting and support

7. **[06-Installation-Deployment-Guide.md](./06-Installation-Deployment-Guide.md)**
   - Complete setup instructions
   - Production deployment guide
   - Maintenance and backup procedures

### 🔧 Utility Files

8. **[generate-pdf.php](./generate-pdf.php)**
   - PDF generation script
   - Combines all documentation into single PDF
   - Requires mPDF library

## Quick Start

### For Developers
1. Read the [Technical Overview](./01-Technical-Overview.md)
2. Study the [Database Schema](./02-Models-Database-Schema.md)
3. Review the [API Documentation](./03-Controllers-API-Documentation.md)
4. Use the [Installation Guide](./06-Installation-Deployment-Guide.md) for setup

### For System Administrators
1. Review the [Technical Overview](./01-Technical-Overview.md)
2. Follow the [Installation Guide](./06-Installation-Deployment-Guide.md)
3. Reference the [User Manual](./05-User-Manual-Roles.md) for user support

### For End Users
1. Read the [User Manual](./05-User-Manual-Roles.md)
2. Find your specific role section
3. Follow the daily workflow guides

### For Designers
1. Study the [UI/UX Design System](./04-UI-UX-Design-System.md)
2. Review component library
3. Understand responsive patterns

## PDF Generation

To generate a single PDF document containing all documentation:

1. Install mPDF library:
   ```bash
   composer require mpdf/mpdf
   ```

2. Run the PDF generation script:
   ```bash
   php generate-pdf.php
   ```

3. The PDF will be saved as `NIRCRM-Complete-Documentation.pdf`

## System Requirements

### Minimum Requirements
- PHP 8.0.2+
- MySQL 5.7+ / MariaDB 10.3+
- Apache 2.4+ / Nginx 1.18+
- 4GB RAM
- 20GB Storage

### Recommended Requirements
- PHP 8.1+
- MySQL 8.0+ / MariaDB 10.6+
- Nginx 1.20+ with PHP-FPM
- 8GB+ RAM
- 50GB SSD Storage

## Key Features

- ✅ Multi-role user management
- ✅ Department-based organization
- ✅ Lead management and tracking
- ✅ Attendance and leave management
- ✅ Invoice and quotation system
- ✅ Real-time notifications
- ✅ WhatsApp-style UI/UX
- ✅ Mobile-responsive design
- ✅ API endpoints for integration

## User Roles

1. **Super Admin** - Full system access
2. **General Manager** - Multi-department oversight
3. **Manager** - Department and team management
4. **Employee** - Basic system access
5. **Customer** - Limited portal access

## Support

For technical support or questions about the documentation:

1. Check the troubleshooting sections in relevant documents
2. Contact your system administrator
3. Reach out to the development team

## Version Information

- **Documentation Version**: 1.0.0
- **Last Updated**: February 2026
- **System Version**: NIRCRM v1.0.0
- **Framework**: Laravel 9.x

## Contributing

When contributing to documentation:

1. Follow the established format and style
2. Test code examples and procedures
3. Update version numbers and dates
4. Regenerate PDF documentation if needed

## File Formats

This documentation is available in:
- **Markdown** (.md) - Source format
- **PDF** - Combined printable document
- **HTML** - Web-based format (when generated)

---

**NIRCRM Documentation Suite**  
*Niranjan Enterprises Customer Relationship Management*  
*Version 1.0.0 | February 2026*
