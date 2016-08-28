<?php

// Poll systemStats from UNIX-like hosts running UCD/Net-SNMPd
// UCD-SNMP-MIB::ssIndex.0 = INTEGER: 1
// UCD-SNMP-MIB::ssErrorName.0 = STRING: systemStats
// UCD-SNMP-MIB::ssSwapIn.0 = INTEGER: 0 kB
// UCD-SNMP-MIB::ssSwapOut.0 = INTEGER: 0 kB
// UCD-SNMP-MIB::ssIOSent.0 = INTEGER: 1864 blocks/s
// UCD-SNMP-MIB::ssIOReceive.0 = INTEGER: 7 blocks/s
// UCD-SNMP-MIB::ssSysInterrupts.0 = INTEGER: 7572 interrupts/s
// UCD-SNMP-MIB::ssSysContext.0 = INTEGER: 10254 switches/s
// UCD-SNMP-MIB::ssCpuUser.0 = INTEGER: 4
// UCD-SNMP-MIB::ssCpuSystem.0 = INTEGER: 3
// UCD-SNMP-MIB::ssCpuIdle.0 = INTEGER: 77
// UCD-SNMP-MIB::ssCpuRawUser.0 = Counter32: 194386556
// UCD-SNMP-MIB::ssCpuRawNice.0 = Counter32: 15673
// UCD-SNMP-MIB::ssCpuRawSystem.0 = Counter32: 65382910
// UCD-SNMP-MIB::ssCpuRawIdle.0 = Counter32: 1655192684
// UCD-SNMP-MIB::ssCpuRawWait.0 = Counter32: 205336019
// UCD-SNMP-MIB::ssCpuRawKernel.0 = Counter32: 0
// UCD-SNMP-MIB::ssCpuRawInterrupt.0 = Counter32: 1128048
// UCD-SNMP-MIB::ssIORawSent.0 = Counter32: 2353983704
// UCD-SNMP-MIB::ssIORawReceived.0 = Counter32: 3172182750
// UCD-SNMP-MIB::ssRawInterrupts.0 = Counter32: 427446276
// UCD-SNMP-MIB::ssRawContexts.0 = Counter32: 4161026807
// UCD-SNMP-MIB::ssCpuRawSoftIRQ.0 = Counter32: 2605010
// UCD-SNMP-MIB::ssRawSwapIn.0 = Counter32: 602002
// UCD-SNMP-MIB::ssRawSwapOut.0 = Counter32: 937422
$ss = snmpwalk_cache_oid($device, 'systemStats', array(), 'UCD-SNMP-MIB');
$ss = $ss[0];

if (is_numeric($ss['ssCpuRawUser']) && is_numeric($ss['ssCpuRawNice']) && is_numeric($ss['ssCpuRawSystem']) && is_numeric($ss['ssCpuRawIdle'])) {
    $rrd_def = array(
        'DS:user:COUNTER:600:0:U',
        'DS:system:COUNTER:600:0:U',
        'DS:nice:COUNTER:600:0:U',
        'DS:idle:COUNTER:600:0:U'
    );

    $fields = array(
        'user'    => $ss['ssCpuRawUser'],
        'system'  => $ss['ssCpuRawSystem'],
        'nice'    => $ss['ssCpuRawNice'],
        'idle'    => $ss['ssCpuRawIdle'],
    );

    $tags = compact('rrd_def');
    data_update($device, 'ucd_cpu', $tags, $fields);

    $graphs['ucd_cpu'] = true;
}

// This is how we'll collect in the future, start now so people don't have zero data.
$collect_oids = array(
    'ssCpuRawUser',
    'ssCpuRawNice',
    'ssCpuRawSystem',
    'ssCpuRawIdle',
    'ssCpuRawInterrupt',
    'ssCpuRawSoftIRQ',
    'ssCpuRawKernel',
    'ssCpuRawWait',
    'ssIORawSent',
    'ssIORawReceived',
    'ssRawInterrupts',
    'ssRawContexts',
    'ssRawSwapIn',
    'ssRawSwapOut',
);

foreach ($collect_oids as $oid) {
    if (is_numeric($ss[$oid])) {
        $rrd_name = 'ucd_'.$oid;
        $rrd_def = 'DS:value:COUNTER:600:0:U';

        $fields = array(
            'value' => $ss[$oid],
        );

        $tags = compact('oid', 'rrd_name', 'rrd_def');
        data_update($device, 'ucd_cpu', $tags, $fields);

        $graphs['ucd_cpu'] = true;
    }
}

// Set various graphs if we've seen the right OIDs.
if (is_numeric($ss['ssRawSwapIn'])) {
    $graphs['ucd_swap_io'] = true;
}

if (is_numeric($ss['ssIORawSent'])) {
    $graphs['ucd_io'] = true;
}

if (is_numeric($ss['ssRawContexts'])) {
    $graphs['ucd_contexts'] = true;
}

if (is_numeric($ss['ssRawInterrupts'])) {
    $graphs['ucd_interrupts'] = true;
}

// #
// Poll mem for load memory utilisation stats on UNIX-like hosts running UCD/Net-SNMPd
// UCD-SNMP-MIB::memIndex.0 = INTEGER: 0
// UCD-SNMP-MIB::memErrorName.0 = STRING: swap
// UCD-SNMP-MIB::memTotalSwap.0 = INTEGER: 32762248 kB
// UCD-SNMP-MIB::memAvailSwap.0 = INTEGER: 32199396 kB
// UCD-SNMP-MIB::memTotalReal.0 = INTEGER: 8187696 kB
// UCD-SNMP-MIB::memAvailReal.0 = INTEGER: 1211056 kB
// UCD-SNMP-MIB::memTotalFree.0 = INTEGER: 33410452 kB
// UCD-SNMP-MIB::memMinimumSwap.0 = INTEGER: 16000 kB
// UCD-SNMP-MIB::memBuffer.0 = INTEGER: 104388 kB
// UCD-SNMP-MIB::memCached.0 = INTEGER: 2595556 kB
// UCD-SNMP-MIB::memSwapError.0 = INTEGER: noError(0)
// UCD-SNMP-MIB::memSwapErrorMsg.0 = STRING:

$snmpdata = snmp_get_multi($device, 'memTotalSwap.0 memAvailSwap.0 memTotalReal.0 memAvailReal.0 memTotalFree.0 memShared.0 memBuffer.0 memCached.0', '-OQUs', 'UCD-SNMP-MIB');
if (is_array($snmpdata[0])) {
    list($memTotalSwap, $memAvailSwap, $memTotalReal, $memAvailReal, $memTotalFree, $memShared, $memBuffer, $memCached) = $snmpdata[0];
    foreach (array_keys($snmpdata[0]) as $key) {
        $$key = $snmpdata[0][$key];
    }
}

$snmpdata = $snmpdata[0];

if (is_numeric($memTotalReal) && is_numeric($memAvailReal) && is_numeric($memTotalFree)) {
    $rrd_def = array(
        'DS:totalswap:GAUGE:600:0:10000000000',
        'DS:availswap:GAUGE:600:0:10000000000',
        'DS:totalreal:GAUGE:600:0:10000000000',
        'DS:availreal:GAUGE:600:0:10000000000',
        'DS:totalfree:GAUGE:600:0:10000000000',
        'DS:shared:GAUGE:600:0:10000000000',
        'DS:buffered:GAUGE:600:0:10000000000',
        'DS:cached:GAUGE:600:0:10000000000'
    );

    $fields = array(
        'totalswap'    => $memTotalSwap,
        'availswap'    => $memAvailSwap,
        'totalreal'    => $memTotalReal,
        'availreal'    => $memAvailReal,
        'totalfree'    => $memTotalFree,
        'shared'       => $memShared,
        'buffered'     => $memBuffer,
        'cached'       => $memCached,
    );

    $tags = compact('rrd_def');
    data_update($device, 'ucd_mem', $tags, $fields);

    $graphs['ucd_memory'] = true;
}

//
// Poll laLoadInt for load averages on UNIX-like hosts running UCD/Net-SNMPd
// UCD-SNMP-MIB::laLoadInt.1 = INTEGER: 206
// UCD-SNMP-MIB::laLoadInt.2 = INTEGER: 429
// UCD-SNMP-MIB::laLoadInt.3 = INTEGER: 479
$load_raw = snmp_get_multi($device, 'laLoadInt.1 laLoadInt.2 laLoadInt.3', '-OQUs', 'UCD-SNMP-MIB');

// Check to see that the 5-min OID is actually populated before we make the rrd
if (is_numeric($load_raw[2]['laLoadInt'])) {
    $rrd_def = array(
        'DS:1min:GAUGE:600:0:5000',
        'DS:5min:GAUGE:600:0:5000',
        'DS:15min:GAUGE:600:0:5000'
    );

    $fields = array(
        '1min'   => $load_raw[1]['laLoadInt'],
        '5min'   => $load_raw[2]['laLoadInt'],
        '15min'  => $load_raw[3]['laLoadInt'],
    );

    $tags = compact('rrd_def');
    data_update($device, 'ucd_load', $tags, $fields);

    $graphs['ucd_load'] = 'TRUE';
}

unset($ss, $load_raw, $snmpdata);
unset($memTotalSwap, $memAvailSwap, $memTotalReal, $memAvailReal, $memTotalFree, $memShared, $memBuffer, $memCached);
unset($key, $collect_oids, $rrd_name, $rrd_def, $oid);
