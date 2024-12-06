SAIL=vendor/bin/sail

all: install build

install:
	bin/install.sh

build:
	$(SAIL) build --no-cache
	$(SAIL) up -d
	$(SAIL) npm install
	$(SAIL) npm run build
	$(SAIL) artisan migrate:fresh --seed
