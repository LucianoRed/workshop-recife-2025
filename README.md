# Workshop Recife 2025

Automação para provisionamento e configuração de ambiente na AWS para o Workshop realizado em Recife em 2025.

## Pré-requisitos

*   Ansible instalado
*   Coleção `amazon.aws` instalada: `ansible-galaxy collection install amazon.aws`
*   Chave SSH `workshop-recife.pem` presente no diretório raiz (com permissão 400).
*   Arquivo `credentials` com as credenciais da AWS.

## Passo a Passo

### 1. Configurar Credenciais

Exporte a variável de ambiente para que o Ansible utilize o arquivo local de credenciais:

```bash
export AWS_SHARED_CREDENTIALS_FILE=$(pwd)/credentials
```

### 2. Provisionar Infraestrutura

Execute o playbook de provisionamento para criar as instâncias EC2. Você pode definir a quantidade de máquinas desejada através da variável `amount` (padrão é 1).

```bash
# Exemplo para criar 1 máquina
ansible-playbook provision_ec2.yml

# Exemplo para criar 3 máquinas
ansible-playbook provision_ec2.yml -e "amount=3"
```

Este passo irá:
*   Criar instâncias EC2 na região `us-east-2`.
*   Configurar Security Group e Subnet definidos.
*   Gerar o arquivo de inventário `inventory_output.ini`.

### 3. Configurar Nós

Após o provisionamento, execute o playbook de configuração para preparar as máquinas (criar usuário `openshift`, configurar SSH e sudo).

```bash
ansible-playbook -i inventory_output.ini configure_nodes.yml
```

Este passo irá:
*   Criar o usuário `openshift` com senha `redhat123`.
*   Configurar acesso SSH por senha.
*   Configurar `sudo` sem senha para o usuário `openshift`.

### 4. Acesso

Você pode acessar as máquinas via SSH utilizando o usuário `openshift`:

```bash
ssh openshift@<IP_PUBLICO>
```
