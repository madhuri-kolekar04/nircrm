<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\MonthlyReport;
use Illuminate\Support\Facades\Mail;


class MonthlyReportController extends Controller
{
    // Show Monthly Report Form
   
    // Store Monthly Report
   public function store(Request $request)
{
    $request->validate([
        'project_id'  => 'required',
        'title'       => 'required',
        'month'       => 'required',
        'description' => 'required',
        'attachment'  => 'nullable|mimes:pdf,doc,docx,xlsx,jpg,png|max:2048',
    ]);

    $filePath = null;

    if ($request->hasFile('attachment')) {
        $filePath = $request->file('attachment')->store('monthly_reports', 'public');
    }

    // Save report
    $report = MonthlyReport::create([
        'project_id'  => $request->project_id,
        'title'       => $request->title,
        'month'       => $request->month,
        'description' => $request->description,
        'attachment'  => $filePath,
    ]);

    // Get project (invoice)
    // $project = Invoice::findOrFail($request->project_id);

    // Send email
//     Mail::raw(
//     "Monthly Report:\n\nTitle: {$report->title}\nMonth: {$report->month}\nDescription: {$report->description}",
//     function ($message) use ($project, $filePath) {

//         $message->to($project->customer_email)
//                 ->subject('Monthly Report - ' . $project->id);

//         if ($filePath) {
//             $message->attach(storage_path('app/public/' . $filePath));
//         }
//     }
// );

    return redirect()->back()->with('success', 'Report saved & emailed successfully!');
}


// monthly report details
public function details(Request $request, $id)
{
    $project = Invoice::findOrFail($id);

    $reports = MonthlyReport::where('project_id', $id)

        ->when($request->month, function ($query) use ($request) {

            $query->where('month', $request->month);

        })

        ->latest()

        ->get();

    return view(
        'project_updates.monthly_reports_details',
        compact('project', 'reports')
    );
}



public function update(Request $request, $id)
{
    $report = MonthlyReport::findOrFail($id);

    $request->validate([
        'title' => 'required',
        'month' => 'required',
        'description' => 'required',
    ]);

    $data = [
        'title' => $request->title,
        'month' => $request->month,
        'description' => $request->description,
    ];

    // attachment upload
    if ($request->hasFile('attachment')) {

        $file = $request->file('attachment');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('uploads/reports'), $filename);

        $data['attachment'] = 'uploads/reports/' . $filename;
    }

    $report->update($data);

    return redirect()->back()->with('success', 'Report updated successfully');
}

// delete report

public function destroy($id){
    $report = MonthlyReport::findOrFail($id);

    if($report->attachment && file_exists(public_path($report->attachment))){
        unlink(public_path($report->attachment));
    }

    $report->delete();

    return redirect()->back()->with('sucess', 'Report deleted successfully');
}
    
//send mail
public function sendMail($id)
{
    $report = MonthlyReport::findOrFail($id);

    // get project/invoice
    $project = Invoice::findOrFail($report->project_id);

    // customer email
    $customerEmail = $project->customer_email;

    Mail::raw(
        "Monthly Report Details\n\n" .
        "Title: {$report->title}\n" .
        "Month: {$report->month}\n" .
        "Description: {$report->description}",

        function ($message) use ($customerEmail, $report) {

            $message->to($customerEmail)
                    ->subject('Monthly Report');

            // attach file if exists
            if ($report->attachment) {

                $filePath = public_path($report->attachment);

                if (file_exists($filePath)) {

                    $message->attach($filePath);
                }
            }
        }
    );

    return redirect()->back()->with('success', 'Report mailed successfully');
}

}
