<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'user') {
            $leaves = Leave::with(['employee', 'approver'])
                ->where('employee_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $leaves = Leave::with(['employee', 'approver'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }


        // $leaves = Leave::with(['employee', 'approver'])
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);

        $leaveTypes = ['Sick Leave', 'Annual Leave', 'Unpaid Leave'];

        return view('admin.leaves.index', compact('leaves', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type' => 'required|string|in:Sick Leave,Annual Leave,Unpaid Leave',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
            // 'reason' => 'required|string|min:10|max:500',
            // 'document' => [
            //     'nullable',
            //     'file',
            //     'mimes:pdf,doc,docx,jpg,jpeg,png',
            //     'max:10240', // 10MB max
            // ],
        ], [
            'leave_type.required' => 'Please select a leave type.',
            'leave_type.in' => 'Please select a valid leave type.',
            'start_date.required' => 'Start date is required.',
            'start_date.after_or_equal' => 'Start date must be today or a future date.',
            'end_date.required' => 'End date is required.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'reason.required' => 'Please provide a reason for your leave.',
            'reason.min' => 'Please provide a more detailed reason (minimum 10 characters).',
            'document.mimes' => 'Document must be a PDF, DOC, DOCX, JPG, JPEG, or PNG file.',
            'document.max' => 'Document size must not exceed 10MB.',
        ]);

        $leave = new Leave();
        $leave->employee_id = auth()->id(); // Assuming you're using authentication
        $leave->leave_type = $validated['leave_type'];
        $leave->start_date = $validated['start_date'];
        $leave->end_date = $validated['end_date'];
        // $leave->reason = $validated['reason'];
        $leave->status = 'pending';

        // if ($request->hasFile('document')) {
        //     $path = $request->file('document')->store('leave-documents', 'public');
        //     $leave->document_path = $path;
        // }

        $leave->save();

        return redirect()->route('leaves.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function updateStatus(Request $request, Leave $leave)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leave->status = $validated['status'];
        $leave->approved_by = auth()->id(); // Assuming you're using authentication
        $leave->save();

        return redirect()->route('leaves.index')
            ->with('success', 'Leave request ' . $validated['status'] . ' successfully.');
    }

    public function destroy(Leave $leave)
    {
        // if ($leave->document_path) {
        //     Storage::disk('public')->delete($leave->document_path);
        // }

        $leave->delete();

        return redirect()->route('leaves.index')
            ->with('success', 'Leave request deleted successfully.');
    }}
