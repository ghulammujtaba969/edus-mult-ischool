<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case CAMPUS_ADMIN = 'campus_admin';
    case PRINCIPAL = 'principal';
    case TEACHER = 'teacher';
    case ACCOUNTANT = 'accountant';
    case PARENT = 'parent';
    case STUDENT = 'student';

    public function label(): string
    {
        return str($this->value)->replace('_', ' ')->title()->toString();
    }
}
