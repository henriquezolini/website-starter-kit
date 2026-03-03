# Website Starter Kit

Pacote inicial para desenvolvimento de websites com PHP, estrutura organizada e recursos prontos para produção.

---

## Objetivo

Pacote inicial para desenvolvimento de websites, com estrutura padronizada e recursos essenciais já configurados.

---

## Conteúdo

- Arquitetura padronizada
- URLs amigáveis com folder friendly router  
  O roteamento funciona de acordo com as pastas criadas dentro de `pages`, semelhante ao folder router do Next.js.
- Minificador automático de arquivos CSS e JS
- Arquitetura preparada para SEO
- Função pronta para envio de e-mails utilizando PHPMailer
- GitHub Actions com workflow configurado para upload via FTP

---

## Requisitos

- PHP > 8.0
- Apache com mod_rewrite habilitado

---

## Instalação

Instalar dependências Node:

```bash
npm install
```

Instalar dependências PHP:

```bash
composer install
```

---

## Configurações iniciais

Arquivos principais:

```
configs/seo.php
configs/layout.php
```

Arquivos estruturais:

```
includes/footer.php
includes/head.php
includes/header.php
includes/scripts.php
```

---

## Utilidades

### Minificação automática

```
npm run watch
```

Esse comando monitora automaticamente as pastas `css` e `js`, gerando as versões minificadas dos arquivos.

---

## Comandos úteis Apache

Editar php.ini:

```
sudo vi /etc/php/8.3/apache2/php.ini
```

Editar configuração do Virtual Host:

```
/etc/apache2/sites-available/000-default.conf
```

Reiniciar Apache:

```
sudo service apache2 restart
```

---

## Estrutura de Rotas

O sistema utiliza roteamento baseado em pastas dentro de `pages`.

Exemplo:

```
pages/
 ├── index/
 ├── sobre/
 └── contato/
```

Cada pasta representa automaticamente uma rota:

- /
- /sobre
- /contato

---

## Deploy Automatizado

O projeto já possui GitHub Action configurada para realizar deploy automático via FTP após push na branch principal.
