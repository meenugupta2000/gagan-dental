<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Blog;
use App\Models\ContactMessage;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\Treatment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'appointments_new' => Appointment::where('status', 'new')->count(),
            'appointments_total' => Appointment::count(),
            'messages_unread' => ContactMessage::where('is_read', false)->count(),
            'treatments' => Treatment::count(),
            'blogs' => Blog::count(),
            'testimonials' => Testimonial::count(),
            'subscribers' => Subscriber::count(),
        ];

        $recentAppointments = Appointment::with('treatment')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments'));
    }
}
