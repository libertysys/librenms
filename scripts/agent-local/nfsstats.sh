#!/bin/bash
#############################################################
# - put this file on the nfs server somewhere like /opt/    #
# - edit your snmpd.conf and add line                       #
#  extend nfsstat /opt/nfsstats.sh                          #
# - restart snmpd                                           #
# - make sure that you have all the binaries required below #
#############################################################

CFG_NFSFILE='/proc/net/rpc/nfsd'
BIN_CAT='/usr/bin/cat'
BIN_SED='/usr/bin/sed'
BIN_AWK='/usr/bin/awk'
BIN_TR='/usr/bin/tr'
BIN_PASTE='/usr/bin/paste'
BIN_RM='/usr/bin/rm'
BIN_MV='/usr/bin/mv'
LOG_OLD='/tmp/nfsio_old'
LOG_NEW='/tmp/nfsio_new'

#get reply cache (rc - values: hits, misses, nocache)
$BIN_CAT /proc/net/rpc/nfsd | $BIN_SED -n 1p | $BIN_AWK '{print $2,$3,$4}' | $BIN_TR " " "\n" > $LOG_NEW

#get server file handle (fh - values: lookup, anon, ncachedir, ncachenondir, stale)
$BIN_CAT /proc/net/rpc/nfsd | $BIN_SED -n 2p | $BIN_AWK '{print $2,$3,$4,$5,$6}' | $BIN_TR " " "\n" >> $LOG_NEW

#get io bytes (io - values: read, write)
$BIN_CAT /proc/net/rpc/nfsd | $BIN_SED -n 3p | $BIN_AWK '{print $2,$3}' | $BIN_TR " " "\n" >> $LOG_NEW

#get read ahead cache (ra - values: size, 0-10%, 10-20%, 20-30%, 30-40%, 40-50%, 50-60%, 60-70%, 70-80%, 80-90%, not-found)
$BIN_CAT /proc/net/rpc/nfsd | $BIN_SED -n 5p | $BIN_AWK '{print $2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12}' | $BIN_TR " " "\n" >> $LOG_NEW

#get server packet stats (net - values: all reads, udp packets, tcp packets, tcp conn)
$BIN_CAT /proc/net/rpc/nfsd | $BIN_SED -n 6p | $BIN_AWK '{print $2,$3,$4,$5}' | $BIN_TR " " "\n" >> $LOG_NEW

#get server rpc operations (rpc - values: calls, badcalls, badfmt, badauth, badclnt)
$BIN_CAT /proc/net/rpc/nfsd | $BIN_SED -n 7p | $BIN_AWK '{print $2,$3,$4,$5,$6}' | $BIN_TR " " "\n" >> $LOG_NEW

#get nfs v3 stats (proc3 - values: null, getattr, setattr, lookup, access, readlink, read, write, create, mkdir, symlink, mknod, remove, rmdir, rename, link, readdir, readdirplus, fsstat, fsinfo, pathconf, commit)
$BIN_CAT /proc/net/rpc/nfsd | $BIN_SED -n 8p | $BIN_AWK '{print $3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20,$21,$22,$23,$24}' | $BIN_TR " " "\n" >> $LOG_NEW

$BIN_PASTE $LOG_NEW $LOG_OLD | while read a b ; do
  echo $(($a-$b))
done

$BIN_RM $LOG_OLD 2>&1
$BIN_MV $LOG_NEW $LOG_OLD 2>&1

