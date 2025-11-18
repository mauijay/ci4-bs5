<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Config\Services as ShieldServices;

class OnlineCheckFilter implements FilterInterface
{
    /**
     * Before filter: gate site when offline.
     *
     * @param array<string>|null $arguments
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null): mixed
    {
        // Site online? Allow through.
        if (setting('AppSettings.siteOnline') !== false) {
            return null;
        }

        // Resolve current path to avoid loops if exceptions misconfigured
        $uriPath = ltrim((string) $request->getUri()->getPath(), '/');
        if ($uriPath === 'site-offline') {
            return null;
        }

        // Only superadmin or users with explicit permission may bypass
        $isAllowed = false;
        /** @var \CodeIgniter\Shield\Authentication\Authentication $auth */
        $auth = ShieldServices::auth();
        if ($auth->loggedIn()) {
            /** @var \CodeIgniter\Shield\Entities\User|null $user */
            $user = $auth->user();
            $isAllowed = $user !== null && ($user->inGroup('superadmin') || $user->hasPermission('app.viewOffline'));
        }
        if ($isAllowed) {
            return null;
        }

        // For JSON/AJAX requests, return 503 JSON instead of redirect
        $accept = strtolower($request->getHeaderLine('Accept'));
        $isAjax = strtolower($request->getHeaderLine('X-Requested-With')) === 'xmlhttprequest';
        $wantsJson = $isAjax || str_contains($accept, 'application/json');
        if ($wantsJson) {
            return service('response')
                ->setStatusCode(503)
                ->setJSON([
                    'message' => 'Service temporarily unavailable (site offline)',
                    'code'    => 503,
                ]);
        }

        // Fallback: redirect using named route to avoid hard-coded paths
        return redirect()->to(site_url(route_to('site.offline')));
    }

    /**
     * After filter: no-op.
     *
     * @param array<string>|null $arguments
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): mixed
    {
        return null;
    }
}
