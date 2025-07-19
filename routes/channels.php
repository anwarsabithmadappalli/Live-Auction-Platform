<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('message-channel', function ($user) {
    return true; // or check something like user role
});