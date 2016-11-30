<?php
/**
 * This file is part of ruogu.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogu\Invitar;

/**
 * 定义可邀请的模型对象
 */
interface Invitable
{
    public function uniqueIdentifier(): string;

    public function inviteCodeProperty(): string;

    public function beInviteCodeProperty(): string;
}
