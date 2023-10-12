<?php
namespace Tests\Feature\V2\Session;


it('can create a login link', function () {
    $response = $this->get(route('login.link'));

    $response->assertOk()->assertJsonStructure([
        'success',
        'message', 
        'data' => [
            'redirectUrl'
        ],
    ]);
});
