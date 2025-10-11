<?php

namespace App\Enums;

enum Role
{
    case ADMIN;
    case STAFF;
    case STAFF_PENGAWAS;

    public function status(): string
    {
        return match ($this) {
            self::ADMIN => 'admin',
            self::STAFF => 'staff',
            self::STAFF_PENGAWAS => 'staff_pengawas',
        };
    }
}
