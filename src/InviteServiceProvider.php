<?php
/**
 * This file is part of ruogu.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogu\Invitar;

use Illuminate\Support\ServiceProvider;

class InviteServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->app->singleton('ruogu.invitar', function ($app) {
            return new InviteManager();
        });
    }

    public function provides()
    {
        return ['ruogu.invitar'];
    }
}
