TEST_BIN:=./vendor/bin/phpunit --colors=always --dont-report-useless-tests
ifndef COMPOSER_BIN
  COMPOSER_BIN := composer
endif
ifndef DATETIME
  DATETIME := $(shell date -u +%Y%m%d%H%M%SZ)
endif

.PHONY: install
install:
	$(COMPOSER_BIN) install
	$(COMPOSER_BIN) install --working-dir literati-example
	cd literati-example && npm install --dev

.PHONY: test
test:
	$(TEST_BIN) $(ARGS) literati-example/tests/

.PHONY: watch-test
watch-test:
	watchexec --ignore vendor/bin/.phpunit.result.cache -- $(TEST_BIN) $(ARGS) literati-example/tests/

.PHONY: build
build:
	cd literati-example && npm run build

.PHONY: release
release:
	rm -rf literati-example.zip
	$(COMPOSER_BIN) install --working-dir literati-example --no-dev
	cd literati-example && npm install && npm run build
	zip -r --exclude="*node_modules*" --exclude="*src*" literati-example.zip literati-example
