# Front Reader for dothNews

Este pacote tem a função de se comunicar com a API do dothnews para buscar as notícias para o front-end (themes).

Exemplos de uso em resources/views/ no repositório https://github.com/dothcom/vejaobem.com.br

## Instalação 


Instalação do pacote via composer

```bash
composer require dothnews/front-reader
```

Publicação do arquivo de configuração

```bash
./vendor/bin/sail artisan vendor:publish --tag=front-reader-config
```

No composer.json, adicione o dont-discover para evitar que o pacote seja carregado em produção:

```json
"dont-discover": [
    "dothcom/front-reader"
]
```

No AppServiceProvider.php, adicione registre o FrontReaderServiceProvider:

```php
use Dothcom\FrontReader;

/**
 * Register any application services.
 */
public function register(): void
{
    $this->app->register(FrontReader\FrontReaderServiceProvider::class);
}
```
## Contribuindo

Veja o arquivo [CONTRIBUTING](CONTRIBUTING.md) para mais detalhes.