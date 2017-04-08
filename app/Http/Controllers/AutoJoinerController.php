<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutoJoinerController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($this->requestSignatureIsValid(), 403);

        // Check X-Github-Event header equals to pull_request (CONSIDER checking against integration_installation for analytics)
        // Get organization name (name: $json->pull_request->base->repo->owner->login id: pull_request->base->repo->owner->id)
        // Check organization is registered
        // Check the PR was merged ($json->action equals merged)
        // Get github username of the user to invite ($json->pull_request->user->login)
        // Invite user to organization
    }

    protected function requestSignatureIsValid() : bool
    {
        $gitHubSignature = request()->header('X-Hub-Signature');
        list($usedAlgorithm, $gitHubHash) = explode('=', $gitHubSignature, 2);
        $payload = file_get_contents('php://input');
        $calculatedHash = hash_hmac($usedAlgorithm, $payload, config('auth.github_secret'));

        return $calculatedHash === $gitHubHash;
    }
}
