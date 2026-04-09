<?php

function addNumbers($a, $b)
{
  return $a + $b;
}

function stringLength($str)
{
  return strlen($str);
}

$result1 = addNumbers(5, 3);
echo "addNumbers(5, 3) = " . $result1 . "\n";

$result2 = addNumbers(100, 250);
echo "addNumbers(100, 250) = " . $result2 . "\n";

$length1 = stringLength("Teknik Informatika");
echo "stringLength(\"Teknik Informatika\") = " . $length1 . "\n";

$length2 = stringLength("Universitas Brawijaya");
echo "stringLength(\"Universitas Brawijaya\") = " . $length2 . "\n";
