<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Root route redirect to CRM login - MUST be first
Route::get('/', function() {
    return redirect('/crmlogin');
});
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\InvoiceManagementController;
use App\Http\Controllers\Backend\ActionController;
use App\Http\Controllers\Backend\GroupController;
use App\Http\Controllers\Backend\Ticket_statusController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\SalesController;
use App\Http\Controllers\Backend\ITEmployeeController;
use App\Http\Controllers\Backend\ReminderController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\systemtypeController;
use App\Http\Controllers\Backend\servicecategoryController;
use App\Http\Controllers\Backend\operatingsystemController;

use App\Http\Controllers\Backend\TicketController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Backend\LogsController;
use App\Http\Controllers\ProjectUpdateController;
use App\Http\Controllers\Backend\ApprovalStatusController;
use App\Http\Controllers\Backend\AccountController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\ReactionNotificationController;
use App\Http\Controllers\Admin\ReactionsSystemController;
use App\Http\Controllers\Admin\StaprioController;
use App\Http\Controllers\LeadNotificationController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\QuotationController;
use App\Http\Controllers\Backend\RoleMenuController;
use App\Http\Controllers\Backend\DepartmentMenuController;
use App\Http\Controllers\CustomerPasswordChangeController;
use App\Http\Controllers\XrayViewerController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\GoogleSheetsController;
use App\Http\Controllers\GoogleSheetsManagementController;
use App\Http\Controllers\SimpleGoogleSheetsController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\AutomatedSyncController;
use App\Http\Controllers\ExternalSyncController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\EmployeeTaskController;
use App\Http\Controllers\AdminController;

use  App\Models\Department;
use  App\Models\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware(['auth'])->get('/redirect' ,[HomeController::class, "index"]);

// Project Completion Status Routes
Route::get('/project-updates/{id}/completion-status', [ProjectUpdateController::class, 'createCompletionStatus'])->name('project-updates.completion-status.create');
Route::post('/project-updates/{id}/completion-status', [ProjectUpdateController::class, 'storeCompletionStatus'])->name('project-updates.completion-status.store');
Route::put('/project-updates/completion-status/{id}', [ProjectUpdateController::class, 'updateCompletionStatus'])->name('project-updates.completion-status.update');
Route::post('/project-updates/{id}/update-progress', [ProjectUpdateController::class, 'updateProgress'])->name('project-updates.progress.update');

// CRM Login Route
Route::get('/crmlogin', function() {
    // Check if we need to clear the splash screen flag
    if (session('clear_splash')) {
        // Flash the clear_splash flag to the view
        return view('crmlogin')->with('clearSplash', true);
    }
    return view('crmlogin');
})->name('crmlogin');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $adminData = Auth::user();
        return view('admin.index', compact('adminData'));
    })->name('admin.dashboard');
    
    // CRM Tasks Management Route
    Route::get('/admin/crm-tasks', [EmployeeTaskController::class, 'adminCrmTasks'])->name('admin.crm.tasks');
    Route::get('/admin/crm-tasks/{taskId}/details', [EmployeeTaskController::class, 'getTaskDetails'])->name('admin.crm.tasks.details');
    
});

// Public attachment download route (for email links) - NO AUTH REQUIRED
Route::get('/public/attachments/{filename}', function($filename) {
    $path = storage_path('app/public/attachments/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->download($path);
})->name('attachments.public.download');

Route::middleware(['auth', 'require.password.change'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Password Change Routes
    Route::get('/check-password-change-required', [CustomerPasswordChangeController::class, 'checkPasswordChangeRequired'])->name('password.check.required');
    Route::post('/change-password', [CustomerPasswordChangeController::class, 'changePassword'])->name('password.change');
    
    // Project Update Routes
    Route::get('/project-updates', [ProjectUpdateController::class, 'index'])->name('project-updates.index');
    Route::get('/project-updates/dashboard', [ProjectUpdateController::class, 'projectDashboard'])->name('project-updates.dashboard');
    Route::get('/project-updates/{id}', [ProjectUpdateController::class, 'show'])->name('project-updates.show');
    Route::post('/project-updates', [ProjectUpdateController::class, 'store'])->name('project-updates.store');
    Route::post('/project-updates/update-status', [ProjectUpdateController::class, 'updateTaskStatus'])->name('project-updates.update-status');
    Route::delete('/project-updates/{id}', [ProjectUpdateController::class, 'destroy'])->name('project-updates.destroy');
    
    // Authenticated attachment download route (for portal)
    Route::get('/attachments/{filename}', function($filename) {
        $path = storage_path('app/public/attachments/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->download($path);
    })->name('attachments.download');
    
    // Attachment view route (opens in browser)
    Route::get('/attachments/{filename}/view', function($filename) {
        $path = storage_path('app/public/attachments/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path, ['Content-Disposition' => 'inline; filename="' . basename($path) . '"']);
    })->name('attachments.view');
    
    // Logs Routes
    Route::get('/logs', [LogsController::class, 'index'])->name('logs');
    Route::get('/api/logs', [LogsController::class, 'getLogs'])->name('logs.api');
    Route::post('/api/logs/{id}/read', [LogsController::class, 'markAsRead'])->name('logs.read');
    Route::post('/api/logs/read-all', [LogsController::class, 'markAllAsRead'])->name('logs.read-all');
    Route::post('/api/logs/activity', [LogsController::class, 'logActivity'])->name('logs.activity');
    Route::get('/api/logs/stats', [LogsController::class, 'getStats'])->name('logs.stats');
    Route::get('/api/logs/realtime', [LogsController::class, 'getRealTimeActivities'])->name('logs.realtime');
});


require __DIR__.'/auth.php';


    Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
    Route::post('/admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/update/change/password', [AdminProfileController::class, 'AdminUpdateChangePassword'])->name('update.change.password');

    // Invoice Routes
Route::resource('invoices', InvoiceController::class);
Route::get('/invoices/{invoice}/view', [InvoiceController::class, 'viewOnly'])->name('invoices.view');
Route::get('/invoices/{invoice}/export/pdf', [InvoiceController::class, 'exportPDF'])->name('invoices.export.pdf');
Route::get('/invoices/{invoice}/export/word', [InvoiceController::class, 'exportWord'])->name('invoices.export.word');
Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'printInvoice'])->name('invoices.print');
Route::post('/invoices/{invoice}/send-reminder', [InvoiceController::class, 'sendPaymentReminder'])->name('invoices.send.reminder');

// Debug route for email testing
Route::get('/test-email', function() {
    return response()->json(['message' => 'Email test route working']);
});

// Debug route for PDF testing
Route::get('/test-pdf', function() {
    try {
        $html = '<html><body><h1>Test PDF</h1><p>This is a test PDF generated at ' . date('Y-m-d H:i:s') . '</p></body></html>';
        
        $pdf = new \Dompdf\Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        
        $filename = 'test_pdf_' . time() . '.pdf';
        
        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
            
    } catch (\Exception $e) {
        return response()->json(['error' => 'PDF generation failed: ' . $e->getMessage()], 500);
    }
});

// Simple PDF download route - always works
Route::get('/simple-pdf-download/{invoice}', [InvoiceController::class, 'simplePdfDownload'])->name('invoices.simple.pdf');

// Simple print route - always works
Route::get('/simple-print/{invoice}', [InvoiceController::class, 'simplePrint'])->name('invoices.simple.print');

// Test email attachment route
Route::get('/test-email-attachment', function() {
    $testUpdate = new stdClass();
    $testUpdate->attachment = '1778135396_1778074637_slider menu first 6 pages.png';
    
    $attachmentPath = storage_path('app/public/' . $testUpdate->attachment);
    
    $html = '<h1>Email Attachment Test</h1>';
    $html .= '<p><strong>Attachment:</strong> ' . basename($testUpdate->attachment) . '</p>';
    $html .= '<p><strong>File Path:</strong> ' . $attachmentPath . '</p>';
    $html .= '<p><strong>File Exists:</strong> ' . (file_exists($attachmentPath) ? 'YES' : 'NO') . '</p>';
    $html .= '<p><strong>Public Download URL:</strong> <a href="/public/attachments/' . basename($testUpdate->attachment) . '">Download Public</a></p>';
    $html .= '<p><strong>Authenticated Download URL:</strong> <a href="/attachments/' . basename($testUpdate->attachment) . '">Download Auth</a></p>';
    
    return $html;
});

    // Employee Routes
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/verify', [EmployeeController::class, 'verify'])->name('employees.verify');
    Route::post('/employees/verify-otp', [EmployeeController::class, 'verifyOtp'])->name('employees.verify-otp');
    Route::post('/employees/resend-otp', [EmployeeController::class, 'resendOtp'])->name('employees.resend-otp');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    
    // Customer Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/verify', [CustomerController::class, 'verify'])->name('customers.verify');
        Route::post('/customers/verify-otp', [CustomerController::class, 'verifyOtp'])->name('customers.verify-otp');
        Route::post('/customers/resend-otp', [CustomerController::class, 'resendOtp'])->name('customers.resend-otp');
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });
    
    // Employee Report Routes
    Route::get('/employee-report', [ProjectUpdateController::class, 'employeeReportIndex'])->name('employee-report.index');
    Route::match(['get', 'post'], '/employee-report/generate', [ProjectUpdateController::class, 'generateEmployeeReport'])->name('employee-report.generate');
    Route::post('/employee-report/email', [ProjectUpdateController::class, 'sendEmployeeReportEmail'])->name('employee-report.email');
    Route::get('/employee-report/export', [ProjectUpdateController::class, 'exportEmployeeReport'])->name('employee-report.export');
    
    // Approval Status Routes
    Route::prefix('approval-status')->group(function () {
        Route::get('/', [ApprovalStatusController::class, 'index'])->name('approval-status.index');
        Route::get('/create', [ApprovalStatusController::class, 'create'])->name('approval-status.create');
        Route::post('/', [ApprovalStatusController::class, 'store'])->name('approval-status.store');
        Route::get('/{id}', [ApprovalStatusController::class, 'show'])->name('approval-status.show');
        Route::post('/{id}/approve', [ApprovalStatusController::class, 'approve'])->name('approval-status.approve');
        Route::post('/{id}/reject', [ApprovalStatusController::class, 'reject'])->name('approval-status.reject');
        Route::get('/statistics', [ApprovalStatusController::class, 'statistics'])->name('approval-status.statistics');
    });
    

    // Test route for debugging
Route::get('/test-categories', function() {
    $category = \App\Models\Department::latest()->get();
    return "Found " . $category->count() . " departments. First: " . ($category->first()->department ?? 'None');
});

// Categories redirect route - redirects to category view  
Route::get('/categories', [CategoryController::class, 'CategoryView'])->name('categories.redirect')->middleware('auth');

// Admin Category all Routes  
Route::prefix('category')->group(function(){

    Route::get('/view', [CategoryController::class, 'CategoryView'])->name('all.category');
    Route::post('/store', [CategoryController::class, 'CategoryStore'])->name('category.store');
    Route::get('/edit/{id}', [CategoryController::class, 'CategoryEdit'])->name('category.edit');
    Route::post('/update/{id}', [CategoryController::class, 'CategoryUpdate'])->name('category.update');
    Route::get('/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('category.delete');
    
    // Admin Sub Category All Routes
    
    Route::get('/sub/view', [SubCategoryController::class, 'SubCategoryView'])->name('all.subcategory');
    Route::post('/sub/store', [SubCategoryController::class, 'SubCategoryStore'])->name('subcategory.store');
    Route::get('/sub/edit/{id}', [SubCategoryController::class, 'SubCategoryEdit'])->name('subcategory.edit');
    Route::post('/update', [SubCategoryController::class, 'SubCategoryUpdate'])->name('subcategory.update');
    Route::get('/sub/delete/{id}', [SubCategoryController::class, 'SubCategoryDelete'])->name('subcategory.delete');
    
    
    // Admin Sub->Sub Category All Routes
    
    Route::get('/sub/sub/view', [SubCategoryController::class, 'SubSubCategoryView'])->name('all.subsubcategory');
    Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'GetSubCategory']);
    Route::get('/sub-subcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'GetSubSubCategory']);
    Route::get('/service_category/ajax/{service_category_id}', [SubCategoryController::class, 'GetCategory']);

    Route::post('/sub/sub/store', [SubCategoryController::class, 'SubSubCategoryStore'])->name('subsubcategory.store');
    Route::get('/sub/sub/edit/{id}', [SubCategoryController::class, 'SubSubCategoryEdit'])->name('subsubcategory.edit');
    Route::post('/sub/update', [SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subsubcategory.update');
    Route::get('/sub/sub/delete/{id}', [SubCategoryController::class, 'SubSubCategoryDelete'])->name('subsubcategory.delete');
    
    });
// employee details  & it supportive

    
        Route::get('reminder/view', [ReminderController::class, 'reminderView'])->name('all.reminder');
        Route::post('reminder/store', [ReminderController::class, 'reminderStore'])->name('reminder.store');
        Route::get('reminder/edit/{id}', [ReminderController::class, 'reminderEdit'])->name('reminder.edit');
        Route::post('reminder/update/{id}', [ReminderController::class, 'reminderUpdate'])->name('reminder.update');
        Route::get('reminder/delete/{id}', [ReminderController::class, 'reminderDelete'])->name('reminder.delete');
        Route::get('reminder/add', [ReminderController::class, 'reminderAdd'])->name('add-reminder');
       Route::get('/generate-id', [ReminderController::class, 'generateId']);





        Route::get('customer/view', [CustomerController::class, 'customerView'])->name('all.customer');
        Route::post('customer/store', [CustomerController::class, 'customerStore'])->name('customer.store');
        Route::get('customer/edit/{id}', [CustomerController::class, 'customerEdit'])->name('customer.edit');
        Route::post('customer/update/{id}', [CustomerController::class, 'customerUpdate'])->name('customer.update');
        Route::get('customer/delete/{id}', [CustomerController::class, 'customerDelete'])->name('customer.delete');
        Route::get('customer/add', [CustomerController::class, 'customerAdd'])->name('add-customer');



        Route::get('Employee/view', [EmployeeController::class, 'EmployeeView'])->name('all.Employee');
        Route::post('Employee/store', [EmployeeController::class, 'EmployeeStore'])->name('Employee.store');
        Route::get('Employee/edit/{id}', [EmployeeController::class, 'EmployeeEdit'])->name('Employee.edit');
        Route::post('Employee/update/{id}', [EmployeeController::class, 'EmployeeUpdate'])->name('Employee.update');
        Route::get('Employee/delete/{id}', [EmployeeController::class, 'EmployeeDelete'])->name('Employee.delete');
        Route::get('Employee/add', [EmployeeController::class, 'EmployeeAdd'])->name('add-Employee');

        Route::get('sales/view', [SalesController::class, 'salesView'])->name('all.sales');
        Route::post('sales/store', [SalesController::class, 'salesStore'])->name('sales.store');
        Route::get('sales/edit/{id}', [SalesController::class, 'salesEdit'])->name('sales.edit');
        Route::post('sales/update/{id}', [SalesController::class, 'salesUpdate'])->name('sales.update');
        Route::get('sales/delete/{id}', [SalesController::class, 'salesDelete'])->name('sales.delete');
        Route::get('sales/add', [SalesController::class, 'salesAdd'])->name('add-sales');



        Route::get('ITEmployee/view', [ITEmployeeController::class, 'EmployeeView'])->name('all.ITEmployee');
        Route::post('ITEmployee/store', [ITEmployeeController::class, 'EmployeeStore'])->name('ITEmployee.store');
        Route::get('ITEmployee/edit/{id}', [ITEmployeeController::class, 'EmployeeEdit'])->name('ITEmployee.edit');
        Route::post('ITEmployee/update/{id}', [ITEmployeeController::class, 'EmployeeUpdate'])->name('ITEmployee.update');
        Route::get('ITEmployee/delete/{id}', [ITEmployeeController::class, 'EmployeeDelete'])->name('ITEmployee.delete');
        Route::get('ITEmployee/add', [ITEmployeeController::class, 'EmployeeAdd'])->name('add-ITEmployee');

        Route::prefix('control')->group(function(){

            // Route of priority

            Route::get('/brand/view', [BrandController::class, 'BrandView'])->name('all.brand');
            Route::post('/brand/store', [BrandController::class, 'BrandStore'])->name('brand.store');
            Route::get('/brand/edit/{id}', [BrandController::class, 'BrandEdit'])->name('brand.edit');
            Route::post('/brand/update', [BrandController::class, 'BrandUpdate'])->name('brand.update');
            Route::get('/brand/delete/{id}', [BrandController::class, 'BrandDelete'])->name('brand.delete');
            

            // system_type
            Route::get('/system_type/view', [systemtypeController::class, 'system_typeView'])->name('all.system_type');
            Route::post('/system_type/store', [systemtypeController::class, 'system_typeStore'])->name('system_type.store');
            Route::get('/system_type/edit/{id}', [systemtypeController::class, 'system_typeEdit'])->name('system_type.edit');
            Route::post('/system_type/update', [systemtypeController::class, 'system_typeUpdate'])->name('system_type.update');
            Route::get('/system_type/delete/{id}', [systemtypeController::class, 'system_typeDelete'])->name('system_type.delete');


              // service_category
            Route::get('/service_category/view', [servicecategoryController::class, 'service_categoryView'])->name('all.service_category');
            Route::post('/service_category/store', [servicecategoryController::class, 'service_categoryStore'])->name('service_category.store');
            Route::get('/service_category/edit/{id}', [servicecategoryController::class, 'service_categoryEdit'])->name('service_category.edit');
            Route::post('/service_category/update', [servicecategoryController::class, 'service_categoryUpdate'])->name('service_category.update');
            Route::get('/service_category/delete/{id}', [servicecategoryController::class, 'service_categoryDelete'])->name('service_category.delete');
            

                    // operating_system
                    Route::get('/operating_system/view', [operatingsystemController::class, 'operating_systemView'])->name('all.operating_system');
                    Route::post('/operating_system/store', [operatingsystemController::class, 'operating_systemStore'])->name('operating_system.store');
                    Route::get('/operating_system/edit/{id}', [operatingsystemController::class, 'operating_systemEdit'])->name('operating_system.edit');
                    Route::post('/operating_system/update', [operatingsystemController::class, 'operating_systemUpdate'])->name('operating_system.update');
                    Route::get('/operating_system/delete/{id}', [operatingsystemController::class, 'operating_systemDelete'])->name('operating_system.delete');
                    
            // Route of department

            Route::get('/Department/view', [DepartmentController::class, 'DepartmentView'])->name('all.Department');
             Route::post('/Department/store', [DepartmentController::class, 'DepartmentStore'])->name('Department.store');
             Route::get('/Department/edit/{id}', [DepartmentController::class, 'DepartmentEdit'])->name('Department.edit');
             Route::post('/Department/update', [DepartmentController::class, 'DepartmentUpdate'])->name('Department.update');
             Route::get('/Department/delete/{id}', [DepartmentController::class, 'DepartmentDelete'])->name('Department.delete');


             //action
             Route::get('/Action/view', [ActionController::class, 'ActionView'])->name('all.Action');
             Route::post('/Action/store', [ActionController::class, 'ActionStore'])->name('Action.store');
             Route::get('/Action/edit/{id}', [ActionController::class, 'ActionEdit'])->name('Action.edit');
             Route::post('/Action/update', [ActionController::class, 'ActionUpdate'])->name('Action.update');
             Route::get('/Action/delete/{id}', [ActionController::class, 'ActionDelete'])->name('Action.delete');
            

            
            //  Route of Ticket Status

             Route::get('/ticket_status/view', [Ticket_statusController::class, 'Ticket_statusView'])->name('all.Ticket_status');
             Route::post('/ticket_status/store', [Ticket_statusController::class, 'Ticket_statusStore'])->name('Ticket_status.store');
             Route::get('/ticket_status/edit/{id}', [Ticket_statusController::class, 'Ticket_statusEdit'])->name('Ticket_status.edit');
             Route::post('/ticket_status/update', [Ticket_statusController::class, 'Ticket_statusUpdate'])->name('Ticket_status.update');
             Route::get('/ticket_status/delete/{id}', [Ticket_statusController::class, 'Ticket_statusDelete'])->name('Ticket_status.delete');
              
            //  Route of Group

             Route::get('/Group/view', [GroupController::class, 'GroupView'])->name('all.Group');
             Route::post('/Group/store', [GroupController::class, 'GroupStore'])->name('Group.store');
             Route::get('/Group/edit/{id}', [GroupController::class, 'GroupEdit'])->name('Group.edit');
             Route::post('/Group/update', [GroupController::class, 'GroupUpdate'])->name('Group.update');
             Route::get('/Group/delete/{id}', [GroupController::class, 'GroupDelete'])->name('Group.delete');
                 
        });

// Sales Department Routes (Protected)
Route::prefix('sales-department')->middleware(['auth'])->group(function() {
    Route::get('/', [DepartmentController::class, 'salesDepartmentView'])->name('sales.department');
    Route::get('{lead}/create-invoice', [DepartmentController::class, 'createInvoiceFromLead'])->name('sales.department.create-invoice');
    Route::post('{lead}/save-invoice', [DepartmentController::class, 'saveInvoiceFromLead'])->name('sales.department.save-invoice');
    Route::post('{lead}/send-approval-email', [DepartmentController::class, 'sendApprovalEmail'])->name('sales.department.send-approval-email');
    Route::put('{lead}/toggle-customer-panel', [DepartmentController::class, 'toggleCustomerPanelForLead'])->name('sales.department.toggle-customer-panel');
});

// Backup standalone route (for testing)
Route::post('/sales-department/{lead}/send-approval-email', [DepartmentController::class, 'sendApprovalEmail'])->name('sales.department.send-approval-email.backup')->middleware('auth');

// API for real-time updates
Route::get('/api/sales-department/invoice-statuses', [DepartmentController::class, 'getInvoiceStatuses'])->name('api.sales-department.invoice-statuses')->middleware('auth');

// API route for accounts invoice statuses
Route::get('/api/accounts/invoice-statuses', [AccountController::class, 'getInvoiceStatuses'])->name('api.accounts.invoice-statuses');

// Invoice Management Routes
Route::prefix('invoices')->middleware(['auth'])->name('invoices.')->group(function () {
    Route::get('/management/{quotationId}', [InvoiceManagementController::class, 'management'])->name('management');
    Route::get('/create-installment/{quotation}/{installmentLetter}', [InvoiceManagementController::class, 'createInstallment'])->name('create-installment');
    Route::post('/save-installment/{quotation}/{installmentLetter}', [InvoiceManagementController::class, 'saveInstallment'])->name('save-installment');
    Route::post('/send-approval-email', [InvoiceManagementController::class, 'sendApprovalEmail'])->name('send-approval-email');
    Route::get('/test-email', [InvoiceManagementController::class, 'testEmail'])->name('test-email');
    Route::get('/show/{invoice}', [InvoiceManagementController::class, 'view'])->name('management-show');
    Route::delete('/delete/{invoice}', [InvoiceManagementController::class, 'delete'])->name('delete');
    Route::get('/api/statuses', [InvoiceManagementController::class, 'getInvoiceStatuses'])->name('api.statuses');
});

// CSRF Token Refresh Route
Route::get('/refresh-csrf', function() {
    return response()->json(['token' => csrf_token()]);
})->middleware('auth');

// Invoice Approval Routes (Public - no auth required for email links)
Route::get('/invoice/approve/{token}', [DepartmentController::class, 'approveInvoiceEnhanced'])->name('invoice.approve');
Route::get('/invoice/reject/{token}', [DepartmentController::class, 'rejectInvoiceEnhanced'])->name('invoice.reject');

// Invoice Status Check Route (Real-time updates)
Route::get('/invoices/check-approval-status/{invoiceId}', [DepartmentController::class, 'checkApprovalStatus'])->name('invoices.check-approval-status');

Route::prefix('product')->group(function(){
    Route::get('/useraddticket', [TicketController::class, 'AddProductuser'])->name('add-productuser');
    
    
    Route::get('/projects/get-by-system-type', [TicketController::class, 'getProjectsBySystemType'])->name('projects.get_by_system_type');

    Route::get('/add', [TicketController::class, 'AddProduct'])->name('add-product');
       Route::get('/showForm', [TicketController::class, 'showForm'])->name('showForm');
    Route::post('/store', [TicketController::class, 'StoreProduct'])->name('product-store');
    Route::post('/userdatastore', [TicketController::class, 'StoreProductuser'])->name('product-storeuser');
    Route::get('/manage', [TicketController::class, 'ManageProduct'])->name('manage-product');
    Route::get('/Mymanage', [TicketController::class, 'MyManageProduct'])->name('my-manage-product');
    Route::get('/edit/{id}', [TicketController::class, 'EditProduct'])->name('product.edit');
    Route::post('/data/update', [TicketController::class, 'ProductDataUpdate'])->name('product.update');
    Route::post('/userassignupdate', [TicketController::class, 'userassignupdate'])->name('userassignupdate');
    Route::post('/image/update', [TicketController::class, 'MultiImageUpdate'])->name('update-product-image');
    Route::post('/thambnail/update', [TicketController::class, 'ThambnailImageUpdate'])->name('update-product-thambnail');
    Route::get('/multiimg/delete/{id}', [TicketController::class, 'MultiImageDelete'])->name('product.multiimg.delete');
    Route::get('/inactive/{id}', [TicketController::class, 'ProductInactive'])->name('product.inactive');
    Route::get('/active/{id}', [TicketController::class, 'ProductActive'])->name('product.active');
    Route::get('/delete/{id}', [TicketController::class, 'ProductDelete'])->name('product.delete');
    Route::get('/Ticket/ajax/{Department_id}', [TicketController::class, 'GetTicketUserName']);
    Route::get('/timer/ajax', [TicketController::class, 'GetTimer']);
    Route::get('/preview_product/{id}', [TicketController::class, 'PreviewProduct'])->name('product.preview');
    
    Route::get('/editemp/{id}', [TicketController::class, 'EditProductemp'])->name('product.editemp');
    
    Route::post('/data/updateemp', [TicketController::class, 'ProductDataUpdateemp'])->name('product.updateemp');

    // Route::get('/download/{id}', [TicketController::class, 'FileDownload'])->name('product.download');
  
    });

    Route::get('excalate/assign/{id}', [TicketController::class, 'nextteirgroupchange'])->name('excalate.assign');
    Route::get('export-user', [TicketController::class, 'exportUser'])->name('export-user');
    Route::post('import-user', [TicketController::class, 'importUser'])->name('import.user');

// Leads Generation Routes
Route::prefix('leadsmanagement')->middleware(['auth'])->group(function() {
    Route::get('/', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/create', [LeadController::class, 'create'])->name('leads.create');
    Route::get('/create-new', [LeadController::class, 'createNew'])->name('leads.create.new');
    Route::post('/', [LeadController::class, 'store'])->name('leads.store');
    Route::post('/store-new', [LeadController::class, 'storeNew'])->name('leads.store.new');
    Route::get('/{lead}/edit-new', [LeadController::class, 'editNew'])->name('leads.edit.new');
    Route::put('/{lead}/update-new', [LeadController::class, 'updateNew'])->name('leads.update.new');
    Route::get('/upload', [LeadController::class, 'uploadForm'])->name('leads.upload');
    Route::post('/upload', [LeadController::class, 'uploadExcel'])->name('leads.upload.excel');
    Route::get('/direct-upload', [LeadController::class, 'directUploadForm'])->name('leads.direct.upload');
    Route::post('/process-excel', [LeadController::class, 'processExcel'])->name('leads.process.excel');
    Route::post('/save-direct-upload', [LeadController::class, 'saveDirectUpload'])->name('leads.save.direct.upload');
    Route::get('/template', [LeadController::class, 'downloadTemplate'])->name('leads.template');
    Route::get('/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::get('/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    Route::patch('/{lead}/update-field', [LeadController::class, 'updateField'])->name('leads.update.field');
    Route::post('/send-email', [LeadController::class, 'sendEmail'])->name('send.email');
    Route::post('/leads/send-email', [LeadController::class, 'sendEmail'])->name('leads.send.email');
    Route::get('/test-email', [LeadController::class, 'testEmail'])->name('test.email');
    Route::get('/{lead}/reaction', [LeadController::class, 'reaction'])->name('leads.reaction');
    Route::post('/{lead}/reaction', [LeadController::class, 'storeReaction'])->name('leads.reaction.store');
    Route::get('/users-by-department/{department}', [LeadController::class, 'getUsersByDepartment'])->name('leads.users.by.department');
});

// Due Date Management Routes
Route::prefix('duedate')->middleware(['auth'])->group(function() {
    Route::get('/', [LeadController::class, 'dueDateIndex'])->name('duedate.index');
    Route::post('/send-reminder/{lead}', [LeadController::class, 'sendDueDateReminder'])->name('duedate.send.reminder');
    Route::post('/send-bulk-reminders', [LeadController::class, 'sendBulkDueDateReminders'])->name('duedate.send.bulk.reminders');
});

// Google Sheets Integration Routes
Route::prefix('google-sheets')->middleware(['auth'])->group(function() {
    Route::get('/', [GoogleSheetsController::class, 'index'])->name('google-sheets.index');
    Route::post('/test-connection', [GoogleSheetsController::class, 'testConnection'])->name('google-sheets.test-connection');
    Route::get('/preview', [GoogleSheetsController::class, 'preview'])->name('google-sheets.preview');
    Route::post('/import', [GoogleSheetsController::class, 'import'])->name('google-sheets.import');
    Route::post('/sync', [GoogleSheetsController::class, 'sync'])->name('google-sheets.sync');
    Route::get('/configuration', [GoogleSheetsController::class, 'configuration'])->name('google-sheets.configuration');
    Route::post('/configuration', [GoogleSheetsController::class, 'updateConfiguration'])->name('google-sheets.configuration.update');
    Route::get('/statistics', [GoogleSheetsController::class, 'statistics'])->name('google-sheets.statistics');
});

// Google Sheets Management Routes  
Route::get('/googlesheet', [GoogleSheetsManagementController::class, 'index'])->name('google-sheets-management.index');
Route::post('/googlesheet/sync', [GoogleSheetsManagementController::class, 'sync'])->name('google-sheets-management.sync');
Route::get('/googlesheet/export', [GoogleSheetsManagementController::class, 'export'])->name('google-sheets.export');

// Simple Google Sheets API Routes
Route::prefix('api/googlesheets')->group(function() {
    Route::get('/test-connection', [SimpleGoogleSheetsController::class, 'testConnection']);
    Route::get('/new-entries', [SimpleGoogleSheetsController::class, 'getNewEntries']);
    Route::get('/column-data', [SimpleGoogleSheetsController::class, 'getColumnData']);
    Route::post('/sync', [SimpleGoogleSheetsController::class, 'sync']);
    Route::get('/export', [SimpleGoogleSheetsController::class, 'export']);
});

// Calling App Login Routes
Route::get('/callingapplogin', [GoogleSheetsManagementController::class, 'showLoginForm'])->name('callingapp.login');
Route::post('/callingapplogin', [GoogleSheetsManagementController::class, 'login'])->name('callingapp.login.post');
Route::post('/callingapplogout', [GoogleSheetsManagementController::class, 'logout'])->name('callingapp.logout');

// Calling App - Protected Google Sheets View (Authentication Required)
Route::middleware(['auth'])->group(function () {
    Route::get('/callingapp', [GoogleSheetsManagementController::class, 'callingApp'])->name('callingapp.index');
    Route::post('/callingapp/sync', [GoogleSheetsManagementController::class, 'sync'])->name('callingapp.sync');
});

// Calling App to Leads Management Integration (Public Access - No Authentication Required)
Route::get('/callingappleads', [GoogleSheetsManagementController::class, 'showAddLeadsForm'])->name('callingapp.add-leads');
Route::post('/callingappleads', [GoogleSheetsManagementController::class, 'storeLeadFromCallingApp'])->name('callingapp.store-lead');

// Calling App API Routes
Route::get('/callingapp/lead-details/{index}', [GoogleSheetsManagementController::class, 'showLeadDetails'])->name('callingapp.lead-details');
Route::get('/callingapp/lead-data/{index}', [GoogleSheetsManagementController::class, 'getLeadDataForTransfer'])->name('callingapp.lead-data');
Route::get('/callingapp/employees', [GoogleSheetsManagementController::class, 'getEmployees'])->name('callingapp.employees');
Route::get('/callingapp/employees-debug', function() {
    \Log::info('Employee debug route accessed at: ' . now());
    return response()->json([
        'success' => true,
        'message' => 'Debug route working',
        'timestamp' => now()->toISOString(),
        'employees' => \App\Models\Employee::active()->get(['id', 'name', 'email'])
    ]);
})->name('callingapp.employees-debug');

// Debug route to check manually added leads
Route::get('/callingappleads/debug', function() {
    $manuallyAddedLeads = \App\Models\Lead::where('source', 'callingapp')
        ->orderBy('created_at', 'desc')
        ->get();
    
    return response()->json([
        'success' => true,
        'message' => 'Debug route for manually added leads',
        'timestamp' => now()->toISOString(),
        'total_manual_leads' => $manuallyAddedLeads->count(),
        'leads' => $manuallyAddedLeads->map(function($lead) {
            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'source' => $lead->source,
                'created_at' => $lead->created_at->toISOString(),
            ];
        })
    ]);
})->name('callingapp.debug-manual-leads');

// Manual Leads Tab Route
Route::get('/callingapp/manual-leads', [GoogleSheetsManagementController::class, 'showManualLeads'])->name('callingapp.manual-leads');
Route::post('/callingapp/add-employee', [GoogleSheetsManagementController::class, 'addEmployee'])->name('callingapp.add-employee');
Route::post('/callingapp/save-call-details', [GoogleSheetsManagementController::class, 'saveMeetingCallDetails'])->name('callingapp.save-call-details');
Route::post('/callingapp/test-connection', [GoogleSheetsManagementController::class, 'testConnection'])->name('callingapp.test-connection');

// WhatsApp Management Routes
Route::get('/mywhatsapp', [WhatsAppController::class, 'index'])->name('whatsapp.main');
Route::prefix('whatsapp')->middleware(['auth'])->group(function() {
    Route::get('/', [WhatsAppController::class, 'index'])->name('whatsapp.index');
    Route::post('/send', [WhatsAppController::class, 'sendMessage'])->name('whatsapp.send');
    Route::post('/bulk-send', [WhatsAppController::class, 'sendBulkMessage'])->name('whatsapp.bulk.send');
    Route::get('/templates', [WhatsAppController::class, 'getTemplates'])->name('whatsapp.templates');
    Route::get('/history/{leadId}', [WhatsAppController::class, 'getMessageHistory'])->name('whatsapp.history');
    Route::get('/status', [WhatsAppController::class, 'checkStatus'])->name('whatsapp.status');
});
Route::get('/callingapp/call-details/{email}', [GoogleSheetsManagementController::class, 'getMeetingCallDetails'])->name('callingapp.get-call-details');
Route::get('/callingapp/callhistory', [GoogleSheetsManagementController::class, 'showCallHistoryPage'])->name('callingapp.callhistory');
Route::get('/callhistory', [GoogleSheetsManagementController::class, 'showCallHistoryPage'])->name('callhistory.direct');
Route::get('/callingapp/call-details-by-lead', [GoogleSheetsManagementController::class, 'getMeetingCallDetailsByLead'])->name('callingapp.get-call-details-by-lead');
Route::get('/callingapp/meeting-call-detail/{id}', [GoogleSheetsManagementController::class, 'getMeetingCallDetail'])->name('callingapp.get-meeting-call-detail');
Route::put('/callingapp/meeting-call-detail/{id}', [GoogleSheetsManagementController::class, 'updateMeetingCallDetail'])->name('callingapp.update-meeting-call-detail');
Route::get('/callingapp/today-followup-count', [GoogleSheetsManagementController::class, 'getTodayFollowupCount'])->name('callingapp.today-followup-count');

// Automated Sync Routes (No authentication required for cron jobs)
Route::prefix('automated-sync')->group(function() {
    Route::get('/auto-sync', [AutomatedSyncController::class, 'autoSync'])->name('automated-sync.auto-sync');
    Route::get('/check-notifications', [AutomatedSyncController::class, 'checkNewEntriesAndNotify'])->name('automated-sync.check-notifications');
    Route::get('/status', [AutomatedSyncController::class, 'getStatus'])->name('automated-sync.status');
});

// Follow-up Routes
Route::get('/followup', [GoogleSheetsManagementController::class, 'showFollowupPage'])->name('followup.index');
Route::get('/followup/entries', [GoogleSheetsManagementController::class, 'getFollowupEntries'])->name('followup.entries');

// External Database Sync Routes
Route::prefix('external-sync')->middleware(['auth'])->group(function() {
    Route::get('/', [ExternalSyncController::class, 'index'])->name('external-sync.index');
    Route::post('/sync', [ExternalSyncController::class, 'sync'])->name('external-sync.sync');
    Route::post('/generate-sql', [ExternalSyncController::class, 'generateSQL'])->name('external-sync.generate-sql');
    Route::get('/status', [ExternalSyncController::class, 'status'])->name('external-sync.status');
    Route::post('/create-trigger', [ExternalSyncController::class, 'createTrigger'])->name('external-sync.create-trigger');
    Route::post('/test-connection', [ExternalSyncController::class, 'testConnection'])->name('external-sync.test-connection');
});

// Staprio Routes (Status and Priority Management)
Route::prefix('staprio')->middleware(['auth'])->group(function() {
    Route::get('/statuses', [StaprioController::class, 'getStatuses'])->name('staprio.statuses');
    Route::get('/priorities', [StaprioController::class, 'getPriorities'])->name('staprio.priorities');
    Route::post('/', [StaprioController::class, 'store'])->name('staprio.store');
    Route::put('/{id}', [StaprioController::class, 'update'])->name('staprio.update');
    Route::delete('/{id}', [StaprioController::class, 'destroy'])->name('staprio.destroy');
});

// Reactions System Routes
Route::prefix('reactions-system')->middleware(['auth'])->group(function() {
    Route::get('/', [ReactionsSystemController::class, 'index'])->name('reactions-system.index');
    Route::post('/', [ReactionsSystemController::class, 'store'])->name('reactions-system.store');
    Route::get('/{id}', [ReactionsSystemController::class, 'show'])->name('reactions-system.show');
    Route::put('/{id}/status', [ReactionsSystemController::class, 'updateStatus'])->name('reactions-system.updateStatus');
    Route::delete('/{id}', [ReactionsSystemController::class, 'destroy'])->name('reactions-system.destroy');
    
    // Notification management routes
    Route::post('/send/test', [ReactionsSystemController::class, 'testNotifications'])->name('reactions.send.test');
    Route::post('/send/pending', [ReactionsSystemController::class, 'sendPendingNotifications'])->name('reactions.send.pending');
    Route::get('/status', [ReactionsSystemController::class, 'getSystemStatus'])->name('reactions.system.status');
});

// Lead Notification Routes
Route::prefix('lead-notifications')->middleware(['auth'])->group(function() {
    Route::get('/', [ReactionNotificationController::class, 'index'])->name('lead-notifications.index');
    Route::get('/count', [ReactionNotificationController::class, 'getNotificationCount'])->name('lead-notifications.count');
    Route::post('/{id}/read', [ReactionNotificationController::class, 'markAsRead'])->name('lead-notifications.read');
    Route::post('/read-all', [ReactionNotificationController::class, 'markAllAsRead'])->name('lead-notifications.read-all');
    Route::get('/upcoming', [ReactionNotificationController::class, 'getUpcomingFollowUps'])->name('lead-notifications.upcoming');
});

// Services Routes (Admin Only)
Route::prefix('services')->middleware(['auth'])->group(function() {
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
});

// Simple Test Route
Route::get('/test-route', function() {
    return response()->json(['message' => 'Route system is working!']);
})->middleware('auth');

// Test Task Status Update Email Route
Route::get('/test-task-status-email/{invoiceId}', function($invoiceId) {
    try {
        $invoice = \App\Models\Invoice::find($invoiceId);
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }
        
        // Create test update data
        $originalUpdate = new \stdClass();
        $originalUpdate->invoice = $invoice;
        $originalUpdate->request_text = "1. Test task content\n2. Another test task";
        
        $workUpdate = new \stdClass();
        $workUpdate->update_point_1 = "✅ Test task content - Completed\n🔄 Another test task - Working";
        $workUpdate->update_date = now();
        
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Send the email
        $controller = new \App\Http\Controllers\ProjectUpdateController();
        $controller->sendTaskStatusUpdateEmail($originalUpdate, $workUpdate, $user);
        
        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully to: ' . $invoice->customer_email,
            'invoice' => [
                'invoice_number' => $invoice->invoice_number,
                'project_name' => $invoice->project_name,
                'customer_email' => $invoice->customer_email
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to send test email: ' . $e->getMessage()
        ], 500);
    }
})->middleware('auth');

// Simple Payment Plan Route (outside prefix group)
Route::get('/payment-plan/{quotation}', [AccountController::class, 'paymentPlan'])->name('payment.plan')->middleware('auth');

// Account Management Routes (Admin Only)
Route::prefix('accounts')->middleware(['auth'])->group(function() {
    Route::get('/', [AccountController::class, 'index'])->name('accounts.index');
    Route::post('/store-session-data', [AccountController::class, 'storeSessionData'])->name('accounts.store-session-data');
    Route::post('/confirm-payment-plan/{quotation}', [AccountController::class, 'confirmPaymentPlan'])->name('accounts.confirm-payment-plan');
    Route::put('/{quotation}/update-payment', [AccountController::class, 'updatePaymentStatus'])->name('accounts.update-payment');
    Route::put('/{quotation}/toggle-customer-panel', [AccountController::class, 'toggleCustomerPanel'])->name('accounts.toggle-customer-panel');
    Route::put('/lead/{lead}/toggle-customer-panel', [AccountController::class, 'toggleCustomerPanelForLead'])->name('accounts.lead.toggle-customer-panel');
    Route::post('/move-lead-to-quotation/{lead}', [AccountController::class, 'moveLeadToQuotation'])->name('accounts.move-lead-to-quotation');
    Route::post('/move-quotation-to-lead/{quotation}/{lead}', [AccountController::class, 'moveQuotationToLead'])->name('accounts.move-quotation-to-lead');
    Route::get('/generate-invoice/{quotation}', [AccountController::class, 'generateInvoice'])->name('accounts.generate-invoice');
    Route::get('/create-invoice/{quotation}', [AccountController::class, 'generateInvoice'])->name('accounts.create-invoice');
    Route::post('/simple-save-invoice/{quotation}', [AccountController::class, 'simpleSaveInvoice'])->name('accounts.simple-save-invoice');
    Route::get('/edit-quotation/{quotation}', [AccountController::class, 'editQuotation'])->name('accounts.edit-quotation');
});

// Quotations Routes
Route::prefix('quotations')->middleware(['auth'])->group(function() {
    Route::get('/', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/create', [QuotationController::class, 'create'])->name('quotations.create');
    Route::post('/', [QuotationController::class, 'store'])->name('quotations.store');
    Route::get('/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::get('/{quotation}/edit', [QuotationController::class, 'edit'])->name('quotations.edit');
    Route::put('/{quotation}', [QuotationController::class, 'update'])->name('quotations.update');
    Route::delete('/{quotation}', [QuotationController::class, 'destroy'])->name('quotations.destroy');
    Route::post('/{quotation}/send', [QuotationController::class, 'sendEmail'])->name('quotations.send');
    Route::get('/{quotation}/pdf', [QuotationController::class, 'downloadPDF'])->name('quotations.pdf');
    Route::get('/{quotation}/email-history', [QuotationController::class, 'getEmailHistory'])->name('quotations.email-history');
});

// Quotation Approval Routes (Public - no auth required for email links)
Route::get('/quotations/approve/{token}', [QuotationController::class, 'approveQuotation'])->name('quotations.approve');
Route::get('/quotations/reject/{token}', [QuotationController::class, 'rejectQuotation'])->name('quotations.reject');

// Customer Company Routes (Customer Only)
Route::prefix('customer')->middleware(['auth'])->group(function() {
    Route::get('/', function() {
        return redirect()->route('invoices.index');
    });
    Route::get('/home', [\App\Http\Controllers\CustomerCompanyController::class, 'home'])->name('customer.home');
    Route::get('/dashboard', [\App\Http\Controllers\CustomerCompanyController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/mycusdashboard', [\App\Http\Controllers\CustomerCompanyController::class, 'myCustomerDashboard'])->name('customer.mycusdashboard');
    Route::get('/companies', [\App\Http\Controllers\CustomerCompanyController::class, 'index'])->name('customer.companies.index');
    Route::get('/companies/{companyName}', [\App\Http\Controllers\CustomerCompanyController::class, 'show'])->name('customer.companies.show');
    Route::get('/companies/{companyName}/invoices', [\App\Http\Controllers\CustomerCompanyController::class, 'invoices'])->name('customer.companies.invoices');
    Route::get('/companies/{companyName}/projects', [\App\Http\Controllers\CustomerCompanyController::class, 'projects'])->name('customer.companies.projects');
    
    // Customer quotation download route
    Route::get('/quotations/{quotation}/pdf', [\App\Http\Controllers\CustomerCompanyController::class, 'downloadQuotationPDF'])->name('customer.quotations.pdf');
});

// Menu Controller Routes (Admin Only - role = 1)
Route::prefix('menu-controller')->middleware(['auth'])->group(function() {
    Route::get('/', [App\Http\Controllers\Backend\MenuController::class, 'index'])->name('menu-controller.index');
    Route::get('/create', [App\Http\Controllers\Backend\MenuController::class, 'create'])->name('menu-controller.create');
    Route::post('/', [App\Http\Controllers\Backend\MenuController::class, 'store'])->name('menu-controller.store');
    Route::get('/{menu}/edit', [App\Http\Controllers\Backend\MenuController::class, 'edit'])->name('menu-controller.edit');
    Route::put('/{menu}', [App\Http\Controllers\Backend\MenuController::class, 'update'])->name('menu-controller.update');
    Route::delete('/{menu}', [App\Http\Controllers\Backend\MenuController::class, 'destroy'])->name('menu-controller.destroy');
    
    // API Routes for menu permissions
    Route::get('/api/permissions', [App\Http\Controllers\Backend\MenuController::class, 'getMenuPermissions'])->name('menu-controller.api.permissions');
    Route::post('/api/permissions', [App\Http\Controllers\Backend\MenuController::class, 'updateMenuPermissions'])->name('menu-controller.api.update');
});

// Employee Menu Controller Routes
Route::prefix('employee-menu-controller')->middleware(['auth'])->group(function() {
    Route::get('/', [App\Http\Controllers\Backend\MenuController::class, 'employeeIndex'])->name('employee-menu-controller.index');
    Route::get('/api/employees', [App\Http\Controllers\Backend\MenuController::class, 'getEmployeesByDepartmentAndRole'])->name('employee-menu-controller.api.employees');
    Route::get('/api/permissions', [App\Http\Controllers\Backend\MenuController::class, 'getEmployeeMenuPermissions'])->name('employee-menu-controller.api.permissions');
    Route::post('/api/permissions', [App\Http\Controllers\Backend\MenuController::class, 'updateEmployeeMenuPermissions'])->name('employee-menu-controller.api.update');
});

// Activity Logs Routes
Route::prefix('activity-logs')->middleware(['auth'])->group(function() {
    Route::get('/', [App\Http\Controllers\Backend\LogsController::class, 'index'])->name('activity-logs.index');
    Route::get('/api/logs', [App\Http\Controllers\Backend\LogsController::class, 'getLogs'])->name('activity-logs.api');
    Route::post('/api/logs/{id}/read', [App\Http\Controllers\Backend\LogsController::class, 'markAsRead'])->name('activity-logs.read');
    Route::post('/api/logs/read-all', [App\Http\Controllers\Backend\LogsController::class, 'markAllAsRead'])->name('activity-logs.read-all');
    Route::delete('/api/logs/{id}', [App\Http\Controllers\Backend\LogsController::class, 'deleteLog'])->name('activity-logs.delete');
});

// Categories Management Routes (Updated) - REMOVED DUPLICATE

// Debug route for user role testing
Route::get('/debug-user', function() {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }
    
    $user = auth()->user();
    return response()->json([
        'user_id' => $user->id,
        'name' => $user->name,
        'role' => $user->role,
        'department' => $user->department,
        'position' => $user->position,
        'can_access_quotations' => true, // Since routes only require auth
        'can_access_services' => true, // Since we removed role restrictions
    ]);
})->middleware('auth');

// X-ray Viewer Routes
Route::prefix('dashboard-xray')->middleware(['auth'])->group(function() {
    Route::get('/', [XrayViewerController::class, 'index'])->name('xray.viewer');
    Route::post('/upload', [XrayViewerController::class, 'uploadDicom'])->name('xray.upload');
    Route::get('/view/{filename}', [XrayViewerController::class, 'viewDicom'])->name('xray.view');
    Route::get('/download/{filename}', [XrayViewerController::class, 'downloadDicom'])->name('xray.download');
});

// Page Customization Routes
Route::prefix('page-customization')->middleware(['auth'])->group(function() {
    Route::get('/', [App\Http\Controllers\Backend\PageCustomizationController::class, 'index'])->name('page-customization.index');
    Route::get('/users-for-role', [App\Http\Controllers\Backend\PageCustomizationController::class, 'getUsersForRole'])->name('page-customization.users-for-role');
    Route::post('/analyze', [App\Http\Controllers\Backend\PageCustomizationController::class, 'analyzePage'])->name('page-customization.analyze');
    Route::get('/get-customizations', [App\Http\Controllers\Backend\PageCustomizationController::class, 'getCustomizations'])->name('page-customization.get-customizations');
    Route::get('/apply-customizations', [App\Http\Controllers\Backend\PageCustomizationController::class, 'applyCustomizations'])->name('page-customization.apply-customizations');
    Route::post('/store', [App\Http\Controllers\Backend\PageCustomizationController::class, 'store'])->name('page-customization.store');
    Route::post('/update-single', [App\Http\Controllers\Backend\PageCustomizationController::class, 'updateSingle'])->name('page-customization.update-single');
    Route::post('/batch-update', [App\Http\Controllers\Backend\PageCustomizationController::class, 'batchUpdate'])->name('page-customization.batch-update');
    Route::delete('/{id}', [App\Http\Controllers\Backend\PageCustomizationController::class, 'destroy'])->name('page-customization.destroy');
    Route::delete('/reset', [App\Http\Controllers\Backend\PageCustomizationController::class, 'reset'])->name('page-customization.reset');
});

// Standalone API Routes
Route::get('/api/current-user', [App\Http\Controllers\Backend\PageCustomizationController::class, 'getCurrentUser'])->middleware('auth');
Route::get('/api/menu-controller-settings', [App\Http\Controllers\Backend\PageCustomizationController::class, 'getMenuControllerSettings'])->middleware('auth');
Route::get('/api/page-customizations', [App\Http\Controllers\Backend\PageCustomizationController::class, 'getSimpleCustomizations'])->middleware('auth');

// Test Route for debugging
Route::post('/test-post', [App\Http\Controllers\TestController::class, 'testPost'])->middleware('auth');

// Role Element Visibility Routes
Route::prefix('role-element-visibility')->middleware(['auth'])->group(function() {
    Route::get('/roles', [App\Http\Controllers\RoleElementVisibilityController::class, 'getRoles'])->name('role-element-visibility.roles');
    Route::get('/get', [App\Http\Controllers\RoleElementVisibilityController::class, 'getVisibility'])->name('role-element-visibility.get');
    Route::post('/update', [App\Http\Controllers\RoleElementVisibilityController::class, 'updateVisibility'])->name('role-element-visibility.update');
    Route::post('/bulk-update', [App\Http\Controllers\RoleElementVisibilityController::class, 'bulkUpdate'])->name('role-element-visibility.bulk-update');
    Route::post('/apply', [App\Http\Controllers\RoleElementVisibilityController::class, 'applyVisibility'])->name('role-element-visibility.apply');
});

// AI Helper Route
Route::get('/ai-helper', function() {
    return view('ai-helper.index');
})->name('ai-helper.index')->middleware('auth');

// Attendance Management Routes
Route::prefix('attendance')->middleware(['auth'])->group(function() {
    Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('attendance.dashboard');
    Route::get('/show/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::get('/edit/{attendance}', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::get('/report', [AttendanceController::class, 'report'])->name('attendance.report');
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.check-out');
    Route::post('/mark', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('/data', [AttendanceController::class, 'getAttendanceData'])->name('attendance.data');
    Route::get('/check-status', [AttendanceController::class, 'checkAttendanceStatus'])->name('attendance.check-status');
    Route::post('/send-email', [AttendanceController::class, 'sendEmailReport'])->name('attendance.send.email');
    Route::get('/clear-popup-session', function() {
        session()->forget('show_attendance_popup');
        return response()->json(['success' => true]);
    });
});

// Shift Management Routes
Route::prefix('shifts')->middleware(['auth'])->group(function() {
    Route::get('/', [ShiftController::class, 'index'])->name('shifts.index');
    Route::get('/create', [ShiftController::class, 'create'])->name('shifts.create');
    Route::post('/', [ShiftController::class, 'store'])->name('shifts.store');
    Route::get('/{shift}/edit', [ShiftController::class, 'edit'])->name('shifts.edit');
    Route::put('/{shift}', [ShiftController::class, 'update'])->name('shifts.update');
    Route::delete('/{shift}', [ShiftController::class, 'destroy'])->name('shifts.destroy');
    Route::post('/assign', [ShiftController::class, 'assignShift'])->name('shifts.assign');
});

// User Management Routes
Route::prefix('users')->middleware(['auth'])->group(function() {
    Route::post('/toggle-status', [UserManagementController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::get('/with-shifts', [UserManagementController::class, 'getUsersWithShifts'])->name('users.with-shifts');
    Route::post('/bulk-assign-shift', [UserManagementController::class, 'bulkAssignShift'])->name('users.bulk-assign-shift');
    Route::get('/get-users-by-department', [UserManagementController::class, 'getUsersByDepartment'])->name('users.get-users-by-department');
});

// Test Routes
Route::get('/test-leave', function() {
    return 'Leave routes are working!';
});

Route::get('/test-controller', [LeaveController::class, 'test']);

Route::get('/test-calendar-no-auth', [LeaveController::class, 'calendar']);

// Leave Management Routes
Route::prefix('leave')->middleware(['auth'])->group(function() {
    Route::get('/', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/create', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('/', [LeaveController::class, 'store'])->name('leave.store');
    Route::get('/calendar-leaves', [LeaveController::class, 'calendarLeaves'])->name('leave.calendar-leaves');
    Route::get('/calendar-leaves-data', [LeaveController::class, 'calendarLeavesData'])->name('leave.calendar-leaves-data');
    Route::get('/leave-bucket', [LeaveController::class, 'leaveBucket'])->name('leave.leave-bucket');
    Route::get('/{leave}', [LeaveController::class, 'show'])->name('leave.show');
    Route::post('/{leave}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::post('/{leave}/reject', [LeaveController::class, 'reject'])->name('leave.reject');
    Route::post('/{leave}/cancel', [LeaveController::class, 'cancel'])->name('leave.cancel');
});

// Leave Approval Status Routes
Route::prefix('approval-status/leave')->middleware(['auth'])->group(function() {
    Route::get('/', [App\Http\Controllers\Admin\LeaveApprovalController::class, 'index'])->name('approval-status.leave.index');
    Route::get('/{leave}', [App\Http\Controllers\Admin\LeaveApprovalController::class, 'show'])->name('approval-status.leave.show');
    Route::post('/{leave}/approve', [App\Http\Controllers\Admin\LeaveApprovalController::class, 'approve'])->name('approval-status.leave.approve');
    Route::post('/{leave}/reject', [App\Http\Controllers\Admin\LeaveApprovalController::class, 'reject'])->name('approval-status.leave.reject');
});

// Off-Time Login Notification Routes
Route::middleware(['auth'])->group(function() {
    Route::post('/off-time-login-notify', [\App\Http\Controllers\OffTimeLoginController::class, 'notifySeniors'])->name('off-time-login.notify');
    Route::post('/clear-off-time-modal', [\App\Http\Controllers\OffTimeLoginController::class, 'clearModal'])->name('off-time-login.clear');
});

// Employee Task Management Routes
// Root route is handled at the top of this file - redirecting to crmlogin

// Redirect old login URLs to new one
Route::any('/niremplogin', function() {
    return redirect('/');
});
Route::get('/employee/register', [AdminController::class, 'showRegistrationForm'])->name('employee.register.show');
Route::post('/employee/register', [AdminController::class, 'register'])->name('employee.register');
Route::get('/niremptask', [EmployeeTaskController::class, 'dashboard'])->name('employee.dashboard')->middleware('auth');
Route::post('/employee/tasks/filter', [EmployeeTaskController::class, 'getFilteredTasks'])->name('employee.tasks.filter')->middleware('auth');
Route::post('/employee/task/store', [EmployeeTaskController::class, 'storeTask'])->name('employee.task.store')->middleware('auth');
Route::get('/employee/task/{id}/edit', [EmployeeTaskController::class, 'editTask'])->name('employee.task.edit')->middleware('auth');
Route::post('/employee/task/{id}/update', [EmployeeTaskController::class, 'updateTask'])->name('employee.task.update')->middleware('auth');
Route::post('/employee/send-daily-tasks-email', [EmployeeTaskController::class, 'sendDailyTasksEmail'])->name('employee.send.daily.tasks.email')->middleware('auth');
Route::get('/test-mail', function() {
    try {
        \Mail::raw('This is a test email from NIRCRM', function($message) {
            $message->to('test@example.com')
                    ->subject('Test Email')
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });
        return 'Test email sent successfully!';
    } catch(\Exception $e) {
        return 'Error sending test email: ' . $e->getMessage();
    }
})->middleware('auth');
Route::delete('/employee/task/{id}/delete', [EmployeeTaskController::class, 'deleteTask'])->name('employee.task.delete')->middleware('auth');
Route::post('/employee/sync-to-google-sheets', [EmployeeTaskController::class, 'syncToGoogleSheets'])->name('employee.sync.google.sheets')->middleware('auth');
Route::post('/employee/logout', [EmployeeTaskController::class, 'logout'])->name('employee.logout');

// Biometric Authentication Routes
Route::post('/biometric/register', [EmployeeTaskController::class, 'registerBiometric'])->name('biometric.register')->middleware('auth');
Route::post('/biometric/authenticate', [EmployeeTaskController::class, 'authenticateBiometric'])->name('biometric.authenticate');
Route::post('/biometric/challenge', [EmployeeTaskController::class, 'getBiometricChallenge'])->name('biometric.challenge');
Route::delete('/biometric/delete', [EmployeeTaskController::class, 'deleteBiometricCredential'])->name('biometric.delete')->middleware('auth');

// Admin Routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');
Route::post('/admin/tasks/filter', [AdminController::class, 'getFilteredTasks'])->name('admin.tasks.filter')->middleware('auth');
Route::get('/admin/task/{id}/edit', [AdminController::class, 'editTask'])->name('admin.task.edit')->middleware('auth');
Route::post('/admin/task/{id}/update', [AdminController::class, 'updateTask'])->name('admin.task.update')->middleware('auth');
Route::delete('/admin/task/{id}/delete', [AdminController::class, 'deleteTask'])->name('admin.task.delete')->middleware('auth');

// Recording Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/allrecordingcall', [RecordingController::class, 'allRecordings'])->name('recordings.all');
});