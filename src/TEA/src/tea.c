//          Realtek SDK 3.x firmware decrypter/encrypter
//
// This program is a C re-write of delphi application from here:
// http://playonhd.ucoz.ru/publ/prodvinutye_manualy/modifikacija_proshivki/razborka_sborka_proshivok_na_sdk3_x/5-1-0-23

/***************************************************************************
 *   Copyright (C) 2010 cipibad                                            *
 *   cipibad@gmail.com                                                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 *   The program is distributed in the hope that it will be useful,        *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of        *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
 *   GNU General Public License for more details.                          *
 *                                                                         *
 *   You may obtain a copy of the GNU General Public License by writing to *
 *   the Free Software Foundation, Inc.,                                   *
 *   51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.             *
 ***************************************************************************/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

#include <limits.h>
#include <errno.h>


#define CRC0        0x0
#define MAGIC1      0x656C656D
#define MAGIC2      0x69676964
#define MAGICU      0x0055454E

#define VERSION     0xb
#define UNK5        0x148

#define HLEN        0x34
#define BUFFER_MAX      (64 * 1024)


typedef unsigned int uint32_t ;
typedef unsigned char uint8_t ;


void usage(int argc, char* argv[]);
void close_files(FILE* input, FILE* output);
int check_crc(FILE* input, FILE* output);



typedef struct fwHeader
{
  uint32_t crc0; // 0
  uint32_t magic1; // mele
  uint32_t magic2; // digi
  uint32_t magicU; // NEU\n
  uint32_t unk1; // 0
  uint32_t unk2; // 1
  uint32_t unk3; // 0
  uint32_t crcp; // crc packed
  uint32_t crcu; // crc unpacked
  uint32_t ver;  // version? 0x0B
  uint32_t unk4; // 0
  uint32_t unk5; // 0x0148
  uint32_t dlen; // data length
} fwHeader_t;


const uint32_t crc32Table[256]=
  {
    0x00000000, 0x77073096, 0xEE0E612C, 0x990951BA,
    0x076DC419, 0x706AF48F, 0xE963A535, 0x9E6495A3,
    0x0EDB8832, 0x79DCB8A4, 0xE0D5E91E, 0x97D2D988,
    0x09B64C2B, 0x7EB17CBD, 0xE7B82D07, 0x90BF1D91,

    0x1DB71064, 0x6AB020F2, 0xF3B97148, 0x84BE41DE,
    0x1ADAD47D, 0x6DDDE4EB, 0xF4D4B551, 0x83D385C7,
    0x136C9856, 0x646BA8C0, 0xFD62F97A, 0x8A65C9EC,
    0x14015C4F, 0x63066CD9, 0xFA0F3D63, 0x8D080DF5,

    0x3B6E20C8, 0x4C69105E, 0xD56041E4, 0xA2677172,
    0x3C03E4D1, 0x4B04D447, 0xD20D85FD, 0xA50AB56B,
    0x35B5A8FA, 0x42B2986C, 0xDBBBC9D6, 0xACBCF940,
    0x32D86CE3, 0x45DF5C75, 0xDCD60DCF, 0xABD13D59,

    0x26D930AC, 0x51DE003A, 0xC8D75180, 0xBFD06116,
    0x21B4F4B5, 0x56B3C423, 0xCFBA9599, 0xB8BDA50F,
    0x2802B89E, 0x5F058808, 0xC60CD9B2, 0xB10BE924,
    0x2F6F7C87, 0x58684C11, 0xC1611DAB, 0xB6662D3D,

    0x76DC4190, 0x01DB7106, 0x98D220BC, 0xEFD5102A,
    0x71B18589, 0x06B6B51F, 0x9FBFE4A5, 0xE8B8D433,
    0x7807C9A2, 0x0F00F934, 0x9609A88E, 0xE10E9818,
    0x7F6A0DBB, 0x086D3D2D, 0x91646C97, 0xE6635C01,

    0x6B6B51F4, 0x1C6C6162, 0x856530D8, 0xF262004E,
    0x6C0695ED, 0x1B01A57B, 0x8208F4C1, 0xF50FC457,
    0x65B0D9C6, 0x12B7E950, 0x8BBEB8EA, 0xFCB9887C,
    0x62DD1DDF, 0x15DA2D49, 0x8CD37CF3, 0xFBD44C65,

    0x4DB26158, 0x3AB551CE, 0xA3BC0074, 0xD4BB30E2,
    0x4ADFA541, 0x3DD895D7, 0xA4D1C46D, 0xD3D6F4FB,
    0x4369E96A, 0x346ED9FC, 0xAD678846, 0xDA60B8D0,
    0x44042D73, 0x33031DE5, 0xAA0A4C5F, 0xDD0D7CC9,

    0x5005713C, 0x270241AA, 0xBE0B1010, 0xC90C2086,
    0x5768B525, 0x206F85B3, 0xB966D409, 0xCE61E49F,
    0x5EDEF90E, 0x29D9C998, 0xB0D09822, 0xC7D7A8B4,
    0x59B33D17, 0x2EB40D81, 0xB7BD5C3B, 0xC0BA6CAD,

    0xEDB88320, 0x9ABFB3B6, 0x03B6E20C, 0x74B1D29A,
    0xEAD54739, 0x9DD277AF, 0x04DB2615, 0x73DC1683,
    0xE3630B12, 0x94643B84, 0x0D6D6A3E, 0x7A6A5AA8,
    0xE40ECF0B, 0x9309FF9D, 0x0A00AE27, 0x7D079EB1,

    0xF00F9344, 0x8708A3D2, 0x1E01F268, 0x6906C2FE,
    0xF762575D, 0x806567CB, 0x196C3671, 0x6E6B06E7,
    0xFED41B76, 0x89D32BE0, 0x10DA7A5A, 0x67DD4ACC,
    0xF9B9DF6F, 0x8EBEEFF9, 0x17B7BE43, 0x60B08ED5,

    0xD6D6A3E8, 0xA1D1937E, 0x38D8C2C4, 0x04FDFF252,
    0xD1BB67F1, 0xA6BC5767, 0x3FB506DD, 0x048B2364B,
    0xD80D2BDA, 0xAF0A1B4C, 0x36034AF6, 0x041047A60,
    0xDF60EFC3, 0xA867DF55, 0x316E8EEF, 0x04669BE79,

    0xCB61B38C, 0xBC66831A, 0x256FD2A0, 0x5268E236,
    0xCC0C7795, 0xBB0B4703, 0x220216B9, 0x5505262F,
    0xC5BA3BBE, 0xB2BD0B28, 0x2BB45A92, 0x5CB36A04,
    0xC2D7FFA7, 0xB5D0CF31, 0x2CD99E8B, 0x5BDEAE1D,

    0x9B64C2B0, 0xEC63F226, 0x756AA39C, 0x026D930A,
    0x9C0906A9, 0xEB0E363F, 0x72076785, 0x05005713,
    0x95BF4A82, 0xE2B87A14, 0x7BB12BAE, 0x0CB61B38,
    0x92D28E9B, 0xE5D5BE0D, 0x7CDCEFB7, 0x0BDBDF21,

    0x86D3D2D4, 0xF1D4E242, 0x68DDB3F8, 0x1FDA836E,
    0x81BE16CD, 0xF6B9265B, 0x6FB077E1, 0x18B74777,
    0x88085AE6, 0xFF0F6A70, 0x66063BCA, 0x11010B5C,
    0x8F659EFF, 0xF862AE69, 0x616BFFD3, 0x166CCF45,

    0xA00AE278, 0xD70DD2EE, 0x4E048354, 0x3903B3C2,
    0xA7672661, 0xD06016F7, 0x4969474D, 0x3E6E77DB,
    0xAED16A4A, 0xD9D65ADC, 0x40DF0B66, 0x37D83BF0,
    0xA9BCAE53, 0xDEBB9EC5, 0x47B2CF7F, 0x30B5FFE9,

    0xBDBDF21C, 0xCABAC28A, 0x53B39330, 0x24B4A3A6,
    0xBAD03605, 0xCDD70693, 0x54DE5729, 0x23D967BF,
    0xB3667A2E, 0xC4614AB8, 0x5D681B02, 0x2A6F2B94,
    0xB40BBE37, 0xC30C8EA1, 0x5A05DF1B, 0x2D02EF8D
  };

void decrypt (uint32_t* v, uint32_t* k);
void encrypt (uint32_t* v, uint32_t* k);

int encrypt_file(FILE* in, FILE* out, uint32_t* key)
{
  rewind(in);
  fseek(out, HLEN, SEEK_SET);
 
  uint32_t v[2];
  uint32_t r = 2 * sizeof(uint32_t);

  while ( r == fread( v, 1, r, in))
    {
      encrypt(v, key);
      if ( r != fwrite(v, 1, r, out))
	{
	  printf ("Wrror writing file\n");
	  exit(1);
	}
    }
  if (feof(in))
    {
      //      printf("Reached end of file\n");
      clearerr(in);
    }
  if (ferror(in))
    {
      printf("Error occured while reading file\n");
      clearerr(in);
    }
}

int decrypt_file(FILE* in, FILE* out, uint32_t* key)
{
  fseek(in, HLEN, SEEK_SET);
  rewind(out);
  uint32_t v[2];
  uint32_t r = 2 * sizeof(uint32_t);

  while ( r == fread( v, 1, r, in))
    {
      decrypt(v, key);
      if ( r != fwrite(v, 1, r, out))
	{
	  printf ("Wrror writing file\n");
	  exit(1);
	}
    }
  if (feof(in))
    {
      //      printf("Reached end of file\n");
      clearerr(in);
    }
  if (ferror(in))
    {
      printf("Error occured while reading file\n");
      clearerr(in);
    }
}

int  get_encrypted_file_crc(FILE* file)
{
  fseek(file, HLEN, SEEK_SET);
  return get_file_crc(file);
}

void update_crc(uint32_t* result, uint8_t* buffer, uint32_t len)
{
  uint32_t index;
  uint32_t crc = *result;
  int i;
  for( i = i ; i < len; i++)
    {
      index = (crc ^ buffer[i]) & 0x000000FF;
      crc = (crc >> 8 ) ^ crc32Table[index];
    }

  *result = crc;
}

int  get_file_crc(FILE* file)
{
  void * buffer = malloc (BUFFER_MAX);
  uint32_t result = 0xFFFFFFFF;
  uint32_t r;
  while ( (r = fread( buffer, 1, BUFFER_MAX, file)) && r > 0)
    {
      update_crc(&result, buffer, r);
    }
  if (feof(file))
    {
      //      printf("Reached end of file\n");
      clearerr(file);
    }
  if (ferror(file))
    {
      printf("Error occured while reading file\n");
      clearerr(file);
    }
  return(~result);
}

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


  while ((c = getopt (argc, argv, "hedi:o:k:")) != -1)
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
      case 'h':
	usage (argc, argv);
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

  int j;
  uint32_t k[4];
  char tkey[8+1];
  tkey[8]=0;
  for (j=0; j < 4; j++)
    {
      errno = 0;    /* To distinguish success/failure after call */
      memcpy(tkey, &kvalue[j*sizeof(char)*8], sizeof(char)*8);

      k[j] = strtol(tkey, 0, 16);
      
      /* Check for various possible errors */
      
      if ((errno == ERANGE && (k[j] == LONG_MAX || k[j] == LONG_MIN))
	  || (errno != 0 && k[j] == 0)) {
	perror("strtol");
	exit(EXIT_FAILURE);
      }
      
    }

  FILE* input;
  FILE* output;

  //Open input and output files
  input = fopen(ivalue, "r");
  output = fopen(ovalue, "w+");
		

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
  if (dflag == 1) //decode operation
    {
      //Check input file header
      if ( check_encrypted_header(input) != 0)
	{
	  close_files(input, output);
	  exit (1);
	}
      //decrypt
      if (decrypt_file(input, output, k) != 0)
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
      //encrypt
      if (encrypt_file(input, output, k) != 0)
	{
	  close_files(input, output);
	  exit (1);
	}
      if (write_encrypted_header(input, output) != 0)
	{
	  close_files(input, output);
	  exit (1);
	}

    }
  close_files(input, output);
  return 0;

}


void encrypt (uint32_t* v, uint32_t* k) {
    uint32_t v0=v[0], v1=v[1], sum=0, i;           /* set up */
    uint32_t delta=0x9e3779b9;                     /* a key schedule constant */
    uint32_t k0=k[0], k1=k[1], k2=k[2], k3=k[3];   /* cache key */
    for (i=0; i < 32; i++) {                       /* basic cycle start */
        sum += delta;
        v0 += (v1<<4) + ( k0 ^ v1) + (sum ^ (v1>>5)) + k1;
        v1 += (v0<<4)+ ( k2 ^ v0) + (sum ^ (v0>>5)) + k3;  
    }                                              /* end cycle */
    v[0]=v0; v[1]=v1;
}
 
void decrypt (uint32_t* v, uint32_t* k) {
    uint32_t v0=v[0], v1=v[1], sum=0xC6EF3720, i;  /* set up */
    uint32_t delta=0x9e3779b9;                     /* a key schedule constant */
    uint32_t k0=k[0], k1=k[1], k2=k[2], k3=k[3];   /* cache key */
    for (i=0; i<32; i++) {                         /* basic cycle start */
      v1 -= ( v0 << 4 ) + ( k2 ^ v0 ) + ( sum ^ ( v0 >> 5 )) + k3;
      v0 -= ( v1 << 4)  + ( k0 ^ v1 ) + ( sum ^ ( v1 >> 5 )) + k1;
      sum -= delta;                                   
    }                                              /* end cycle */
    v[0]=v0; v[1]=v1;
}


void usage(int argc, char* argv[])
{
  printf("Invalid arguments\n");
  printf("Usage: %s -[e|d] -i infile -o outfile -k key\n", argv[0]); 
  exit(0);
}

void close_files(FILE* input, FILE* output)
{
  //Close files
  fclose(input);
  fclose(output);
}

int check_encrypted_header(FILE * file)
{ 
  fwHeader_t header_;
  if (read_header (&header_, file) != 0)
    {
      printf("Cannot check header 1\n");
      return(1);
    }
  int res = 0;
  if ( (header_.crc0	!= CRC0) ||
       (header_.magic1	!= MAGIC1) ||
       (header_.magic2	!= MAGIC2))
    {
      printf("Bad magic\n");
      res = 1;
    }
  
  fseek(file, 0, SEEK_END);
  if (header_.dlen != (ftell(file) - HLEN))
    {
      printf("Bad data len\n");
      res = 1;
    }

  if (header_.crcp != get_encrypted_file_crc(file))
    {
      printf("Bad crc\n");
      res = 1;
    }
  return res;
}


int read_header (fwHeader_t * pHeader, FILE* file)
{
  int r;
  rewind(file);
  r = fread( (void*) pHeader, 1, sizeof(fwHeader_t), file);
  if (r < sizeof(fwHeader_t))
    { 
      printf("Cannot read header\n");
      return(1);
    }
  return 0;
  
}

int fill_header (fwHeader_t * pHeader, FILE* input, FILE* output)
{

  pHeader->crc0 = CRC0; // 0
  pHeader->magic1 = MAGIC1; // mele
  pHeader->magic2 = MAGIC2; // digi
  pHeader->magicU = MAGICU; // NEU\n
  pHeader->unk1 = 0; // 0
  pHeader->unk2 = 1; // 1
  pHeader->unk3 = 0; // 0

  pHeader->crcp = 0; // crc packed
  pHeader->crcu = 0; // crc unpacked

  pHeader->ver = VERSION;  // version? 0x0B
  pHeader->unk4 = 0; // 0
  pHeader->unk5 = UNK5; // 0x0148

  fseek(input  , 0, SEEK_END);
  pHeader->dlen = ftell(input); // data length

  fseek(input, 0, SEEK_SET);
  pHeader->crcu = get_file_crc(input);

  pHeader->crcp = get_encrypted_file_crc(output);

  return 0;
}

int write_encrypted_header ( FILE* input, FILE* output)
{
  fwHeader_t header_;

  if (fill_header (&header_, input, output) != 0)
    {
      printf("Cannot fill\n");
      return(1);
    }

  if (write_header (&header_, output) != 0)
    {
      printf("Cannot write header\n");
      return(1);
    }


  
}

int write_header (fwHeader_t * pHeader, FILE* file)
{
  int r;
  rewind(file);
  r = fwrite( (void*) pHeader, 1, sizeof(fwHeader_t), file);
  if (r < sizeof(fwHeader_t))
    { 
      printf("Cannot read header\n");
      return(1);
    }
  return 0;
  
}

int check_crc(FILE* input, FILE* output)
{
  fwHeader_t header_;
  if (read_header (&header_, input) != 0)
    {
      printf("Cannot check header 1\n");
      return(1);
    }
  rewind(output);
  if (header_.crcu != get_file_crc(output))
    {
      printf("Wrong CRC32 of unencrypted data\n");
      return(1);
    }
}
