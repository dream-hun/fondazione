<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\Notices\Status as NoticeStatus;
use App\Models\Blog;
use App\Models\Notice;
use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

final class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $cacheKey = 'sitemap.xml';
        $xml = Cache::remember($cacheKey, 3600, fn (): string => $this->generateSitemap());

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    private function generateSitemap(): string
    {
        $baseUrl = 'https://fmorwanda.org';

        $urls = [
            // Static pages
            [
                'loc' => $baseUrl.'/',
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'loc' => $baseUrl.'/about-us',
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => $baseUrl.'/our-team',
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => $baseUrl.'/resources',
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
            [
                'loc' => $baseUrl.'/tvet-training-center',
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => $baseUrl.'/donate',
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ],
            [
                'loc' => $baseUrl.'/blog',
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => $baseUrl.'/projects',
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'loc' => $baseUrl.'/announcements',
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
            [
                'loc' => $baseUrl.'/reports',
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
        ];

        // Published blogs
        $blogs = Blog::published()->select('slug', 'updated_at')->get();
        foreach ($blogs as $blog) {
            $urls[] = [
                'loc' => $baseUrl.'/blog/'.$blog->slug,
                'lastmod' => $blog->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        // Published projects
        $projects = Project::published()->select('slug', 'updated_at')->get();
        foreach ($projects as $project) {
            $urls[] = [
                'loc' => $baseUrl.'/projects/'.$project->slug,
                'lastmod' => $project->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        // Published notices
        $notices = Notice::query()->where('status', NoticeStatus::Published)->select('slug', 'updated_at')->get();
        foreach ($notices as $notice) {
            $urls[] = [
                'loc' => $baseUrl.'/announcements/'.$notice->slug,
                'lastmod' => $notice->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        // Published reports (if they have individual pages)
        $reports = Report::published()->select('id', 'updated_at')->get();
        foreach ($reports as $report) {
            $urls[] = [
                'loc' => $baseUrl.'/reports/'.$report->id,
                'lastmod' => $report->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= '    <url>'."\n";
            $xml .= '        <loc>'.htmlspecialchars($url['loc']).'</loc>'."\n";

            if (isset($url['lastmod'])) {
                $xml .= '        <lastmod>'.$url['lastmod'].'</lastmod>'."\n";
            }

            $xml .= '        <changefreq>'.$url['changefreq'].'</changefreq>'."\n";
            $xml .= '        <priority>'.$url['priority'].'</priority>'."\n";
            $xml .= '    </url>'."\n";
        }

        return $xml.'</urlset>';
    }
}
