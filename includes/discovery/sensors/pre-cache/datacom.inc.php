<?php

echo 'Pre-cache Datacom: ';

$pre_cache['datacom_oids'] = snmpwalk_cache_multi_oid($device, 'ddTransceiversEntry', array(), 'DMswitch-MIB');
