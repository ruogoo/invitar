<?php
/**
 * This file is part of ruogu.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogu\Invitar;

interface InviteContract
{
    /**
     * 设置邀请者
     * @param Invitable $inviter
     * @return mixed
     */
    public function setInviter(Invitable $inviter);

    /**
     * 获取邀请者.
     * @return Invitable
     */
    public function getInviter(): Invitable;

    /**
     * 获取邀请码
     * @return string
     */
    public function getInviteCode(): string;

    /**
     * 为被邀请者生成邀请码
     * @param Invitable $invitee
     * @return string
     */
    public function generateCodeForInvitee(Invitable $invitee): string;
}
