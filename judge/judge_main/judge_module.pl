#!/usr/bin/perl
use File::Basename;
use XML::Simple;
use Data::Dumper;
use HTTP::Request::Common; 
use LWP::UserAgent;

my $req = dirname($0)."/load_config.pl";
require $req;

$user_agent = LWP::UserAgent->new;
$request = POST 'http://192.168.145.132/cgireader.cgi',
    [text1 => 'Hello', text2 => 'there'];
$response = $user_agent->request($request);
print $response->as_string;
