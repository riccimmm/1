<?php

	function nominal($age,$nominal)
{
if ($age <= 17){$str = intval($nominal+(($nominal/100)*50));}
elseif ($age >= 18 && $age <= 21){$str = intval($nominal+(($nominal/100)*30));}
elseif ($age >= 22 && $age <= 25){$str = intval($nominal+(($nominal/100)*10));}
elseif ($age >= 26 && $age <= 29){$str = $nominal;}
elseif ($age >= 30 && $age <= 33){$str = intval($nominal-(($nominal/100)*10));}
elseif ($age >= 34 && $age <= 37){$str = intval($nominal-(($nominal/100)*30));}
elseif ($age >= 38){$str = intval($nominal-(($nominal/100)*50));}
return $str;
}

	
?>