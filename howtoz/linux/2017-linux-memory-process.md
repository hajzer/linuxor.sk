## Virtuálna pamäť užívateľského procesu v OS Linux
**FILE:** linux-memory-process.md<br>
**DATE:** 2017 <br>
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk <br>
**VERSION:** 0 (Demo/Draft)


## 1 Intro


### 1.1 Fyzická pamäť


Fyzická pamäť je úložné hardvérové zariadenie. Viac detailov -> [https://en.wikipedia.org/wiki/Computer_memory](https://en.wikipedia.org/wiki/Computer_memory)


### 1.2 Virtuálna pamäť


Virtuálna pamäť poskytuje softvérovo riadenú správu pamäťových adries, umožňujúc
každému programu/procesu mať vlastný unikátny pohľad na pamäť počítača. 

Vo viac-úlohových (multi-tasking) operačných systémoch je každý proces spustený vo vlastnej pamäťovej klietke (sandbox), ktorý sa nazýva
virtuálny adresný priestor (Virtual Address Space). Na 32 bitových platformách je to blok pamäťových adries o veľkosti 4GB. 

Jedným zo
spôsobov ako spravovať pamäť OS je mechanizmus stránkovania, ktorý umožňuje, aby
fyzický adresný priestor programu/procesu nebol súvisly. Mechanizmus stránkovania je 
použitý v v operačnom systéme Linux ako aj ďalších OS. Virtuálny
adresný priestor je pri mechanizme stránkovania mapovaný na fyzickú pamäť pomocou tabuliek stránok, ktoré spravuje jadro operačného systému.


### 1.3 Stránkovanie


Pri stránkovaní je fyzická ako aj logická pamäť rozdelená na bloky rovnakej veľkosti pričom pri fyzickej pamäti hovoríme o rámcoch (frame) a pri logickej pamäti hovoríme o stránkach (page). Kedže veľkosti blokov sú konštantne veľké, stačí stránky iba číslovať a nie je nutné zaregistrovať celé adresy stránok. Mapovanie fyzických adries
na virtuálne, mechanizmom stránkovania je znazornené na nasledujúcej blokovej schéme.


<pre>
                                               +----------+
                                              0|          |
    +----------+             +---+             +----------+
    |  page 0  |            0| 1 |            1|  page 0  |
    +----------+             +---+             +----------+
    |  page 1  |            1| 5 |            2|  page 2  |
    +----------+             +---+             +----------+
    |  page 2  |            2| 2 |            3|          |
    +----------+             +---+             +----------+
    |  page 3  |            3| 8 |            4|          |
    +----------+             +---+             +----------+
    |   ...    |            4|   |            5|  page 1  |
    +----------+             +---+             +----------+
    |  page N  |            5|   |            6|          |
    +----------+             +---+             +----------+
                                              7|          |
                                               +----------+
                                              8|  page 3  |
                                               +----------+

   logicka pamat        tabulka stranok        fyzicka pamat
</pre>


### 1.4 Lineárny adresný priestor


Z perspektívy užívateľského priestoru je adresný priestor plochý lineárny adresný priestor, ale
perspektíva jadra OS je odlišná. Adresný priestor je v OS rozdelený na 2 časti, užívateľský adresný priestor 
a adresný priestor jadra OS. Miesto rozdelenia na tieto dve časti je určené hodnotou premennej **"PAGE_OFFSET"**, 
ktorá ma na platforme x86 hodnotu a teda sa nachádza na adrese **"0xc0000000"**. To znamená, že 1 GiB je vždy mapovaný jadrom OS a zvyšné 3 GiB su dostupné pre užívateľské procesy.


### 1.5 Správa adresného priestoru v Linux OS


Adresný priestor použiteľný Linux procesom je spravovaný dátovou štruktúrou **"mm_struct"**. Každý adresný 
priestor pozostáva z určitého počtu pamaťových regionov, ktoré sa nikdy neprekrývajú. Pamäťový región 
môže reprezentovať haldu (heap) procesu určenú pre alokovanie pamäte pomocou **"malloc()"**, mapovanie 
súborov do pamäte ako napríklad zdieľané knižnice alebo anonymnú pamäť alokovanú pomocou **"mmap()"**.


### 1.6 Pamaťové regióny Linux procesu


Adresný priestor procesu je len zriedkavo použitý celý, vačšinou sú použité len  určité časti pamäťových regiónov.
Každý pamäťový región je reprezentovaný štruktúrov **"vm\_area\_struct"** a ako bolo už vyššie spomenuté, tieto
pamäťové regióny sa nikdy neprekrývajú. Zoznam všetkých pamäťových regionov Linux procesu je možné
preskúmať cez PROC rozhranie, konkrétne v **"/proc/[pid]/maps"** pričom [pid] je jednoznačný identifikátor
procesu.


### 1.7 Systémové volania súvisiace s pamäťovými regiónmi Linux procesu


- **fork()** - Vytvorí nový proces s novým adresným priestorom. Všetky stránky (pages) sú označené ako COW (Copy On Write) a sú zdieľané medzi týmito dvoma procesmi dovtedy pokiaľ nenastane zlyhanie stranky (page fault), ktoré spôsobí vytvorenie privátnych kópií stránok.
- **clone()** - Vytvorí nový proces pričom novému procesu umožní zdieľať časť kontextu jeho rodiča. Takto sú na Linux OS implementované vlákna procesu.
- **mmap()** - Vytvorí nový pamäťový región v adresnom priestore procesu.
- **mremap()** - Premapuje alebo upraví veľkosť pamäťového regiónu.
- **munmap()** - Odstráni časť alebo celý pamäťový región.
- **shmat()** - Pripojí zdieľaný pamäťový segment do adresného priestoru procesu.
- **shmdt()** - Odstráni zdieľaný pamäťový segment z adresného priestoru procesu.
- **execve()** - Načíta nový spustiteľný súbor prepísaním aktuálneho adresného priestoru.
- **exit()** - Zruší adresný priestor a všetky pamäťové regióny procesu.


## 2 Virtuálna pamäť Linux programu/procesu


> !!! Upozornenie !!! Niektoré z nasledujúcich informácií sa vzťahujú na verziu jadra 3.10. V iných verziách jadra sa tieto informácie môžu líšiť. 


### 2.1 Blokový diagram pamäte Linux procesu


Na nasledujúcom blokovom diagrame je znázornené rozloženie pamäte Linux procesu napísaného v jazyku C.


<pre>
                                                                     Vyssie pamatove adresy

            0xffffffff -------> =============================
                                | Kernel / System           | Uzivatelske programy nemozu zapisovat ani citat z tychto adries
                                |                           | Pokus o citanie alebo zapisovanie skonci zlyhanim segmentacie 
                                |                           | (Segmentation Fault).
            0xc0000000 -------> =============================
                                |###########################|
                                |###########################|      Prazdne pamatove miesto
                                |###########################|      Nahodny posun zasobnika (stack)
                                |###########################|
       start_stack -----------> ============================= . . . . . . . . . . . . . . . . . . . . ==========================
                       smer |   | Zasobnik (Stack)          |                                         |      STACK segment     |
                      rastu |   |                           |                                         |                        |
                            |   | env                       |                                         |                        |
                            |   | argv                      |                                         |                        |
                            |   | argc                      |                                         |                        |
                            |   -----------------------------                                         |                        |
                            |   | automaticke premenne pre  |                                         |                        |
                            |   | funkciu "main()"          |                                         |                        |
                            |   -----------------------------                                         |                        |
                            |   | automaticke premenne pre  |                                         |                        |
                            v   | funkciu "funkcia()"       |                                         |                        |
     stack_pointer -----------> ============================= . . . . . . . . . . . . . . . . . . . . ==========================
(ukazuje na vrchol zasobnika)   |###########################|
                                |###########################|      Prazdne pamatove miesto
                                |###########################|      Dostupne pre rast zasobnika
                                |###########################|
         mmap_base -----------> ============================= . . . . . . . . . . . . . . . . . . . . ==========================
                       smer |   | malloc.o  (lib*.so)       | Mapovanie suborov (Funkcie z kniznic v  | Memory mapping segment |  
                      rastu |   |                           | pripade dynamickeho linkovania) alebo   |                        |
                            v   | printf.o  (lib*.so)       |      anonymne mapovanie                 |                        |
                   ------------ ============================= . . . . . . . . . . . . . . . . . . . . ==========================
                                |###########################|
                                |###########################|      Prazdne pamatove miesto
                                |###########################|      Dostupne pre rast haldy
     program break              |###########################|
               brk -----------> ============================= . . . . . . . . . . . . . . . . . . . . ==========================
                            ^   | Halda (Heap)              |                                         |      HEAP segment      |
                            |   |                           |                                         |                        |
                       smer |   | malloc()                  |                                         |                        |
                      rastu |   | calloc()                  |                                         |                        |
                                | new                       |                                         |                        |
         start_brk -----------> ============================= . . . . . . . . . . . . . . . . . . . . ==========================
                                |###########################|     
                                |###########################|     Prazdne pamatove miesto
                                |###########################|     Nahodny brk posun/offset
                                |###########################|   
                   -----------> ============================= . . . . . . . . . . . . . . . . . . . . ==========================
           end_bss              | Globalne premenne         |      Nenainicializovane data            |      BSS segment       |
                                |                           |      (inicializovane na nulu)           |        (.bss)          |
                                | char *s;                  |                                         |                        |
         start_bss -----------> |---------------------------| . . . . . . . . . . . . . . . . . . . . ==========================
          end_data              | int  n = 10;              |      Inicializovane data                |     DATA segment       |
                                |                           | (premenne inicializovane programatorom) |       (.data)          |
                                | char *s = "Retazec";      |                                         |                        |
        start_data -----------> ============================= . . . . . . . . . . . . . . . . . . . . ==========================
          end_code              | malloc.o  (lib*.a)        |     Funkcie z kniznic v                 |  TEXT / CODE (ELF)     |
                                |                           |     pripade statickeho                  |       segment          |
                                | printf.o  (lib*.a)        |     linkovania                          |                        |
                                ============================= . . . . . . . . . . . . . . . . . . . . |                        |
                                | program.o                 |                                         |  Skompilovany kod      |
                                |                           |                                         |    (program.out)       |
                                -----------------------------                                         |                        |
                                | main.o                    |                                         |                        |
                                |                           |                                         |  Binarny obraz procesu |
                                |                funkcia()  | <--- Navratova adresa                   |    (/bin/program)      |
                                =============================                                         |                        |
                                |                           |                                         |                        |
                                | crt0.o (spustacia rutina) |                                         |                        |
                                |                           |                                         |                        |
        start_code ------------ =============================                                         ==========================

                                                                    Nizsie pamatove adresy
</pre>


### 2.2 Pamäťový deskriptor Linux procesu


Jadro operačného systému Linux reprezentuje adresný priestor procesu pomocou dátovej štruktúry nazvanej **"Desktriptor pamäte (Memory Descriptor)"**. Táto štruktúra obsahuje všetky informácie súvisiace s adresným priestorom procesu. Pamäťový deskriptor je v OS Linux (jadro verzie 3.10) reprezentovaný štruktúrov **"mm\_struct"** a definovaný v hlavičkovom súbore **"<linux/mm\_types.h>"** (v starších verziách v <linux/sched.h>). Pre každý proces existuje práve jedna dátová štruktúra **"mm\_struct"**, ktorá je zdieľaná vláknami procesu. 


<pre>
struct mm_struct {

struct vm_area_struct  *mmap;             /* Smernik smerujuci na vrchny prvok zoznamu objektov pamatovych oblasti (Virtual Memory Areas).  */
                                          /* Inak povedane je to zoznam pamatovych oblasti (Virtual Memory Areas).                          */
struct rb_root         mm_rb;             /* Smernik smerujuci na koren red-black stromu objektov pamatovych oblasti .                      */
struct vm_area_struct  *mmap_cache;       /* Smernik smerujuci na naposledy pouzitu (referencovanu) pamatovu oblast.                        */
unsigned long          mmap_base;         /* Zakladna/bazova adresa pamatovych mapovacich (mmap) oblasti.                                   */
unsigned long          task_size;         /* Celkova velkost adresneho priestoru procesu.                                                   */
unsigned long          cached_hole_size;  /* Ak ma nenulovu hodnotu tak obsahuje velkost najvacsieho prazdneho pamatoveho miesta, ktore sa  */
                                          /* nachadza nizsie ako adresa "free_area_cache".                                                  */
unsigned long          free_area_cache;   /* Prva adresa smerujuca na prazdne miesto, ktore ma velkost "free_area_cache" alebo vacsiu.      */
                                          /* Je to adresa z ktorej jadro zacne hladat volny rozsah linearnych adries v adresnom priestore   */
                                          /* procesu.                                                                                       */
unsigned long          highest_vm_end;    /* Najvyssia koncova/posledna adresa virtualnej pamatovej oblasti.                                */
pgd_t                  *pgd;              /* Smernik na tzv. Page Global Directory. Kazdy proces ma nastaveny tento smernik                 */
                                          /* na svoj vlastny PGD, ktory vlastne predstavuje fyzicky ramec stranky (physical page frame).    */
atomic_t               mm_users;          /* Sekundarne pocitadlo pouziti. Pocet procesov, ktore zdielaju datovu strukturu "mm_struct".     */
atomic_t               mm_count;          /* Primarne pocitadlo pouziti.                                                                    */
int                    map_count;         /* Pocet pamatovych oblasti .                                                                     */
spinlock_t             page_table_lock;   /* Zamok tabuliek stranok (page tables lock). Chrani tabulky stranok a niektore pocitadla.        */
struct rw_semaphore    mmap_sem;          /* Semafor pamatovych oblasti (Read/Write semafor).                                               */
struct list_head       mmlist;            /* Zoznam vsetkych struktur "mm_struct".                                                          */
unsigned long          hiwater_rss;       /* Najvyssia hodnota (High-watermark) ukazovatela RSS (Resident Set Size).                        */
unsigned long          hiwater_vm;        /* Najvyssia hodnota (High-watermark) celkovej velkosti adresneho priestoru procesu (pocet        */
                                          /* stranok procesu).                                                                              */
unsigned long          total_vm;          /* Celkova velkost adresneho priestoru procesu (pocet stranok procesu).                           */
unsigned long          locked_vm;         /* Pocet uzamknutych stranok, ktore nemozu byt umiestnene do SWAP priestoru.                      */
                                          /* Jedna sa o stranky, ktore maju nastaveny priznak "PG_mlocked".                                 */
unsigned long          pinned_vm;         /* Pocet stranok adresneho priestoru procesu, ktore su permanentne napinovane v pamati.           */
                                          /* TODO -> preskumat ako to je s tym pinovanim myslene.                                           */
unsigned long          shared_vm;         /* Pocet zdielanych stranok (subory).                                                             */
unsigned long          exec_vm;           /* Pocet stranok adresneho priestoru procesu, ktore maju nastavene opravnenia VM_EXEC & ~VM_WRITE */
unsigned long          stack_vm;          /* Pocet stranok adresneho priestoru procesu, ktore patria zasobniku (stack). VM_GROWSUP/DOWN     */
unsigned long          def_flags;         /* Predvolene (default) pristupove opravnenia (flag-y) pamatovych oblasti.                        */
unsigned long          nr_ptes;           /* Page table pages.                                                                              */
unsigned long          start_code;        /* Startovacia adresa segmentu code.                                                              */
unsigned long          end_code;          /* Posledna adresa segmentu code.                                                                 */
unsigned long          start_data;        /* Startovacia adresa segmentu data.                                                              */
unsigned long          end_data;          /* Posledna adresa segmentu data.                                                                 */
unsigned long          start_brk;         /* Startovacia addresa segmentu haldy (heap).                                                     */
unsigned long          brk;               /* Posledna adresa segmentu haldy (heap).                                                         */
unsigned long          start_stack;       /* Startovacia adresa segmentu zasobnika (stack).                                                 */
unsigned long          arg_start;         /* Startovacia adresa argumentov programu.                                                        */
unsigned long          arg_end;           /* Posledna adresa argumentov programu.                                                           */
unsigned long          env_start;         /* Startovacia adresa premennych prostredia.                                                      */
unsigned long          env_end;           /* Posledna adresa premennych prostredia.                                                         */

/* Specialne pocitadla, ktore su v niektorych konfiguraciach chranene pomocou "page_table_lock" a v inych konfiguraciach tym, ze operacie   */
/* su atomicke.                                                                                                                             */
struct mm_rss_stat     rss_stat;             
struct linux_binfmt    *binfmt;
cpumask_var_t          cpu_vm_mask_var;   /* Bitova maska pre lenivy TLB (Translation Lookaside Buffer) prepinac (lazy TLB switch).         */
                                          /* TLB (Translation Lookaside Buffer) je cache pamat na procesore (na MMU jednotke), ktora sa     */
                                          /* pouziva na redukovanie casu potrebneho pre pristup k uzivatelskej pamatovej lokacii.           */
                                          /* Inymi slovami povedane v TLB su ulozene nedavne preklady virtualnych adries na fyzicke adresy. */
mm_context_t           context;           /* Specificke data/kontext pre konkretnu architekturu.                                            */

...

};
</pre>


> Štruktúra "mm\_struct" ma viac elementov/členov, ale pre pamäťovo orientované úlohy si vystačíme s touto definíciou. Celú definíciu štruktúry "mm\_struct" pre verziu jadra 3.10 je možné nájsť -> [http://lxr.linux.no/linux+v3.10/include/linux/mm_types.h#L325](http://lxr.linux.no/linux+v3.10/include/linux/mm_types.h#L325)


## 4 Informácie o pamäti linuxového programu/procesu


### 4.1 Štatistické informácie o pamäti Linux procesu
Zobrazenie základných informácii o využívaní pamäte programom/procesom, (merané v jednotkách stránok [pages]) vykonáme nasledovne.


<pre>
# cat /proc/<[pid]/statm
--------------------------------------------------------------------------------
size  resident shared  text  lib  data  dt
--------------------------------------------------------------------------------
40938 1257     894     261   0    408   0
</pre>


- **size/VmSize**             - Celková veľkosť programu/procesu v pamäti (total program size)
- **resident/VmRSS**          - Rezidentná veľkosť (resident set size)
- **shared/RssFile+RssShmem** - Počet rezidentných zdieľaných stránok (resident shared pages)
- **text/code**               - Text (Code)
- **lib**                     - Knižnice/Library (od verzie 2.6 sa nepoužíva, má stále hodnotu 0)
- **data**                    - Data + Stack
- **dt**                      - Špinavé/Dirty stránky/pages (od verzie 2.6 sa nepoužíva, má stále hodnotu 0)


### 4.2 Popis pamäťových regiónov Linux procesu


Zobrazenie popisu regiónov virtuálnej pamäte programu/procesu alebo vlákna vykonáme nasledovne.


<pre>
# cat /proc/<[pid]/maps
--------------------------------------------------------------------------------
address           perm offset   dev   inode                              path
--------------------------------------------------------------------------------
00400000-00505000 r-xp 00000000 fd:00 50818536                           /usr/bin/mc
00705000-0070a000 r--p 00105000 fd:00 50818536                           /usr/bin/mc
0070a000-0070f000 rw-p 0010a000 fd:00 50818536                           /usr/bin/mc
0070f000-00747000 rw-p 00000000 00:00 0
01e5f000-01f10000 rw-p 00000000 00:00 0                                  [heap]
</pre>


- **address**             - Prvá a posledná adresa pamäťového regiónu v adresnom priestore programu/procesu.
- **perm**                - Popisuje ako sú stránky pamäťového regiónu sprístupnene:
                      r = read                    [umožnené čítať]
                      w = write                   [umožnený zápis]
                      x = execute                 [umožnené vykonávanie]
                      s = shared                  [zdieľaná virtuálna pamäť]
                      p = private (copy on write) [privátna virtuálna pamäť]
                      
>Poznámka: Oprávnenia môžu byť zmenené systémovým volaním "mprotect()".

- **offset**              - Ak je pamäťový región mapovaný zo súboru pomocou systémového volania "mmap()" tak táto hodhota je posun/offset v danom súbore na ktorom začína mapovanie. Ak pamäťový región nie je mapovaný zo súboru je hodnota posunu/offset-u rovná nule (0).
- **device**              - Ak je pamäťový región mapovaný zo súboru, tak táto hodnota obsahuje major a minor čísla zariadenia na ktorom sa súbor nachádza.
- **inode**               - Ak je pamäťový región mapovaný zo súboru, tak táto hodnota obsahuje inode číslo súboru.
- **path**                - Ak je pamäťový región mapovaný zo súboru, tak táto hodnota obsahuje cestu k súboru. Hodnota môže byť prázdna ak sa jedná o anonymne mapovaný pamäťový región.
                      Existujú špeciálne pamäťové regióny ako sú:
                      [stack] = zásobnik programu/procesu
                      [heap]  = halda programu/procesu
                      [vdso]  = dynamicky zdieľaný objekt (virtual dynamic shared object)


## 5 Čítanie pamäťových regiónov Linux procesu


Linux sprístupňuje virtuálnu pamäť procesu prostredníctvom záznamu v pseudo súborovom systéme/rozhraní **"/proc"** v pseudo súbore **"/proc/[pid]/mem"**. Pseudo súbor **"/proc/[pid]/mem"** zobrazuje obsah pamäťových regiónov procesu rovnakým spôsobom ako sú mapované v samotnom procese. Bajt (Byte) na offsete X (alebo inak povedané posunutý o X) v súbore **"/proc/[pid]/mem"** je rovnaký resp. ten istý ako bajt na adrese X v samotnom procese. Ak je adresa v procese odmapovaná, tak čítanie z tohoto offsetu zo súboru **"/proc/[pid]/mem"** skončí chybovým hlásením o chybe vstupu/výstupu (**"EIO", "Input/Output Error"**). Nakoľko na prvej stránke (page) procesu nie je väčšinou namapované nič, tak čítanie prvej stránky zo súboru **"/proc/[pid]/mem"** skončí s chybovým hlásením o chybe vstupu/výstupu. Toto trvdenie je možné otestovať tak, že sa pokúsime prečítať pamäť procesu príkazom **"cat /proc/[pid]/mem"** (s právami užívateľa **"root"**). 

Nie všetky pamäťové regióny sú čitateľné. Pamäťové regióny procesu sú zaznamenané v súborovom systéme **"/proc"** v pseudo textovom súbore 
**"/proc/[pid]/maps"**. V podstate sa jedná o pamäťovú mapu procesu. Ak chceme prečítať pamäť nejakého iného procesu musíme ako prvé prečítať popis jeho pamäťových regiónov, ktorý sa nachádza v súbore **"/proc/[pid]/maps"** a  v ktorom sa nachádzajú aj prístupové informácie (čítanie/zapisovanie, ...) k týmto pamäťovým regiónom. Ak vieme ku ktorým
pamäťovým regiónom je povolený prístup, môžeme tieto regióny prečítať a skopírovať z pseudo súboru **"/proc/[pid]/mem"** pomocou systemových
volaní **"read()"** a **"mmap()"** avšak proces čítania pamäte nie je taký priamočiary a musia byť splnené určité podmienky. 

Na to, aby bolo možné čítať (proces reader) pamäťové regióny iného procesu (proces target) musia byť splnené určité podmienky:


- Proces, ktorý chce čítať (reader) pamäťové regióny iného procesu (target) z **"/proc/[pid]/mem"** sa musí na tento iný proces (target) 
  pripojiť pomocou systémového volania **"ptrace()"** s nastaveným príznakom (flag-om) **"PTRACE\_ATTACH"**. Po ukončení čítania z **"/proc/[pid]/mem"** 
  by sa mal čítajúci proces (reader) odpojiť od procesu (target) opäť pomocou systémového volania **"ptrace()"**, ale s príznakom 
  **"PTRACE\_DETACH"**. Takýmto spôsobom sa k procesu pripájajú debugger nástroje. 
  Nutnosť pripojiť sa na iný proces pomocou **"ptrace()"** neplatí pre procesy (reader), ktoré boli spustené pod užívateľom "root" avšak 
  proces (target), ktorého pamäť sa snažíme čítať musí byť zastavený.
- Proces (target), ktorého pamäť sa snažíme čítať musí byť zastavený. Je to z toho dôvodu, že spustený proces (target) si počas svojho behu
  dynamicky alokuje pamäť podľa požiadavok samotného programu a tým pádom modifikuje svoje pamäťové regióny, čo môže mať za dôsledok to, že čítajúci proces (reader) sa bude snažiť prečítať taký pamäťový región (resp. stránky), ktorý už bol z procesu odmapovaný a tak čítajúci proces snažiaci sa prečítať takéto stránky dostane chybové hlásenie **"EIO", "Input/Output Error"**, viď. vyššie začiatok tejto kapitoly.


 Systémove volanie **"ptrace()"** 
  s príznakom **"PTRACE\_ATTACH"** vykoná zastavenie cieľového procesu (target) zaslaním signálu STOP. Nakoľko je doručenie signálu asynchrónne,
  proces, ktorý vykonáva čítanie pamäte (reader) musí chvíľku počkať na to, pokiaľ cieľový proces (target) zmení svoj stav a to tak, že zavolá 
  systémové volanie **"waitpid()"**, ktoré pozastaví vykonávanie procesu (reader) do času pokiaľ proces (target) špecifikovaný pomocou PID zmení
  svoj stav.


Ukážka C kódu, ktorý sa pripojí na cieľový proces (target) identifikovaný identifikátorom procesu (PID) a vykoná čítanie pamäťového regiónu:


<pre>
/* Do premennej "mem_file_name" si uložíme cestu k PROC pseudo suboru.          */
/* Pr: mem_file_name = "/proc/15482/mem".                                       */
sprintf(mem_file_name, "/proc/%d/mem", pid);

/* Otvoríme PROC pseudo súbor na čítanie (O_RDONLY).                            */
mem_fd = open(mem_file_name, O_RDONLY);

/* Pripojíme sa k procesu (target) pomocou systémového volania "ptrace()        */
/* s nastaveným príznakom "PTRACE_ATTACH".                                      */
ptrace(PTRACE_ATTACH, pid, NULL, NULL);

/* Kedže volanie "ptrace()" je asynchrónne musí proces (reader) chvíľku počkať. */
waitpid(pid, NULL, 0);

/* V otvorenom PROC pseudo súbore nastavíme posun/offset na región, ktorý       */
/* chceme čítať.                                                                */
lseek(mem_fd, offset, SEEK_SET);

/* Z otvoreného PROC pseudo súboru (mem_fd) prečítame pamäťovú stránku          */
read(mem_fd, buf, _SC_PAGE_SIZE);

/* Odpojíme sa od procesu (target) pomocou systémového volania "ptrace()"       */
/* s nastaveným príznakom "PTRACE_DETTACH".                                     */
ptrace(PTRACE_DETACH, pid, NULL, NULL);

/* Zatvoríme PROC pseudo súbor.                                                 */
close(mem_fd);
</pre>


## 6 Nástroje na čítanie / uloženie(dump) a prehľadávanie obsahu pamäte procesu - Linux OS


### 6.1 Volatility Framework
The Volatility Framework is open source and written in Python. Releases are available in zip and tar archives, Python module installers, and standalone executables.

- [http://www.volatilityfoundation.org](http://www.volatilityfoundation.org "test")
- [https://github.com/volatilityfoundation/volatility/wiki](https://github.com/volatilityfoundation/volatility/wiki)
- [https://www.aldeid.com/wiki/Volatility](https://www.aldeid.com/wiki/Volatility)
- [https://www.aldeid.com/wiki/Volatility/Retrieve-hostname](https://www.aldeid.com/wiki/Volatility/Retrieve-hostname)
- [https://www.aldeid.com/wiki/Volatility/Retrieve-password](https://www.aldeid.com/wiki/Volatility/Retrieve-password)


### 6.2 memdump


A utility to dump memory of unixy processes


- [https://github.com/bitw1ze/memdump](https://github.com/bitw1ze/memdump)


### 6.3 The Coroner's Toolkit (TCT) - memdump (Wietse Venema)


- [http://www.porcupine.org/forensics/tct.html](http://www.porcupine.org/forensics/tct.html)
- [http://www.porcupine.org/forensics/memdump-1.01.tar.gz](http://www.porcupine.org/forensics/memdump-1.01.tar.gz)


### 6.4 memgrep (Matt Miller a.k.a skape)

- [http://www.hick.org/code/skape/memgrep/](http://www.hick.org/code/skape/memgrep/)
- [http://www.hick.org/code/skape/memgrep/memgrep-0.8.0.tar.gz](http://www.hick.org/code/skape/memgrep/memgrep-0.8.0.tar.gz)


### 6.5 Memfetch (Michal Zalewski a.k.a lcamtuf)


Memfetch, a simple utility to take non-destructive snapshots of process address space.


- [http://lcamtuf.coredump.cx/soft/memfetch.tgz](http://lcamtuf.coredump.cx/soft/memfetch.tgz)


### 6.6 fmem - kernel driver, that creates /dev/fmem device (Ivo Kollar a.k.a niekt0)


/dev/fmem behave in same way that /dev/mem (direct access to physical memory), but does not have limits that /dev/mem have. It is possible to dump whole physical memory through /dev/fmem. (Alternative to /dev/crash)


- [http://hysteria.cz/niekt0/](http://hysteria.cz/niekt0/)
- [http://hysteria.cz/niekt0/fmem/fmem_current.tgz](http://hysteria.cz/niekt0/fmem/fmem_current.tgz)


### 6.7 Foriana - FOrensic Ram Image ANAlyzer (Ivo Kollar a.k.a niekt0)


Version 1.0 can list processes and modules from memory dump of i386/x86_64/arm linux/bsd kernels, and provide option for reading linear memory from dumps. Theory is described in my master thesis (english).


- [http://hysteria.cz/niekt0/](http://hysteria.cz/niekt0/)
- [http://hysteria.cz/niekt0/foriana/foriana_current.tgz](http://hysteria.cz/niekt0/foriana/foriana_current.tgz)
- [http://hysteria.cz/niekt0/foriana/doc/foriana.pdf](http://hysteria.cz/niekt0/foriana/doc/foriana.pdf)


### 6.8 LiME ~ Linux Memory Extractor


A Loadable Kernel Module (LKM) which allows for volatile memory acquisition from Linux and Linux-based devices, such as Android. This makes LiME unique as it is the first tool that allows for full memory captures on Android devices. It also minimizes its interaction between user and kernel space processes during acquisition, which allows it to produce memory captures that are more forensically sound than those of other tools designed for Linux memory acquisition.


- [https://github.com/504ensicslabs/lime](https://github.com/504ensicslabs/lime)


### 6.9 BASH memory dumper


Jednoduchý skript, ktorý som napísal pre BASH interpreter.


- [https://github.com/hajzer/bash-memory-dump](https://github.com/hajzer/bash-memory-dump)


## 7 Nástroje na čítanie / uloženie(dump) a prehľadávanie obsahu pamäte procesu - Windows OS


### 7.1 memgrep - Memory grep


A memory searching utility across multiple processes on Windows platform.

- Opens each process
- Works out the valid memory pages
- Search for ascii and unicode incarnation of the string


- [https://github.com/nccgroup/memgrep](https://github.com/nccgroup/memgrep)
- [http://blog.wirhabenstil.de/2016/01/19/searching-greping-inside-live-process-memory/](http://blog.wirhabenstil.de/2016/01/19/searching-greping-inside-live-process-memory/)


### 7.2 FireEye - Memoryze

- [https://www.fireeye.com/services/freeware/memoryze.html](https://www.fireeye.com/services/freeware/memoryze.html)


## 8 memdump - inštalácia a príklady použitia nástroja [6.2]


### 8.1 Stiahnutie a rozbalenie nástroja memdump


<pre>
# cd /install
# wget https://github.com/bitw1ze/memdump/archive/master.zip
# mv ./master.zip ./memdump.zip
# unzip ./memdump.zip
</pre>


### 8.2 Kompilácia nástroja memdump


<pre>
# cd /install/memdump-master
# gcc main.c memdump.c -o memdump
</pre>


### 8.3 Spustenie nápovedy nástroja memdump


<pre>
# cd /install/memdump-master
# ./memdump -h
----------------------------------------------------------------------------------------------------------------
Usage: ./memdump <segment(s)> [opts] -p <pid>
    
Options:
    -A          dump all segments
    -D          dump data segments
    -S          dump the stack
    -H          dump the heap
    -d [dir]    save dumps to custom directory [dir]
    -p [pid]    pid of the process to dump
    -v          verbose
    -h          this menu
</pre>


### 8.4 Uloženie (dump) vybraných pamäťových regiónov procesu


<pre>
-S - uložíme (dump) segmentu zásobníka (stack)
-H - uložíme (dump) segmentu haldy (heap)
-p - uložíme (dump) procesu, ktorý ma PID=102347
-d - výstupy uložíme do adresára mc.dump   
----------------------------------------------------------------------------------------------------------------
# cd /install/memdump-master
# mkdir dumps
# ./memdump -d ./dumps/mc.dump -S -H -p 102347
</pre>


Tento príkaz uložil pamäťové regióny procesu do nasledujúcich súborov:


<pre>
# ls -lh /install/memdump-master/dumps/mc.dump
----------------------------------------------------------------------------------------------------------------
-rw-r--r--. 1 root root 528K Dec  2 11:23 0000000002715000-0000000002799000.dump
-rw-r--r--. 1 root root 132K Dec  2 11:23 00007ffd2f019000-00007ffd2f03a000.dump
-rw-r--r--. 1 root root  11K Dec  2 11:23 maps
</pre>


### 8.5 Identifikovanie súborov regiónov zásobnika (stack) a haldy (heap) - použijeme na to súbor "maps"


<pre>
# cd /install/memdump-master/dumps/mc.dump
# cat ./maps | grep 'heap\|stack'
----------------------------------------------------------------------------------------------------------------
0000000002715000-0000000002799000 rw-p 0000000000000000 00:00 0 [heap]
00007ffd2f019000-00007ffd2f03a000 rw-p 0000000000000000 00:00 0 [stack]
</pre>


Z uvedeného výstupu je zrejmé, že:

- pamaťový región zásobníka (stack) procesu "mc" bol uložený do súboru -> **00007ffd2f019000-00007ffd2f03a000.dump**
- pamäťový segment haldy (heap) procesu "mc" bola uložená do súboru      -> **0000000002715000-0000000002799000.dump**



### 8.6 Prehľadávanie obsahu pamäťových regiónov


<pre>
[1] Všetky výskyty reťazcov, ktoré sa nachádzajú v halde uložíme do súboru "mc-heap-strings"
[2] Všetky výskyty reťazcov, ktorá sa nachádzajú v zásobníku uložíme do súboru "mc-stack-strings"
----------------------------------------------------------------------------------------------------------------
# cd /install/memdump-master/dumps/mc.dump
[1]# strings 0000000002715000-0000000002799000.dump > ./mc-heap-strings
[2]# strings 00007ffd2f019000-00007ffd2f03a000.dump > ./mc-stack-strings
</pre>


### 8.7 Uloženie (dump) všetkých pamäťových regiónov procesu


<pre>
-A - uložíme (dump) všetky pamäťové regióny
-p - uložíme (dump) procesu, ktorý ma PID=102347
-d - výstupy uložíme do adresára "mc.dump.all"
----------------------------------------------------------------------------------------------------------------
./memdump -d ./dumps/mc.dump.all -A -p 102347
</pre>


Zoznam súborov do ktorých "memdump" uložil všetky pamäťové regióny procesu je nasledovný:

<pre>
# ls -lh /install/memdump-master/dumps/mc.dump.all
----------------------------------------------------------------------------------------------------------------
-rw-r--r--. 1 root root 1.1M Dec  2 11:58 0000000000400000-0000000000505000.dump
-rw-r--r--. 1 root root  20K Dec  2 11:58 0000000000705000-000000000070a000.dump
-rw-r--r--. 1 root root  20K Dec  2 11:58 000000000070a000-000000000070f000.dump
-rw-r--r--. 1 root root 224K Dec  2 11:58 000000000070f000-0000000000747000.dump
-rw-r--r--. 1 root root 528K Dec  2 11:58 0000000002715000-0000000002799000.dump
-rw-r--r--. 1 root root  24K Dec  2 11:58 00007f4677010000-00007f4677016000.dump
-rw-r--r--. 1 root root 102M Dec  2 11:58 00007f4677016000-00007f467d53f000.dump
-rw-r--r--. 1 root root 8.0K Dec  2 11:58 00007f467d9c5000-00007f467d9c7000.dump
-rw-r--r--. 1 root root 8.0K Dec  2 11:58 00007f467dbdf000-00007f467dbe1000.dump
-rw-r--r--. 1 root root 4.0K Dec  2 11:58 00007f467e225000-00007f467e226000.dump
-rw-r--r--. 1 root root  16K Dec  2 11:58 00007f467ef5b000-00007f467ef5f000.dump
-rw-r--r--. 1 root root  20K Dec  2 11:58 00007f467fa8f000-00007f467fa94000.dump
-rw-r--r--. 1 root root  16K Dec  2 11:58 00007f467fcac000-00007f467fcb0000.dump
-rw-r--r--. 1 root root 4.0K Dec  2 11:58 00007f467ffe6000-00007f467ffe7000.dump
-rw-r--r--. 1 root root 400K Dec  2 11:58 00007f4680930000-00007f4680994000.dump
-rw-r--r--. 1 root root  44K Dec  2 11:58 00007f4680b9e000-00007f4680ba9000.dump
-rw-r--r--. 1 root root 4.0K Dec  2 11:58 00007f4680baa000-00007f4680bab000.dump
-rw-r--r--. 1 root root  28K Dec  2 11:58 00007f4680bab000-00007f4680bb2000.dump
-rw-r--r--. 1 root root 4.0K Dec  2 11:58 00007f4680bb2000-00007f4680bb3000.dump
-rw-r--r--. 1 root root 4.0K Dec  2 11:58 00007f4680bb5000-00007f4680bb6000.dump
-rw-r--r--. 1 root root 132K Dec  2 11:58 00007ffd2f019000-00007ffd2f03a000.dump
-rw-r--r--. 1 root root 8.0K Dec  2 11:58 00007ffd2f03f000-00007ffd2f041000.dump
-rw-r--r--. 1 root root 4.0K Dec  2 11:58 ffffffffff600000-ffffffffff601000.dump
-rw-r--r--. 1 root root  11K Dec  2 11:58 maps
</pre>


## 9 memdump (Wietse Venema) - inštalácia a príklady použitia nástroja [6.3]


Tento softvér je od známeho nemeckého programátora a fyzika Wietse Venema, ktorý je autorom ešte známejšieho poštového servera Postfix, TCP wrapper-a ako aj sady nástrojov na digitálnu forenznú analýzu s nazvom TCT (The Coroner's Toolkit). Nástroj memdump je práve zo sady nástrojov TCT.


### 9.1 Stiahnutie a rozbalenie nástroja memdump (Wietse Venema)


>  Neviem z akého dôvodu ma archív koncovku ".gz" keď sa nejedna o TAR-ovaný GZIP archív. Je to štandardný POSIX TAR archív a tak použijeme iba prepínač "-x".


<pre>
# cd /install
# wget http://www.porcupine.org/forensics/memdump-1.01.tar.gz
# tar -xvf ./memdump-1.01.tar.gz
</pre>


### 9.2 Kompilácia nástroja memdump


Nakoľko je tento SW písaný pre Linux s verziou jadra "2" resp. "2.4" a systém na ktorom som vykonával testovanie je RHEL systém verzie 7.3, ktorý používa jadro 3.10 nebudeme strácať čas úpravou tohoto SW pre novšie verzie Linux OS nakoľko existujú adekvátne náhrady. Výhodou tohoto SW je to, že dokáže ukladať pamäťové regióny po sieti na vzdialený server, čo je veľmi vhodné pri digitálnej forenznej analýze (neprepíšeme si fragmenty dôkazov).


## 10 memgrep - inštalácia a príklady použitia nástroja [6.4]


> Upozornenie: Tento SW bol napísaný v čase kedy nebola 64 bitová platforma až tak rozšírená a tak ho odporúčam použivať iba na 32 bitovej platforme.
  

### 10.1 Stiahnutie a rozbalenie nástroja memgrep


<pre>
# cd /install
# wget http://www.hick.org/code/skape/memgrep/memgrep-0.8.0.tar.gz
# tar -xzvf memgrep-0.8.0.tar.gz
# cd memgrep-0.8.0
</pre>


### 10.2 Riešenie problémov s kompiláciou nástroja memgrep


Nástroj "memgrep" ma niekoľko neduhov, ktoré musíme pred samotnou kompiláciou vyriešiť. Tieto neduhy pochádzajú resp. pramenia z toho, že tento SW je trošku starší a bol písaný pre staršie verzie Linux jadra. Počas životného cyklu Linux jadra boli v pamäťovom subsystéme ale aj iných častiach jeho kódu vykonané zmeny a tak sa bez úpravy samotného kódu nástroja memgrep nedá tento SW prekompilovať.


#### 10.2.1 Chyba vloženia (include) hlavičkového súboru "memgrep.h"


V zdrojovom súbore "memgrep.c" je chyba pri vkladaní (include) hlavičkového súboru "memgrep.h". Tento problém môžeme vyriešiť dvoma spôsobmi:


- A> úpravou zdrojového súboru "memgrep.c", viď. nižšie


<pre>
# vi /install/memgrep-0.8.0/src/memgrep.c
----------------------------------------------------------------------------------------------------------------
Nesprávne:
#include "memgrep.h"

Správne: 
#include "../include/memgrep.h"
</pre>


- B> umiestnením súboru "include/memgrep.h" do adresára "src/", viď. nižšie


<pre>
# cp /install/memgrep-0.8.0/include/memgrep.h /install/memgrep-0.8.0/src/
</pre>


#### 10.2.2 Chyba vloženia (include) hlavičkového súboru "<linux/user.h>"


V zdrojovom súbore "memgrep.c" je pokus o vloženie (include) hlavičkového súboru "<linux/user.h>", v ktorom bola definovaná štruktúra "user\_regs\_struct". Táto štruktúra je aktuálne definovaná v inom hlavičkovom súbore a to v "<sys/user.h>". Túto nezhodu opravíme jednoduchou úpravou kódu.


<pre>
# vi /install/memgrep-0.8.0/src/memgrep.c
----------------------------------------------------------------------------------------------------------------
Nesprávne:
#include &lt;linux/user.h>

Správne: 
#include &lt;sys/user.h>
</pre>


#### 10.2.3 Chyba vloženia (include) hlavičkového súboru "<sys/ptrace.h>"


V zdrojovom súbore "memgrep.c" sa používajú príznaky/flagy (PTRACE\_ATTACH, PTRACE\_DETACH, PTRACE\_GETREGS, atd.) systémovej funkcie "ptrace()", ale v Linuxovej časti kódu nie je žiaden pokus o vloženie (include) správneho hlavičkového súboru "<sys/ptrace.h>". Tento hlavičkový súbor je vložený len vo FreeBSD časti kódu. Tento problém opravíme jednoduchou úpravou kódu a to tak, že za stať inkludovania hlavičkového súboru "<sys/user.h>" doplníme ďalšiu stať vloženia hlavičkového súboru "<sys/ptrace.h>".


<pre>
# vi /install/memgrep-0.8.0/src/memgrep.c
----------------------------------------------------------------------------------------------------------------
Povodné: 
#include &lt;sys/user.h>
...

Upravené: 
#include &lt;sys/user.h>
#include &lt;sys/ptrace.h>
</pre>


#### 10.2.4 Chyba v explicitnej deklarácii funkcie "ptrace()"


V zdrojovom súbore "memgrep.c" je explicitná deklarácia funkcie "ptrace()", ktorá je ale v konflikte s definíciou tejto funkcie v hlavičkovom súbore "<sys/ptrace.h>". Z tohto dôvodu túto explicitnú deklaráciu zakomentujeme.


<pre>
# vi /install/memgrep-0.8.0/src/memgrep.c
----------------------------------------------------------------------------------------------------------------
Povodné: 
extern long int ptrace (unsigned long int cmd, unsigned long int pid, void *param, unsigned long int data);

Upravené:
/* LH OFF - odstránime explicitnú deklaráciu funkcie "ptrace()"
extern long int ptrace (unsigned long int cmd, unsigned long int pid, void *param, unsigned long int data);
*/
</pre>


#### 10.2.5 Štruktúra "user\_regs\_struct" nemá na 64 bitovej platforme člena/element "esp"


V zdrojovom súbore "memgrep.c" sa používa štruktúra "user\_regs\_struct", ktorá ale na 64 bitových platformách nemá člena "esp". Tento problém vyriešime tak, že nástroj "memgrep" vykompilujeme pre 32 bitovú platformu. Kompilátoru (gcc) povieme, že máme záujem o 32 bitovú verziu (prepínač -m32), viď. samotná kompilácia v bode [10.3]. Na to, aby sme boli schopný vykompilovať na 64 bitovom systéme 32 bitovú binárku budeme
potrebovať dodatočné balíčky s 32 bitovými knižnicami a preto ich nainštalujeme.


<pre>
# yum install glibc-devel.i686
# yum install libgcc-4.8.5-11.el7.i686
</pre>


### 10.3 Kompilácia nástroja memgrep


Ak sme vyriešili všetky problémy popísane v bodoch [10.2.1] az [10.2.5] môžeme slávnostne pristúpiť ku kompilovaniu.


<pre>
# cd /install/memgrep-0.8.0/src
# gcc -m32 -Wall -O3 memgrep.c -o memgrep
</pre>


### 10.4 Spustenie nápovedy nástroja memgrep


<pre>
# cd /install/memgrep-0.8.0/src/
# ./memgrep -h
----------------------------------------------------------------------------------------------------------------
memgrep -- Run-time/core-time memory searching, dumping and modifying utility.
Usage: ./memgrep [-p pid] [-o core] [-T] [-d] [-r] [-s] [-e] [-a addr1,addr2,bss,addr3] [-l length]
                 [-f fmt,search data] [-t fmt,replace data] [-b pad] [-m minimum size]
                 [-F fmt] [-L] [-v] [-h]
    
   -p [pid]   The process id to operate on.
   -o [core]  The core file to operate on.
   -T         Build a referential tree for the given address(es).
   -d         Dump memory from the specified address(es) for the given length (-l).
   -r         Replace memory at the specified address(es).  If -s is also specified.
              only memory that matches the search criteria will be replaced.
   -s         Search memory at the specified address(es).
   -e         Enumerate the heap.
   -a [addr]  The address(es) to operate on seperated by commas.  Addresses can be
              in the following format:
              0x821c4ac
              821c4ac
              Also, the following keywords can be used:
                 bss       -> Uses the VMA associated with the .bss section (uninit global vars, heap data).
                 rodata    -> Uses the VMA associated with the .rodata section (read-only data, ie, static text).
                 data      -> Uses the VMA associated with the .data section (data, ie, global variables).
                 text      -> Uses the VMA associated with the .text section (text, ie, executable code).
                 stack     -> Dynamically determines the current stack pointer.
                 all       -> Uses bss, stack, rodata, data, text.  This is the only keyword that can be used
                              when operating on core files.
   -l [len]   The length to use when searching or dumping.  A length of 0 means search
              till end-of-memory.
   -f [data]  This specifies the search criteria.  Multiple formats are accepted for ease
              of use.  Below are accepted formats and their examples:
                 s -> String format  (Ex: 's,Testing')
                 x -> Hex format     (Ex: 'x,00414100AB')
                 i -> Integer format (Ex: 'i,4724')
   -t [data]  This specifies the replace data.  The same formats used with the -f parameter
              are valid for the -t parameter.
   -m [minsz] The minimum size of a heap allocation for use when enumerating.
   -b [pad]   Number of bytes of padding to use around dump addresses (default is 0).
   -F [fmt]   The format to use when dumping memory, can be one of the following:
                 hexint    -> Four byte hexi-decimal integers.
                 hexshort  -> Two byte hexi-decimal shorts.
                 hexbyte   -> One byte hexi-decimal characters.
                 decint    -> Four byte decimal integers.
                 decshort  -> Two byte decimal shorts.
                 decbyte   -> One byte decimal characters.
                 printable -> Printable characters.
   -L         List memory segments of a process or core file.
   -v         Version information.
   -h         Help.
    
   Example search (search for 'Jane' in .bss):
      ./memgrep -p 1335 -s -a bss -f s,Jane
    
   Example replace (replace memory at 0x8423143 and 0x8443147 with 0x00ff0041):
      ./memgrep -p 1335 -r -a 0x8423143,0x8443147 -t x,00ff0041
    
   Example search/replace (Replace 'Test' with 'Rest' in .bss and .rodata):
      ./memgrep -p 1335 -s -r -a bss,rodata -f s,Test -t s,Rest
    
   Example dump (Dump memory starting at 0x8422113 for 16 bytes):
      ./memgrep -p 1335 -d -a 0x8422113 -l 16
</pre>


## TODO

TODO


## 99 Odkazy


### 99.1 Prednášky / slides o pamäťovom systéme v OS Linux
 
- [1] [2016 - Alan Ott - Virtual Memory and Linux](https://events.linuxfoundation.org/sites/events/files/slides/elc_2016_mem.pdf) (****)
- [2] [2015 - Memory Subsystem and Data Types in the Linux Kernel - Praktikum Kernel Programming](https://wr.informatik.uni-hamburg.de/_media/teaching/wintersemester_2015_2016/kp-2015-16-memory_management-slides.pdf) (****)
- [3] [Free Electrons - Complete training materials](http://free-electrons.com/docs/) (*****) - Veľa zaujímavých informácií o low level záležitostiach, vývoji jadra a podobne !!!


### 99.2 Detailné informácie o pamäťovom systéme v OS Linux

Tieto diela sú sice staršie (pre jadrá 2.4, 2.6), ale dosť oblastí/termínov stále platí. Už aby vyšlo štvrté vydanie knihy Linux Device Drivers.


- [1] [2007 - Ulrich Drepper - What Every Programmer Should Know About Memory](https://www.akkadia.org/drepper/cpumemory.pdf) (*****)
- [2] [2004 - Understanding the Linux Virtual Memory Manager](http://ptgmedia.pearsoncmg.com/images/0131453483/downloads/gorman_book.pdf) (*****)
- [3] [2005 - Linux Device Drivers, Third Edition - Memory Mapping and DMA](https://lwn.net/images/pdf/LDD3/ch15.pdf) 


### 99.3 Ďalšie dokumenty súvisiace s pamäťovým systémom v OS Linux

- [1] [2016 - An Evolutionary Study of Linux Memory Management for Fun and Profit](https://www.usenix.org/system/files/conference/atc16/atc16_paper-huang.pdf) (****) -
Vynikajúci dokument o zmenách v subsystéme správy pamäte na Linux OS, ktorý popisuje zmeny v jadre OS od verzie 2.6.32 po verziu 4.0-rc4.
- [2] [2016 - An adaptive approach for Linux memory analysis based on kernel code reconstruction](http://jis.eurasipjournals.springeropen.com/articles/10.1186/s13635-016-0038-z)
- [3] [2015 - Deep dive into linux memory management](http://balodeamit.blogspot.sk/2015/11/deep-dive-into-linux-memory-management.html)
- [4] [COMPILER, ASSEMBLER, LINKER AND LOADER: A BRIEF STORY](http://www.tenouk.com/download/pdf/ModuleW.pdf) (****)
- [5] [2005 - What is linux-gate.so.1?](http://www.trilithium.com/johan/2005/08/linux-gate/)


### 99.4 Tutoriál - Intersec Techtalk (****)

- [1] [2013 - Intersec Techtalk - Memory – Part 1: Memory Types](https://techtalk.intersec.com/2013/07/memory-part-1-memory-types/)
- [2] [2013 - Intersec Techtalk - Memory – Part 2: Understanding Process memory](https://techtalk.intersec.com/2013/07/memory-part-2-understanding-process-memory/)
- [3] [2013 - Intersec Techtalk - Memory – Part 3: Managing memory](https://techtalk.intersec.com/2013/08/memory-part-3-managing-memory/)
- [4] [2014 - Intersec Techtalk - More about locality](https://techtalk.intersec.com/2014/02/more-about-locality/)
- [5] [2013 - Intersec Techtalk - Memory – Part 4: Intersec’s custom allocators](https://techtalk.intersec.com/2013/10/memory-part-4-intersecs-custom-allocators/)
- [6] [2013 - Intersec Techtalk - Memory – Part 5: Debugging Tools](https://techtalk.intersec.com/2013/12/memory-part-5-debugging-tools/)
- [7] [2014 - Intersec Techtalk - Memory – Part 6: Optimizing the FIFO and Stack allocators](https://techtalk.intersec.com/2014/09/memory-part-6-optimizing-the-fifo-and-stack-allocators/)

### 99.5 Tutoriál - Gustavo Duartes - Software Illustrated (****)

- [1] [2009 - Getting Physical With Memory](http://duartes.org/gustavo/blog/post/getting-physical-with-memory/)
- [2] [2009 - Anatomy of a Program in Memory](http://duartes.org/gustavo/blog/post/anatomy-of-a-program-in-memory/)
- [3] [2009 - How the Kernel Manages Your Memory](http://duartes.org/gustavo/blog/post/how-the-kernel-manages-your-memory/)
- [4] [2009 - Page Cache, the Affair Between Memory and Files](http://duartes.org/gustavo/blog/post/page-cache-the-affair-between-memory-and-files/)
- [5] [2010 - Journey to the Stack, Part I](http://duartes.org/gustavo/blog/post/journey-to-the-stack/)
- [6] [2010 - Epilogues, Canaries, and Buffer Overflows](http://duartes.org/gustavo/blog/post/epilogues-canaries-buffer-overflows/) 


### 99.6 Staré materiály ohľadom pamäťového systému v Linux OS

- [1] [2003 - KernelAnalysis-HOWTO - 7. Linux Memory Management](http://www.tldp.org/HOWTO/KernelAnalysis-HOWTO-7.html)
- [2] [2003 - The Linux Kernel - 9. Memory](http://www.win.tue.nl/~aeb/linux/lk/lk-9.html)
- [3] [1999 - The Linux Kernel - Chapter 3 Memory Management](http://www.tldp.org/LDP/tlk/mm/memory.html)
