# NIRCRM - Controllers & API Documentation

## Controllers Overview

The NIRCRM system follows Laravel's MVC pattern with controllers handling HTTP requests, processing business logic, and returning responses. Controllers are organized into logical groups based on functionality.

## Core Controllers

### 1. AttendanceController

**Location**: `app/Http/Controllers/AttendanceController.php`

**Purpose**: Manages employee attendance tracking, check-in/check-out functionality, and attendance reporting.

#### Key Methods

##### `dashboard()`
- **Purpose**: Main attendance dashboard with role-based data filtering
- **Access**: All authenticated users
- **Features**:
  - Role-based user filtering (Admin sees all, Manager sees department, Employee sees self)
  - Today's attendance display
  - Attendance statistics
  - Recent leave requests (for approvers)
  - Monthly attendance summary
  - Shift management integration

##### `checkIn()`
- **Purpose**: Handle employee check-in
- **Validation**: Prevents duplicate check-ins, validates shift timing
- **Features**:
  - IP address tracking
  - Location recording
  - Late arrival detection
  - Email notifications

##### `checkOut()`
- **Purpose**: Handle employee check-out
- **Features**:
  - Working hours calculation
  - Overtime detection
  - Early checkout tracking
  - Automatic status updates

##### `getAttendanceStats()`
- **Purpose**: Calculate attendance statistics
- **Returns**: Present, absent, leave counts with percentages

##### `getFilteredUsers()`
- **Purpose**: Role-based user filtering
- **Logic**:
  - Admin/General Manager: All users
  - Manager: Department users + subordinates
  - Employee: Self only

#### API Endpoints

```
GET /attendance/dashboard          - Attendance dashboard
POST /attendance/check-in          - Check-in endpoint
POST /attendance/check-out         - Check-out endpoint
GET /attendance/reports/{date}     - Attendance reports
GET /attendance/user/{id}          - User attendance history
```

---

### 2. InvoiceController

**Location**: `app/Http/Controllers/InvoiceController.php`

**Purpose**: Complete invoice management system with PDF generation and email delivery.

#### Key Methods

##### `index()`
- **Purpose**: Invoice listing dashboard
- **Features**:
  - Role-based filtering (Customers see only their invoices)
  - Statistics (total, paid, pending invoices)
  - Revenue calculations
  - Pagination support

##### `create()`
- **Purpose**: Invoice creation form
- **Data**: Departments list for assignment

##### `store()`
- **Purpose**: Process invoice creation
- **Validation**: Comprehensive field validation
- **Features**:
  - Installment processing
  - Automatic invoice number generation
  - GST calculation (fixed 18%)
  - Department assignment
  - Email notifications

##### `generatePDF()`
- **Purpose**: Generate PDF version of invoice
- **Library**: DomPDF
- **Features**: Professional invoice layout with company details

##### `sendEmail()`
- **Purpose**: Email invoice to customer
- **Features**: PDF attachment, professional email template

#### API Endpoints

```
GET /invoices                    - Invoice listing
GET /invoices/create             - Creation form
POST /invoices                   - Store new invoice
GET /invoices/{id}               - View invoice
GET /invoices/{id}/edit          - Edit invoice
PUT /invoices/{id}               - Update invoice
DELETE /invoices/{id}            - Delete invoice
GET /invoices/{id}/pdf          - Download PDF
POST /invoices/{id}/email        - Send via email
```

---

### 3. LeaveController

**Location**: `app/Http/Controllers/LeaveController.php`

**Purpose**: Comprehensive leave management system with multi-level approval workflow.

#### Key Methods

##### `index()`
- **Purpose**: Leave listing with role-based filtering
- **Features**: Status filtering, date range filtering

##### `create()`
- **Purpose**: Leave request form
- **Data**: Leave types, user balances, statistics
- **Features**: Balance checking, upcoming leaves display

##### `store()`
- **Purpose**: Process leave request
- **Validation**: Overlap checking, balance validation
- **Features**:
  - Full day and half day support
  - Attachment handling
  - Approval chain creation
  - Email notifications

##### `approve()`
- **Purpose**: Approve leave request
- **Access**: Managers and above
- **Features**:
  - Multi-level approval workflow
  - Approval chain management
  - Email notifications
  - Status updates

##### `reject()`
- **Purpose**: Reject leave request
- **Features**: Reason recording, notifications

##### `balanceService` Integration
- **Service**: `LeaveBalanceService`
- **Features**: Balance calculation, statistics, upcoming leaves

#### Approval Workflow

```
Employee (Role 2) → Manager (Role 4) → General Manager (Role 5) → Admin (Role 1)
```

#### API Endpoints

```
GET /leaves                       - Leave listing
GET /leaves/create               - Creation form
POST /leaves                     - Store new request
GET /leaves/{id}                 - View leave details
PUT /leaves/{id}/approve         - Approve leave
PUT /leaves/{id}/reject          - Reject leave
GET /leaves/balance              - Leave balance API
GET /leaves/calendar            - Calendar view
```

---

### 4. Backend Controllers

#### EmployeeController
**Purpose**: Employee management with department and role assignments

**Key Features**:
- CRUD operations for employees
- Department assignment
- Role management
- Shift assignment
- Profile photo upload
- Contact information management

**API Endpoints**:
```
GET /employees                   - Employee listing
GET /employees/create            - Creation form
POST /employees                  - Store employee
GET /employees/{id}              - View employee
GET /employees/{id}/edit         - Edit employee
PUT /employees/{id}              - Update employee
DELETE /employees/{id}           - Delete employee
```

#### DepartmentController
**Purpose**: Organizational department management

**Key Features**:
- Hierarchical department structure
- Parent-child relationships
- Active/inactive status
- Department codes

#### CustomerController
**Purpose**: Customer relationship management

**Key Features**:
- Customer profiles
- Project history
- Communication tracking
- Document management

#### QuotationController
**Purpose**: Project quotation management

**Key Features**:
- Quotation creation
- Service management
- Customer approval workflow
- PDF generation
- Email delivery

---

### 5. NotificationController

**Location**: `app/Http/Controllers/NotificationController.php`

**Purpose**: System-wide notification management

#### Key Methods

##### `index()`
- **Purpose**: Notification listing
- **Features**: Read/unread status, filtering

##### `markAsRead()`
- **Purpose**: Mark notifications as read
- **Features**: Bulk operations, individual marking

##### `getUnreadCount()`
- **Purpose**: Get unread notification count
- **Returns**: Integer count for UI display

#### API Endpoints

```
GET /notifications               - Notification listing
PUT /notifications/{id}/read     - Mark as read
GET /notifications/unread/count  - Unread count
POST /notifications/mark-all     - Mark all as read
```

---

### 6. LeadController (Backend)

**Location**: `app/Http/Controllers/Backend/LeadController.php`

**Purpose**: Lead management and conversion tracking

#### Key Methods

##### `index()`
- **Purpose**: Lead listing with advanced filtering
- **Features**: Status, priority, department filtering

##### `store()`
- **Purpose**: Lead creation
- **Features**: Assignment, follow-up scheduling

##### `convertToInvoice()`
- **Purpose**: Convert lead to invoice
- **Features**: Data transfer, status updates

#### API Endpoints

```
GET /leads                       - Lead listing
POST /leads                     - Create lead
GET /leads/{id}                 - Lead details
PUT /leads/{id}                 - Update lead
DELETE /leads/{id}              - Delete lead
POST /leads/{id}/convert        - Convert to invoice
```

---

## Authentication Controllers

### Auth Controllers Directory
**Location**: `app/Http/Controllers/Auth/`

#### LoginController
- **Purpose**: User authentication
- **Features**: Email/password login, remember me, session management

#### RegisterController
- **Purpose**: User registration
- **Features**: Account creation, email verification, role assignment

#### ForgotPasswordController
- **Purpose**: Password reset functionality
- **Features**: Email reset links, secure token generation

#### OTPVerificationController
- **Purpose**: Two-factor authentication
- **Features**: OTP generation, verification, expiration

---

## API Response Format

### Standard Response Structure

```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        // Response data
    },
    "errors": [],
    "meta": {
        "pagination": {
            "current_page": 1,
            "total_pages": 10,
            "per_page": 15,
            "total": 150
        }
    }
}
```

### Error Response Structure

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "field_name": ["Error message"],
        "another_field": ["Another error"]
    },
    "data": null
}
```

---

## Middleware & Security

### Authentication Middleware
- `auth` - Basic authentication requirement
- `auth:sanctum` - API token authentication

### Role-Based Middleware
- `role:admin` - Admin only access
- `role:manager` - Manager and above
- `role:employee` - All authenticated users

### Custom Middleware
- `department.access` - Department-based access control
- `permission.check` - Custom permission verification

---

## Request Validation

### Common Validation Rules

```php
// User Data
'name' => 'required|string|max:255'
'email' => 'required|email|unique:users'
'password' => 'required|min:8|confirmed'

// Lead Data
'name' => 'required|string|max:255'
'email' => 'required|email'
'phone' => 'required|string|max:20'
'budget' => 'nullable|numeric|min:0'

// Invoice Data
'project_name' => 'required|string|max:255'
'customer_email' => 'required|email'
'advance_payment' => 'required|numeric|min:0'
'total_payment' => 'required|numeric|min:0'
```

### Custom Validation Rules
- Unique invoice numbers
- Leave date overlap checking
- Department assignment validation
- Role hierarchy validation

---

## File Upload Handling

### Supported File Types
- PDF documents
- Microsoft Office documents
- Images (JPG, JPEG, PNG)
- Maximum file size: 2MB

### Upload Process
1. File validation
2. Secure storage in `storage/app/uploads`
3. Database path recording
4. Thumbnail generation (for images)

---

## Email Integration

### Email Services
- SMTP configuration
- Queue-based sending
- Template system
- Attachment support

### Email Types
- Welcome emails
- Password reset
- Leave notifications
- Invoice delivery
- System notifications

---

## API Rate Limiting

### Rate Limits
- Standard users: 60 requests per minute
- API users: 1000 requests per hour
- Admin users: No limits

### Throttling Response
```json
{
    "success": false,
    "message": "Too many requests",
    "retry_after": 60
}
```

---

## Error Handling

### Exception Types
- Validation exceptions
- Authentication exceptions
- Authorization exceptions
- Model not found exceptions
- Custom business exceptions

### Error Logging
- Laravel logging system
- Custom error tracking
- Production error monitoring
- Debug information for development

---

## Performance Optimization

### Query Optimization
- Eager loading relationships
- Query result caching
- Database indexing
- Pagination for large datasets

### Response Caching
- View caching
- API response caching
- Static asset caching
- Browser caching headers

---

## Testing Coverage

### Controller Tests
- HTTP response testing
- Authentication testing
- Authorization testing
- Validation testing

### Feature Tests
- Complete workflow testing
- Multi-user scenarios
- Edge case handling
- Performance testing

---

## API Versioning

### Current Version: v1
- Stable API endpoints
- Backward compatibility
- Deprecation warnings
- Version-specific documentation

### Future Versions
- v2 planning phase
- Breaking changes notification
- Migration guides
- Parallel version support

---

**Version**: 1.0.0  
**Last Updated**: February 2026  
**API Version**: v1.0  
**Laravel Version**: 9.x
