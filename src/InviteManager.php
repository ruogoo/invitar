<?php
/**
 * This file is part of ruogu.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogu\Invitar;

class InviteManager implements InviteContract
{
    /**
     * 邀请码生成机制的 key
     */
    const ENCRYPT_KEY = 1102;

    /**
     * @var Invitable
     */
    protected $inviter;

    /**
     * @var string
     */
    protected $inviteCode;

    public function setInviter(Invitable $inviter)
    {
        $this->inviter = $inviter;
    }

    public function getInviter(): Invitable
    {
        return $this->inviter;
    }

    public function getInviteCode(): string
    {
        return $this->inviteCode;
    }

    public function generateCodeForInvitee(Invitable $invitee): string
    {
        $uniqueIdentifier = $invitee->uniqueIdentifier();

        return NumberConvert::encrypt($invitee->$uniqueIdentifier, self::ENCRYPT_KEY, true);
    }
}
