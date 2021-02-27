function ageCalculator($date1,$date2) {

    $age = '';
    $diff = date_diff(date_create($date2), date_create($date1));
    $years = $diff->format("%y");
    $months = $diff->format("%m");
    $days = $diff->format("%d");

    if ($years) {
        $age = ($years < 2) ? '1 Year' : "$years Years";
    } else {
        $age = '';
        if ($months) $age .= ($months < 2) ? '1 Month ' : "$months Months ";
        if ($days) $age .= ($days < 2) ? '1 Day' : "$months Days";
    }
    //$ageData=  array('years'=>$years,'months'=>$months,'days'=>$days);
    return trim($age);
    //return $ageData;
}
echo ageCalculator('2016-05-06','2021-05-06');
