FROM nginx:1.24.0
RUN mkdir -p /etc/nginx/ssl
COPY ssl/ /etc/nginx/ssl/
RUN chmod 600 /etc/nginx/ssl/server.key
