# NIRCRM - Models & Database Schema Documentation

## Database Overview

The NIRCRM system uses MySQL/MariaDB as its database backend, following Laravel's Eloquent ORM conventions. The database consists of over 40 tables managing users, leads, departments, invoices, attendance, leaves, and more.

## Core Models & Relationships

### 1. User Model (`users` table)

**Purpose**: Central user management and authentication

**Key Fields**:
- `id` - Primary key
- `name`, `last_name` - User's full name
- `email` - Login email (unique)
- `password` - Hashed password
- `role` - User role (1=Admin, 2=Employee, 3=Customer, 4=Manager, 5=General Manager)
- `department_id` - Foreign key to departments
- `manager_id` - Self-referencing key for manager-subordinate relationship
- `employeeID` - Employee identification number
- `contact_number`, `phone` - Contact information
- `position`, `designation` - Job title and position
- `salary` - Employee salary
- `joining_date` - Employment start date
- `is_active` - Account status
- `shift_id` - Work shift assignment

**Relationships**:
- `department()` - BelongsTo Department
- `manager()` - BelongsTo User (self-reference)
- `subordinates()` - HasMany User (self-reference)
- `attendances()` - HasMany Attendance
- `leaves()` - HasMany Leave
- `shift()` - BelongsTo Shift

**Key Methods**:
- `isCheckedIn()` - Check if user is currently checked in
- `canApproveLeave()` - Check leave approval permissions
- `getSubordinatesIds()` - Get IDs of all subordinates
- `getDepartmentUsersIds()` - Get IDs of department colleagues

---

### 2. Department Model (`departments` table)

**Purpose**: Organizational structure management

**Key Fields**:
- `id` - Primary key
- `name` - Department name
- `description` - Department description
- `parent_id` - Self-referencing for hierarchical structure
- `is_active` - Department status
- `department_code` - Unique department identifier

**Relationships**:
- `parent()` - BelongsTo Department (self-reference)
- `children()` - HasMany Department (self-reference)
- `users()` - HasMany User
- `departmentMenus()` - HasMany DepartmentMenu

**Key Methods**:
- `getFullPathAttribute()` - Get full hierarchical path
- `getAllDescendants()` - Get all child departments recursively

---

### 3. Lead Model (`leads` table)

**Purpose**: Customer lead management and tracking

**Key Fields**:
- `id` - Primary key
- `name` - Lead contact name
- `email`, `phone` - Contact information
- `company_name` - Lead's company
- `website` - Company website
- `address`, `city`, `state`, `country`, `pincode` - Address details
- `industry` - Industry type
- `lead_status` - Current status (hot, cold, warm, qualified, lost)
- `source` - Lead source (website, referral, social_media, etc.)
- `budget` - Project budget
- `assigned_to` - Assigned user ID
- `follow_up_date` - Scheduled follow-up
- `priority` - Priority level (high, medium, low)
- `department_id` - Department assignment
- `created_by` - User who created the lead

**Relationships**:
- `creator()` - BelongsTo User
- `assignedUser()` - BelongsTo User
- `department()` - BelongsTo Department

**Key Methods**:
- `getLeadStatuses()` - Get available lead statuses
- `getSources()` - Get lead source options
- `getPriorities()` - Get priority options
- `getStatusColor()` - Get UI color for status

---

### 4. Invoice Model (`invoices` table)

**Purpose**: Invoice and billing management

**Key Fields**:
- `id` - Primary key
- `project_name` - Project title
- `project_topic` - Project description
- `project_full_details` - Detailed project information
- `start_date`, `end_date` - Project timeline
- `customer_name`, `customer_email`, `customer_phone` - Customer details
- `customer_address` - Customer address
- `advance_payment` - Amount paid in advance
- `remaining_payment` - Balance amount
- `gst` - GST amount
- `total_payment` - Total invoice amount
- `invoice_number` - Unique invoice identifier
- `invoice_date` - Invoice creation date
- `status` - Invoice status
- `installments` - JSON array of installment details
- `bank_account_number`, `ifsc_code` - Banking details
- `gst_number` - GST identification
- `place_of_supply` - GST place of supply
- `hsn_code` - HSN/SAC code

**Relationships**:
- Soft deletes enabled
- No direct relationships (customer data stored in invoice)

**Key Methods**:
- `generateInvoiceNumber()` - Generate unique invoice number
- `calculateTotalPayment()` - Calculate total with GST
- `formatCurrency()` - Format amounts as currency

---

### 5. Attendance Model (`attendances` table)

**Purpose**: Employee attendance tracking

**Key Fields**:
- `id` - Primary key
- `user_id` - Employee ID
- `date` - Attendance date
- `check_in_time` - Check-in timestamp
- `check_out_time` - Check-out timestamp
- `status` - Attendance status (present, absent, half_day, on_leave, holiday, weekend)
- `working_hours` - Total hours worked
- `overtime_hours` - Overtime hours
- `notes` - Additional notes
- `ip_address` - Check-in IP address
- `location` - Check-in location
- `is_late` - Late arrival flag
- `is_early_checkout` - Early checkout flag

**Relationships**:
- `user()` - BelongsTo User

**Key Methods**:
- `calculateWorkingHours()` - Calculate working and overtime hours
- `scopeByUser()` - Filter by user
- `scopeByDateRange()` - Filter by date range
- `scopeByStatus()` - Filter by status

---

### 6. Leave Model (`leaves` table)

**Purpose**: Employee leave management

**Key Fields**:
- `id` - Primary key
- `user_id` - Employee ID
- `leave_type_id` - Leave type reference
- `start_date`, `end_date` - Leave period
- `total_days` - Number of leave days
- `reason` - Leave reason
- `status` - Leave status (pending, approved, rejected, cancelled, on_hold)
- `approver_id` - Approving manager ID
- `approval_date` - Approval timestamp
- `approval_notes` - Approval comments
- `rejection_reason` - Rejection reason
- `attachments` - File attachments (JSON array)
- `is_half_day` - Half-day leave flag
- `is_full_day` - Full-day leave flag
- `half_day_type` - First/second half
- `emergency_contact` - Emergency contact details
- `is_paid_leave` - Paid leave status

**Relationships**:
- `user()` - BelongsTo User
- `leaveType()` - BelongsTo LeaveType
- `approver()` - BelongsTo User
- `approvals()` - HasMany LeaveApproval

**Key Methods**:
- `getNextApprovalLevel()` - Determine next approval in hierarchy
- `getNextApprover()` - Get next approving authority
- `canBeApprovedBy()` - Check approval permissions
- `approve()` - Approve leave request
- `reject()` - Reject leave request

---

### 7. LeaveType Model (`leave_types` table)

**Purpose**: Leave type definitions and policies

**Key Fields**:
- `id` - Primary key
- `name` - Leave type name
- `description` - Leave type description
- `days_per_year` - Annual entitlement
- `is_paid` - Paid leave status
- `requires_approval` - Approval requirement
- `is_active` - Active status

---

### 8. Shift Model (`shifts` table)

**Purpose**: Work shift management

**Key Fields**:
- `id` - Primary key
- `name` - Shift name
- `start_time` - Shift start time
- `end_time` - Shift end time
- `break_duration` - Break duration in minutes
- `is_active` - Active status

---

### 9. Quotation Model (`quotations` table)

**Purpose**: Project quotations management

**Key Fields**:
- `id` - Primary key
- `project_name` - Project title
- `customer_name` - Customer details
- `customer_email` - Customer email
- `total_amount` - Quotation amount
- `status` - Quotation status
- `valid_until` - Validity period
- `notes` - Additional notes
- `approval_status` - Customer approval status
- `customer_panel` - Customer panel access
- `banking_details` - Banking information

---

### 10. ActivityLog Model (`activity_logs` table)

**Purpose**: System activity audit trail

**Key Fields**:
- `id` - Primary key
- `user_id` - User who performed action
- `action` - Action description
- `model_type` - Model type affected
- `model_id` - Model ID affected
- `old_values` - Previous values (JSON)
- `new_values` - New values (JSON)
- `ip_address` - User IP address
- `user_agent` - Browser information
- `read_at` - Read timestamp

---

### 11. LeadReaction Model (`lead_reactions` table)

**Purpose**: Lead interaction tracking

**Key Fields**:
- `id` - Primary key
- `lead_id` - Lead reference
- `user_id` - User who reacted
- `reaction_type` - Type of reaction
- `message` - Reaction message
- `email_sent` - Email notification status
- `notification_sent` - Notification status

---

### 12. DepartmentMenu Model (`department_menus` table)

**Purpose**: Department-specific menu permissions

**Key Fields**:
- `id` - Primary key
- `department_id` - Department reference
- `menu_name` - Menu identifier
- `is_active` - Menu status
- `order` - Display order

---

### 13. MenuPermission Model (`menu_permissions` table)

**Purpose**: Role-based menu access control

**Key Fields**:
- `id` - Primary key
- `role_id` - Role reference
- `menu_name` - Menu identifier
- `can_access` - Access permission
- `can_create` - Create permission
- `can_edit` - Edit permission
- `can_delete` - Delete permission

---

## Database Schema Relationships

### Hierarchical Relationships

```
Users
├── Department (Many-to-One)
├── Manager (Self-reference, Many-to-One)
├── Subordinates (Self-reference, One-to-Many)
├── Attendances (One-to-Many)
├── Leaves (One-to-Many)
└── Shift (Many-to-One)

Departments
├── Parent Department (Self-reference, Many-to-One)
├── Child Departments (Self-reference, One-to-Many)
└── Users (One-to-Many)

Leads
├── Creator (User, Many-to-One)
├── Assigned User (User, Many-to-One)
└── Department (Many-to-One)

Leaves
├── User (Many-to-One)
├── Leave Type (Many-to-One)
├── Approver (User, Many-to-One)
└── Approvals (One-to-Many)
```

### Data Flow Relationships

```
Lead Creation → Lead Assignment → Lead Reactions → Lead Conversion
     ↓              ↓                ↓               ↓
User (creator)  User (assigned)  User (reactor)  Invoice/Quotation
     ↓              ↓                ↓               ↓
Department    Department      Department      Department
```

## Database Constraints & Indexes

### Primary Keys
All tables use auto-incrementing integer primary keys named `id`.

### Foreign Keys
- `users.department_id` → `departments.id`
- `users.manager_id` → `users.id`
- `users.shift_id` → `shifts.id`
- `leads.assigned_to` → `users.id`
- `leads.created_by` → `users.id`
- `leads.department_id` → `departments.id`
- `attendances.user_id` → `users.id`
- `leaves.user_id` → `users.id`
- `leaves.leave_type_id` → `leave_types.id`
- `leaves.approver_id` → `users.id`

### Indexes
- Unique indexes on email fields
- Composite indexes on frequently queried combinations
- Date indexes for time-based queries
- Status indexes for filtering

### Soft Deletes
- Invoices model uses soft deletes
- Preserves data integrity for financial records

## Data Types & Casting

### Date/Time Fields
- `date` fields cast to `date`
- `datetime` fields cast to `datetime`
- Time fields use `datetime:H:i` format

### Numeric Fields
- Currency fields cast to `decimal:2`
- Boolean fields cast to `boolean`
- Integer fields remain as integers

### JSON Fields
- Array fields cast to `array`
- Configuration data stored as JSON
- Flexible data structure support

## Security Considerations

### Sensitive Data
- Passwords are automatically hashed by Laravel
- OTP fields have expiration dates
- Financial data uses decimal precision

### Audit Trail
- Activity logs track all changes
- IP addresses and user agents recorded
- Old and new values preserved

### Access Control
- Role-based permissions enforced at model level
- Department-based data filtering
- Manager-subordinate hierarchy respected

---

## Migration Files Structure

The database schema is managed through Laravel migrations in the `database/migrations/` directory. Key migration files include:

- User management: `2022_12_09_144604_create_users_table.php`
- Department structure: `2024_02_18_000001_create_departments_table.php`
- Attendance system: `2024_02_18_000003_create_attendances_table.php`
- Leave management: `2024_02_18_000004_create_leaves_table.php`
- Lead management: `2026_01_30_180000_create_leads_table.php`
- Invoice system: `2026_01_07_155436_create_invoices_table.php`

Each migration file contains the complete table structure with column definitions, indexes, and foreign key constraints.

---

**Version**: 1.0.0  
**Last Updated**: February 2026  
**Database Version**: MySQL 5.7+ / MariaDB 10.3+
