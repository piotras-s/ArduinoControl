<?php

const NUMBER_OF_BOOL_PARAMS = 1;
$params = '';
for ($i=0; $i<NUMBER_OF_BOOL_PARAMS; $i++) {
    $params .= rand(0,1);
}

echo sprintf("Temperatura:
T6: %d;
T5: %d;
Napiecia:
P6: %d;
P5: %d;
PA3: %d;
Params: %s;", rand(-10, 20), rand(-10, 20), rand(0, 1024), rand(0, 1024), rand(0, 1024), $params);
