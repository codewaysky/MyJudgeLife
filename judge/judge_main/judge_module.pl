#!/usr/bin/perl
use File::Basename;
use Data::Dumper;
use HTTP::Request::Common; 
use LWP::UserAgent;
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