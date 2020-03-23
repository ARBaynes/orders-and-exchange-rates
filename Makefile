test-suite:
	vendor/bin/behat -s exchange_features;
	vendor/bin/phpspec run;
