Installation:
* docker-compose up -d
* docker-compose exec php sh
* composer install

Usage:

`curl http://localhost/language` List all languages

`curl --request POST --data '{"name":"en"}' http://localhost/language` Add language

`curl --request DELETE' http://localhost/language/1` Delete language

`curl --request DELETE' http://localhost/language/1` Delete language

`curl -X POST --data '{"key": "translation key", "value": "text"}' http://localhost/translation/1` Add translation for language with id 1
`curl http://localhost/translation/1` Get all translation for language with id 1
`curl http://localhost/translation/1/key` Get translation for language with id 1 and key "key"


Some thoughts:
* Error handling is a TODO
* Validation though symfony Validator
* Need documentation. Swagger or ApiPlatform is fine.
* It would be possible to use the symbolic representation of the language instead of id, but this would lead to additional requests to the db and in fact it is not a problem for the client application to get the list of languages separately
* Application has nothing but controllers and repositories. So unit-testing is not really applicable. Functional tests cover basics but lacks some negative cases. Fixtures are also comes handy 
