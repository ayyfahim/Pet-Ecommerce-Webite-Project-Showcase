<?php

namespace App\Services\Csp;

use Spatie\Csp\Keyword;
use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Policy;

class CustomPolicy extends Policy
{
    public function configure()
    {
        parent::configure();

        $this
            ->addDirective(Directive::BASE, [
                Keyword::SELF,
                env('APP_URL'),
            ])
            ->addDirective(Directive::DEFAULT, [
                Keyword::SELF,
                env('APP_URL'),
            ])
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::IMG, [
                Keyword::SELF,
                'data:',
                'blob:',
                env('APP_URL'),
            ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::OBJECT, Keyword::SELF)
            ->addDirective(Directive::FRAME, [
                Keyword::SELF,
                'data:',                 // tinymce iframe
                '*.youtube.com',         // youtube
                '*.google.com',          // google
            ])
            ->addDirective(Directive::CONNECT, [
                Keyword::SELF,                          // ajax
                env('APP_URL') . ':6001',               // websocket
                'ws://' . env('APP_DOMAIN') . ':6001',  // websocket
                'wss://' . env('APP_DOMAIN') . ':6001', // websocket
            ])
            ->addDirective(Directive::FONT, [
                Keyword::SELF,
                'data:',
                'fonts.gstatic.com',
            ])
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                '*.google.com',   // google
                '*.gstatic.com',  // google
                'unsafe-eval',    // vue
            ])
            ->addDirective(Directive::WORKER, [
                Keyword::SELF,
            ])
            ->addDirective(Directive::STYLE, [
                env('APP_URL'),
                Keyword::SELF,
                // 'unsafe-inline',
                'fonts.googleapis.com',
                'fonts.gstatic.com',
            ]);
        // ->addNonceForDirective(Directive::STYLE)
            // ->addNonceForDirective(Directive::SCRIPT);
    }
}
