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
                                'title'      => ['label' => 'Title', 'required' => true],
                                'name'       => ['label' => 'Section Name', 'required' => true],
                                'short'      => ['label' => 'Short Description', 'required' => true],
                                'img_path'   => ['label' => 'Image', 'required' => false],
                                'img_paths'  => ['label' => 'Images', 'required' => false],
                                'video_path' => ['label' => 'Background Video', 'required' => false],
                                'status'     => ['label' => 'Status', 'required' => true],
                        ],
                        // About page
                        'our-history' => [
                                'title'            => ['label' => 'Main Title', 'required' => true],
                                'body'             => ['label' => 'History Description Part 1', 'required' => true],
                                'body_2'           => ['label' => 'History Description Part 2', 'required' => false],
                                'short'            => ['label' => 'Stat — Established Years (e.g. 50+)', 'required' => true],
                                'location'         => ['label' => 'Stat — Completed Projects (e.g. 150+)', 'required' => true],
                                'extra'            => ['label' => 'Stat — Business Concerns (e.g. 17+)', 'required' => true],
                                'body_3'           => ['label' => 'Stat — Industries Served (e.g. 5+)', 'required' => true],
                                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                                'status'           => ['label' => 'Status', 'required' => true],
                        ],

                        'our-mission-vision' => [
                                'title'            => ['label' => 'Mission Title (e.g. Our Mission)', 'required' => true],
                                'body'             => ['label' => 'Mission Description', 'required' => true],
                                'short'            => ['label' => 'Vision Title (e.g. Our Vision)', 'required' => true],
                                'body_2'           => ['label' => 'Vision Description', 'required' => true],
                                'img_path'         => ['label' => 'Center Building Image', 'required' => false],
                                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                                'status'           => ['label' => 'Status', 'required' => true],
                        ],

                        'our-founder' => [
                                'title'            => ['label' => 'Section Title (e.g. This is our Founder)', 'required' => true],
                                'short'            => ['label' => 'Founder Name & Role', 'required' => true],
                                'body'             => ['label' => 'Founder Quote / Description', 'required' => true],
                                'img_path'         => ['label' => 'Founder Image', 'required' => true],
                                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                                'status'           => ['label' => 'Status', 'required' => true],
                        ],

                        'our-members' => [
                                'title'            => ['label' => 'Member Name', 'required' => true],
                                'short'            => ['label' => 'Member Role (e.g. Chairman)', 'required' => true],
                                'body'             => ['label' => 'Description', 'required' => true],
                                'img_path'         => ['label' => 'Member Image', 'required' => true],
                                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                                'status'           => ['label' => 'Status', 'required' => true],
                        ],

                        // News and Gallery page
                        'news-article' => [
                                'title'            => ['label' => 'Section Title (e.g. Latest News & Articles)', 'required' => true],
                                'short'            => ['label' => 'Section Subtitle', 'required' => false],
                                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                                'status'           => ['label' => 'Status', 'required' => true],
                        ],

                        'news' => [
                                'title'            => ['label' => 'News Title', 'required' => true],
                                'img_path'         => ['label' => 'News Image', 'required' => true],
                                'body'             => ['label' => 'News Content', 'required' => true],
                                'short'            => ['label' => 'Read Time (e.g. 5)', 'required' => false],
                                'start_date'       => ['label' => 'Publish Date', 'required' => false],
                                'meta_title'       => ['label' => 'Meta Title', 'required' => false],
                                'meta_description' => ['label' => 'Meta Description', 'required' => false],
                                'meta_keywords'    => ['label' => 'Meta Keywords', 'required' => false],
                                'status'           => ['label' => 'Status', 'required' => true],
                        ],


                        'events' => [
                                'title'      => ['label' => 'Title', 'required' => true],
                                'name'       => ['label' => 'Slug', 'required' => true],
                                'location'   => ['label' => 'Location', 'required' => true],
                                'extra'      => ['label' => 'Map Link', 'required' => true],
                                'start_date' => ['label' => 'Start Date', 'required' => false],
                                'end_date'   => ['label' => 'End Date', 'required' => false],
                                'img_path'   => ['label' => 'Thumbnail', 'required' => true],
                                'img_paths'  => ['label' => 'Events Photos', 'required' => false],
                                'body'       => ['label' => 'Details', 'required' => true],
                                'body_2'     => ['label' => 'Details box 2', 'required' => false],
                                'status'     => ['label' => 'Status', 'required' => true],
                        ],

                        'brand' => [
                                'title'    => ['label' => 'Title', 'required' => true],
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
                                'url'    => ['label' => 'Social Link', 'required' => true],
                                'name'   => ['label' => 'Icon Code - FontAwesome', 'required' => true],
                                'status' => ['label' => 'Status', 'required' => true],
                        ],

                        'settings' => [
                                'title'    => ['label' => 'Site Name', 'required' => true],
                                'name'     => ['label' => 'Slogan', 'required' => false],
                                'img_path' => ['label' => 'Logo', 'required' => false],
                                'extra'    => ['label' => 'Hotline Number', 'required' => false],
                                'short'    => ['label' => 'Email', 'required' => false],
                                'location' => ['label' => 'Hospital Address', 'required' => false],
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

                ];

                $setting = Content::where('type', 'settings')->where('status', 1)->latest()->first();
                $socials = Content::where('type', 'social')->where('status', 1)->latest()->get();
                $pages = Content::where('type', 'pages')->where('status', 1)->get();

                View::share('contents', $contents);
                View::share('setting', $setting);
                View::share('socials', $socials);
                View::share('pages', $pages);
        }
}
