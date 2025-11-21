<?php

namespace App\Matching\Strategy;

use App\Repository\ConferenceRepository;

abstract class AbstractMatchingStrategy
{
    public function __construct(
        protected readonly ConferenceRepository $repository,
    ) {}
}
