<?php

namespace App\models;

abstract class ExerciseStatus
{
    const BUILDING = 1;
    const ANSWERING = 2;
    const CLOSED = 3;
}