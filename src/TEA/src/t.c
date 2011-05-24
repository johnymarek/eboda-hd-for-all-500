#include <stdio.h>
#include <string.h>
#include <stdlib.h>

char res[17];
unsigned int crunch (unsigned int seed, char* file);
char * vlt(void);

int main (int argc, char *argv[])
{
  if (argc != 3) {
    printf("Usage: t seed movie\n");
    exit (1);
    
  }
  int seed;
  sscanf(argv[1],"%x",&seed);
  
  char * p=vlt();
  printf ("%x%s\n",crunch(crunch(crunch(seed,argv[2]),"0"),p),p);
  exit (0);
  
}


char * vlt()
{

  char * str="0123456789abcdef";
  int len = strlen(str);
  int t;
  int a;
  int i;
  
  for (i=0;i<8;i++) {
    a = random();
    t = a / (RAND_MAX/len);
    res[i]=str[t];
  }
  res[8]=0;
  return res;

  
  
}


unsigned int crunch (unsigned int seed, char* file)
{
  unsigned char c;
  int len = strlen(file);
  int i = 0;
  for (i = 0;i < len;i++) {
    c = file[i];
    seed ^= c;
    c %= 32;
    seed=((seed << c) & 0xffffffff)|(seed >> (32 - c));
  }
  return seed;
}



