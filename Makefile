composeFile = docker-compose.yml

build: # build containers
	docker-compose -f $(composeFile) build

start: #start previously stopped containers
	docker-compose -f $(composeFile) up -d --no-recreate

stop: # stop containers
	docker-compose -f $(composeFile) stop

clean: # delete container + data volumes
	docker-compose -f $(composeFile) rm -f
