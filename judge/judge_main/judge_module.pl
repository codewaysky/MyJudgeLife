#!/usr/bin/perl
use File::Basename;
use XML::Simple;
use Data::Dumper;
use HTTP::Request::Common; 
use LWP::UserAgent;
use Digest::MD5::File;
use Digest::MD5;
use Tie::File;
use MIME::Base64;

my $req = dirname($0)."/load_config.pl";
require $req;
my $req = dirname($0)."/load_codeinfo.pl";
require $req;

#Compile Code

$codetype = $codeinfo->{lang};
if ($codetype==1) {
	system("gcc -o ".dirname($0)."/judge_code ".dirname($0)."/judge_code.c -lm >".dirname($0)."/error.txt  2>&1");
} elsif ($codetype==2) {
	system("g++ -o ".dirname($0)."/judge_code ".dirname($0)."/judge_code.cpp >".dirname($0)."/error.txt  2>&1");
} elsif ($codetype==3) {
	system("fpc ".dirname($0)."/judge_code.pas >".dirname($0)."/error.txt  2>&1");
}

my $filename = dirname($0).'/error.txt';
tie my @stat, 'Tie::File', $filename;

my $judge_stat = 5;

if(!@stat) {
   #Judge
   system("cp ".dirname($0)."/judge_code ".dirname($0)."/sandbox");
   #Load Problem Details
   my $xmlfile = dirname($0)."/Data/".$codeinfo->{pid}."/problem.xml";
   if (-e $xmlfile) {
    my $problemxs = XML::Simple->new();
    our $pinfo = $problemxs->XMLin($xmlfile); 
   }
   #Go To Judge
   for(my $i=1;$i<=$pinfo->{DataAmount};$i++) {
    my $file_2 = shift || dirname($0)."/Data/".$codeinfo->{pid}."/out/out.".$i;
    open( FH, $file_2 ) or die "Can't open '$file_2': $!";
    binmode(FH);
    $md5hash = Digest::MD5->new->addfile(*FH)->hexdigest, " $file_2\n";
    open HASH,">",dirname($0)."/sandbox/outhash.txt" or print $!;
    print HASH $md5hash;
    close HASH;
    system("cp ".dirname($0)."/Data/".$codeinfo->{pid}."/in/in.".$i." ".dirname($0)."/sandbox/");
    system("mv ".dirname($0)."/sandbox/in.".$i." ".dirname($0)."/sandbox/input.in");
    system(dirname($0)."/judgestart");
   }
} else {
    #Code Compile Error
    $judge_stat = 0;
}
$user_agent = LWP::UserAgent->new;
$request = POST $config->{LocalPHPAddr}."?pass=".$config->{ServerPass}."&controller=update", 
	[msgs => encode_base64(join("\n",@stat)), stat => $judge_stat, jid => $codeinfo->{jid}];
$response = $user_agent->request($request);
#print $response->as_string;

return true;
