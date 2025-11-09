<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Resource hints for better performance -->
        <link rel="preconnect" href="{{ config('app.url') }}">
        <meta http-equiv="x-dns-prefetch-control" content="on">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Critical CSS - Inline for instant render --}}
        <style>
            /* Base colors */
            html {
                background-color: #ffffff;
            }
            html.dark {
                background-color: #0a0a0a;
            }
            
            /* Critical layout - optimized for LCP */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                min-height: 100vh;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                line-height: 1.5;
            }
            
            /* Critical styles for login page (LCP element) */
            .min-h-screen {
                min-height: 100vh;
            }
            
            .flex {
                display: flex;
            }
            
            .items-center {
                align-items: center;
            }
            
            .justify-center {
                justify-content: center;
            }
            
            .bg-gray-100 {
                background-color: #f3f4f6;
            }
            
            .bg-white {
                background-color: #ffffff;
            }
            
            .rounded-lg {
                border-radius: 0.5rem;
            }
            
            .shadow {
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            }
            
            .p-6 {
                padding: 1.5rem;
            }
            
            .p-8 {
                padding: 2rem;
            }
            
            .w-full {
                width: 100%;
            }
            
            .max-w-md {
                max-width: 28rem;
            }
            
            /* Loading state - instant feedback */
            #app:empty {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                background-color: #f3f4f6;
            }
            
            #app:empty::before {
                content: '';
                width: 48px;
                height: 48px;
                border: 4px solid #e5e7eb;
                border-top-color: #3b82f6;
                border-radius: 50%;
                animation: spin 0.8s linear infinite;
            }
            
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            
            /* Instant app render - no fade animation */
            #app {
                opacity: 1;
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Skip custom fonts - use system fonts only for better LCP -->
        <style>
            /* System font stack - instant render, no download needed */
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }
        </style>

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
