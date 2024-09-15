# Usa uma imagem base oficial do PHP com Apache
FROM php:8.1-apache

# Copia o código da aplicação para o diretório padrão do Apache
COPY . /var/www/html/

# Define o diretório de trabalho do Apache para /public
# Isso faz com que o Apache sirva arquivos a partir do diretório 'public'
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Habilita o módulo rewrite do Apache (se necessário para sua aplicação)
RUN a2enmod rewrite

# Configura as permissões apropriadas
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta 80 para o Apache
EXPOSE 80
