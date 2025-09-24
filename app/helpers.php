<?php

function _dt($datetime)
{
	$dateFormat = config('constant.date_format');
	$timeFormat = config('constant.time_format');

	return date($dateFormat . ' ' . $timeFormat, strtotime($datetime));
}