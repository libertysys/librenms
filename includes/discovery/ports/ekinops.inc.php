<?php
/**
 * ekinops.inc.php
 *
 * -Description-
 *
 * The Ekinops interface naming scheme is overly verbose (see example).
 * The ifDescr and ifName returned by the device are the same. This
 * script reduces ifDescr to slot/card type/interface and sets ifAlias
 * to the user defined description found on the interface's configuration
 * on the Ekinops shelf.
 *
 * Example:
 * ifName: EKINOPS/C600HC/13/PM_10010-MR/S10-Client10(PORT_Number 10)
 * ifDescr: 13/PM_10010-MR/S10-Client10
 * ifAlias: PORT_Number 10
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Traps when Adva objects are created. This includes Remote User Login object,
 * Flow Creation object, and LAG Creation object.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2020 KanREN, Inc
 * @author     Heath Barnhart <hbarnhart@kanren.net>
 */

foreach ($port_stats as $index => $port) {

    /*
     * Split up ifName and drop the EKIPS/Chassis
    */ 
    $intName = array_filter(multiexplode(["/","(",")"], $port['ifName']));

    array_shift($intName);
    array_shift($intName);


    // Make ifDescr slot/card/int

    $ifDescr = $intName[0] . '/' . $intName[1] . '/' . $intName[2];

    // Make ifAlias descr

    $ifAlias = $intName[3];

    $port_stats[$index]['ifAlias'] = $ifAlias;
    $port_stats[$index]['ifDescr' ] = $ifDescr;

}

function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}  
