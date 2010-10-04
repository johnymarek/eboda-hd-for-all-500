//XOR Encryption

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <linux/types.h>

#define MAX_SIZE 256

void encrypt_data(FILE* input_file, FILE* output_file, char *key);
void usage(int argc, char* argv[]);
void close_files(FILE* input, FILE* output);

typedef __u32 uint32_t ;

struct fwHeader
{
  __u32 crc0; // 0
  __u32 magic1; // mele
  __u32 magic2; // digi
  __u32 magicU; // NEU\n
  __u32 unk1; // 0
  __u32 unk2; // 1
  __u32 unk3; // 0
  __u32 crcp; // crc packed
  __u32 crcu; // crc unpacked
  __u32 ver;  // version? 0x0B
  __u32 unk4; // 0
  __u32 unk5; // 0x0148
  __u32 dlen; // data length
} fwHeader;


int main(int argc, char* argv[])
{

  struct fwHeader header;

  int eflag = 0; //encode
  int dflag = 0; //decode
  char *ivalue = NULL; //infile
  char *ovalue = NULL; //outfile
  char *kvalue = NULL; //outfile

  int index;
  int c;

  while ((c = getopt (argc, argv, "edi:o:k:")) != -1)
    switch (c)
      {
      case 'e':
	eflag = 1;
	break;
      case 'd':
	dflag = 1;
	break;
      case 'i':
	ivalue = optarg;
	break;
      case 'o':
	ovalue = optarg;
	break;
      case 'k':
	kvalue = optarg;
	break;
      case '?':
	if (optopt == 'i' || optopt == 'o' || optopt == 'k' )
	  fprintf (stderr, "Option -%c requires an argument.\n", optopt);
	else if (isprint (optopt))
	  fprintf (stderr, "Unknown option `-%c'.\n", optopt);
	else
	  fprintf (stderr,
		   "Unknown option character `\\x%x'.\n",
		   optopt);
	return 1;
      default:
	usage (argc, argv);
      }
  for (index = optind; index < argc; index++)
    printf ("Non-option argument %s\n", argv[index]);

  if ( eflag == 0 && dflag == 0 )
	usage (argc, argv);
  if ( eflag == 1 && dflag == 1 )
	usage (argc, argv);
  if ( ivalue == NULL || ovalue == NULL )
	usage (argc, argv);
  if ( kvalue == NULL )
	usage (argc, argv);

  FILE* input;
  FILE* output;

  //Open input and output files
  input = fopen(ivalue, "r");
  output = fopen(ovalue, "w");
		

  //Check input file
  if (input == NULL)
    {
      printf("Input file cannot be read.\n");
      exit(0);
    }
	
  //Check output file
  if (output == NULL)
    {
      printf("Output file cannot be written to.\n");
      exit(0);
    }
  if (dflag == 1)
    {
      //Check input file header
      if ( check_encrypted_header(input) != 0)
	{
	  close_files(input, output);
	  exit (1);
	}
      
      //decrypt
      if (decrypt_file(input, output) != 0)
	{
	  close_files(input, output);
	  exit (1);
	}
	  
      if (check_crc(input, output) != 0)
	{
	  close_files(input, output);
	  exit (1);
	}
	// OK
   }
  if (eflag == 1)
    {
      //crypt file
      //compute_deader
      //write header file
      
    }
  return 0;

}


void encrypt_data(FILE* input_file, FILE* output_file, char* key)
{
  int key_count = 0; //Used to restart key if strlen(key) < strlen(encrypt)
  int encrypt_byte;
	
  while( (encrypt_byte = fgetc(input_file)) != EOF) //Loop through each byte of file until EOF
    {
      //XOR the data and write it to a file
      fputc(encrypt_byte ^ key[key_count], output_file);

      //Increment key_count and start over if necessary
      key_count++;
      if(key_count == strlen(key))
	key_count = 0;
    }
}

void encrypt (uint32_t* v, uint32_t* k) {
    uint32_t v0=v[0], v1=v[1], sum=0, i;           /* set up */
    uint32_t delta=0x9e3779b9;                     /* a key schedule constant */
    uint32_t k0=k[0], k1=k[1], k2=k[2], k3=k[3];   /* cache key */
    for (i=0; i < 32; i++) {                       /* basic cycle start */
        sum += delta;
        v0 += ((v1<<4) + k0) ^ (v1 + sum) ^ ((v1>>5) + k1);
        v1 += ((v0<<4) + k2) ^ (v0 + sum) ^ ((v0>>5) + k3);  
    }                                              /* end cycle */
    v[0]=v0; v[1]=v1;
}
 
void decrypt (uint32_t* v, uint32_t* k) {
    uint32_t v0=v[0], v1=v[1], sum=0xC6EF3720, i;  /* set up */
    uint32_t delta=0x9e3779b9;                     /* a key schedule constant */
    uint32_t k0=k[0], k1=k[1], k2=k[2], k3=k[3];   /* cache key */
    for (i=0; i<32; i++) {                         /* basic cycle start */
        v1 -= ((v0<<4) + k2) ^ (v0 + sum) ^ ((v0>>5) + k3);
        v0 -= ((v1<<4) + k0) ^ (v1 + sum) ^ ((v1>>5) + k1);
        sum -= delta;                                   
    }                                              /* end cycle */
    v[0]=v0; v[1]=v1;
}


void usage(int argc, char* argv[])
{
  printf("Invalid arguments\n");
  printf("Usage: %s -[e|d] -i infile -o ofile -k key\n", argv[0]); 
  exit(0);
}

void close_files(FILE* input, FILE* output)
{
  //Close files
  fclose(input);
  fclose(output);
}
