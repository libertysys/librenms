<?php

if (str_contains($sysDescr, 'ProSafe')) {
    $os = 'netgear';
}

if (starts_with($sysObjectId, '.1.3.6.1.4.1.4526')) {
    $os = 'netgear';
}
