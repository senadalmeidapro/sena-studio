<?php

namespace App\Enums;

enum ProjectOutcomeType: string
{
    case Delivered = 'delivered';
    case Ongoing = 'ongoing';
    case Internal = 'internal';
}
