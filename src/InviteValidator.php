<?php
/**
 * This file is part of ruogu.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogu\Invitar;

interface InviteValidator
{
    /**
     * 校验邀请码是否有效.
     *
     * @param array|string $data
     *
     * @return bool
     */
    public function validate($data);

    public function passed();

    public function failed();
}
