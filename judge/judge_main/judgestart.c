#include <stdlib.h>
#include <stdio.h>
#include <string.h>
void main()
{
  if (setuid(0)) printf("Failed") ;
  system("chroot sandbox /judge_start");
}
