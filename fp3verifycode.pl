use strict;
use warnings;

use Getopt::Long;
use List::Util qw(sum);
use Digest::MD5 qw(md5_hex);

sub help {
    return <<"."
Usage: perl $0 --imei 123456789012345 --serial A1234567890
.
}

my ($imei, $serial);
GetOptions ("imei=s" => \$imei,
            "serial=s"   => \$serial)
or die(help());

if (!defined($imei) || length($imei) != 15 ||
    !defined($serial) || length($serial) < 10) {
    print help();
    exit;
}

# the key
my $key = "$imei$serial";
my $md5 = md5_hex($key);
print "md5 : $md5\n";

# weird checksum over the first 8 characters in the md5sum...
my $chk = 0;
for (my $i = 0; $i < 8; $i++) {
    $chk += ord(substr($md5,$i,1)) * 256**($i%4);
}
$chk &= 0xFFFFFFFF;
printf("chk: %08x\n", $chk);
