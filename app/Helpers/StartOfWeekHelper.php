<?php

function startOfWeek()
{
  return Carbon\Carbon::now()->startOfWeek()->format('Y-m-d H:i');
}