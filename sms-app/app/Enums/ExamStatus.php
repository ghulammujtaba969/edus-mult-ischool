<?php

namespace App\Enums;

enum ExamStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case LOCKED = 'locked';
}
