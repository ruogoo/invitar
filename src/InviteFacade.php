<?php
/**
 * This file is part of ruogu.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogu\Invitar;

use Illuminate\Support\Facades\Facade;

class InviteFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ruogu.invitar';
    }
}
