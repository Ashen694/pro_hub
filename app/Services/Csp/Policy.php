<?php

namespace App\Services\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class Policy extends Basic
{
    public function configure()
    {
        parent::configure();

        // Local development: ALL possible Vite server variations
        if (app()->isLocal()) {
            $viteHttpHost = 'http://localhost:5173';
            $viteWsHost   = 'ws://localhost:5173';

            $this->addDirective(Directive::STYLE, $viteHttpHost)
                 ->addDirective(Directive::SCRIPT, $viteHttpHost)
                 ->addDirective(Directive::CONNECT, [$viteHttpHost, $viteWsHost]);
        }

        // Clickjacking 
        $this->addDirective(Directive::FRAME_ANCESTORS, 'none');

        // Common CSP rules
        $this->addDirective(Directive::STYLE, [
            "'self'",
            'fonts.googleapis.com',
            'cdnjs.cloudflare.com',
            'cdn.jsdelivr.net',
            "'unsafe-inline'",
        ])
        ->addDirective(Directive::FONT, [
            "'self'",
            'fonts.gstatic.com',
            'cdnjs.cloudflare.com',
            'cdn.jsdelivr.net',
        ])
        ->addDirective(Directive::SCRIPT, [
            "'self'",
            'cdnjs.cloudflare.com',
            'cdn.jsdelivr.net',
            "'unsafe-inline'",
        ])
        ->addDirective(Directive::CONNECT, [
            "'self'",
            'cdn.jsdelivr.net',
        ]);
    }
}