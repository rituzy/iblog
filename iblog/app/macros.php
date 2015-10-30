<?php

Form::macro('selectMonth', function($name, $selected = null, $options = array()) {
    $months = [];
    foreach (range(1, 12) as $month)
    {
        $months[$month] = date('F', mktime(0, 0, 0, $month));
    }
    return $this->select($name, $months, $selected, $options);
});

Form::macro('selectYear', function($name, $startYear, $endYear, $selected = null, $options = array()) {
    $years = range($startYear, $endYear);
    $years = array_combine($years, $years); 
    return $this->select($name, $years, $selected, $options);
});

Form::macro('selectDay', function($name, $startDay, $endDay, $selected = null, $options = array()) {
    $days = range(1, 31);
    $days = array_combine($days, $days); 
    return $this->select($name, $days, $selected, $options);
});
