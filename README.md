# Clínica Focal — Site e Painel Administrativo

Sistema web para uma clínica oftalmológica, construído em Laravel + Filament + Livewire. Reúne o site institucional (com CMS próprio), o agendamento de consultas, o portal do paciente e um painel administrativo completo para a gestão da clínica.

## Stack

- PHP 8.2+ / Laravel 11
- Filament 3 (painel administrativo)
- Livewire 3 + Volt (site e portal do paciente)
- Vite + Tailwind

## Funcionalidades

### Site institucional
- Páginas com conteúdo editável via CMS no próprio painel administrativo (grupo "Site"): Hero, Sobre, Configurações do site, itens de menu, equipe, depoimentos e serviços.
- Seção de agendamento de consulta para visitantes.

### Portal do paciente
- Área logada (`/portal`) onde o paciente acompanha seus agendamentos e documentos.
- Visualização de receitas e graduações (óculos) emitidas pela equipe, com controle de acesso (paciente só vê os próprios documentos; equipe vê todos).

### Painel administrativo (Filament)
- **Agendamentos**: agenda de consultas, vinculação a médicos e convênios, solicitações de agendamento.
- **Pacientes e Prontuários**: cadastro de pacientes, histórico clínico, receitas e graduações.
- **Financeiro**: contas, caixas e pagamentos.
- **Convênios e Médicos**: cadastro e gestão.
- **Relatórios gerenciais**: produção por médico, convênios mais utilizados e visão geral de estatísticas.
- **Segurança e auditoria**: registro de acessos e trilha de auditoria das ações no sistema.
- **Usuários**: gestão de usuários e permissões de acesso ao painel.

## Estrutura de deploy

O diretório público do Laravel foi renomeado de `public` para `public_html`, compatível com hospedagens compartilhadas (cPanel). Ao configurar o servidor web, aponte o document root para `public_html`.

## Instalação

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate
npm run build
```

Para desenvolvimento local, use:

```bash
composer run dev
```

Esse comando sobe simultaneamente o servidor Laravel, o worker de filas, os logs (Pail) e o Vite em modo watch.
