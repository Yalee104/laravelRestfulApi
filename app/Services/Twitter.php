<?php

namespace App\Services;


class Twitter {

    protected $key;

    public function __construct(string $GivenKey = null)
    {
        if ($GivenKey) {
            $this->key = $GivenKey;
        }
        else {
            $this->key = config('services.twitter.key');
        }
    }

    public function Post()
    {
        //TODO: We will be posting the review to Twitter as well
    }
}