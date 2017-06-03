RSRS Sandbox 
=============

Tento balíček vychází z [Nette](https://nette.org) sandboxu. Oproti němu používá Dibi. 

Instalace
----------

Klasicky použij [composer](https://doc.nette.org/composer):

	composer create-project svatekr/sandbox path/to/install
	cd path/to/install


Zajisti, ať mají adresáře `temp/` a `log/` práva pro zápis.


Web Server
----------

Pokud nemáš apache, nebo jiný webový server, můžeš si webový server spustit přímo příkazem PHP ve složce projektu:

	php -S localhost:8000 -t www

Na adrese `http://localhost:8000` ti pak poběží projekt.

Jestli používáš Apache nastav si virtual host na adresář `www/`.

Je opravdu důležité, aby adresáře `app/`, `log/` a `temp/` nebyly přístupné z prohlížeče. Je to bezpečnostní riziko. Podívej se na
[varování](https://nette.org/security-warning).


License
-------
- Nette: New BSD License or GPL 2.0 or 3.0
- Adminer: Apache License 2.0 or GPL 2
