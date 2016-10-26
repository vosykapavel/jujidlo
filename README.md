# Jujidlo

Použitelnější jídelníček pro menzu Jihočeské univerzity.

Dostupný na adrese [www.jujidlo.tk](http://jujidlo.tk)


## Proč je tak skvělý?
- po načtení ukazuje jídelníček na **aktuální den** (prvořadá funkce!)
- **zvýrazňuje** zajímavá jídla (minutky, bezobjednávkové obědy a speciality)
- je responozivní a **vymazlenej**

## Motivace a technická stránka

** Na tomto projektu se chci naučit: **
- vyvtvořit použitelnější UI jídelníčku
- používat github
- zkusit to s PHP trochu víc objektově
- naučit nějaké návrhové vzory, ale pěkně postupně, od píky

** Návod na spuštění: **
(prerekvizitou je mít nainstalované php a composer)
- git clone
- cd jujidlo
- composer install
- php -S localhost:8080

Po té spusť adresu [localhost:8080](http://localhost:8080)
Zatím je nutné být připojený k internetu kvůli načítání bootstrapu a hlavně
kvůli extrahování jídelníčků z webů menzy JU.


** Changelog: **
- 2016-10-25 separace PHP tříd, zavedena pre-alpha JSON API (s úvahou používat javascriptového - odděleného klienta), zavedeno šablonování pomocí latte (což pak teda trochu jde úvaze vlastní JS klienta :D) => významné **pročištění kódu**

