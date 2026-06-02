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
            'phone'         => 'required|string|max:20',
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
            'message'       => $request->message,
            'is_read'       => false,
        ]);

        return redirect(route('getintouch') . '#contact-form')
            ->with('contact_success', 'Thank you! We will get back to you shortly.');
    }

    public function about()
    {
        $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
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
        ));
    }
    public function career()
    {
        $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
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
        ));
    }
    public function jobDetail($slug)
    {
        $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
        $job = Content::where('type', 'job-position')
            ->where('name', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.careerDetails', compact('job'));
    }
   public   function trackFacebook($event, $userData = [], $customData = [])
    {
        return app(FacebookConversionApi::class)
            ->sendEvent($event, $userData, $customData);
    }

    public function applyJob(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'phone'      => 'required|string|max:20',
            'email'      => 'required|email|max:100',
            'subject'    => 'required|string|max:200',
            'resume'     => 'required|file|mimes:pdf|max:2048',
            'content_id' => 'required|exists:contents,id',
        ]);
        

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
                'em' => [hash('sha256', strtolower($request->email))]
            ],
            [
                'lead_type' => 'Job Application',
                'job_id' => $request->content_id
            ]
        );

        return back()->with('success', 'Application submitted successfully!');
    }


    public function pageShow($slug)
    {
         $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );

        $page = Content::where('type', 'pages')->where('name', $slug)->firstOrFail();
        return view('frontend.page', compact('page'));
    }
    public function index()
    {
        $hero = Content::where('type', 'hero')
            ->where('name', 'home')
            ->where('status', 1)
            ->latest()
            ->first();

        $dreams = $this->fetchContent('building-dreams-for-decades', 1);
        // img_paths JSON decode
        $extraImages = json_decode($dreams->img_paths ?? '[]', true);
        $featuredProjects = $this->fetchContent('project');
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
         $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );

        return view('frontend.index', compact('hero', 'dreams', 'extraImages', 'featuredProjects', 'expertise', 'storiesSection', 'storiesItems', 'newsEvents', 'partners'));
    }

    public function projects()
    {
        $projectHero = Content::where('type', 'hero')
            ->where('name', 'projects')
            ->where('status', 1)
            ->latest()
            ->first();

        $allProjects = Content::where('type', 'project')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($p) => [
                'id'       => $p->id,
                'title'    => $p->title,
                'type'     => strtolower($p->short ?? ''),
                'location' => $p->location ?? '',
                'img'      => $p->img_path ?? asset('assets/images/placeholder.jpg'),
                'status'   => strtolower(json_decode($p->extra ?? '{}', true)['status'] ?? 'ongoing'),
                'url'      => '/projects/' . $p->id,
            ])->values();

        $projectLocations = Content::where('type', 'project')
            ->where('status', 1)
            ->whereNotNull('location')
            ->pluck('location')
            ->unique()
            ->values();
        $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
        return view('frontend.projects', compact('projectHero', 'allProjects', 'projectLocations'));
    }

    public function showProject($id)
    {
        $project = Content::where('type', 'project')
            ->where('status', 1)
            ->findOrFail($id);

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

    public function events()
    {
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
                'type'  => $item->type,
                'title' => $item->title,
                'date'  => $item->start_date
                    ? \Carbon\Carbon::parse($item->start_date)->format('d F Y')
                    : null,
                'url' => '/' . $item->type . '/' . $item->id,
            ])->values();
             $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
        return view('frontend.event', compact('eventHero', 'newsEvents'));
    }
    public function show($id)
    {
        $item = Content::whereIn('type', ['news', 'events'])
            ->where('status', 1)
            ->findOrFail($id);

        $imgPaths = json_decode($item->img_paths ?? '[]', true) ?? [];


        $related = Content::where('type', $item->type)
            ->where('status', 1)
            ->where('id', '!=', $item->id)
            ->orderBy('start_date', 'desc')
            ->take(3)
            ->get();
 $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
        return view('frontend.news-event-detail', compact('item', 'imgPaths', 'related'));
    }
    public function customerContact()
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
 $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
        return view('frontend.customer', compact('contactHero', 'contactImages'));
    }

    public function customerContactStore(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => [
                'required',
                'string',
                'regex:/^(?:\+?880|0)1[3-9]\d{8}$/',
            ],
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'Please enter your name.',
            'email.email'      => 'Please enter a valid email address.',
            'phone.required'   => 'Please enter your phone number.',
            'phone.regex'      => 'Please enter a valid  phone number (e.g. 01XXXXXXXXX).',
            'subject.required' => 'Please enter a subject.',
            'message.required' => 'Please write your message.',
        ]);

        $validated['phone'] = preg_replace('/[\s\-]/', '', $validated['phone']);

        Contact::create(array_merge($validated, ['type' => 'customer']));
        $this->trackFacebook(
            'Lead',
            [
                'em' => $validated['email']
                    ? [hash('sha256', strtolower($validated['email']))]
                    : [],
                'ph' => [hash('sha256', preg_replace('/\D/', '', $validated['phone']))],
            ],
            [
                'lead_type' => 'customer_contact',
                'subject'   => $validated['subject'],
            ]
        );
        return back()
            ->with('success', 'Your message has been sent. We will contact you soon.')
            ->withInput(['_scrollTo' => 'contactForm']);
    }

    public function landowner()
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
 $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
        return view('frontend.landowner', compact('hero', 'contactImages'));
    }
    public function landownerStore(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => [
                'required',
                'string',
                'regex:/^(?:\+?880|0)1[3-9]\d{8}$/',
            ],
            'locality'      => 'required|string|max:255',
            'address'       => 'nullable|string|max:500',
            'land_category' => 'required|string|max:255',
            'message'       => 'required|string|max:2000',
        ], [
            'name.required'          => 'Please enter your name.',
            'email.email'            => 'Please enter a valid email address.',
            'phone.required'         => 'Please enter your phone number.',
            'phone.regex'            => 'Please enter a valid  phone number (e.g. 01XXXXXXXXX).',
            'locality.required'      => 'Please enter your locality.',
            'land_category.required' => 'Please select a land category.',
            'message.required'       => 'Please write your message.',
        ]);

        // Store phone in clean format (strip spaces/dashes)
        $validated['phone'] = preg_replace('/[\s\-]/', '', $validated['phone']);

        Contact::create(array_merge($validated, ['type' => 'landowner']));

        return back()
            ->with('success', 'Your message has been sent. We will contact you soon.')
            ->withInput(['_scrollTo' => 'contactForm']);
    }

    public function concerns()
    {
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
 $this->facebook->sendEvent(
            'PageView',
            [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ]
        );
        return view('frontend.concerns', compact('concern', 'rows', 'concernHero'));
    }
}
