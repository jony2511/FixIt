<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages (Admin only)
     */
    public function index()
    {
        $this->authorize('viewAny', ContactMessage::class);
        
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.contact.index', compact('messages'));
    }

    /**
     * Store a newly created contact message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            ContactMessage::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting us! We will get back to you soon.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified contact message (Admin only)
     */
    public function show(ContactMessage $contact)
    {
        $this->authorize('view', $contact);
        
        // Mark as read
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        
        return view('admin.contact.show', compact('contact'));
    }

    /**
     * Remove the specified contact message (Admin only)
     */
    public function destroy(ContactMessage $contact)
    {
        $this->authorize('delete', $contact);
        
        $contact->delete();
        
        return redirect()->route('admin.contact.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    /**
     * Mark contact message as read/unread (Admin only)
     */
    public function toggleRead(ContactMessage $contact)
    {
        $this->authorize('update', $contact);
        
        $contact->update(['is_read' => !$contact->is_read]);
        
        return response()->json([
            'success' => true,
            'is_read' => $contact->is_read
        ]);
    }
}
