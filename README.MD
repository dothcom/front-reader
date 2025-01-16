# Front Reader for dothNews

This is a package that provides functionality for reading api data from dothNews API v6.

## Installation in production

To install this package, you can use Composer. Run the following command in your terminal:

```bash
composer require dothnews/front-reader
```

## Configuration

To publish the configuration file, run the following command in your terminal:

```bash
sail artisan vendor:publish --tag=front-reader-config
```

---

# Install to deveploment 

## Fork

1. Crie a pasta dentro da pasta de um tema:

```bash
mkdir -p vejaobem.com.br/packages/dothcom/
```

2. Crie um fork do pacote a partir do [Repositório do Pacote](https://github.com/dothcom/front-reader)

3. Clone o fork (no comando abaixo, altere `<usuario>` com seu usuário no Github):

```bash
git clone git@github.com:<usuario>/front-reader.git vejaobem.com.br/packages/dothcom/front-reader
```

> **Nota:** O pacote será CLONADO em `packages/dothcom/front-reader` dentro da pasta do tema.


## Configurando composer.json

    1. Em require, troque a tag para dev-main -> "dothcom/front-reader": "dev-main"
    2. Em repositories, adicione o seguinte trecho:
    
        ```
        "repositories": [
            {
                "type": "path",
                "url": "./packages/dothcom/front-reader"
            }
        ],
        ```
    3. Adicione autoload-dev:
    
        ```
        "autoload-dev": {
            "psr-4": {
                "Dothcom\\FrontReader\\": "vendor/dothcom/front-reader/src/"
            }
        },
        ```
    3. Rode o comando `composer update dothcom/front-reader` para instalar o pacote.
