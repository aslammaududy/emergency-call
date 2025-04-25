<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('emergency', function () {
    return true;
});
