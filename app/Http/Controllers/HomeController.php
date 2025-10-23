<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as MaintenanceRequest;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Blog;

class HomeController extends Controller
{
    /**
     * Show the public homepage (landing page)
     * Displays recent public requests like a social media feed
     */
    public function index()
    {
        // Get request statistics for homepage
        $stats = [
            'total_requests' => MaintenanceRequest::count(),
            'completed_requests' => MaintenanceRequest::completed()->count(),
            'pending_requests' => MaintenanceRequest::pending()->count(),
            'in_progress_requests' => MaintenanceRequest::inProgress()->count(),
        ];

        // Get active testimonials for display
        $testimonials = Testimonial::active()->ordered()->get();

        return view('home', compact('stats', 'testimonials'));
    }

    /**
     * Show the authenticated user dashboard (newsfeed)
     * Main page after login - shows personalized request feed
     */
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        
        // Build base query based on user role
        if ($user->isAdmin()) {
            // Admins see all requests
            $query = MaintenanceRequest::with(['user', 'category', 'assignedTechnician', 'comments']);
        } elseif ($user->isTechnician()) {
            // Technicians see all requests but prioritize assigned ones
            $query = MaintenanceRequest::with(['user', 'category', 'assignedTechnician', 'comments'])
                ->where(function($q) use ($user) {
                    $q->where('assigned_to', $user->id)
                      ->orWhere('is_public', true);
                });
        } else {
            // Regular users see public requests
            $query = MaintenanceRequest::with(['user', 'category', 'assignedTechnician', 'comments'])
                ->public();
        }

        // Apply category filter if specified
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Apply status filter if specified
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply search filter if specified
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $requests = $query->latest()->paginate(15);

        // Get categories for quick filtering
        $categories = Category::active()->orderBy('priority')->get();

        // Get user-specific stats
        $userStats = [
            'my_requests' => $user->requests()->count(),
            'my_pending' => $user->requests()->pending()->count(),
            'my_completed' => $user->requests()->completed()->count(),
        ];

        // Add technician stats if applicable
        if ($user->isTechnician()) {
            $userStats['assigned_to_me'] = $user->assignedRequests()->whereIn('status', ['assigned', 'in_progress'])->count();
            $userStats['completed_by_me'] = $user->assignedRequests()->completed()->count();
        }

        return view('dashboard', compact('requests', 'categories', 'userStats'));
    }

    /**
     * Show the about page
     * Displays company story, metrics, team, and capabilities
     */
    public function about()
    {
        // Get key metrics for the about page
        $completedRequests = MaintenanceRequest::completed()->count();
        $activeClients = MaintenanceRequest::distinct('user_id')->count('user_id');
        $blogCount = Blog::where('is_published', true)->count();
        $technicianCount = User::where('role', 'technician')
            ->orWhere('role', 'admin')
            ->count();

        // Metrics cards data
        $metrics = [
            [
                'value' => number_format($completedRequests),
                'label' => 'Projects Completed',
                'description' => 'Successfully delivered maintenance solutions',
                'gradient' => 'from-cyan-500 to-blue-600'
            ],
            [
                'value' => number_format($activeClients) . '+',
                'label' => 'Active Clients',
                'description' => 'Trusted partners across industries',
                'gradient' => 'from-purple-500 to-pink-600'
            ],
            [
                'value' => $technicianCount . '+',
                'label' => 'Expert Technicians',
                'description' => 'Certified professionals at your service',
                'gradient' => 'from-green-500 to-emerald-600'
            ],
            [
                'value' => '24/7',
                'label' => 'Support Available',
                'description' => 'Round-the-clock assistance',
                'gradient' => 'from-orange-500 to-red-600'
            ]
        ];

        // Platform pillars
        $pillars = [
            [
                'icon' => 'fa-bolt',
                'title' => 'Speed & Efficiency',
                'description' => 'Our AI-powered platform ensures rapid response times and streamlined workflows, reducing downtime by up to 60%.'
            ],
            [
                'icon' => 'fa-shield-alt',
                'title' => 'Security First',
                'description' => 'Enterprise-grade security with end-to-end encryption, ensuring your data and operations remain protected.'
            ],
            [
                'icon' => 'fa-chart-line',
                'title' => 'Data-Driven Insights',
                'description' => 'Advanced analytics and reporting help you make informed decisions and optimize maintenance strategies.'
            ]
        ];

        // Company timeline
        $timeline = [
            [
                'year' => '2020',
                'headline' => 'Foundation',
                'details' => 'FixIT was founded with a vision to transform maintenance services through technology.'
            ],
            [
                'year' => '2022',
                'headline' => 'AI Integration',
                'details' => 'Launched AI-powered request categorization and intelligent technician matching.'
            ],
            [
                'year' => '2024',
                'headline' => 'E-commerce Launch',
                'details' => 'Expanded services with integrated parts marketplace and seamless ordering.'
            ],
            [
                'year' => '2025',
                'headline' => 'Global Expansion',
                'details' => 'Serving ' . number_format($activeClients) . '+ clients worldwide with 24/7 support.'
            ]
        ];

        // Leadership team
        $leadership = [
            [
                'name' => 'John Smith',
                'role' => 'Chief Executive Officer',
                'bio' => '15+ years of experience in facility management and technology innovation.',
                'avatar' => 'https://ui-avatars.com/api/?name=John+Smith&size=200&background=0D8ABC&color=fff'
            ],
            [
                'name' => 'Sarah Johnson',
                'role' => 'Chief Technology Officer',
                'bio' => 'Former lead engineer at major tech firms, specializing in AI and automation.',
                'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&size=200&background=7C3AED&color=fff'
            ],
            [
                'name' => 'Michael Chen',
                'role' => 'Head of Operations',
                'bio' => 'Expert in scaling service operations and ensuring exceptional customer satisfaction.',
                'avatar' => 'https://ui-avatars.com/api/?name=Michael+Chen&size=200&background=10B981&color=fff'
            ]
        ];

        // Platform capabilities
        $capabilities = [
            [
                'icon' => 'fa-robot',
                'title' => 'AI-Powered',
                'subtitle' => 'Smart categorization and predictive maintenance scheduling'
            ],
            [
                'icon' => 'fa-mobile-alt',
                'title' => 'Mobile-First',
                'subtitle' => 'Access from anywhere with our responsive design'
            ],
            [
                'icon' => 'fa-clock',
                'title' => 'Real-Time',
                'subtitle' => 'Live updates and instant notifications'
            ],
            [
                'icon' => 'fa-cog',
                'title' => 'Customizable',
                'subtitle' => 'Tailored workflows to match your processes'
            ]
        ];

        return view('about', compact('metrics', 'pillars', 'timeline', 'leadership', 'capabilities'));
    }
}
