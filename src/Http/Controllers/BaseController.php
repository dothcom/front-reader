<?php

namespace Dothcom\FrontReader\Http\Controllers;

use Dothcom\FrontReader\Services\SettingsService;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;

        view()->share('settingsService', $this->settingsService);
    }
}
