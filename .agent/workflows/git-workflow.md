---
description: Regras de Git - Branching, versionamento e commits seguros
---

# Regras de Git para o Projeto

## ⚠️ REGRA OBRIGATÓRIA: Fluxo Completo Após Toda Alteração

**Após QUALQUER alteração no código, o assistente DEVE informar ao usuário o fluxo completo de deploy, incluindo:**

1. **Commit local** — com mensagem semântica
2. **Push para o GitHub** — merge develop → main, tag, push
3. **Comandos SSH no servidor** — exatamente o que rodar no terminal cPanel

**Formato da instrução ao usuário após cada alteração:**

```
### 📦 Deploy das alterações

**1. Local (já feito):**
✅ commit: "tipo: descrição"
✅ push para GitHub

**2. No terminal do cPanel, execute:**
cd /home/curr6441/repositories/situacaodaentrega.com.br
git pull origin main
php artisan config:cache
php artisan route:cache
php artisan view:cache
# + comandos extras se necessário (migrate, composer install, etc.)
```

**Esta regra é OBRIGATÓRIA e deve ser seguida em TODAS as conversas.**

---

## Informações do Projeto

| Campo                | Valor                                                        |
|----------------------|--------------------------------------------------------------|
| **Repositório GitHub** | <https://github.com/jorleytavares/situacao-da-entrega.git>   |
| **Usuário Git**      | jorleytavares                                                |
| **Email Git**        | <tavaresjorley@gmail.com>                                      |
| **PHP Local**        | C:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe        |

## Informações do Servidor (cPanel)

| Campo                | Valor                                                        |
|----------------------|--------------------------------------------------------------|
| **Servidor**         | pro126.dnspro.com.br                                         |
| **Usuário cPanel**   | curr6441                                                     |
| **IP**               | 186.209.113.112                                              |
| **Domínio**          | situacaodaentrega.com.br                                     |
| **Home**             | /home/curr6441                                               |
| **Document Root**    | /home/curr6441/situacaodaentrega.com.br (symlink → public)   |
| **Repositório Servidor** | /home/curr6441/repositories/situacaodaentrega.com.br     |
| **SSH Key Servidor** | ~/.ssh/github_deploy (chave do servidor para GitHub)         |
| **DB Nome**          | curr6441_entrega                                             |
| **DB Usuário**       | curr6441_situacao-da-entrega                                 |

## URLs de Acesso

| Recurso              | URL                                                          |
|----------------------|--------------------------------------------------------------|
| **Site Público**     | <https://situacaodaentrega.com.br>                             |
| **Admin Login**      | <https://situacaodaentrega.com.br/admin/dash-hostamazonas>     |
| **Admin Dashboard**  | <https://situacaodaentrega.com.br/admin/visao-geral>           |
| **cPanel**           | <https://pro126.dnspro.com.br:2083>                            |
| **GitHub Repo**      | <https://github.com/jorleytavares/situacao-da-entrega>         |

---

## Estrutura de Branches

- **`main`** → Código estável, pronto para produção. Nunca desenvolver diretamente aqui.
- **`develop`** → Branch de integração. Novas features são mergeadas aqui primeiro.
- **`feature/*`** → Para novas funcionalidades (ex: `feature/filtro-transportadoras`)
- **`fix/*`** → Para correções de bugs (ex: `fix/css-media-page`)
- **`hotfix/*`** → Para correções urgentes em produção (ex: `hotfix/login-quebrado`)

---

## Commits Semânticos (OBRIGATÓRIO)

Toda mensagem de commit DEVE seguir o padrão:

| Prefixo      | Uso                                      | Exemplo                                    |
|--------------|------------------------------------------|--------------------------------------------|
| `feat:`      | Nova funcionalidade                      | `feat: adiciona upload de mídia`           |
| `fix:`       | Correção de bug                          | `fix: corrige CSS órfão na página de mídia`|
| `style:`     | Mudanças visuais/CSS                     | `style: ajusta cores do dashboard`         |
| `refactor:`  | Refatoração sem mudar comportamento      | `refactor: reorganiza rotas admin`         |
| `docs:`      | Documentação                             | `docs: atualiza README`                    |
| `chore:`     | Tarefas de manutenção                    | `chore: atualiza dependências`             |

---

## Versionamento Semântico (SemVer)

Formato: `vMAJOR.MINOR.PATCH`

- **MAJOR** (v2.0.0) → Mudança que quebra compatibilidade
- **MINOR** (v1.1.0) → Nova funcionalidade sem quebrar nada
- **PATCH** (v1.1.1) → Correção de bug

---

## Fluxo de Trabalho Completo (Local → GitHub → cPanel)

### ETAPA 1: Desenvolvimento Local

1. Garantir que está na branch correta:

   ```bash
   git checkout develop
   git checkout -b feature/nome-da-feature
   ```

2. Desenvolver e commitar:

   ```bash
   git add .
   git commit -m "feat: descrição da feature"
   ```

3. Mergear na develop:

   ```bash
   git checkout develop
   git merge feature/nome-da-feature
   ```

### ETAPA 2: Push para GitHub

1. Quando pronto para produção, mergear na main:

   ```bash
   git checkout main
   git merge develop
   git tag -a vX.Y.Z -m "Descrição da versão"
   ```

2. Enviar tudo para o GitHub:

   ```bash
   git push origin main develop vX.Y.Z
   ```

### ETAPA 3: Deploy no Servidor via SSH + cPanel Terminal

1. Acessar o terminal do cPanel (via web ou SSH)

2. Executar o deploy:

   ```bash
   cd /home/curr6441/repositories/situacaodaentrega.com.br
   git pull origin main
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Deploy Rápido (sem migrations ou dependências novas)

   ```bash
   cd /home/curr6441/repositories/situacaodaentrega.com.br
   git pull origin main
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## Estrutura no Servidor

```
/home/curr6441/
├── repositories/
│   └── situacaodaentrega.com.br/        ← Repo Git (clone do GitHub)
│       ├── app/
│       ├── public/                       ← Apontado via symlink ↓
│       ├── storage/
│       ├── .env                          ← Configurado SOMENTE no servidor
│       └── ...
└── situacaodaentrega.com.br             ← Symlink → repositories/.../public
```

---

## Segurança

- **NUNCA** commitar `.env`, chaves de API, senhas ou tokens
- Sempre verificar o `.gitignore` antes de fazer `git add`
- O `.env` de produção deve ser configurado **somente no servidor**, nunca versionado
- Se acidentalmente commitar algo sensível:

  ```bash
  git rm --cached arquivo-sensivel
  git commit -m "chore: remove arquivo sensível do tracking"
  ```

---

## Checklist de Deploy

- [ ] Código testado localmente
- [ ] Commits com mensagens semânticas
- [ ] Merge na `main` feito a partir da `develop`
- [ ] Tag de versão criada
- [ ] Push para GitHub realizado
- [ ] Acessar terminal cPanel
- [ ] `git pull origin main`
- [ ] `composer install --no-dev` (se dependências mudaram)
- [ ] `php artisan migrate --force` (se migrations novas)
- [ ] Cache recriado (`config:cache`, `route:cache`, `view:cache`)
- [ ] Site testado em produção

---

## Primeiro Deploy (Referência - já realizado em 2026-02-10)

Caso precise recriar o servidor do zero:

```bash
# No servidor cPanel
cd /home/curr6441/repositories
GIT_SSH_COMMAND="ssh -i ~/.ssh/github_deploy" git clone git@github.com:jorleytavares/situacao-da-entrega.git situacaodaentrega.com.br
cd situacaodaentrega.com.br
git config core.sshCommand "ssh -i ~/.ssh/github_deploy"
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
# Editar .env com dados de produção
nano .env
php artisan migrate --force
php artisan storage:link
mkdir -p storage/framework/{cache/data,sessions,testing,views}
mkdir -p storage/logs
chmod -R 775 storage bootstrap/cache
php artisan config:cache
php artisan route:cache
rm -rf /home/curr6441/situacaodaentrega.com.br
ln -s /home/curr6441/repositories/situacaodaentrega.com.br/public /home/curr6441/situacaodaentrega.com.br
```
