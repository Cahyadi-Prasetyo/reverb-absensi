<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add cache headers for static assets
        if ($this->isStaticAsset($request)) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
        }

        // Add preload headers for critical resources on auth pages
        if ($request->is('/') || $request->is('login') || $request->is('register')) {
            // Get manifest to find actual file names
            $manifest = $this->getManifest();
            
            if ($manifest) {
                $preloadLinks = [];
                
                // Preload critical CSS
                if (isset($manifest['resources/js/app.ts']['css'])) {
                    foreach ($manifest['resources/js/app.ts']['css'] as $css) {
                        $preloadLinks[] = '<' . asset('build/' . $css) . '>; rel=preload; as=style';
                    }
                }
                
                // Preload vendor JS
                if (isset($manifest['resources/js/app.ts']['file'])) {
                    $preloadLinks[] = '<' . asset('build/' . $manifest['resources/js/app.ts']['file']) . '>; rel=modulepreload';
                }
                
                if (!empty($preloadLinks)) {
                    $response->headers->set('Link', implode(', ', $preloadLinks), false);
                }
            }
        }

        return $response;
    }

    /**
     * Get Vite manifest
     */
    private function getManifest(): ?array
    {
        $manifestPath = public_path('build/manifest.json');
        
        if (file_exists($manifestPath)) {
            return json_decode(file_get_contents($manifestPath), true);
        }
        
        return null;
    }

    /**
     * Check if request is for static asset
     */
    private function isStaticAsset(Request $request): bool
    {
        return $request->is('build/*') || 
               $request->is('*.css') || 
               $request->is('*.js') || 
               $request->is('*.woff2') ||
               $request->is('*.woff') ||
               $request->is('*.ttf');
    }
}
