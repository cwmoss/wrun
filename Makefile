all: one-file

one-file:
	tail -n +2 -q vendor/nategood/httpful/src/**/*.php > build-http.php
	tail -n +2 -q src/*.php > build-runner.php
	sed -i -e 's/require_once/#require_once/g' build-runner.php
	cat prefix.php build-http.php build-runner.php > wrun.php