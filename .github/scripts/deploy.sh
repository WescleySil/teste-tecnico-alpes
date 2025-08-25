#!/bin/bash

EC2_USER=$AWS_USER
EC2_HOST=$AWS_HOST
EC2_PATH=/apps/
PEM_KEY=~/.ssh/aws_key.pem
GIT_REPO=https://github.com/WescleySil/teste-tecnico-alpes.git
BRANCH=main

# Criar a chave PEM a partir do secret
echo "$AWS_KEY" > $PEM_KEY
chmod 400 $PEM_KEY

echo "🚀 Iniciando deploy para $EC2_HOST ..."

ssh -i $PEM_KEY $EC2_USER@$EC2_HOST << EOF
  mkdir -p $EC2_PATH
  cd $EC2_PATH

  echo 'dentro do servidor'
EOF

echo "✅ Deploy concluído!"
