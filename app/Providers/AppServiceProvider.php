<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Content;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    function slug($key)
    {
        return $slug = strtolower(str_replace(' ', '-', $key));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $contents = [

            'hero' => [
                'title'             => ['label' => 'Title', 'required' => true],
                'name'              => ['label' => 'Section Name', 'required' => true],
                'short'             => ['label' => 'Short Description', 'required' => false],
                'img_path'          => ['label' => 'Image Background', 'required' => false],
                'img_paths'         => ['label' => 'Images', 'required' => false],
                'video_path'        => ['label' => 'Video', 'required' => false],
                'body'              => ['label' => 'Paragraph 1', 'required' => false],
                'body_2'            => ['label' => 'Paragraph 2', 'required' => false],
                'meta_title'        => ['label' => 'Meta Title', 'required' => false],
                'meta_description'  => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'     => ['label' => 'Meta Keywords', 'required' => false],
                'status'            => ['label' => 'Status', 'required' => true],
            ],
            'building-dreams-for-decades' => [
                'title'             => ['label' => 'Title',              'required' => true],
                'short'             => ['label' => 'Description',        'required' => true],
                'url'               => ['label' => 'Button URL',         'required' => false],
                'img_path'          => ['label' => 'Main Center Image',  'required' => false],
                'img_paths'         => ['label' => 'Other Images (Top Right, Bottom Left, Middle)', 'required' => false],
                'meta_title'        => ['label' => 'Meta Title', 'required' => false],
                'meta_description'  => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'     => ['label' => 'Meta Keywords', 'required' => false],
                'status'            => ['label' => 'Status', 'required' => true],
            ],
            'project' => [
                'title'            => ['label' => 'Project Name', 'required' => true],
                'short'            => ['label' => 'Project Type (Residential/Commercial)', 'required' => true],
                'body_3'           => ['label' => 'Short Description', 'required' => false],
                'location'         => ['label' => 'Location/Address', 'required' => true],
                'body'             => ['label' => 'Description', 'required' => false],

                'body_2'           => ['label' => 'Description Box 2', 'required' => false],

                'img_path'         => ['label' => 'Thumbnail Image',  'required' => true],
                'img_paths'         => ['label' => 'Multiple Image(1 main image,2-3 Gallary,3+ Slider', 'required' => false],
                'video_path'        => ['label' => 'Video', 'required' => false],
                'extra'            => ['label' => 'Extra (JSON: status, featured, map_url)', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            'years-of-expertise' => [
                'title'              => ['label' => 'Top Title ', 'required' => true],
                'name'               => ['label' => 'Section Heading', 'required' => true],
                'body'               => ['label' => 'Left Description', 'required' => true],
                'body_2'             => ['label' => 'Right Description', 'required' => true],
                'img_path'           => ['label' => 'Top Center Image', 'required' => false],
                'img_paths'          => ['label' => 'Other Images (Left Bottom, Right)', 'required' => false],
                'short'              => ['label' => 'Left BG Text (e.g. Quality Construction)', 'required' => false],
                'location'           => ['label' => 'Right BG Text (e.g. Timely)', 'required' => false],
                'meta_title'         => ['label' => 'Meta Title', 'required' => false],
                'meta_description'   => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'      => ['label' => 'Meta Keywords', 'required' => false],
                'status'             => ['label' => 'Status', 'required' => true],
            ],
            'stories-of-satisfaction' => [
                'title'              => ['label' => 'Section Title (e.g. The stories of satisfaction)', 'required' => true],
                'body'               => ['label' => 'Bottom Left Description', 'required' => false],
                'img_path'           => ['label' => 'Bottom Left Image', 'required' => false],
                'img_paths'          => ['label' => 'Bottom Right Image ([0])', 'required' => false],
                'meta_title'         => ['label' => 'Meta Title', 'required' => false],
                'meta_description'   => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'      => ['label' => 'Meta Keywords', 'required' => false],
                'status'             => ['label' => 'Status', 'required' => true],
            ],

            'stories-item' => [
                'title'              => ['label' => 'Client Name (e.g. Md. Abu Nasar Ahmed)', 'required' => true],
                'name'               => ['label' => 'Designation (e.g. Job Holder)', 'required' => true],
                'body'               => ['label' => 'Testimonial Text', 'required' => true],
                'img_path'           => ['label' => 'Client Photo', 'required' => false],
                'meta_title'         => ['label' => 'Meta Title', 'required' => false],
                'meta_description'   => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'      => ['label' => 'Meta Keywords', 'required' => false],
                'status'             => ['label' => 'Status', 'required' => true],
            ],
            'news' => [
                'title'            => ['label' => 'News Title', 'required' => true],
                'img_path'         => ['label' => 'News Image', 'required' => false],
                'body'             => ['label' => 'News Content', 'required' => false],
                'short'            => ['label' => 'Read Time (e.g. 5)', 'required' => false],
                'start_date'       => ['label' => 'Publish Date', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],


            'events' => [
                'title'            => ['label' => 'Title', 'required' => true],
                'name'             => ['label' => 'Slug', 'required' => true],
                'location'         => ['label' => 'Location', 'required' => false],
                'extra'            => ['label' => 'Map Link', 'required' => false],
                'start_date'       => ['label' => 'Start Date', 'required' => false],
                'end_date'         => ['label' => 'End Date', 'required' => false],
                'img_path'         => ['label' => 'Thumbnail', 'required' => true],
                'img_paths'        => ['label' => 'Events Photos', 'required' => false],
                'body'             => ['label' => 'Details', 'required' => false],
                'body_2'           => ['label' => 'Details box 2', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            'partners' => [
                'title'            => ['label' => 'Section Title (e.g. Be a partner, be a patron)', 'required' => true],
                'body'             => ['label' => 'Landowner Box Description',                       'required' => true],
                'body_2'           => ['label' => 'Customer Box Description',                        'required' => true],
                'short'            => ['label' => 'Landowner Box Label (e.g. Contact as Landowner)', 'required' => true],
                'location'         => ['label' => 'Customer Box Label (e.g. Contact as Customer)',   'required' => true],
                'img_path'         => ['label' => 'Customer Box Background Image',                   'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status',                                          'required' => true],
            ],

            // About page
            'mission_vision' => [
                'title'            => ['label' => 'Center Title (e.g. Building dreams, creating spaces.)', 'required' => true],
                'body'             => ['label' => 'Mission Description', 'required' => true],
                'body_2'           => ['label' => 'Vision Description', 'required' => true],
                'name'             => ['label' => 'Mission Label (e.g. Mission)', 'required' => false],
                'short'            => ['label' => 'Vision Label (e.g. Vision)', 'required' => false],
                'img_path'         => ['label' => 'Bg Image', 'required' => false],
                'img_paths'        => ['label' => 'Other Images', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            'history-timeline' => [
                'title'            => ['label' => 'Section Title (e.g. History Timeline)', 'required' => true],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],

            'timeline-item' => [
                'title'            => ['label' => 'Year (e.g. 1972)', 'required' => true],
                'name'             => ['label' => 'Heading (e.g. Bhaiya Group)', 'required' => true],
                'short'             => ['label' => 'Description', 'required' => true],
                'img_path'         => ['label' => 'Year Image', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            'leaders-message' => [
                'title'            => ['label' => 'Section Title (e.g. Message from leaders)', 'required' => true],
                'img_path'         => ['label' => 'Image Background', 'required' => true],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],

            'leaders-message-item' => [
                'title'            => ['label' => 'Leader Name',        'required' => true],
                'name'             => ['label' => 'Designation',        'required' => true],
                'body'             => ['label' => 'Message',            'required' => true],
                'img_path'         => ['label' => 'Leader Photo',       'required' => true],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status',             'required' => true],
            ],
            'visionaries' => [
                'title'            => ['label' => 'Section Title (e.g. Meet the Visionaries)', 'required' => true],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],

            'visionaries-item' => [
                'title'            => ['label' => 'Name',        'required' => true],
                'name'             => ['label' => 'Designation', 'required' => true],
                'img_path'         => ['label' => 'Photo',       'required' => true],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status',      'required' => true],
            ],
            'about-bhaiya' => [
                'title'            => ['label' => 'Title (e.g. About Bhaiya Housing)',  'required' => true],
                'short'             => ['label' => 'Paragraph 1', 'required' => true],
                'extra'           => ['label' => 'Paragraph 2', 'required' => false],
                'img_path'         => ['label' => 'Left Image', 'required' => false],
                'img_paths'        => ['label' => 'Other Images ([0] Right)', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            'about-bhaiya-group' => [
                'title'            => ['label' => 'Title (e.g. About Bhaiya Housing Group)', 'required' => true],
                'body'             => ['label' => 'Paragraph 1', 'required' => true],
                'body_2'           => ['label' => 'Paragraph 2', 'required' => false],
                'img_path'         => ['label' => 'Cover Image', 'required' => false],
                'img_paths'        => ['label' => 'Other Images ([0] Overflow image)', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            //others concern
            'other-concern' => [
                'title'            => ['label' => 'Title', 'required' => false],
                'short'            => ['label' => 'Paragraph 1', 'required' => true],
                'body'             => ['label' => 'Paragraph 2', 'required' => true],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            'other-logo' => [
                'title'            => ['label' => 'Title', 'required' => false],
                'img_path'         => ['label' => 'Image', 'required' => true],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            //career
            'career-overview' => [
                'title'            => ['label' => 'Title', 'required' => false],
                'short'            => ['label' => 'Paragraph 1', 'required' => true],
                'body'             => ['label' => 'Paragraph 2', 'required' => false],
                'body_2'           => ['label' => 'Bottom Paragraph', 'required' => false],
                'img_path'         => ['label' => 'Left Small Image', 'required' => false],
                'img_paths'        => ['label' => 'Right Large Image', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],
            'job-position' => [
                'title'             => ['label' => 'Job Title (e.g. Sales Executive)', 'required' => true],
                'name'              => ['label' => 'Slug (e.g. sales-executive)', 'required' => true],
                'short'             => ['label' => 'Job Description', 'required' => true],
                'body'              => ['label' => 'Full Details (Summary, Responsibilities, Qualifications, Benefits)', 'required' => false],
                'extra'             => ['label' => 'Department', 'required' => false],
                'location'          => ['label' => 'Location', 'required' => false],
                'body_2'            => ['label' => 'Job Type (e.g. Full Time)', 'required' => false],
                'body_3'            => ['label' => 'Experience (e.g. 2+ years)', 'required' => false],
                'meta_title'        => ['label' => 'Meta Title', 'required' => false],
                'meta_description'  => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'     => ['label' => 'Meta Keywords', 'required' => false],
                'status'            => ['label' => 'Status', 'required' => true],
            ],

            'contact-image' => [
                'title'    => ['label' => 'Title', 'required' => false],
                'img_path' => ['label' => 'Image', 'required' => true],
                'status'   => ['label' => 'Status', 'required' => true],
            ],

            'albums' => [
                'title'            => ['label' => 'Title', 'required' => true],
                'body'             => ['label' => 'Details', 'required' => true],
                'start_date'       => ['label' => 'Date', 'required' => true],
                'img_path'         => ['label' => 'Thumbnail', 'required' => true],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],

            'gallery' => [
                'img_path' => ['label' => 'Thumbnail', 'required' => true],
                'parent'   => ['label' => 'Select Parent', 'required' => true],
                'status'   => ['label' => 'Status', 'required' => true],
            ],

            'blogs' => [
                'title'            => ['label' => 'Title', 'required' => true],
                'name'             => ['label' => 'Slug', 'required' => true],
                'short'            => ['label' => 'Short Description', 'required' => true],
                'img_path'         => ['label' => 'Images', 'required' => true],
                'body'             => ['label' => 'Description 1', 'required' => false],
                'body_2'           => ['label' => 'Description 2', 'required' => false],
                'body_3'           => ['label' => 'Description 3', 'required' => false],
                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                'status'           => ['label' => 'Status', 'required' => true],
            ],

            'pages' => [
                'title'  => ['label' => 'Title', 'required' => true],
                'name'   => ['label' => 'Slug', 'required' => true],
                'body'   => ['label' => 'Description', 'required' => true],
                'status' => ['label' => 'Status', 'required' => true],
            ],

            'social' => [
                'title'  => ['label' => 'Platform Name (e.g. WhatsApp)', 'required' => true],
                'url'    => ['label' => 'Social Link', 'required' => true],
                'short'   => ['label' => 'SVG Icon Code', 'required' => true],
                'extra'  => ['label' => 'Background Color (e.g. #25D366)', 'required' => false],
                'status' => ['label' => 'Status', 'required' => true],
            ],

            'settings' => [
                'title'    => ['label' => 'Site Name', 'required' => true],
                'name'     => ['label' => 'Slogan', 'required' => false],
                'img_path' => ['label' => 'Logo', 'required' => false],
                'extra'    => ['label' => 'Hotline Number', 'required' => false],
                'short'    => ['label' => 'Email', 'required' => false],
                'location' => ['label' => '', 'required' => false],
                'body'     => ['label' => 'Head Office Address', 'required' => false],
                'body_2'   => ['label' => 'Corporate Office Address', 'required' => false],
                'url'      => ['label' => 'Google Map Embed Link', 'required' => false],
                'status'   => ['label' => 'Status', 'required' => true],
            ],
            'location_map' => [
                'title'  => ['label' => 'Title', 'required' => true],
                'short'  => ['label' => 'Google Map Embed Link', 'required' => true],
                'status' => ['label' => 'Status', 'required' => true],
            ],
            'menu-image' => [
                'name'   => ['label' => 'Page Key (about, projects, concerns, career, events, contact)', 'required' => true],
                'img_path' => ['label' => 'Hover Image', 'required' => true],
                'status'   => ['label' => 'Status', 'required' => true],
            ],

        ];
        $menuImages = Content::where('type', 'menu-image')->where('status', 1)->orderBy('id')->get()->keyBy('name');
        View::share('menuImages', $menuImages);
        $setting = Content::where('type', 'settings')->where('status', 1)->latest()->first();
        $socials = Content::where('type', 'social')->where('status', 1)->latest()->get();
        $pages = Content::where('type', 'pages')->where('status', 1)->get();

        View::share('contents', $contents);
        View::share('setting', $setting);
        View::share('socials', $socials);
        View::share('pages', $pages);
    }
}
