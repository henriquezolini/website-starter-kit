# Website Starter Kit

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

O projeto utiliza roteamento baseado em pastas dentro do diretório `pages`.  
Cada pasta representa uma URL automaticamente, mantendo a estrutura simples e organizada.

### Exemplo

```
pages/
 ├── blog/index.php        → https://domain.com/blog/
 ├── contato/index.php     → https://domain.com/contato/
 ├── sobre/index.php       → https://domain.com/sobre/
 ├── post/[slug].php       → https://domain.com/post/123/
 └── index.php             → https://domain.com/
```

### Como funciona

- `index.php` dentro de uma pasta representa a rota daquela pasta.
- A raiz do projeto é controlada pelo `pages/index.php`.
- Arquivos dinâmicos como `[slug].php` permitem capturar parâmetros da URL, possibilitando páginas dinâmicas como posts, produtos ou categorias.

Essa estrutura facilita a organização do projeto e torna as URLs mais limpas e amigáveis.

## Deploy FTP Automatizado

O projeto já conta com GitHub Actions configurado para realizar o deploy automático via FTP sempre que houver push na branch principal.

Para configurar com seus dados, edite o arquivo:

```
.github/workflows/main.yml
```

Atualize as informações do servidor:

```yml
server: ftp.example.com
username: webmaster@example.com
password: ${{ secrets.ftp_password }}
server-dir: ./
```

Depois, adicione a variável `ftp_password` nas Secrets do seu repositório:

1. Acesse o repositório no GitHub
2. Vá em **Settings**
3. Clique em **Secrets and variables**
4. Selecione **Actions**
5. Clique em **New repository secret**
6. Crie a secret com o nome `ftp_password` e informe a senha do seu FTP

Após isso, o deploy será feito automaticamente a cada push na branch configurada.
