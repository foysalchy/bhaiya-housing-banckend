<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\EventRegistration;
use App\Models\InvestorForm;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Validator;
use App\Services\FacebookConversionApi;
use Illuminate\Support\Facades\Http;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class WebController extends Controller
{

    protected $facebook;
    public function __construct(FacebookConversionApi $facebook)
    {
        $this->facebook = $facebook;
    }


    // $all   = $this->fetchContent('slider'); get all
    // $whos      = $this->fetchContent('who-we-are', 3); take() limit
    // Fetch only defined fields from AppServiceProvider
    private function getFields($type)
    {
        $contents = view()->shared('contents');

        if (!isset($contents[$type])) {
            return ['id', 'type', 'title', 'img_path', 'short', 'status'];
        }

        $fields = array_keys($contents[$type]);
        $fields[] = 'id';
        $fields[] = 'type';

        // parent_id always include if parent is a field
        if (in_array('parent', $fields)) {
            $fields[] = 'parent_id';
        }

        return array_unique($fields);
    }
    // Reusable content fetcher
    private function fetchContent($type, $limit = null)
    {
        $query = Content::select($this->getFields($type))
            ->where('type', $type)
            ->where('status', '1');

        if ($limit == 1) {
            return $query->first();
        } elseif ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }



    public function home()
    {


        return view('welcome');
    }
    public function getintouch()
    {
        $locationMap = Content::where('type', 'location_map')
            ->where('status', 1)
            ->first();
        $footerCapsule = Content::where('type', 'footer-capsule')
            ->where('name', 'contact')
            ->where('status', 1)
            ->first();
        return view('frontend.getintouch', compact('locationMap', 'footerCapsule'));
    }

    public function getintouchStore(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'   => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-()]{7,18}$/',
            ],
            'interested_in' => 'required|string',
            'message'       => 'required|string|max:2000',
        ], [
            'name.required'          => 'Full name is required.',
            'email.email'            => 'Please enter a valid email.',
            'phone.required'         => 'Mobile number is required.',
            'interested_in.required' => 'Please select your interest.',
            'message.required'       => 'Message is required.',
        ]);

        Contact::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone_code'    => '+880',
            'phone'         => $request->phone,
            'interested_in' => $request->interested_in,
            'message' => $request->message, 'ip_address' => $request->ip(),
            'is_read'       => false,
        ]);

        return redirect(route('getintouch') . '#contact-form')
            ->with('contact_success', 'Thank you! We will get back to you shortly.');
    }

    public function about(Request $request)
    {
        $query = Content::where('type', 'meta_info')
            ->where('name', 'about');

        if ($request->query('preview') !== 'true') {
            $query->where('status', 1);
        }

        $content = $query->first();
        
        $about = Content::where('type', 'hero')
            ->where('name', 'about-hero')
            ->where('status', 1)
            ->first();
        $missionVision = Content::where('type', 'mission_vision')
            ->where('status', 1)
            ->first();
        $historyTimeline = Content::where('type', 'history-timeline')->where('status', 1)->first();
        $timelineItems = Content::where('type', 'timeline-item')->where('status', 1)->oldest()->get();

        $leadersMessage = $this->fetchContent('leaders-message', 1);
        $leaders = Content::where('type', 'leaders-message-item')->where('status', 1)->get();
        $visionaries     = Content::where('type', 'visionaries-item')->where('status', 1)->get();
        $aboutBhaiya     = Content::where('type', 'about-bhaiya')->where('status', 1)->first();
        $aboutBhaiyaGroup = Content::where('type', 'about-bhaiya-group')->where('status', 1)->first();

        $timelineData = $timelineItems->map(function ($item) {
            return [
                'year'  => $item->title,
                'title' => $item->name,
                'desc'  => $item->short,
                'img'   => $item->img_path ? asset($item->img_path) : '',
            ];
        })->values()->toArray();

        return view('frontend.about', compact(
            'about',
            'missionVision',
            'historyTimeline',
            'timelineItems',
            'timelineData',
            'leadersMessage',
            'leaders',
            'visionaries',
            'aboutBhaiya',
            'aboutBhaiyaGroup',
            'content',
        ));
    }
    public function career(Request $request)
    {

        $query = Content::where('type', 'meta_info')
            ->where('name', 'career');

        if ($request->query('preview') !== 'true') {
            $query->where('status', 1);
        }

        $content = $query->first();
        
        $career = Content::where('type', 'hero')
            ->where('name', 'career-hero')
            ->where('status', 1)
            ->first();

        $careerOverview = Content::where('type', 'career-overview')->where('status', 1)->first();
        $jobPositions = Content::where('type', 'job-position')->where('status', 1)->latest()->get();
        $jobList = Content::where('type', 'job-position')->where('status', 1)->latest()->get();


        return view('frontend.career', compact(
            'career',
            'careerOverview',
            'jobPositions',
            'jobList',
            'content',
        ));
    }
    public function jobDetail(Request $request, $slug)
    {
        
        $job = Content::where('type', 'job-position')
            ->where('name', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.careerDetails', compact('job'));
    }
    public function trackFacebook($event, $userData = [], $customData = [], $eventId = null) { return FacebookConversionApi::sendEvent($event, $eventId, $customData, $userData); }


    public function applyJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:100',
            'phone'   => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-()]{7,18}$/',
            ],
            'email'      => 'required|email|max:100',
            'subject'    => 'required|string|max:200',
            'resume'     => 'required|file|mimes:pdf|max:2048',
            'content_id' => 'required|exists:contents,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->withFragment('apply-job-section');
        }

        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/resumes'), $fileName);
            $finalPath = 'uploads/resumes/' . $fileName;
        }

        JobApplication::create([
            'content_id' => $request->content_id,
            'name'       => $request->name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'subject'    => $request->subject,
            'resume'     => $finalPath,
        ]);

        $this->trackFacebook(
            'Lead',
            [
                'em' => $request->email ?? null,
                'ph' => $request->phone ?? null
            ],
            [
                'lead_type' => 'Job Application',
                'job_id' => $request->content_id
            ]
        );

        return redirect()->back()
            ->withFragment('apply-job-section')
            ->with('success', 'Application submitted successfully!');
    }


    public function pageShow(Request $request, $slug)
    {
        

        $page = Content::where('type', 'pages')->where('name', $slug)->firstOrFail();
        return view('frontend.page', compact('page'));
    }
    public function index(Request $request)
    {
        $hero = Content::where('type', 'hero')
            ->where('name', 'home')
            ->where('status', 1)
            ->latest()
            ->first();

        $dreams = $this->fetchContent('building-dreams-for-decades', 1);
        // img_paths JSON decode
        $extraImages = json_decode($dreams->img_paths ?? '[]', true);
        $featuredProjects = $this->fetchContent('project', 5);
        $expertise = $this->fetchContent('years-of-expertise', 1);
        $storiesSection = $this->fetchContent('stories-of-satisfaction', 1);
        $storiesItems = Content::where('type', 'stories-item')->where('status', 1)->get()
            ->map(fn($t) => [
                'name'   => $t->title,
                'role'   => $t->name,
                'text'   => strip_tags($t->body),
                'avatar' => $t->img_path ?? asset('assets/images/4.jpeg'),
            ])->values();

        $newsEvents = Content::whereIn('type', ['news', 'events'])
            ->where('status', 1)
            ->orderBy('start_date', 'desc')
            ->take(6)
            ->get();
        $partners = $this->fetchContent('partners', 1);

        

        return view('frontend.index', compact('hero', 'dreams', 'extraImages', 'featuredProjects', 'expertise', 'storiesSection', 'storiesItems', 'newsEvents', 'partners'));
    }

    public function projects(Request $request)
    {
        $query = Content::where('type', 'meta_info')
            ->where('name', 'projects');

        if ($request->query('preview') !== 'true') {
            $query->where('status', 1);
        }

        $content = $query->first();
        $projectHero = Content::where('type', 'hero')
            ->where('name', 'projects')
            ->where('status', 1)
            ->latest()
            ->first();

        $allProjects = Content::where('type', 'project')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($p) {
                $slug = !empty($p->name) ? $p->name : $p->id;

                return [
                    'id'       => $p->id,
                    'title'    => $p->title,
                    'type'     => strtolower($p->short ?? ''),
                    'location' => $p->location ?? '',
                    'img'      => $p->img_path ? asset(ltrim($p->img_path, '/')) : asset('frontend/images/building.webp'),
                    'status'   => strtolower(json_decode($p->extra ?? '{}', true)['status'] ?? 'ongoing'),

                    'url'      => route('projects.show', ['name' => $slug]),
                ];
            })->values();

        $projectLocations = Content::where('type', 'project')
            ->where('status', 1)
            ->whereNotNull('location')
            ->pluck('location')
            ->unique()
            ->values();
        
        return view('frontend.projects', compact('projectHero', 'allProjects', 'projectLocations', 'content'));
    }

    public function showProject(Request $request, $name)
    {
        $project = Content::where('type', 'project')
            ->where('name', $name)
            ->where('status', 1)
            ->firstOrFail();

        $extra      = json_decode($project->extra ?? '{}', true);
        $imgPaths = collect(json_decode($project->img_paths ?? '[]', true))
            ->map(fn($path) => asset($path))
            ->values()
            ->toArray();

        $sliderImages = array_slice($imgPaths, 3);
        $sliderTotal  = count($sliderImages);
        $this->trackFacebook(
            'ViewContent',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ],
            [
                'content_type' => 'project',
                'content_id'   => $project->id,
                'content_name'  => $project->title ?? null,
            ]
        );

        return view('frontend.projects-show', compact('project', 'extra', 'imgPaths', 'sliderImages', 'sliderTotal'));
    }

    public function events(Request $request)
    {
        $query = Content::where('type', 'meta_info')
            ->where('name', 'event');

        if ($request->query('preview') !== 'true') {
            $query->where('status', 1);
        }

        $content = $query->first();

        $eventHero = Content::where('type', 'hero')
            ->where('name', 'events')
            ->where('status', 1)
            ->latest()
            ->first();
        $newsEvents = Content::whereIn('type', ['news', 'events'])
            ->where('status', 1)
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(fn($item) => [
                'id'    => $item->id,
                'name'  => $item->name,
                'type'  => $item->type,
                'title' => $item->title,
                'date'  => $item->start_date
                    ? \Carbon\Carbon::parse($item->start_date)->format('d F Y')
                    : null,
                'url' => '/' . ($item->type === 'events' ? 'event/' : 'news/') . ($item->name ?? $item->id),
            ])->values();
        
        return view('frontend.event', compact('eventHero', 'newsEvents', 'content'));
    }
    public function page(Request $request, $slug)
    {
        $page = Content::where('type', 'pages')
            ->where('name', $slug)
            ->where('status', 1)
            ->firstOrFail();

        

        return view('frontend.page', compact('page'));
    }
    public function blog(Request $request)
    {
        $query = Content::where('type', 'meta_info')
            ->where('name', 'blog');

        if ($request->query('preview') !== 'true') {
            $query->where('status', 1);
        }

        $content = $query->first();
        $blogs = Content::where('type', 'blogs')

            ->where('status', 1)
            ->get();

        

        return view('frontend.blogs', compact('blogs', 'content'));
    }
    public function blogDetail(Request $request, $slug)
    {
        $blogs = Content::where('type', 'blogs')

            ->where('status', 1)
            ->get();
        $blog = Content::where('type', 'blogs')
            ->where('name', $slug)
            ->where('status', 1)
            ->firstOrFail();

        

        return view('frontend.blog-detail', compact('blog', 'blogs'));
    }
    public function show(Request $request, $slug)
    {
        $item = Content::whereIn('type', ['news', 'events'])
            ->where('status', 1)
            ->where(function ($q) use ($slug) {
                $q->where('name', $slug);
                if (is_numeric($slug)) {
                    $q->orWhere('id', $slug);
                }
            })->firstOrFail();

        $imgPaths = json_decode($item->img_paths ?? '[]', true) ?? [];
        $related = Content::where('type', $item->type)->where('status', 1)->where('id', '!=', $item->id)->take(3)->get();

        return view('frontend.news-event-detail', compact('item', 'imgPaths', 'related'));
    }
    public function customerContact(Request $request)
    {
        $contactHero = Content::where('type', 'hero')
            ->where('name', 'contact')
            ->where('status', 1)
            ->first();

        $contactImages = Content::where('type', 'contact-image')
            ->where('status', 1)
            ->latest()
            ->take(2)
            ->get();
        
        return view('frontend.customer', compact('contactHero', 'contactImages'));
    }

    public function officeLocations(\Illuminate\Http\Request $request)
    {
        $contactHero = \App\Models\Content::where('type', 'hero')
            ->where('name', 'contact')
            ->where('status', 1)
            ->first();

        $offices = \App\Models\Content::where('type', 'office_location')
            ->where('status', 1)
            ->orderBy('sort_order', 'asc')->orderBy('id', 'asc')
            ->get();

        $cities = $offices->pluck('name')->filter()->unique()->values();

        return view('frontend.office-locations', compact('contactHero', 'offices', 'cities'));
    }

    public function customerContactStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-()]{7,18}$/',
            ],
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'Please enter your name.',
            'email.email'      => 'Please enter a valid email address.',
            'phone.required'   => 'Please enter your phone number.',
            'phone.regex'      => 'Please enter a valid phone number (e.g. 01XXXXXXXXX).',
            'subject.required' => 'Please enter a subject.',
            'message.required' => 'Please write your message.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->withFragment('contact-section');
        }

        $validated = $validator->validated();

        $validated['phone'] = preg_replace('/[\s\-]/', '', $validated['phone']);

        Contact::create(array_merge($validated, ['type' => 'customer', 'ip_address' => $request->ip()]));

        $eventId = $request->input('fb_event_id') ?? 'lead_' . time() . '_' . \Illuminate\Support\Str::random(10);

        $this->trackFacebook(
            'Lead',
            [
                'em' => $validated['email'] ?? null,
                'ph' => $validated['phone'] ?? null,
            ],
            [
                'lead_type' => 'customer_contact',
                'subject'   => $validated['subject'],
            ],
            $eventId
        );

        return redirect()->back()
            ->withFragment('contact-section')
            ->with('success', 'Your message has been sent. We will contact you soon.');
    }
    public function contactInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => ['required', 'string', 'regex:/^\+?[0-9\s\-()]{7,18}$/'],
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string|max:2000',
            'designation' => 'nullable|string|max:255',
            'estimate_budget' => 'nullable|string|max:255',
            'g-recaptcha-response' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ])->json();

        if (!($response['success'] ?? false) || ($response['score'] ?? 0) < 0.5) {
            return response()->json(['errors' => ['g-recaptcha-response' => ['reCAPTCHA verification failed.']]], 422);
        }

        $validated = $validator->validated();
        $validated['phone'] = preg_replace('/[\s\-]/', '', $validated['phone']);
        Contact::create(array_merge($validated, ['type' => 'customer', 'ip_address' => $request->ip()]));

        $eventId = $request->input('fb_event_id') ?? 'lead_' . time() . '_' . \Illuminate\Support\Str::random(10);

        $this->trackFacebook(
            'Lead',
            [
                'em' => $validated['email'] ?? null,
                'ph' => $validated['phone'] ?? null,
            ],
            ['lead_type' => 'customer_contact', 'subject' => $validated['subject']],
            $eventId
        );

        return response()->json(['message' => 'Thank you! Your information has been submitted successfully. Our team will contact you shortly.']);
    }
    public function landowner(Request $request)
    {
        $hero = Content::where('type', 'hero')
            ->where('name', 'contact')
            ->where('status', 1)
            ->first();

        $contactImages = Content::where('type', 'contact-image')
            ->where('status', 1)
            ->latest()
            ->take(2)
            ->get();
        
        return view('frontend.landowner', compact('hero', 'contactImages'));
    }

    public function landownerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'   => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-()]{7,18}$/',
            ],
            'locality'      => 'required|string|max:255',
            'address'       => 'nullable|string|max:500',
            'land_category' => 'required|string|max:255',
            'message'       => 'required|string|max:2000',
        ], [
            'name.required'          => 'Please enter your name.',
            'email.email'            => 'Please enter a valid email address.',
            'phone.required'         => 'Please enter your phone number.',
            'phone.regex'            => 'Please enter a valid phone number (e.g. 01XXXXXXXXX).',
            'locality.required'      => 'Please enter your locality.',
            'land_category.required' => 'Please select a land category.',
            'message.required'       => 'Please write your message.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->withFragment('landowner-section');
        }

        $validated = $validator->validated();

        $validated['phone'] = preg_replace('/[\s\-]/', '', $validated['phone']);

        Contact::create(array_merge($validated, ['type' => 'landowner', 'ip_address' => $request->ip()]));

        $eventId = $request->input('fb_event_id') ?? 'lead_' . time() . '_' . \Illuminate\Support\Str::random(10);

        $this->trackFacebook(
            'Lead',
            [
                'em' => $validated['email'] ?? null,
                'ph' => $validated['phone'] ?? null,
            ],
            [
                'lead_type' => 'landowner_contact',
                'locality'  => $validated['locality'],
            ],
            $eventId
        );

        return redirect()->back()
            ->withFragment('landowner-section')
            ->with('success', 'Your message has been sent. We will contact you soon.');
    }

    public function concerns(Request $request)
    {

        $query = Content::where('type', 'meta_info')
            ->where('name', 'concerns');

        if ($request->query('preview') !== 'true') {
            $query->where('status', 1);
        }

        $content = $query->first();
        $concern = $this->fetchContent('other-concern', 1);
        $logos = $this->fetchContent('other-logo');

        $logos   = Content::where('type', 'other-logo')->where('status', 1)->get();

        $concernHero = Content::where('type', 'hero')
            ->where('name', 'concerns')
            ->where('status', 1)
            ->first();

        $rows    = [];
        $items   = $logos->values();
        $i       = 0;
        $rowNum  = 1;

        while ($i < count($items)) {
            $chunkSize = ($rowNum % 2 === 1) ? 5 : 4;
            $rows[]    = $items->slice($i, $chunkSize)->values();
            $i        += $chunkSize;
            $rowNum++;
        }
        
        return view('frontend.concerns', compact('concern', 'rows', 'concernHero', 'content'));
    }

    public function sitemap()
    {
        $sitemap = Sitemap::create();

        // Static Pages
        $staticPages = [
            '/',
            '/about',
            '/career',
            '/projects',
            '/event',
            '/blog',
            '/customer-contact',
            '/landowner-contact',
            '/concerns',
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create(url($page))
                    ->setPriority(1.0)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        }

        $items = Content::where('status', 1)->get();

        foreach ($items as $item) {
            $slug = $item->name;
            if (empty($slug)) continue; 

            switch ($item->type) {
                case 'job-position':
                    $sitemap->add(Url::create(route('job.details', $slug))->setLastModificationDate($item->updated_at)->setPriority(0.9));
                    break;

                case 'project':
                    $sitemap->add(Url::create(route('projects.show', $slug))->setLastModificationDate($item->updated_at)->setPriority(0.9));
                    break;

                case 'blogs':
                    $sitemap->add(Url::create(route('blog.details', $slug))->setLastModificationDate($item->updated_at)->setPriority(0.8));
                    break;

                case 'news':
                    $sitemap->add(Url::create(route('news.show', $slug))->setLastModificationDate($item->updated_at)->setPriority(0.8));
                    break;

                case 'events':
                    $sitemap->add(Url::create(route('events.show', $slug))->setLastModificationDate($item->updated_at)->setPriority(0.8));
                    break;

                case 'pages':
                    $sitemap->add(Url::create(route('page.show', $slug))->setLastModificationDate($item->updated_at)->setPriority(0.7));
                    break;
            }
        }

        return response($sitemap->render(), 200, ['Content-Type' => 'application/xml']);
    }
}




