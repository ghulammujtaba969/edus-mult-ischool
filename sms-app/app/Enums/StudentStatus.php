<?php

namespace App\Enums;

enum StudentStatus: string
{
    case APPLICANT = 'applicant';
    case ENROLLED = 'enrolled';
    case ACTIVE = 'active';
    case TRANSFERRED = 'transferred';
    case LEFT = 'left';
    case EXPELLED = 'expelled';
    case ALUMNI = 'alumni';
}
