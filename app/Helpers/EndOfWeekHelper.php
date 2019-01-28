<?php
function endOfWeek()
{
  return Carbon\Carbon::now()->endOfWeek()->format('Y-m-d H:i');
}