<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\EventRegistration;
use App\Models\InvestorForm;
use Illuminate\Support\Facades\Validator;


class WebController extends Controller
{


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

        $timelineData = $timelineItems->map(function($item) {
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


    public function pageShow($slug)
    {
        $page = Content::where('type', 'pages')->where('name', $slug)->firstOrFail();
        return view('frontend.page', compact('page'));
    }
    public function index()
    {
        return view('frontend.index',);
    }

}
