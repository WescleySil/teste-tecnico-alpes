#!/bin/bash

EC2_USER=$AWS_USER
EC2_HOST=$AWS_HOST
EC2_PATH=~/apps/
GIT_REPO=https://github.com/WescleySil/teste-tecnico-alpes.git
BRANCH=main

# Criar a chave PEM a partir do secret

echo -e "$AWS_KEY" > aws_key.pem

chmod 400 aws_key.pem

echo "🚀 Iniciando deploy para $EC2_HOST ..."

ssh -i aws_key.pem -o StrictHostKeyChecking=no -T $EC2_USER@$EC2_HOST << EOF
  mkdir -p $EC2_PATH
  cd $EC2_PATH

  echo 'dentro do servidor'
EOF

echo "✅ Deploy concluído!"
