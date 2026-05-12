# NIRCRM - User Manual for Different Roles

## Table of Contents

1. [System Overview](#system-overview)
2. [Getting Started](#getting-started)
3. [Super Admin Guide](#super-admin-guide)
4. [General Manager Guide](#general-manager-guide)
5. [Manager Guide](#manager-guide)
6. [Employee Guide](#employee-guide)
7. [Customer Guide](#customer-guide)
8. [Common Features](#common-features)
9. [Troubleshooting](#troubleshooting)

---

## System Overview

NIRCRM is a comprehensive Customer Relationship Management system designed to streamline business operations, manage customer relationships, track leads, handle employee management, and automate various business processes.

### Key Features
- **Lead Management**: Track and convert leads into customers
- **Employee Management**: Complete HR and attendance system
- **Invoice Management**: Professional invoicing with PDF generation
- **WhatsApp-Style Interface**: Familiar and intuitive user experience
- **Role-Based Access**: Different features for different user roles
- **Real-Time Notifications**: Stay updated with important events
- **Multi-Department Support**: Organize teams by departments
- **Attendance Tracking**: Check-in/check-out with shift management
- **Leave Management**: Request and approve leave applications
- **Reporting & Analytics**: Comprehensive business insights

---

## Getting Started

### First-Time Login

1. **Access the System**
   - Open your web browser
   - Navigate to your company's CRM URL
   - Enter your credentials provided by your administrator

2. **Initial Setup**
   - Update your profile information
   - Set a strong password
   - Upload a profile photo (optional)
   - Configure notification preferences

3. **Navigation Basics**
   - **Sidebar**: Main navigation menu (collapsible)
   - **Dashboard**: Your personalized home screen
   - **Search**: Quick access to records
   - **Notifications**: Stay informed about updates

### Interface Overview

```
┌─────────────────────────────────────────────────────────┐
│                    Header Bar                            │
├─────────┬───────────────────────────────────────────────┤
│ Sidebar │                Main Content                   │
│         │                                               │
│ • Profile│  • Dashboard                                   │
│ • Notifs│  • Search Bar                                  │
│ • Chat  │  • List View                                   │
│ • Leads │  • Detail View                                 │
│ • Tasks │  • Action Buttons                              │
│ • ...   │                                               │
├─────────┴───────────────────────────────────────────────┤
│                    Status Bar                            │
└─────────────────────────────────────────────────────────┘
```

---

## Super Admin Guide

### Role Overview
**Super Admin** has complete system access and can manage all aspects of the CRM system.

### Responsibilities
- System configuration and maintenance
- User account management
- Department structure setup
- Global reporting and analytics
- Security and permissions management
- System backups and maintenance

### Key Features Access

#### 1. User Management
```
Path: Users → Employee Management
```

**Actions Available:**
- Create, edit, delete user accounts
- Assign roles and departments
- Set manager-subordinate relationships
- Manage user permissions
- Deactivate/reactivate accounts
- Reset passwords

**Step-by-Step: Creating a New User**
1. Navigate to **Users → Employee Management**
2. Click **"Add New Employee"**
3. Fill in required information:
   - Personal details (name, email, phone)
   - Job information (position, department, salary)
   - Account settings (role, permissions)
4. Assign to department and manager
5. Set work shift if applicable
6. Click **"Create Employee"**

#### 2. Department Management
```
Path: Settings → Departments
```

**Actions Available:**
- Create hierarchical department structure
- Assign department managers
- Set department-specific permissions
- Configure department menus
- Activate/deactivate departments

**Creating Department Hierarchy:**
1. Go to **Settings → Departments**
2. Click **"Add Department"**
3. Enter department details:
   - Department name
   - Description
   - Parent department (for sub-departments)
   - Department code
4. Assign department manager
5. Configure menu access
6. Save department

#### 3. System Configuration
```
Path: Settings → System Configuration
```

**Configuration Options:**
- Company information
- Email settings
- Backup schedules
- Security policies
- Notification preferences
- Theme customization

#### 4. Global Reports
```
Path: Reports → Analytics
```

**Available Reports:**
- User activity reports
- Department performance
- Lead conversion rates
- Revenue analytics
- Attendance statistics
- System usage metrics

#### 5. Security Management
```
Path: Settings → Security
```

**Security Tasks:**
- Password policy configuration
- Two-factor authentication setup
- Session management
- Access log monitoring
- Security audit reports

### Daily Workflow

#### Morning Routine
1. **Check System Status**
   - Review system health
   - Check backup completion
   - Monitor error logs

2. **Review User Activity**
   - Check new user registrations
   - Review permission requests
   - Monitor unusual activity

3. **Department Updates**
   - Review department changes
   - Approve department requests
   - Update organizational structure

#### Weekly Tasks
1. **User Management Review**
   - Deactivate inactive accounts
   - Update user permissions
   - Review role assignments

2. **System Maintenance**
   - Apply security updates
   - Optimize database performance
   - Review backup integrity

3. **Reporting**
   - Generate weekly usage reports
   - Analyze system performance
   - Plan system improvements

---

## General Manager Guide

### Role Overview
**General Manager** oversees multiple departments and has high-level approval authority.

### Responsibilities
- Multi-department oversight
- High-level leave approvals
- Strategic decision support
- Performance monitoring
- Resource allocation

### Key Features Access

#### 1. Department Oversight
```
Path: Dashboard → Department Overview
```

**Features:**
- View all department performance
- Compare department metrics
- Resource allocation analysis
- Inter-department collaboration

#### 2. High-Level Approvals
```
Path: Approvals → Pending Items
```

**Approval Authority:**
- Manager leave requests
- High-value invoices
- Department budget requests
- Strategic project approvals

#### 3. Strategic Reports
```
Path: Reports → Strategic Analytics
```

**Report Types:**
- Department performance comparison
- Revenue trends analysis
- Resource utilization
- Growth projections

#### 4. Team Management
```
Path: Teams → Management
```

**Management Features:**
- Manager assignments
- Department restructuring
- Performance reviews
- Team coordination

### Daily Workflow

#### Morning Review
1. **Department Status Check**
   - Review department dashboards
   - Check critical issues
   - Monitor team performance

2. **Approval Queue**
   - Review pending high-level approvals
   - Process urgent requests
   - Delegate when appropriate

#### Strategic Planning
1. **Performance Analysis**
   - Review department metrics
   - Identify improvement areas
   - Plan resource allocation

2. **Team Coordination**
   - Meet with department managers
   - Address cross-department issues
   - Align team objectives

---

## Manager Guide

### Role Overview
**Manager** oversees specific departments and teams with approval authority for team members.

### Responsibilities
- Department team management
- Leave approval for team members
- Performance monitoring
- Task assignment and tracking
- Team coordination

### Key Features Access

#### 1. Team Management
```
Path: Dashboard → My Team
```

**Team Features:**
- View team member profiles
- Monitor attendance
- Track performance metrics
- Assign tasks and projects
- Team communication

**Managing Team Members:**
1. Navigate to **Dashboard → My Team**
2. View team roster with status
3. Click on team member for details
4. Review attendance and performance
5. Assign tasks or projects
6. Send messages or notifications

#### 2. Leave Management
```
Path: Leave → Team Leave Requests
```

**Leave Approval Process:**
1. **Review Leave Requests**
   - Check leave details
   - Verify team coverage
   - Review leave balance

2. **Approval Actions**
   - Approve with notes
   - Reject with reason
   - Request more information

3. **Team Coverage Planning**
   - Plan for absence coverage
   - Reassign tasks if needed
   - Update project timelines

**Step-by-Step Leave Approval:**
1. Go to **Leave → Team Leave Requests**
2. Review pending requests
3. Click on request for details:
   - Leave dates and duration
   - Reason for leave
   - Team impact assessment
4. Make decision:
   - **Approve**: Add approval notes
   - **Reject**: Provide clear reason
   - **Request Info**: Ask for clarification

#### 3. Attendance Monitoring
```
Path: Attendance → Team Attendance
```

**Attendance Features:**
- Real-time attendance status
- Late arrival tracking
- Absence reporting
- Monthly attendance summaries

**Daily Attendance Review:**
1. Check team check-in status
2. Identify late arrivals
3. Follow up on absent team members
4. Address attendance issues

#### 4. Task Management
```
Path: Tasks → Team Tasks
```

**Task Management Features:**
- Create and assign tasks
- Set priorities and deadlines
- Track task progress
- Monitor completion rates

**Assigning Tasks:**
1. Go to **Tasks → Team Tasks**
2. Click **"New Task"**
3. Fill in task details:
   - Task title and description
   - Assigned team member(s)
   - Priority level
   - Due date
   - Required resources
4. Set up notifications
5. Save and assign task

#### 5. Performance Tracking
```
Path: Reports → Team Performance
```

**Performance Metrics:**
- Individual performance scores
- Team productivity metrics
- Goal completion rates
- Attendance patterns

### Daily Workflow

#### Morning Routine
1. **Team Status Check**
   - Review team attendance
   - Check urgent messages
   - Review overnight updates

2. **Task Prioritization**
   - Review new task assignments
   - Prioritize daily activities
   - Allocate resources

3. **Leave Approvals**
   - Process pending leave requests
   - Plan team coverage
   - Update schedules

#### Throughout the Day
1. **Team Communication**
   - Check team messages
   - Address team issues
   - Provide guidance and support

2. **Progress Monitoring**
   - Track task completion
   - Monitor project progress
   - Address bottlenecks

3. **Performance Management**
   - Provide feedback
   - Address performance issues
   - Recognize achievements

#### End of Day
1. **Daily Review**
   - Review completed tasks
   - Plan next day's priorities
   - Update project status

2. **Team Check-in**
   - Review team accomplishments
   - Address outstanding issues
   - Plan for tomorrow

---

## Employee Guide

### Role Overview
**Employee** has access to personal dashboard, assigned tasks, and basic CRM functions.

### Responsibilities
- Complete assigned tasks
- Manage personal attendance
- Request leave when needed
- Update personal information
- Communicate with team

### Key Features Access

#### 1. Personal Dashboard
```
Path: Dashboard (Home)
```

**Dashboard Features:**
- Personal attendance status
- Assigned tasks list
- Recent notifications
- Quick actions menu
- Team updates

**Using Your Dashboard:**
1. **Check Attendance Status**
   - View current check-in status
   - See working hours today
   - Review attendance history

2. **Task Overview**
   - View assigned tasks
   - Check due dates
   - Mark tasks as complete

3. **Notifications Center**
   - Review new notifications
   - Check important updates
   - Respond to messages

#### 2. Attendance Management
```
Path: Attendance → My Attendance
```

**Attendance Features:**
- Daily check-in/check-out
- Attendance history
- Working hours summary
- Leave records

**Daily Check-in Process:**
1. Go to **Attendance → My Attendance**
2. Click **"Check In"** button
3. Confirm check-in time
4. Add notes if needed
5. System records location and time

**Check-out Process:**
1. Click **"Check Out"** button
2. Review working hours
3. Add end-of-day notes
4. Confirm check-out

#### 3. Leave Management
```
Path: Leave → My Leave Requests
```

**Leave Features:**
- Request leave
- View leave balance
- Track leave status
- Leave history

**Requesting Leave:**
1. Go to **Leave → My Leave Requests**
2. Click **"Request Leave"**
3. Select leave type:
   - Casual Leave
   - Sick Leave
   - Annual Leave
   - Half Day Leave
4. Choose dates:
   - Start date and end date
   - Or half day with time
5. Add reason for leave
6. Upload supporting documents (if required)
7. Submit request

**Leave Balance Check:**
1. View available leave days
2. Check leave type balances
3. Review used leave history
4. Plan future leave requests

#### 4. Task Management
```
Path: Tasks → My Tasks
```

**Task Features:**
- View assigned tasks
- Update task status
- Add task comments
- Mark tasks complete

**Working on Tasks:**
1. **View Task List**
   - See all assigned tasks
   - Check priorities and due dates
   - Review task details

2. **Update Task Progress**
   - Mark tasks as in progress
   - Add status updates
   - Upload completed work

3. **Complete Tasks**
   - Mark tasks as complete
   - Add completion notes
   - Request review if needed

#### 5. Lead Management
```
Path: Leads → My Leads
```

**Lead Features:**
- View assigned leads
- Update lead status
- Add lead notes
- Schedule follow-ups

**Managing Leads:**
1. **Review Lead Details**
   - Contact information
   - Lead source and status
   - Previous interactions

2. **Update Lead Status**
   - Change lead status
   - Add new information
   - Schedule follow-up actions

3. **Lead Communication**
   - Add contact notes
   - Record communication
   - Plan next steps

#### 6. Profile Management
```
Path: Profile → My Profile
```

**Profile Features:**
- Update personal information
- Change password
- Upload profile photo
- Set preferences

**Updating Your Profile:**
1. Go to **Profile → My Profile**
2. Edit personal details:
   - Contact information
   - Emergency contacts
   - Personal preferences
3. Update password if needed
4. Upload new profile photo
5. Save changes

### Daily Workflow

#### Start of Day
1. **Check In**
   - Log into system
   - Check in for attendance
   - Review dashboard

2. **Review Priorities**
   - Check assigned tasks
   - Review notifications
   - Plan daily activities

#### During the Day
1. **Task Management**
   - Work on assigned tasks
   - Update task progress
   - Communicate with team

2. **Lead Management**
   - Follow up on leads
   - Update lead information
   - Schedule next actions

3. **Communication**
   - Check messages
   - Respond to notifications
   - Collaborate with team

#### End of Day
1. **Complete Tasks**
   - Finish daily tasks
   - Update task status
   - Report progress

2. **Check Out**
   - Check out from attendance
   - Review day's accomplishments
   - Plan for tomorrow

---

## Customer Guide

### Role Overview
**Customer** has limited access to view their projects, invoices, and communicate with the team.

### Responsibilities
- View project status
- Access invoices and quotations
- Communicate with service team
- Provide feedback and requirements

### Key Features Access

#### 1. Customer Dashboard
```
Path: Dashboard (Customer View)
```

**Dashboard Features:**
- Active projects overview
- Recent invoices
- Unpaid invoices
- Messages from team
- Quick contact options

#### 2. Project Management
```
Path: Projects → My Projects
```

**Project Features:**
- View project details
- Track project progress
- Download project files
- View project timeline

#### 3. Invoice Management
```
Path: Invoices → My Invoices
```

**Invoice Features:**
- View invoice details
- Download PDF copies
- Check payment status
- View payment history

#### 4. Communication
```
Path: Messages → Communication
```

**Communication Features:**
- Send messages to team
- View conversation history
- Share files and documents
- Request support

---

## Common Features

### 1. Search Functionality
```
Keyboard Shortcut: Ctrl/Cmd + K
```

**Search Options:**
- Global search across all modules
- Filter by record type
- Advanced search options
- Search history

### 2. Notifications System
```
Path: Notifications (Bell Icon)
```

**Notification Types:**
- Task assignments
- Leave approvals
- System updates
- Message alerts
- Deadline reminders

### 3. Theme Switching
```
Path: Sidebar → Theme Toggle
```

**Theme Options:**
- Light mode (default)
- Dark mode
- System preference
- Auto-switch based on time

### 4. File Management
```
Supported Formats: PDF, DOC, DOCX, JPG, JPEG, PNG
Maximum Size: 2MB per file
```

**File Operations:**
- Upload files
- Download documents
- Preview files
- Share with team

### 5. Reporting
```
Path: Reports → [Report Type]
```

**Report Features:**
- Generate custom reports
- Export to PDF/Excel
- Schedule reports
- Share reports

---

## Troubleshooting

### Common Issues

#### Login Problems
**Problem**: Can't log into the system
**Solutions**:
1. Check username and password
2. Verify account is active
3. Clear browser cache
4. Try password reset
5. Contact administrator

#### Attendance Issues
**Problem**: Can't check in or check out
**Solutions**:
1. Check internet connection
2. Verify current time
3. Ensure you're not already checked in/out
4. Contact manager if system error

#### Leave Request Issues
**Problem**: Leave request not submitting
**Solutions**:
1. Check leave balance
2. Verify date format
3. Ensure required fields are filled
4. Try different browser
5. Contact HR department

#### Performance Issues
**Problem**: System running slowly
**Solutions**:
1. Clear browser cache
2. Check internet speed
3. Close unnecessary tabs
4. Try different browser
5. Report to IT department

### Getting Help

#### Self-Service Options
1. **Help Center**: Built-in documentation
2. **FAQ Section**: Common questions answered
3. **Video Tutorials**: Step-by-step guides
4. **System Status**: Check current system status

#### Contact Support
1. **IT Helpdesk**: Technical issues
2. **HR Department**: Account and leave issues
3. **Manager**: Work-related questions
4. **System Admin**: System-wide issues

#### Emergency Contacts
- **System Administrator**: [Admin Email/Phone]
- **IT Support**: [IT Email/Phone]
- **HR Department**: [HR Email/Phone]

### Best Practices

#### Security
- Use strong passwords
- Log out when finished
- Don't share credentials
- Report suspicious activity

#### Data Management
- Save work frequently
- Backup important data
- Follow data retention policies
- Keep information accurate

#### Communication
- Check notifications regularly
- Respond to messages promptly
- Use professional communication
- Document important conversations

---

## Quick Reference

### Keyboard Shortcuts
```
Ctrl/Cmd + K     - Open search
Ctrl/Cmd + /     - Show keyboard shortcuts
Escape           - Close modals/popup
Ctrl/Cmd + S     - Save (in forms)
Enter            - Submit forms
Tab              - Navigate fields
```

### Common Paths
```
Dashboard        - Home/Dashboard
Profile          - User profile
Attendance       - Check-in/Check-out
Leave            - Leave requests
Tasks            - Task management
Leads            - Lead management
Invoices         - Invoice management
Reports          - Reports and analytics
Settings         - System settings
```

### Contact Information
```
System Admin:    admin@company.com
IT Support:       it@company.com
HR Department:    hr@company.com
Manager:          manager@company.com
```

---

**Version**: 1.0.0  
**Last Updated**: February 2026  
**Document Type**: User Manual  
**Target Audience**: All System Users
