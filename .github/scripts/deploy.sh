#!/bin/bash

EC2_USER=$AWS_USER
EC2_HOST=$AWS_HOST
EC2_PATH=/home/$EC2_USER/apps/
GIT_REPO=https://github.com/WescleySil/teste-tecnico-alpes.git
BRANCH=test-workflow-github

# Criar a chave PEM a partir do secret

echo -e "$AWS_KEY" > aws_key.pem

chmod 400 aws_key.pem

echo "🚀 Iniciando deploy para $EC2_HOST ..."

ssh -i aws_key.pem -o StrictHostKeyChecking=no -T $EC2_USER@$EC2_HOST << EOF

   if [ -d "$EC2_PATH/.git" ]; then
      echo "📥 Atualizando repositório existente..."
      cd $EC2_PATH
      git fetch origin
      git reset --hard origin/$BRANCH
      docker compose down
      docker compose up -d
    else
      echo "📥 Clonando repositório..."
      git clone -b $BRANCH $GIT_REPO $EC2_PATH
      cd $EC2_PATH
      docker compose up -d
    fi

EOF

echo "✅ Deploy concluído!"
