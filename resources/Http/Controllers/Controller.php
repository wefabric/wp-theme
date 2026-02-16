<?php

namespace Theme\Http\Controllers;

use Themosis\Core\Forms\FormHelper;
use Themosis\Core\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use FormHelper, ValidatesRequests;
}
