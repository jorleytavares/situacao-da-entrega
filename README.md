# 📦 Situação da Entrega

> **Entenda rapidamente o que está acontecendo com sua entrega.**

Plataforma colaborativa onde usuários podem consultar e relatar situações de entregas de diversas transportadoras brasileiras. Com painel administrativo completo, blog integrado e rastreamento via SEO otimizado.

🌐 **Produção:** [situacaodaentrega.com.br](https://situacaodaentrega.com.br)

---

## 📋 Índice

- [Visão Geral](#-visão-geral)
- [Stack Tecnológica](#-stack-tecnológica)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Models (Eloquent)](#-models-eloquent)
- [Rotas Principais](#-rotas-principais)
- [Painel Administrativo](#-painel-administrativo)
- [Setup Local](#-setup-local)
- [Deploy (cPanel)](#-deploy-cpanel)
- [Git Workflow](#-git-workflow)
- [Versionamento](#-versionamento)

---

## 🎯 Visão Geral

O **Situação da Entrega** é uma aplicação web focada em ajudar consumidores brasileiros a entenderem o status de suas encomendas. Funcionalidades principais:

- **Consulta de situações** por transportadora, região e tipo de problema
- **Relatos colaborativos** — usuários compartilham suas experiências
- **Blog & Dicas** — artigos sobre rastreamento, importação e logística
- **Painel Admin** — dashboard com métricas, CRUD de posts, gerenciador de mídia
- **SEO avançado** — Schema.org, Open Graph, sitemap dinâmico, meta tags otimizadas
- **Google Analytics** — tracking gerenciado via painel admin (configurável)

---

## 🛠 Stack Tecnológica

| Camada        | Tecnologia                          |
|---------------|-------------------------------------|
| **Framework** | Laravel 11 (PHP 8.3)               |
| **Banco**     | MySQL 8                            |
| **Frontend**  | Blade Templates + Vanilla CSS + JS |
| **Gráficos**  | Chart.js (via `graficos.js`)       |
| **Servidor**  | cPanel (Apache) + Git Deploy       |
| **Tracking**  | Google Analytics (GA4)             |

---

## 📂 Estrutura do Projeto

```
situacao-da-entrega/
├── app/
│   ├── Console/              # Comandos Artisan customizados
│   ├── Http/
│   │   ├── Controllers/      # 24 controllers (Admin + Público)
│   │   ├── Middleware/        # Middleware customizado
│   │   └── Requests/         # Form Requests de validação
│   ├── Models/               # 10 models Eloquent
│   ├── Providers/            # Service Providers
│   ├── Services/             # Camada de serviços
│   └── ViewModels/           # View Models
├── config/                   # Configurações Laravel
├── database/
│   ├── migrations/           # Migrations do banco
│   └── seeders/              # Seeders de dados
├── public/
│   ├── css/                  # Stylesheets (index.css, search.css, admin.css)
│   ├── js/                   # Scripts (graficos.js)
│   ├── favicon.svg           # Ícone do site
│   └── logo.svg              # Logo principal
├── resources/views/
│   ├── admin/                # Views do painel admin (8 arquivos)
│   ├── components/           # Componentes Blade reutilizáveis
│   ├── errors/               # Páginas de erro customizadas
│   ├── institucional/        # Páginas institucionais (6 arquivos)
│   ├── layouts/              # Layouts base (app.blade.php, admin.blade.php)
│   ├── pages/                # Páginas públicas (21 arquivos)
│   └── partials/             # Partials reutilizáveis
├── routes/
│   ├── web.php               # Rotas web (pública + admin)
│   ├── api.php               # Rotas API
│   └── console.php           # Comandos de console
├── .agent/workflows/         # Workflows automatizados (git-workflow)
├── CHANGELOG.md              # Histórico de mudanças do Laravel base
├── RELATORIO_MUDANCAS.md     # Relatório de implementações do projeto
└── README.md                 # Este arquivo
```

---

## 🗃 Models (Eloquent)

| Model             | Descrição                                          |
|-------------------|----------------------------------------------------|
| `User`            | Usuários do sistema (admin)                        |
| `Transportadora`  | Transportadoras cadastradas (Correios, Jadlog...)  |
| `Problema`        | Tipos de problemas de entrega                      |
| `Regiao`          | Regiões geográficas                                |
| `Relato`          | Relatos dos usuários sobre entregas                |
| `Post`            | Posts do blog (título, slug, conteúdo, categoria)  |
| `Media`           | Gerenciador de mídia (imagens com alt text)        |
| `SearchLog`       | Log de buscas realizadas no site                   |
| `AdminLog`        | Log de ações administrativas                       |
| `Configuracao`    | Configurações dinâmicas do sistema (GA4, etc.)     |

---

## 🛣 Rotas Principais

### Públicas

| Rota                  | Descrição                          |
|-----------------------|------------------------------------|
| `/`                   | Página inicial (home)              |
| `/buscar`             | Busca global                       |
| `/relatar`            | Formulário de relato               |
| `/blog`               | Listagem de posts do blog          |
| `/blog/{slug}`        | Post individual                    |
| `/metodologia`        | Página de metodologia              |
| `/aviso-legal`        | Aviso legal                        |
| `/politica-privacidade` | Política de privacidade          |
| `/sitemap.xml`        | Sitemap dinâmico                   |

### Admin (protegidas por auth)

| Rota                           | Descrição                    |
|--------------------------------|------------------------------|
| `/admin/dash-hostamazonas`     | Login do admin               |
| `/admin/visao-geral`           | Dashboard principal          |
| `/admin/blog`                  | CRUD de posts do blog        |
| `/admin/midia`                 | Gerenciador de mídia         |
| `/admin/configuracoes`         | Configurações do sistema     |

---

## 🔐 Painel Administrativo

- **Login seguro** com rota personalizada (`/admin/dash-hostamazonas`)
- **Dashboard** com métricas: total de relatos, quizzes ativos, respostas recentes
- **Blog** — CRUD completo com editor, upload de capa, categorias e status
- **Mídia** — Upload drag-and-drop, alt text obrigatório, cópia de URL
- **Configurações** — Scripts de tracking (GA4) gerenciados via interface
- **Relatórios** — Visualização e reset de logs de busca

---

## ⚙️ Setup Local

### Pré-requisitos

- PHP 8.3+
- Composer
- MySQL 8+
- Laragon (recomendado no Windows)

### Instalação

```bash
# Clonar repositório
git clone https://github.com/jorleytavares/situacao-da-entrega.git
cd situacao-da-entrega

# Instalar dependências
composer install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Editar .env com credenciais do banco local
# DB_DATABASE=situacao_entrega
# DB_USERNAME=root
# DB_PASSWORD=

# Executar migrations e seeders
php artisan migrate --seed

# Criar link simbólico do storage
php artisan storage:link

# Iniciar servidor
php artisan serve
```

O site estará disponível em `http://localhost:8000`.

---

## 🚀 Deploy (cPanel)

### Estrutura no Servidor

```
/home/curr6441/
├── repositories/
│   └── situacaodaentrega.com.br/    ← Clone do GitHub
│       ├── app/
│       ├── public/                   ← Apontado via symlink
│       ├── .env                      ← Configurado SOMENTE no servidor
│       └── ...
└── situacaodaentrega.com.br         ← Symlink → .../public
```

### Deploy Rápido (sem migrations)

```bash
cd /home/curr6441/repositories/situacaodaentrega.com.br
git pull origin main
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Deploy Completo (com migrations ou dependências)

```bash
cd /home/curr6441/repositories/situacaodaentrega.com.br
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔀 Git Workflow

| Branch        | Propósito                                    |
|---------------|----------------------------------------------|
| `main`        | Código estável, pronto para produção         |
| `develop`     | Branch de integração                         |
| `feature/*`   | Novas funcionalidades                        |
| `fix/*`       | Correções de bugs                            |
| `hotfix/*`    | Correções urgentes em produção               |

### Commits Semânticos

```
feat:      Nova funcionalidade
fix:       Correção de bug
style:     Mudanças visuais/CSS
refactor:  Refatoração sem mudar comportamento
docs:      Documentação
chore:     Manutenção
```

> Para detalhes completos, consulte `.agent/workflows/git-workflow.md`

---

## 📌 Versionamento

Formato: **`vMAJOR.MINOR.PATCH`** (SemVer)

| Versão   | Data       | Descrição                                           |
|----------|------------|-----------------------------------------------------|
| `v1.0.0` | 2026-02-10 | Deploy inicial — aplicação completa em produção     |
| `v1.0.1` | 2026-02-10 | Fix GA4 duplicado, tracking via admin               |
| `v1.0.2` | 2026-02-11 | Fix Blog Layout (print match) e rota 500            |

---

## 📄 Licença

Este projeto é privado e de propriedade de **Host Amazonas**.

---

<p align="center">
  Desenvolvido com ❤️ por <a href="https://hostamazonas.com.br">Host Amazonas</a>
</p>
