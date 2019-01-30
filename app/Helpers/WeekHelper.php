<?php

use Carbon\Carbon;

function startOfWeek()
{
  return Carbon::now()->startOfWeek()->format('Y-m-d H:i');
}

function endOfWeek()
{
  return Carbon::now()->endOfWeek()->format('Y-m-d H:i');
}