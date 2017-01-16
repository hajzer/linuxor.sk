

## MNT (Mount points and filesystems) menné priestory v OS Linux

**FILE:** 2016-linux-namespaces-mnt.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 0  


## 1 Úvod

Menný priestor MNT (Mount points and filesystems namespace) slúži na izoláciu prípojných bodov, ktoré vidí proces alebo skupina procesov takže programy/procesy v rozdielnych MNT menných priestoroch môžu mať rozdielny pohľad na hierarchiu súborového systému. Táto izolácia je podobná izolácii, ktorú umožnuje systemové volanie "chroot()" s tým rozdielom, že MNT menný priestor by mal byť na tieto účely bezpečnejšou a flexibilnejšou voľbou.

![mnt_namespace](http://www.linuxor.sk/content/howtoz/images/mnt_namespace_v01.png)


## 2 Základná práca s MNT mennými priestormi

TODO
